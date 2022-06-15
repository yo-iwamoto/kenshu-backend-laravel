<?php

namespace App\Services;

use App\Models\Post;
use App\Models\PostImage;
use App\Models\PostToTag;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Exception;
use Throwable;

class UpdatePostService implements UpdatePostServiceInterface
{
    public function execute($post_id, $user_id, $title, $content, $thumbnail_image_index, $images, $tag_ids)
    {
        DB::beginTransaction();

        try {
            /** @var Post */
            $post = Post::find($post_id);

            $post->update([
                'user_id' => $user_id,
                'title' => $title,
                'content' => $content,
            ]);

            if ($images !== null && $thumbnail_image_index !== null) {
                $to_delete_image_urls = $this->bulkUpdateImages($post, $images);
                /** @var PostImage[] */
                $post_images = $post->images()->getResults();
                $thumbnail_post_image = $post_images[intval($thumbnail_image_index)];
                $post->update([
                    'post_image_id' => $thumbnail_post_image->id,
                ]);
            }

            if ($tag_ids !== null) {
                $this->bulkUpdateTags($post, $tag_ids);
            }

            DB::commit();

            if (isset($to_delete_image_urls)) {
                $this->removeImages($to_delete_image_urls);
            }

            return $post;
        } catch (Throwable $e) {
            DB::rollBack();

            throw $e;
        }
    }

    /**
     * PostImage を全て更新する
     *
     * @param Post $post
     * @param UploadedFile[] $images
     * @return string[] 削除対象の画像パス
     * @throws Exception
     */
    private function bulkUpdateImages($post, $images)
    {
        // トランザクションコミット後に削除する画像パス
        $to_delete_image_urls = [];

        /** @var PostImage[] */
        $current_post_images = $post->images()->getResults();
        foreach ($current_post_images as $post_image) {
            // image_url を取得
            array_push($to_delete_image_urls, $post_image->image_url);
            // レコードを削除
            $post_image->delete();
        }

        /** @var string[] */
        $image_urls = array_map(function ($uploaded_file) {
            // 推論が効かないので型ガード
            if (!($uploaded_file instanceof UploadedFile)) {
                throw new Exception();
            }

            $storage_path = Storage::putFile('public/img/posts', $uploaded_file);
            if (!$storage_path) {
                throw new Exception('failed to upload file');
            }

            return str_replace('public', '', "/storage$storage_path");
        }, $images);

        /** @var array<string, string>[] */
        $data = array_map(fn ($image_url) => [
            'post_id' => $post->id,
            'image_url' => $image_url
        ], $image_urls);

        PostImage::upsert($data, 'id');

        return $to_delete_image_urls;
    }

    /**
     * 指定したパスの画像を全て削除する
     *
     * @param string[] $image_urls
     */
    private function removeImages($image_urls)
    {
        foreach ($image_urls as $image_url) {
            Storage::disk('public')->delete(str_replace('/storage', '', $image_url));
        }
    }

    /**
     * Tag との関連を一括更新する
     *
     * @param Post $post
     * @param string[] $tag_ids
     * @return void
     */
    private function bulkUpdateTags($post, $tag_ids)
    {

        /** @var string[]  */
        $current_tag_ids = $post
            ->tags()
            ->getResults()
            ->pluck('id')
            ->toArray();

        // 現在紐づいている Tag で、フォームで指定されていないものとの関連を削除
        $disposed_tag_ids = array_diff($current_tag_ids, $tag_ids);
        PostToTag::where('post_id', $post->id)->whereIn('tag_id', $disposed_tag_ids)->delete();

        // フォームで指定されていて、現在関連がない Tag との関連を作成
        $to_create_tag_ids = array_diff($tag_ids, $current_tag_ids);
        PostToTag::upsert(array_map(fn (string $tag_id) => [
            'post_id' => $post->id,
            'tag_id' => $tag_id,
        ], $to_create_tag_ids), ['post_id', 'tag_id']);
    }
}

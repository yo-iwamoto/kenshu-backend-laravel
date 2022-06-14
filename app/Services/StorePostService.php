<?php

namespace App\Services;

use App\Models\Post;
use App\Models\PostImage;
use App\Services\StorePostServiceInterface;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Exception;
use Throwable;

class StorePostService implements StorePostServiceInterface
{
    public function execute($user_id, $title, $content, $thumbnail_image_index, $images)
    {
        DB::beginTransaction();

        try {
            /** @var Post */
            $post = Post::create([
                'user_id' => $user_id,
                'title' => $title,
                'content' => $content,
            ]);

            if ($images !== null && $thumbnail_image_index !== null) {
                $this->createPostImages($post->id, $images);
                /** @var PostImage[] */
                $post_images = $post->images()->getResults();
                $thumbnail_post_image = $post_images[intval($thumbnail_image_index)];
                $post->update([
                    'post_image_id' => $thumbnail_post_image->id,
                ]);
            }

            DB::commit();

            return $post;
        } catch (Throwable $e) {
            DB::rollBack();

            throw $e;
        }
    }

    /**
     * PostImage を複数件作成する
     *
     * @param string $post_id
     * @param UploadedFile[] $images
     * @return void
     * @throws Exception
     */
    private function createPostImages($post_id, $images)
    {
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
            'post_id' => $post_id,
            'image_url' => $image_url
        ], $image_urls);

        PostImage::upsert($data, 'id');
    }
}

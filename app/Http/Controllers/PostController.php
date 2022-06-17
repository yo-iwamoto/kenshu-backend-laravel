<?php

namespace App\Http\Controllers;

use App\Http\Requests\DestroyPostRequest;
use App\Http\Requests\StorePostRequest;
use App\Http\Requests\UpdatePostRequest;
use App\Services\DestroyPostServiceInterface;
use App\Services\IndexPostServiceInterface;
use App\Services\IndexTagServiceInterface;
use App\Services\ShowPostServiceInterface;
use App\Services\StorePostServiceInterface;
use App\Services\UpdatePostServiceInterface;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Validation\UnauthorizedException;

class PostController extends Controller
{
    public function index(
        IndexPostServiceInterface $index_post_service,
        IndexTagServiceInterface $index_tag_service,
    ) {
        $posts = $index_post_service->execute();
        $tags = $index_tag_service->execute();

        return view('post.index', [
            'posts' => $posts,
            'tags' => $tags,
        ]);
    }

    public function show(
        string $post_id,
        ShowPostServiceInterface $show_post_service,
    ) {
        $post = $show_post_service->execute($post_id);

        return view('post.show', [
            'post' => $post,
        ]);
    }

    public function store(
        StorePostRequest $request,
        StorePostServiceInterface $store_post_service,
    ) {
        try {
            // ゲストユーザーのエラー処理
            if ($request->user() === null) {
                return redirect('/')->with([
                'message' => 'ゲストユーザーは記事を投稿できません。新規会員登録またはログインしてください',
            ]);
            }

            $form_data = $request->validated();

            $store_post_service->execute(
                user_id: $request->user()->id,
                title: $form_data['title'],
                content: $form_data['content'],
                thumbnail_image_index: $form_data['thumbnail_image_index'],
                images: $request->file('images'),
                tag_ids: isset($form_data['tags']) ? $form_data['tags'] : null,
            );

            return redirect('/');
        } catch (Exception $e) {
            return redirect('/')->with([
                'message' => '記事の作成に失敗しました',
            ]);
        }
    }


    public function edit(
        Request $request,
        ShowPostServiceInterface $show_post_service,
        IndexTagServiceInterface $index_tag_service,
        string $post_id,
    ) {
        try {
            // ゲストユーザーのエラー処理
            // 記事の取得処理が省略可能なため、他のユーザーの場合と分けて先に行なっている
            if ($request->user() === null) {
                throw new UnauthorizedException();
            }

            $post = $show_post_service->execute($post_id);

            // 他のユーザーのエラー処理
            if ($post->user->id !== $request->user()->id) {
                throw new UnauthorizedException();
            }

            $all_tags = $index_tag_service->execute();
            $related_tag_ids = $post->tags()->getResults()->pluck('id')->toArray();

            return view('post.edit', [
                'post' => $post,
                'tags' => $all_tags,
                'tag_ids' => $related_tag_ids,
            ]);
        } catch (UnauthorizedException $e) {
            return redirect('/')->with([
                'message' => '他のユーザーの記事を編集することはできません',
            ]);
        }
    }

    public function update(
        UpdatePostRequest $request,
        UpdatePostServiceInterface $update_post_service,
        string $post_id,
    ) {
        try {
            $form_data = $request->validated();

            $update_post_service->execute(
                post_id: $post_id,
                user_id: $request->user()->id,
                title: $form_data['title'],
                content: $form_data['content'],
                thumbnail_image_index: $form_data['thumbnail_image_index'],
                images: $request->file('images'),
                tag_ids: isset($form_data['tags']) ? $form_data['tags'] : null,
            );

            return redirect(route('post.show', ['post' => $post_id]));
        } catch (Exception $e) {
            return redirect(route('post.show', ['post' => $post_id]))->with([
                'message' => '更新処理に失敗しました',
            ]);
        }
    }

    public function destroy(
        DestroyPostRequest $request,
        string $post_id,
        DestroyPostServiceInterface $destroy_post_service,
    ) {
        try {
            $destroy_post_service->execute(
                post_id: $post_id,
                current_user_id: $request->user()->id,
            );

            return redirect('/')->with([
                'message' => '削除しました',
            ]);
        } catch (UnauthorizedException $e) {
            return redirect('/')->with([
                'message' => '他のユーザーの投稿を削除することはできません',
            ]);
        } catch (ModelNotFoundException $e) {
            return redirect('/')->with([
                'message' => '指定した投稿は既に削除されています',
            ]);
        }
    }
}

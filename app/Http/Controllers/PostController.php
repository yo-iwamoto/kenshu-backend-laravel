<?php

namespace App\Http\Controllers;

use App\Http\Requests\DestroyPostRequest;
use App\Http\Requests\StorePostRequest;
use App\Services\DestroyPostServiceInterface;
use App\Services\IndexPostServiceInterface;
use App\Services\ShowPostServiceInterface;
use App\Services\StorePostServiceInterface;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Routing\Controller;
use Illuminate\Validation\UnauthorizedException;

class PostController extends Controller
{
    public function __construct(
        private DestroyPostServiceInterface $destroy_post_service,
        private IndexPostServiceInterface $index_post_service,
        private ShowPostServiceInterface $show_post_service,
        private StorePostServiceInterface $store_post_service,
    ) {
    }

    public function index()
    {
        $posts = $this->index_post_service->execute();

        return view('post.index', [
            'posts' => $posts,
        ]);
    }

    public function show(string $post_id)
    {
        $post = $this->show_post_service->execute($post_id);

        return view('post.show', [
            'post' => $post,
        ]);
    }

    public function store(StorePostRequest $request)
    {
        $form_data = $request->validated();

        $this->store_post_service->execute(
            user_id: $request->user()->id,
            title: $form_data['title'],
            content: $form_data['content'],
            thumbnail_image_index: $form_data['thumbnail_image_index'],
            images: $request->file('images'),
        );

        return redirect('/');
    }

    public function destroy(DestroyPostRequest $request, string $post_id)
    {
        try {
            $this->destroy_post_service->execute(
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

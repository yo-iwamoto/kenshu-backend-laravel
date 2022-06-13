<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePostRequest;
use App\Services\IndexPostServiceInterface;
use App\Services\ShowPostServiceInterface;
use App\Services\StorePostServiceInterface;
use Illuminate\Routing\Controller;

class PostController extends Controller
{
    public function __construct(
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
        );

        return redirect('/');
    }

    public function destroy()
    {
        return redirect('/');
    }
}

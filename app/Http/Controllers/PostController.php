<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePostRequest;
use App\Services\StorePostServiceInterface;
use Illuminate\Routing\Controller;

class PostController extends Controller
{
    public function __construct(
        private StorePostServiceInterface $store_post_service,
    ) {
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
}

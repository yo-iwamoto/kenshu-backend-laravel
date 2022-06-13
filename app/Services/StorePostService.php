<?php

namespace App\Services;

use App\Models\Post;
use App\Services\StorePostServiceInterface;

class StorePostService implements StorePostServiceInterface
{
    public function execute($user_id, $title, $content)
    {
        return Post::create([
            'user_id' => $user_id,
            'title' => $title,
            'content' => $content,
        ]);
    }
}

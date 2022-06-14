<?php

namespace App\Services;

use App\Models\Post;
use App\Services\IndexPostServiceInterface;

class IndexPostService implements IndexPostServiceInterface
{
    public function execute()
    {
        return Post::with(['user', 'thumbnail_post_image'])->get()->sortByDesc('created_at');
    }
}

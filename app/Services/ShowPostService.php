<?php

namespace App\Services;

use App\Models\Post;

use App\Services\ShowPostServiceInterface;

class ShowPostService implements ShowPostServiceInterface
{
    public function execute($id)
    {
        return Post::with(['user', 'images', 'tags'])->get()->find($id);
    }
}

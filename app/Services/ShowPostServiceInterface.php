<?php

namespace App\Services;

use App\Models\Post;

interface ShowPostServiceInterface
{
    /**
     * @param string $id
     * @return Post
     */
    public function execute($id);
}

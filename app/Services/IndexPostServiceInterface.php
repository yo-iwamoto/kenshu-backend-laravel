<?php

namespace App\Services;

use App\Models\Post;

interface IndexPostServiceInterface
{
    /**
     * @return Post[]
     */
    public function execute();
}

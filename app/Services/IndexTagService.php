<?php

namespace App\Services;

use App\Models\Tag;

class IndexTagService implements IndexTagServiceInterface
{
    public function execute()
    {
        return Tag::all();
    }
}

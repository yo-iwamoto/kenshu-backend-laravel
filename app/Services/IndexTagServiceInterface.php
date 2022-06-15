<?php

namespace App\Services;

use App\Models\Tag;

interface IndexTagServiceInterface
{
    /**
     * @return Tag[]
     */
    public function execute();
}

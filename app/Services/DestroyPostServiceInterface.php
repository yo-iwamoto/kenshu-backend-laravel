<?php

namespace App\Services;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Validation\UnauthorizedException;

interface DestroyPostServiceInterface
{
    /**
     * @param string $post_id
     * @param string $current_user_id
     * @return void
     * @throws ModelNotFoundException|UnauthorizedException
     */
    public function execute($post_id, $current_user_id);
}

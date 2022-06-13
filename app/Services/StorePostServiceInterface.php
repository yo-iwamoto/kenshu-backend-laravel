<?php

namespace App\Services;

interface StorePostServiceInterface
{
    /**
     * @param string $user_id
     * @param string $title
     * @param string $content
     * @return void
     */
    public function execute($user_id, $title, $content);
}

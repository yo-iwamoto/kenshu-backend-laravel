<?php

namespace App\Services;

use Illuminate\Http\UploadedFile;

interface StorePostServiceInterface
{
    /**
     * @param string $user_id
     * @param string $title
     * @param string $content
     * @param string|null $thumbnail_image_index
     * @param UploadedFile[]|null $images
     * @return void
     */
    public function execute($user_id, $title, $content, $thumbnail_image_index, $images);
}

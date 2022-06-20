<?php

namespace App\Services;

use Illuminate\Http\UploadedFile;

interface UpdatePostServiceInterface
{
    /**
     * @param string $post_id
     * @param string $user_id
     * @param string $title
     * @param string $content
     * @param string|null $thumbnail_image_index
     * @param UploadedFile[]|null $images
     * @param string[]|null $tag_ids
     * @return void
     *
     * 渡す値は App\Http\Requests\UpdatePostRequest のバリデーションをパスしていること
     */
    public function execute($post_id, $user_id, $title, $content, $thumbnail_image_index, $images, $tag_ids);
}

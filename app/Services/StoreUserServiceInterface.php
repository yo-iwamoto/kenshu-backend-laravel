<?php

namespace App\Services;

use Illuminate\Http\UploadedFile;

interface StoreUserServiceInterface
{
    /**
     * @param string $name
     * @param string $email
     * @param string $password
     * @param UploadedFile|UploadedFile[]|array|null $file
     * @return void
     * @throws Exception
     */
    public function execute($name, $email, $password, $file);
}

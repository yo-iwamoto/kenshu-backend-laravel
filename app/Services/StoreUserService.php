<?php

namespace App\Services;

use App\Models\User;
use Exception;
use Illuminate\Support\Facades\Storage;
use App\Services\StoreUserServiceInterface;
use Illuminate\Http\UploadedFile;

class StoreUserService implements StoreUserServiceInterface
{
    public function execute($name, $email, $password, $file)
    {
        if ($file instanceof UploadedFile) {
            // ファイルをストア
            $storage_path = Storage::putFile('public/img/users', $file);
            if (!$storage_path) {
                throw new Exception('failed to upload file');
            }
            $full_path = "/storage$storage_path";

            // ファイルパスから public を除いたもの (img の src に使える状態) を $formFields にセット
            $profile_image_url = str_replace('public', '', $full_path);
        }
        $profile_image_url ??= '/img/default-icon.png';

        // パスワードのハッシュ化
        $password_hash = bcrypt($password);

        $user = User::create([
            'name' => $name,
            'email' => $email,
            'password' => $password_hash,
            'profile_image_url' => $profile_image_url,
        ]);

        auth()->login($user);
    }
}

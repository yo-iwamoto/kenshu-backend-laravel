<?php

namespace App\Services;

use App\Models\User;
use Exception;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use App\Services\StoreUserServiceInterface;

class StoreUserService implements StoreUserServiceInterface
{
    public function execute($request)
    {
        $formFields = $request->validate([
            'name' => ['required', 'min:1', 'max:50'],
            'email' => ['required', 'email', Rule::unique('users', 'email')],
            'password' => ['required', 'min:6', 'max:72'],
            'profile_image' => ['file', 'max:1024'], // ファイルサイズを 1MB までに制限
        ]);

        if ($request->file('profile_image') !== null) {
            // ファイルをストア
            $storage_path = Storage::putFile('public/img/users', $request->file('profile_image'));
            if (!$storage_path) {
                throw new Exception('failed to upload file');
            }
            $full_path = "/storage/$storage_path";

            // ファイルパスから public を除いたもの (img の src に使える状態) を $formFields にセット
            $profile_image_url = str_replace('public', '', $full_path);
        }
        $profile_image_url ??= '/img/default-icon.png';

        // パスワードのハッシュ化
        $password_hash = bcrypt($formFields['password']);

        $user = User::create([
            'name' => $formFields['name'],
            'email' => $formFields['email'],
            'password' => $password_hash,
            'profile_image_url' => $profile_image_url,
        ]);

        auth()->login($user);
    }
}

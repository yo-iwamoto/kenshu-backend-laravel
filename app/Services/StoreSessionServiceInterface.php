<?php

namespace App\Services;

use Illuminate\Validation\ValidationException;

interface StoreSessionServiceInterface
{
    /**
     * @param string $email
     * @param string $password
     * @return bool Auth::attempt の返り値
     * @throws ValidationException
     *
     * 渡す値は App\Http\Requests\StoreSessionRequest のバリデーションをパスしていること
     */
    public function execute($email, $password);
}

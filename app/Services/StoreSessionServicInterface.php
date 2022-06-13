<?php

namespace App\Services;

use Illuminate\Validation\ValidationException;

interface StoreSessionServicInterface
{
    /**
     * @param string $email
     * @param string $password
     * @return bool Auth::attempt の返り値
     * @throws ValidationException
     */
    public function execute($email, $password);
}

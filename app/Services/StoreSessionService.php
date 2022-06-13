<?php

namespace App\Services;

use App\Services\StoreSessionServiceInterface;
use Illuminate\Support\Facades\Auth;

class StoreSessionService implements StoreSessionServiceInterface
{
    public function execute($email, $password)
    {
        return Auth::attempt([
            'email' => $email,
            'password' => $password,
        ]);
    }
}

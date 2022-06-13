<?php

namespace App\Services;

use App\Services\StoreSessionServicInterface;
use Illuminate\Support\Facades\Auth;

class StoreSessionService implements StoreSessionServicInterface
{
    public function execute($email, $password)
    {
        return Auth::attempt([
            'email' => $email,
            'password' => $password,
        ]);
    }
}

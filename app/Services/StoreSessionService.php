<?php

namespace App\Services;

use App\Services\StoreSessionServicInterface;
use Illuminate\Support\Facades\Auth;

class StoreSessionService implements StoreSessionServicInterface
{
    public function execute($request)
    {
        $data = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        return Auth::attempt($data);
    }
}

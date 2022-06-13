<?php

namespace App\Http\Controllers;

use App\Services\StoreUserServiceInterface;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class UserController extends Controller
{
    public function __construct(
        private StoreUserServiceInterface $store_user_service,
    ) {
    }

    public function create()
    {
        return view('users.signup');
    }

    public function store(Request $request)
    {
        $this->store_user_service->execute($request);

        return redirect('/')->with('message', "Woohoo🎉 You're now logged in!");
    }
}

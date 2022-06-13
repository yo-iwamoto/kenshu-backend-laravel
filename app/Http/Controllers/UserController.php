<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreUserRequest;
use App\Services\StoreUserServiceInterface;
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

    public function store(StoreUserRequest $request)
    {
        $form_data = $request->validated();

        $this->store_user_service->execute(
            name: $form_data['name'],
            email: $form_data['email'],
            password: $form_data['password'],
            file: $request->file('profile_image'),
        );

        return redirect('/')->with('message', "Woohoo🎉 You're now logged in!");
    }
}

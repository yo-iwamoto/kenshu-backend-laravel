<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreSessionRequest;
use App\Services\StoreSessionServiceInterface;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;

class SessionController extends Controller
{
    public function __construct(
        private StoreSessionServiceInterface $store_session_service,
    ) {
    }

    public function create()
    {
        return view('sessions.login');
    }

    public function store(StoreSessionRequest $request)
    {
        $form_data = $request->validated();

        $succeeded = $this->store_session_service->execute(
            email: $form_data['email'],
            password: $form_data['password'],
        );

        if ($succeeded) {
            $request->session()->regenerate();

            return redirect('/');
        }

        return back()->withErrors([
            'email' => 'メールアドレスかパスワードが間違っています',
        ])->onlyInput('email');
    }

    public function destroy()
    {
        Auth::logout();

        return redirect('/');
    }
}

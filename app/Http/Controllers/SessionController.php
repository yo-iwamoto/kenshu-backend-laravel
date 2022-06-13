<?php

namespace App\Http\Controllers;

use App\Services\StoreSessionServicInterface;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;

class SessionController extends Controller
{
    public function __construct(
        private StoreSessionServicInterface $store_session_service,
    ) {
    }

    public function create()
    {
        return view('sessions.login');
    }

    public function store(Request $request)
    {
        $succeeded = $this->store_session_service->execute($request);

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

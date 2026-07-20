<?php

namespace App\Http\Controllers;

use App\Enums\RoutesName;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class LoginController extends Controller
{

    public function getViewPath(): string
    {
        return 'Login';
    }

    public function loginForm()
    {
        return $this->render(
            'Index',
            ['sendUrl' => RoutesName::Login->value]
        );
    }

    /**
     * Login
     */
    public function login(Request $request)
    {
        $credentials = $request->only('number', 'password');

        if (Auth::guard()->attempt($credentials)) {
            $request->session()->regenerate();
            return Inertia::location('/cheque');
        }

        return back()->withErrors([
            'number' => 'اطلاعات ورود نادرست است',
        ]);
    }
}

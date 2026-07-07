<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LoginController extends Controller
{

    public function getViewPath(): string
    {
        return 'Login';
    }

    public function loginForm()
    {
        return $this->render('Index');
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index()
    {
        return inertia('Dashboard/Index');
    }

    public function login() {
        
    }
}

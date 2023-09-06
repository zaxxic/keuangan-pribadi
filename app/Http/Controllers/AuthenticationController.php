<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AuthenticationController extends Controller
{
    function RegisterIndex() {
        return view('auth.register');
    }
}

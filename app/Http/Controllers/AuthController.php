<?php

namespace App\Http\Controllers;

use function Ramsey\Uuid\v1;



use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    //login and register

    public function loginPage() {
        return view('login');
    }

    public function registerPage() {
        return view('register');
    }

    // direct dashboard
    public function dashboard() {
        if(Auth::user()->role == 'admin') {
            return redirect()->route('category#list');
        }
        return redirect()->route('user#home');
    }


}

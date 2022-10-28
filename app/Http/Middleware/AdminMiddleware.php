<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        // dd(url()->current());
        // dd(route('auth#login'));
        if(!empty(Auth::user())) { // if user login
            if(url()->current() == route('auth#login') || url()->current() == route('auth#register')) {

                if (Auth::user()->role == 'admin') {
                    return redirect()->route('category#list');
                }else {
                    return redirect()->route('user#home');
                }
            }

            if (Auth::user()->role != 'admin') {
                return redirect()->route('user#home');
            }
            return $next($request);
        }else {
            if (url()->current() == route('category#list') || url()->current() == route('user#home')) {

                abort(404);
            }
        }
        return $next($request);
    }
}

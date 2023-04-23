<?php

namespace App\Http\Middleware;

use Illuminate\Support\Facades\Auth;
use Closure;
use Illuminate\Http\Request;

class CheckRole
{

    public function handle(Request $request, Closure $next)
    {
        $roles = array_slice(func_get_args(), 2);
        foreach ($roles as $role) {


            if (isset(Auth::user()->role))
                if (Auth::user()->role == $role) {
                    return $next($request);
                }
        }
        return redirect('login');
    }
}

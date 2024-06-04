<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class EnsureEmailIsVerified
{
    public function handle($request, Closure $next)
    {
        $user = $request->user();

        if($user && $user->active == true) {
            return $next($request);
        }
        else {
            return redirect()->route('verification.notice');
        }
    }
}

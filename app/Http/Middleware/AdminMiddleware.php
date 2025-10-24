<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;
use function Laravel\Prompts\alert;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = Auth::user();

        if (!$user) {
            return redirect()->route('login')->with('messages', 'You must be an admin to access this page.');
        } elseif ($user->userType === 'teacher') {
            return $next($request);
        } elseif ($user->userType === 'student') {
            return redirect()->back()->with('messages', 'You cannot edit student details.');
        }
        return $next($request);
    }
}

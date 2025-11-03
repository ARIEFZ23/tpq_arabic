<?php

namespace App\Http\Middleware;

use App\Providers\RouteServiceProvider;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, string ...$guards): Response
    {
        $guards = empty($guards) ? [null] : $guards;

        foreach ($guards as $guard) {
            if (Auth::guard($guard)->check()) {
                // Get authenticated user
                $user = Auth::guard($guard)->user();
                
                // Redirect based on user role
                if ($user->role === 'admin') {
                    return redirect()->route('admin.dashboard');
                } elseif ($user->role === 'ustadz' || $user->role === 'ustadzah') {
                    return redirect()->route('ustadz.dashboard');
                } elseif ($user->role === 'santri_putra' || $user->role === 'santri_putri') {
                    return redirect()->route('santri.dashboard');
                }
                
                // Fallback to default home if role not recognized
                return redirect(RouteServiceProvider::HOME);
            }
        }

        return $next($request);
    }
}
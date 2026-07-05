<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RedirectByRole
{
    public function handle(Request $request, Closure $next): Response
    {
        // Kontrollojmë nëse përdoruesi është i loguar
        if (Auth::check()) {
            $user = Auth::user();

            // Kontrollojmë rolet e Spatie
            if ($user->hasRole('admin')) {
                // Nëse admini po tenton të shkojë te faqja kryesore (/) ose login, e dërgojmë te raportet
                if ($request->is('/') || $request->is('login') || $request->is('dashboard')) {
                    return redirect()->route('admin.bilanci.transaksioneve');
                }
            }

            if ($user->hasRole('user')) {
                // Nëse operatori/user po tenton të shkojë te kryesorja ose login, e dërgojmë te operacionet
                if ($request->is('/') || $request->is('login') || $request->is('dashboard')) {
                    return redirect()->route('operatori.operacionet');
                }
            }
        }

        return $next($request);
    }
}

<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CompleteProfile
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
        $existing_alerts = session('alert', []);

        if (!$request->user()->profileComplete()) {
            return redirect(route('profile.edit'))
                ->with('alert', [
                    ...($existing_alerts),
                    ['mode' => 'danger', 'message' => 'Anda harus melengkapi profil terlebih dahulu'],
                ]);
        }

        return $next($request);
    }
}

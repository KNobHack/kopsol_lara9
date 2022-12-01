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
        $user = Auth::user();

        if (
            $this->hasAnggotaField($user) &&
            $this->isFilled($user)
        ) {
            return redirect(route('profile.edit'));
        }

        return $next($request);
    }

    protected function hasAnggotaField($user): bool
    {
        return $user->anggota !== null;
    }

    protected function isFilled($user): bool
    {
        return true;
    }
}

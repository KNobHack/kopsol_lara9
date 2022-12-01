<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
        if (
            $this->doesNotHaveAnggota() ||
            $this->notFilled()
        ) {
            return redirect(route('profile.edit'));
        }

        return $next($request);
    }

    protected function doesNotHaveAnggota(): bool
    {
        return Auth::user()->anggota !== null;
    }

    protected function notFilled(): bool
    {
        return true;
    }
}

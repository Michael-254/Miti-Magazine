<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\Role;

class IsEmailSet
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if(auth()->user()->email == null) {
            return redirect('auth/email');
        }

        return $next($request);
    }
}

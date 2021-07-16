<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\User;
use Carbon\Carbon;

class IsMyInvoice
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $myInvoice = true;
   
        // Check if it is the user's invoice
        if ($myInvoice) {
            return $next($request);
        } else {
            return redirect()->back();
        }
    }
}

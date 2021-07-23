<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Invoice;
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
        $invoice = Invoice::find($request->route('id'));
   
        // Check if it is the user's invoice
        if ($invoice->user_id == auth()->user()->id) {
            return $next($request);
        } else {
            return redirect()->back();
        }
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use App\Models\Payment;
use App\Models\Paypal;
use Illuminate\Http\Request;

class ViewTransactionController extends Controller
{
    public function paypalTransaction()
    {
        return view('admin.paypal-transactions');
    }

    public function ipayTransaction()
    {
        return view('admin.ipay-transactions');
    }

    public function ipayInvoice(Payment $payment)
    {
        $invoice = Invoice::where('reference', '=', $payment->reference)->first();
        if (!$invoice) {
            abort(404);
        } else {
            return view('invoice/invoice', compact('invoice'));
        }
    }

    public function paypalInvoice(Paypal $paypal)
    {
        $invoice = Invoice::where('reference', '=', $paypal->reference)->first();
        if (!$invoice) {
            abort(404);
        } else {
            return view('invoice/invoice', compact('invoice'));
        }
    }

    public function rates()
    {
        return view('admin/exchange');
    }
}

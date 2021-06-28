<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ViewTransactionController extends Controller
{
    public function paypalTransaction(){
        return view('admin.paypal-transactions');
    }

    public function ipayTransaction(){
        return view('admin.ipay-transactions');
    }
}

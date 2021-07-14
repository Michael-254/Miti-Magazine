<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    //
    public function index(){
        return view('admin.customers');
    }

    public function customerInfo(User $customer){
        return view('admin.Customer-Information',compact('customer'));
    }
}

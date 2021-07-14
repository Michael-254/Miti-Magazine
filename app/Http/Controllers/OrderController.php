<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    //
    public function CartOrder(){
        return view('admin/CartOrders');
    }

    public function SubOrder(){
        return view('admin/subscription-orders');
    }
}

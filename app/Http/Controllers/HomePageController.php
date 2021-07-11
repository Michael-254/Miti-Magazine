<?php

namespace App\Http\Controllers;

use App\Models\Magazine;
use Illuminate\Http\Request;
use Cart;

class HomePageController extends Controller
{
    public function welcome()
    {
        $recentmagazines = Magazine::latest()->limit(4)->get();
        return view('welcome',compact('recentmagazines'));
    }

    public function previous()
    {
        $recentmagazines = Magazine::latest()->limit(4)->get();
        //$previousmagazines= Magazine::whereNotIn('id', $recentmagazines->pluck('id'))->get();
          $previousmagazines= Magazine::all();
        return view('previous-issue',compact('previousmagazines'));
    }

    public function cart(Request $request)
    {
       $magazine = Magazine::findOrFail($request->input('product'));
       $cart = Cart::add([
        'id' => $magazine->id,
        'name' => $magazine->issue_no,
        'price' => 250,
        'quantity' => $request->input('quantity'),
       ]);

       return redirect('/Previous-Issues')->with('message', 'Successfully added');
    }

    public function remove(Request $request)
    {
        Cart::remove($request->product);

       return redirect('/Previous-Issues')->with('message', 'Successfully removed');
    }
}

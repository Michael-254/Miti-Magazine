<?php

namespace App\Http\Controllers;

use App\Models\Magazine;
use Illuminate\Http\Request;
use Cart;

class HomePageController extends Controller
{
    public function welcome()
    {
        $recentmagazines = Magazine::where('type','payable')->latest()->limit(4)->get();
        $freemagazines = Magazine::where('type','promotional')->latest()->limit(4)->get();
        return view('welcome',compact('recentmagazines','freemagazines'));
    }

    public function previous()
    {
        $recentmagazines = Magazine::latest()->limit(4)->get();
        $previousmagazines= Magazine::whereNotNull('created_at')->whereNotIn('id', $recentmagazines->pluck('id'))->get();
        return view('previous-issue',compact('previousmagazines'));
    }

}

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
        $previousmagazines= Magazine::whereNotIn('id', $recentmagazines->pluck('id'))->get();
        return view('previous-issue',compact('previousmagazines'));
    }

}

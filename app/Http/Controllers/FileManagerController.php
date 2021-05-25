<?php

namespace App\Http\Controllers;

class FileManagerController extends Controller
{
    /**
     * Show the media panel.
     *
     * @return \Illuminate\Http\Response
    */
    public function index()
    {
        return view('file-manager');
    }
}
<?php

namespace App\Http\Controllers;

use App\Models\Magazine;

class FileManagerController extends Controller
{
    /**
     * Show the media panel.
     *
     * @return \Illuminate\Http\Response
    */
    public function index()
    {
        return view('admin.file-manager');
    }

}
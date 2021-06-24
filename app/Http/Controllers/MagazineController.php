<?php

namespace App\Http\Controllers;

use App\Models\Magazine;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;
use File;

class MagazineController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'issue_no' => 'required',
            'title' => 'required',
            'file' => 'required|mimes:pdf',
            'image' => 'required|mimes:jpeg,jpg,png,gif',
        ]);
        $slug = Str::slug($request->title);
        ini_set('memory_limit', '256M');

        //Image
        $image = $request->image;
        $image_name = time() . '_' . $image->getClientOriginalName() . '.' . $image->getClientOriginalExtension();
        $dir = public_path('files/magazines/cover');
        if (!file_exists($dir)) {
            File::makeDirectory($dir, 493, true);
        }
        $imgResize = Image::make($image->getRealPath())->resize(160, 200);
        $imgResize->save($dir . '/' . $image_name, 80);

        //file
        $file = $request->file('file');
        $filename = Carbon::now()->timestamp . '_' . $file->getClientOriginalName();
        $destinationPath = public_path() . '/files/magazines';
        $file->move($destinationPath, $filename);

        $magazine = Magazine::create([
            'issue_no' => $request->issue_no,
            'title' => $request->issue_no,
            'slug' => $slug,
            'file' => $filename,
            'image' =>  $image_name,
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Magazine  $magazine
     * @return \Illuminate\Http\Response
     */
    public function show($slug)
    {
        //$magazine = Magazine::whereSlug($slug)->first();
        $magazine = collect();

        return view('read', compact('magazine'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Magazine  $magazine
     * @return \Illuminate\Http\Response
     */
    public function edit(Magazine $magazine)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Magazine  $magazine
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Magazine $magazine)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Magazine  $magazine
     * @return \Illuminate\Http\Response
     */
    public function destroy(Magazine $magazine)
    {
        //
    }
}

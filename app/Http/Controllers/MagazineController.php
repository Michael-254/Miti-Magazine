<?php

namespace App\Http\Controllers;

use App\Models\Magazine;
use Brian2694\Toastr\Facades\Toastr;
use Delights\Sage\SageEvolution;
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
            'title' => 'required|unique:magazines,title',
            'file' => 'required|mimes:pdf',
            'image' => 'required|mimes:jpeg,jpg,png,gif',
        ]);
        $slug = Str::slug($request->title);
        ini_set('memory_limit', '256M');

        //Image
        $image = $request->image;
        $image_name = time() . '_' . $image->getClientOriginalName();
        $dir = public_path('files/magazines/cover');
        $imgResize = Image::make($image->getRealPath());
        $imgResize->save($dir . '/' . $image_name, 80);

        //file
        $file = $request->file('file');
        $filename = Carbon::now()->timestamp . '_' . $file->getClientOriginalName();
        $destinationPath = public_path() . '/files/magazines';
        $file->move($destinationPath, $filename);

        // check sage
        // $code = $request->item_code;
        // $sage = new SageEvolution();
        // $inventoryItemFind = $sage->getTransaction('InventoryItemFind?Code='.$code);
        // $response = json_decode($inventoryItemFind, true);

        $magazine = Magazine::updateOrCreate([
            'issue_no' => $request->issue_no,
        ],[
            'item_code' => $request->item_code,
            'title' => $request->title,
            'slug' => $slug,
            'file' => $filename,
            'image' =>  $image_name,
            'quantity' =>  $request->inventory,
            'created_at' => Carbon::now()->toDateString(),
        ]);

        return redirect('admin/file-manager')->with('message','Uploaded successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Magazine  $magazine
     * @return \Illuminate\Http\Response
     */
    public function show($slug)
    {
        $magazine = Magazine::whereSlug($slug)->first();

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

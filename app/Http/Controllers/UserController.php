<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function show()
    {
        return view('users.update-profile');
    }

    public function update(Request $request, User $user)
    {
        $request->validate([
            'name' => 'required',
            'country' => 'required',
        ]);

        $user->update([
            'name' => $request->name,
            'country' => $request->country,
            'gender' => $request->gender,
            'company' => $request->company,
        ]);

        Toastr::success('Updated successfully', 'Success');
        return back();
    }

    public function passwordChange()
    {
        return view('users.password-change');
    }

    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'password' => 'required|confirmed|min:8',
        ]);

        if (!Hash::check($request->current_password, auth()->user()->password)) {
            return back()->withErrors('Current password does not match!');
        }

        Toastr::success('Password updated', 'Success');
        return view('users.password-change');
    }
}

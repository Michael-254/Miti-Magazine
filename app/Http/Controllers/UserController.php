<?php

namespace App\Http\Controllers;

use App\Http\Requests\ChangePasswordRequest;
use App\Http\Requests\ProfileUpdateRequest;
use App\Models\User;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function show()
    {
        return view('users.update-profile');
    }

    public function update(ProfileUpdateRequest $request, User $user)
    {

        $user->update($request->validated());

        Toastr::success('Updated successfully', 'Success');
        return back();
    }

    public function passwordChange()
    {
        return view('users.password-change');
    }

    public function updatePassword(ChangePasswordRequest $request)
    {
        if (!Hash::check($request->current_password, auth()->user()->password)) {
            return back()->withErrors('Current password does not match!');
        }

        User::find(auth()->user()->id)->update(['password' => Hash::make($request->password)]);
        Toastr::success('Password updated', 'Success');
        return view('users.password-change');
    }
}

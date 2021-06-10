<?php

namespace App\Http\Controllers;

use App\Http\Requests\ChangePasswordRequest;
use App\Http\Requests\ProfileUpdateRequest;
use App\Models\Country;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function show()
    {
        $countries = Country::all();
        return view('users.update-profile', compact('countries'));
    }

    public function update(ProfileUpdateRequest $request, User $user)
    {

        $user->update($request->validated());
        return redirect('user/profile')->with('message','Updated successfully');
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
        return redirect('user/profile')->with('message','Password updated');
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;

class SocialiteController extends Controller
{

    public function redirect($key)
    {
        return Socialite::driver($key)->redirect();
    }

    public function callback($key)
    {
        $user = Socialite::driver($key)->stateless()->user();

        $findUser = User::where('email', $user->getEmail())->first();

        if ($findUser) {
            Auth::login($findUser);
        } else {
            $name = $user->getName();
            $email = $user->getEmail();
            $password = bcrypt('123456');

            $newUser = User::create([
                'name' => $name,
                'email' => $email,
                'password' => $password,
            ]);

            Auth::login($newUser);
        }

        return redirect('/user/profile');
    }
}

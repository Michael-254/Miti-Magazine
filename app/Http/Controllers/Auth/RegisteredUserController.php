<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Delights\Sage\SageEvolution;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('auth.register');
    }

    /**
     * Display the email prompt view.
     *
     * @return \Illuminate\View\View
     */
    public function email()
    {
        return view('auth.email-input');
    }
	
    private function getCustomerCode($names)
    {
        $name_array = explode(' ',trim($names));
        $firstWord = $name_array[0];
        $lastWord = $name_array[count($name_array)-1];
        $initials = $firstWord[0]."".$lastWord[0];

        $digits = 3;
        $code = str_pad(rand(0, pow(10, $digits)-1), $digits, '0', STR_PAD_LEFT);
        return $initials."".$code;
    }

    /**
     * Handle an incoming registration request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|confirmed|min:8',
        ]);

        $customerCode = "";
        $names = $request->name;
        $email = $request->email;
        
		$customerCode = $this->getCustomerCode($names);

		$user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

		$sage = new SageEvolution();
		$customerExists = $sage->getTransaction('CustomerExists?Code='.$customerCode);
		if($customerExists == "true") {
			$customerFind = $sage->getTransaction('CustomerFind?Code='.$customerCode);
			$response = json_decode($customerFind, true);
			if($response["Description"] != $names) {
				$customerCode = $this->getCustomerCode($names);
			
				$user->update(['customer_code' => $customerCode]);

				$customerInsert = $sage->postTransaction('CustomerInsert', (object)["client" => ["Active" => true, "Description" => $names, "ChargeTax" => true, "Code" => $customerCode]]);
			}
		}
		else {
			$customerInsert = $sage->postTransaction('CustomerInsert', (object)["client" => ["Active" => true, "Description" => $names, "ChargeTax" => true, "Code" => $customerCode]]);
		}

        event(new Registered($user));

        Auth::login($user);

        return redirect(RouteServiceProvider::HOME);
    }
}

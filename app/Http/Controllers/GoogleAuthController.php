<?php

namespace CachetHQ\Cachet\Http\Controllers;

use Socialite;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use CachetHQ\Cachet\Models\User;
use Illuminate\Support\Facades\Hash;


class GoogleAuthController extends Controller
{
    /**
     * Redirect the user to the GitHub authentication page.
     *
     * @return Response
     */
    public function redirectToProvider()
    {
        //return Socialite::driver('google')->with(['redirect_uri' => ''])->redirect();
        return Socialite::driver('google')->redirect();
    }

    /**
     * Obtain the user information from GitHub.
     *
     * @return Response
     */
    public function handleProviderCallback()
    {
        $user = Socialite::driver('google')->user();
        // $user->token;

        $domain =  config('services.google.domain');

        if ($domain){
            $email = $user->getEmail();
            $allowed = array($domain);
            $explodedEmail = explode('@', $email);
            $domain = array_pop($explodedEmail);
            if ( ! in_array($domain, $allowed))
            {
                echo "$email not allowed!";
                return;
            }
        }

        $hashed_random_password = Hash::make(str_random(8));

        // stroing data to our use table and logging them in
	$data = [
		'username' => $user->getEmail(),
		'email' => $user->getEmail(),
		'password' => $hashed_random_password,
                
	];
	    
	// Here, check if the user already exists in your records

	$my_user = User::where('email','=', $user->getEmail())->first();
	if($my_user === null) {
	    Auth::login(User::firstOrCreate($data));
	} else {
	    Auth::login($my_user);
	}
        return redirect('/');

    }
}

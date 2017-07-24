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
        echo "asking user details...";
        $user = Socialite::driver('google')->user();
        // $user->token;

        echo "passou user details..";
        $domain =  config('services.google.domain');


        echo "pegou domains..";
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

        echo "vai buscar user...";
	$my_user = User::where('email','=', $user->getEmail())->first();
	if($my_user === null) {
            echo "vai LOGAR criando...";
            return;
	    Auth::login(User::firstOrCreate($data));
            echo "logou criando...";
	} else {
            echo "vai logar sem criar..";
	    Auth::login($my_user);
            echo "logou sem criar..";
	}
        return redirect('/');

    }
}

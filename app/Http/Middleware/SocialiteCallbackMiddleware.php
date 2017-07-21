<?php

namespace App\Http\Middleware;

use Closure;

use Laravel\Socialite\Facades\Socialite;

class SocialiteCallbackMiddleware
{
	/**
	 * Handle an incoming request.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  \Closure  $next
	 * @param  string $providerDriver
	 *
	 * @return mixed
	 */
	public function handle($request, Closure $next, $providerDriver = 'google')
	{
		$socialite = Socialite::driver($providerDriver)->user();
		
		/**
		 * You can do whatever you want. All user's data are in $socialite.
		 * 
		 * Such as:
		 * $socialite->getId();
		 * $socialite->getEmail();
		 * $socialite->getName();
		 * $socialite->getAvatar();
		 * and etc.
		 */
		
		return $next($request);
	}
}

?>

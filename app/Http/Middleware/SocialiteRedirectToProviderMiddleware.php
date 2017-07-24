<?php

namespace CachetHQ\Cachet\Http\Middleware;

use Closure;

use Laravel\Socialite\Facades\Socialite;

class SocialiteRedirectToProviderMiddleware
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
		/**
		 * If user has signed in yet redirect him to somewhere.
		 */
                echo "AUTH checking";
		if (auth()->check()) {
                echo "AUTH checked";
			return $next($request);
		}
		
		/**
		 * Otherwise, redirect him to current socialite driver's authorization page.
		 */
		return Socialite::driver($providerDriver)->redirect();
		
	}
}

?>

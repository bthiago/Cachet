<?php

namespace CachetHQ\Cachet\Http\Routes;

use Illuminate\Contracts\Routing\Registrar;

class GoogleAuthRoutes
{
    /**
     * Define the status page routes.
     *
     * @param \Illuminate\Contracts\Routing\Registrar $router
     *
     * @return void
     */
    public function map(Registrar $router)
    {
        $router->group(['middleware' => ['web','ready', 'localize']], function (Registrar $router) {
            $router->get('/google','GoogleAuthController@redirectToProvider');
            $router->get('/google/callback', 'GoogleAuthController@handleProviderCallback');
        });
    }
}

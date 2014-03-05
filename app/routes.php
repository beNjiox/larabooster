<?php

/*
|--------------------------------------------------------------------------
| Filter classes
|--------------------------------------------------------------------------
|
| Registering of classes handling filters
|
*/

Route::filter('beforeRateLimit', 'Larabooster\Filters\RateLimitFilter@before');
Route::filter('afterRateLimit', 'Larabooster\Filters\RateLimitFilter@after');

/*
|--------------------------------------------------------------------------
| Routes
|--------------------------------------------------------------------------
|
| Registering of routes
|
*/


Route::get('/', function()
{
    return View::make('home');
});

Route::group(array('prefix' => 'api', 'before' => 'beforeRateLimit', 'after' => 'afterRateLimit'), function()
{

    $storages = [
        'mysql'    => [ 'repo' => 'Larabooster\Repositories\DbColorRepository' ],
        'memcache' => [ 'repo' => 'Larabooster\Repositories\MemcacheColorRepository' ],
        'redis'    => [ 'repo' => 'Larabooster\Repositories\RedisColorRepository' ]
     ];

    foreach ($storages as $kStorage => $vStorage)
    {
        Route::group(array('prefix' => $kStorage), function() use ($kStorage, $vStorage) {

            $repo       = new $vStorage['repo'];
            $controller = new ColorsController($repo, new Larabooster\Validators\ColorValidator($repo));

            Route::get("/", function() use ($controller) {
                return $controller->getAll();
            });
            Route::post("/", function() use ($controller) {
                return $controller->store();
            });
            Route::delete("/", function() use ($controller) {
                return $controller->delete();
            });

        });
    }
});
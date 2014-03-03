<?php

Route::get('/', function()
{
    return View::make('home');
});

Route::group(array('prefix' => 'api', 'before' => 'apiRateLimiter'), function()
{

    $storages = [
        'mysql'    => [ 'repo' => 'Larabooster\Repositories\DbColorRepository' ],
        'memcache' => [ 'repo' => 'Larabooster\Repositories\MemcacheColorRepository' ],
        'redis'    => [ 'repo' => 'Larabooster\Repositories\RedisColorRepository' ]
     ];

    foreach ($storages as $kStorage => $vStorage)
    {
        Route::group(array('prefix' => $kStorage), function() use ($kStorage, $vStorage) {

            $controller = new ColorsController(new $vStorage['repo']);

            Route::get("/", function() use ($controller) {
                return $controller->getAll(3);
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
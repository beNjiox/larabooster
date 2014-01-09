<?php

Route::get('/', function()
{
    return View::make('home');
});

Route::group(array('prefix' => 'api'), function()
{

    $storages = [
        'mysql'    => [ 'repo' => 'Larabooster\DbColorRepository' ],
        'memcache' => [ 'repo' => 'Larabooster\MemcacheColorRepository' ],
        'redis'    => [ 'repo' => 'Larabooster\RedisColorRepository' ]
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
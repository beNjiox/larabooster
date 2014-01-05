<?php

function is_hexadecimal($color)
{
    return preg_match('/^#[a-f0-9]{6}$/i', $color);
}

use Larabooster\DbColorRepository;
use Larabooster\MemcacheColorRepository;
use Larabooster\RedisColorRepository;

Route::get('/', function()
{    
    $MySQL_storage    = new ColorsController(new DbColorRepository);
    $memcache_storage = new ColorsController(new MemcacheColorRepository);
    $redis_storage    = new ColorsController(new RedisColorRepository);

    $mysql_colors    = $MySQL_storage->getAll();
    $memcache_colors = $memcache_storage->getAll();
    $redis_colors    = $redis_storage->getAll();

    $to_view = [
        'mysql_colors'    => $mysql_colors,
        'memcache_colors' => $memcache_colors,
        'redis_colors'    => $redis_colors
    ];

    return View::make('home')->with($to_view);
});

Route::group(array('prefix' => 'api'), function()
{
    Route::post('mysql', function() {
        $controller = new ColorsController(new DbColorRepository);
        return $controller->store();
    });

    Route::delete('mysql', function() {        
        $controller = new ColorsController(new DbColorRepository);
        return $controller->delete();
    });

    Route::post('memcache', function() {
        $controller = new ColorsController(new MemcacheColorRepository);
        return $controller->store();
    });

    Route::delete('memcache', function() {        
        $controller = new ColorsController(new MemcacheColorRepository);
        return $controller->delete();
    });

    Route::post('redis', function() {
        $controller = new ColorsController(new RedisColorRepository);
        return $controller->store();
    });

    Route::delete('redis', function() {        
        $controller = new ColorsController(new RedisColorRepository);
        return $controller->delete();
    });
});
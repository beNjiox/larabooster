<?php

function is_hexadecimal($color)
{
    return preg_match('/^#[a-f0-9]{6}$/i', $color);
}


// There is something wrong here
// the output from all these datastores are not consistent, find a elegant way to fix it
Route::get('/', function()
{    
    $mysql_colors    = Color::orderBy('id', 'desc')->get()->toArray();
    $memcache_colors = Cache::has('colors') ? Cache::get('colors') : [];
    foreach ($memcache_colors as $colors) {
        $memcache_colors['code'] = $colors;
    }

    $redis_colors    = Redis::smembers('colors');
    foreach ($redis_colors as $colors) {
        $redis_colors['code'] = $colors;
    }

    $to_view = [
        'mysql_colors'    => $mysql_colors,
        'memcache_colors' => $memcache_colors,
        'redis_colors'    => $redis_colors
    ];

    dd($to_view);

    return View::make('home')->with($to_view);
});

use Larabooster\DbColorRepository;
use Larabooster\MemcacheColorRepository;
use Larabooster\RedisColorRepository;

Route::group(array('prefix' => 'api'), function()
{
    Route::post('mysql/add', function() {        
        $controller = new ColorsController(new DbColorRepository);
        return $controller->store();
    });

    Route::post('memcache/add', function() {        
        $controller = new ColorsController(new MemcacheColorRepository);
        return $controller->store();
    });

    Route::post('redis/add', function() {        
        $controller = new ColorsController(new RedisColorRepository);
        return $controller->store();
    });
});
<?php namespace Larabooster;

use Larabooster\ColorRepositoryInterface;

class MemcacheColorRepository implements ColorRepositoryInterface
{
    public $whoami = "Memcache";

    public function add($code, $name)
    {
        if (\Cache::has('colors'))
        {
            $colors = \Cache::get('colors');
            $colors[$name] = $code;
            \Cache::forever('colors', $colors);
        }
        else
        {
            $colors = [ $code ];
            \Cache::forever('colors', $colors);                    
        }
        return true;
    }
} 
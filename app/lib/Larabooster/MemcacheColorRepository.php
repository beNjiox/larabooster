<?php namespace Larabooster;

use Larabooster\ColorRepositoryInterface;

class MemcacheColorRepository implements ColorRepositoryInterface
{
    public $whoami = "Memcache";

    public function exists($code)
    {
        if (!(\Cache::has('colors')))
            return false;
        $colors = \Cache::get('colors');
        return in_array($code, $colors);
    }

    public function add($code)
    {
        if (\Cache::has('colors'))
        {
            $colors             = \Cache::get('colors');
            $colors[] = $code;
            \Cache::forever('colors', $colors);
            \Cache::increment('nb_colors');
        }
        else
        {
            $colors = [ $code ];
            \Cache::forever('colors', $colors);
        }
        return true;
    }

    public function delete($code)
    {        
        if (!(\Cache::has('colors')))
            return false;
        $colors = \Cache::get('colors');
        $key = array_search($code, $colors);
        if (isset($colors[$key]))
        {
            \Log::info("Delete $key from memcache #2");
            unset($colors[$key]);
            \Cache::forever('colors', $colors);
        }
    }

    public function getAll($limit = 10)
    {
        $colors = [];
        if (\Cache::has('colors'))
        {
            $colors = \Cache::get('colors');
        }
        \Log::info(print_r($colors, true));
        return array_reverse($colors);
    }
} 
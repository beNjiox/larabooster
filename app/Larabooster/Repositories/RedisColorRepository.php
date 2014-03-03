<?php namespace Larabooster\Repositories;

use Larabooster\Repositories\ColorRepositoryInterface;

class RedisColorRepository implements ColorRepositoryInterface
{
    public $whoami = "Redis";

    public function exists($code)
    {
        /* http://redis.io/commands/SISMEMBER */
        return $colors = \Redis::sismember('colors', $code) == 1;
    }

    public function add($code)
    {
        \Redis::sadd('colors', $code);
        return true;
    }

    public function delete($code)
    {
        \Redis::srem('colors', $code);
        return true;
    }

    public function getAll($page, $rpp)
    {
        $redis_colors    = array_reverse(\Redis::smembers('colors'));
        return array_splice($redis_colors, $page * $rpp, $rpp);
    }

}
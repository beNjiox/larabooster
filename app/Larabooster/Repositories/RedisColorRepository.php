<?php namespace Larabooster\Repositories;

use Larabooster\Repositories\ColorRepositoryInterface;
use Redis;

class RedisColorRepository implements ColorRepositoryInterface
{
    public $whoami = "Redis";

    public function exists($code)
    {
        /* http://redis.io/commands/SISMEMBER */
        return $colors = Redis::sismember('colors', $code) == 1;
    }

    public function add($code)
    {
        Redis::sadd('colors', $code);
        return true;
    }

    public function delete($code)
    {
        Redis::srem('colors', $code);
        return true;
    }

    private function _getAll()
    {
      return Redis::smembers('colors');
    }

    public function getAll($page, $rpp)
    {
        $redis_colors    = array_reverse($this->_getAll());
        return array_splice($redis_colors, $page * $rpp, $rpp);
    }

    public function total()
    {
      return count($this->_getAll());
    }
}
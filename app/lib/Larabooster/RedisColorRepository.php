<?php namespace Larabooster;

use Larabooster\ColorRepositoryInterface;

class RedisColorRepository implements ColorRepositoryInterface
{
    public $whoami = "Redis";

    public function add($code, $name)
    {
        \Redis::sadd('colors', $code);
        return true;
    }
}
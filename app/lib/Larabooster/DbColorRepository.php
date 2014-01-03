<?php namespace Larabooster;

use Larabooster\ColorRepositoryInterface;

class DbColorRepository implements ColorRepositoryInterface 
{

    public $whoami = "MySQL";

    public function add($code, $name)
    {
        $color       = new \Color;
        $color->code = $code;
        $color->name = $name;
        return $color->save();
    }
} 

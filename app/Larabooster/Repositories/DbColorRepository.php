<?php namespace Larabooster\Repositories;

use Larabooster\Repositories\ColorRepositoryInterface;

class DbColorRepository implements ColorRepositoryInterface
{

    public $whoami = "MySQL";

    public function exists($code)
    {
        return \Color::where('code', $code)->count() > 0;
    }

    public function delete($code)
    {
        \Color::where('code', $code)->delete();
    }

    public function add($code)
    {
        $color       = new \Color;
        $color->code = $code;
        return $color->save();
    }

    public function getAll($limit = 10)
    {
      \Log::info(print_r("getAllDB", true));
      $colors_raw = \Color::orderBy('id', 'desc')->take($limit)->get()->toArray();
      $colors = [];
      foreach ($colors_raw as $color) {
          $colors[] = $color['code'];
      }
      return $colors;
    }
}

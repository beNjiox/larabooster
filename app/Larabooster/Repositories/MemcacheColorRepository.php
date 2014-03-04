<?php namespace Larabooster\Repositories;

use Larabooster\Repositories\ColorRepositoryInterface;
use Cache;

class MemcacheColorRepository implements ColorRepositoryInterface
{
    public $whoami = "Memcache";

    public function exists($code)
    {
        if (!(Cache::has('colors')))
            return false;
        $colors = Cache::get('colors');
        return in_array($code, $colors);
    }

    public function add($code)
    {
        if (Cache::has('colors'))
        {
            $colors             = Cache::get('colors');
            $colors[] = $code;
            Cache::forever('colors', $colors);
            Cache::increment('nb_colors');
        }
        else
        {
            $colors = [ $code ];
            Cache::forever('colors', $colors);
        }
        return true;
    }

    public function delete($code)
    {
        if (!(Cache::has('colors')))
            return false;
        $colors = Cache::get('colors');
        $key = array_search($code, $colors);
        if (isset($colors[$key]))
        {
            unset($colors[$key]);
            Cache::forever('colors', $colors);
        }
    }

    private function _getAll()
    {
      $colors = [];
      if (Cache::has('colors'))
      {
          $colors = Cache::get('colors');
      }
      return $colors;
    }

    public function getAll($page, $rpp)
    {
      $colors = $this->_getAll();
      $colors = array_reverse($colors);
      return array_splice($colors, $page * $rpp, $rpp);
    }

    public function total()
    {
      return count($this->_getAll());
    }
}
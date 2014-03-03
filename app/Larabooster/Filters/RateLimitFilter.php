<?php namespace Larabooster\Filters;

use Cache;
use Config;
use Response;

class RateLimitFilter
{
  protected function _getRequestPerHours()
  {
    return Config::get('app.API_RATE_LIMIT') ?: 1000;
  }

  protected function _getClientKey($request)
  {
    return sprintf("api:%s", $request->getClientIp());
  }

  public function after($route, $request, $response)
  {
    $request_per_hours    = $this->_getRequestPerHours();
    $client_key           = $this->_getClientKey($request);
    $request_already_done = 0;

    if (Cache::has($client_key)) $request_already_done = Cache::get($client_key);

    $response->header('X-Ratelimit-Limit', $request_per_hours);
    $response->header('X-Ratelimit-Remaining', $request_per_hours - $request_already_done);
  }

  public function before($route, $request)
  {
    $request_per_hours    = $this->_getRequestPerHours();
    $client_key           = $this->_getClientKey($request);
    $request_already_done = 0;

    if (Cache::has($client_key))
      $request_already_done = Cache::increment($client_key);
    else
      Cache::add($client_key, 0, 60);

    if ($request_already_done > $request_per_hours) return Response::json('Api Limit Exceeded', 403);
  }
}
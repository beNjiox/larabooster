<?php

/*
|--------------------------------------------------------------------------
| Application & Route Filters
|--------------------------------------------------------------------------
|
| Below you will find the "before" and "after" events for the application
| which may be used to do any work before or after a request into your
| application. Here you may also register your custom route filters.
|
*/

App::before(function($request)
{
});


App::after(function($request, $response)
{
});

/*
|--------------------------------------------------------------------------
| ApiRateLimiter Filter
|--------------------------------------------------------------------------
|
| This filter check if a particular user is not spamming the API
|
*/

Route::filter('apiRateLimiter', function($route, $request)
{
  $request_per_hours = \Config::get('app.API_RATE_LIMIT') ?: 20;
  $client_key = sprintf("api:%s", $request->getClientIp());
  Log::info(print_r($client_key, true));

  $request_already_done = 0;
  if (\Cache::has($client_key))
  {
    $request_already_done = \Cache::increment($client_key);
    Log::info(print_r(['request_already_done' => $request_already_done], true));
  }
  else
    \Cache::add($client_key, 0, 60);


  if ($request_already_done > $request_per_hours)
  {
    $headers = [
      'X-Ratelimit-Limit'     => $request_per_hours,
      'X-Ratelimit-Remaining' => $request_per_hours - $request_already_done
    ];

    $error = [
      'error' => 'Api limit exceeded.'
    ];

    return Response::json($error, 403, $headers);
  }

});

/*
|--------------------------------------------------------------------------
| Authentication Filters
|--------------------------------------------------------------------------
|
| The following filters are used to verify that the user of the current
| session is logged into this application. The "basic" filter easily
| integrates HTTP Basic authentication for quick, simple checking.
|
*/

Route::filter('auth', function()
{
	if (Auth::guest()) return Redirect::guest('login');
});


Route::filter('auth.basic', function()
{
	return Auth::basic();
});

/*
|--------------------------------------------------------------------------
| Guest Filter
|--------------------------------------------------------------------------
|
| The "guest" filter is the counterpart of the authentication filters as
| it simply checks that the current user is not logged in. A redirect
| response will be issued if they are, which you may freely change.
|
*/

Route::filter('guest', function()
{
	if (Auth::check()) return Redirect::to('/');
});

/*
|--------------------------------------------------------------------------
| CSRF Protection Filter
|--------------------------------------------------------------------------
|
| The CSRF filter is responsible for protecting your application against
| cross-site request forgery attacks. If this special token in a user
| session does not match the one given in this request, we'll bail.
|
*/

Route::filter('csrf', function()
{
	if (Session::token() != Input::get('_token'))
	{
		throw new Illuminate\Session\TokenMismatchException;
	}
});
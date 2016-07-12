<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Contracts\Auth\Guard;
use Session;
use Auth;
class Admin {

	/**
	 * The Guard implementation.
	 *
	 * @var Guard
	 */
	protected $auth;

	/**
	 * Create a new filter instance.
	 *
	 * @param  Guard  $auth
	 * @return void
	 */
	public function __construct(Guard $auth)
	{
		$this->auth = $auth;
	}

	/**
	 * Handle an incoming request.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  \Closure  $next
	 * @return mixed
	 */
	public function handle($request, Closure $next)
	{
		/*
		if ($this->auth->guest()) {
			if ($request->ajax()) {
				return response('Unauthorized.', 401);
			} else {
				return redirect()->guest('auth/login');
			}
		}
		*/
		
		/*
		if($this->auth->user()->access != 2){ //admin access
			if ($request->ajax()) {
				return response('Unauthorized.', 401);
			} else {
				return redirect()->guest('auth/login');
			}
		}
		*/
		if ( Auth::check() && Auth::user()->access == 2 )
		{
			return $next($request);
		}
		Session::flash('user-info', 'You have no rights');  //if user do not login
		return redirect()->guest('auth/login');
		//return $next($request);
	}
}
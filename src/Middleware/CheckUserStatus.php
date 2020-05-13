<?php

namespace LaraSnap\LaravelAdmin\Middleware;

use Closure;
use Auth;

class CheckUserStatus{
    public function handle($request, Closure $next){  
        if ($request->user()->status != 1) {
			Auth::logout(); //clear the authentication information from the user's session
            return redirect('/')->with('error','You account has been currently blocked. Please contact site administrator for more info.');
		}
		return $next($request);
    }
}	
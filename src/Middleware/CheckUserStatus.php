<?php

namespace LaraSnap\LaravelAdmin\Middleware;

use Closure;
use Auth;

class CheckUserStatus{
    public function handle($request, Closure $next){  
        if ($request->user()->status != 1) {
			Auth::logout(); //clear the authentication information from the user's session
            return redirect('/')->with('error','Your account has been currently inactive. Please contact site administrator for more info.');
		}
		return $next($request);
    }
}	
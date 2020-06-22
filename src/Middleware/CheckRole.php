<?php

namespace LaraSnap\LaravelAdmin\Middleware;

use Closure;
use Auth;

class CheckRole{
    public function handle($request, Closure $next){  
		$route = $request->route();
		
		// Get the route name from the route
        $routeName = $this->getRouteName($route); 
        // If route name is added to exculded action, bypass the screen based authentication
        $actions = $route->getAction();
        $excludeRoutes = isset($actions['exculde']) ? $actions['exculde'] : [];
        if(in_array($routeName, $excludeRoutes)){
           return $next($request); 
        }
		// Get the required roles for the route(screen)
		$screenRoles = $request->user()->getRequiredRoleForRoute($routeName);
		// Check if a role is required for the route, and if so, ensure that the user has that role.
        if ($request->user()->hasRole($screenRoles)) {
            return $next($request);
        }
		
		return redirect()->route('errors.401');
    }
	
	private function getRouteName($route){
		$routeName = $route->getName();
		return $routeName;
    }
	
	/*private function getRequiredRoleForRoute($route){
        $actions = $route->getAction();

        $routes = isset($actions['roles']) ? $actions['roles'] : null;
    }*/
}	
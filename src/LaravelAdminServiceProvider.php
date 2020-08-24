<?php

namespace LaraSnap\LaravelAdmin;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Validator;
use LaraSnap\LaravelAdmin\Commands\InstallCommand;
use LaraSnap\LaravelAdmin\Models\Screen;

class LaravelAdminServiceProvider extends ServiceProvider{
	
	public function register(){
		$this->mergeConfigFrom(__DIR__.'/../config/larasnap.php', 'larasnap');	
	}
	
	public function boot(){
		//$this->loadRoutesFrom(__DIR__.'/../routes/web.php'); //uncomment if the routes needs to be loaded from package
		$this->loadViewsFrom(__DIR__.'/../resources/views', 'larasnap');	
		$this->loadMigrationsFrom(__DIR__.'/../database/migrations');
		
		$router = $this->app['router'];
        $router->aliasMiddleware('check-userstatus', \LaraSnap\LaravelAdmin\Middleware\CheckUserStatus::class);
        $router->aliasMiddleware('check-roles', \LaraSnap\LaravelAdmin\Middleware\CheckRole::class);
		
		if ($this->app->runningInConsole()) {
			$this->registerPublishableResources();
            $this->registerConsoleCommands();
        }

        $this->bladeCanAccess();
        $this->bladeUserHasRole();
        $this->bladeShowData();
        
        $this->customValidationRule();
	}
	
	private function registerPublishableResources(){
        $publishablePath = __DIR__.'/../';

        $publishable = [
            'larasnap-config' => [
                "{$publishablePath}/config/larasnap.php" => config_path('larasnap.php'),
            ],
            'larasnap-assets' => [
                "{$publishablePath}/assets"              => public_path('vendor/larasnap'),
            ],
            'larasnap-seeds' => [
                "{$publishablePath}/database/seeds"      => database_path('seeds'),
            ],
            'larasnap-migrations' => [
                "{$publishablePath}/database/migrations" => database_path('migrations'),
            ],
            'larasnap-views' => [
                "{$publishablePath}/resources/views"     => resource_path('views/vendor/larasnap'),
            ],
            'larasnap-auth-login-controller' => [
                __DIR__."/Controllers/Publishable-7.x/7.10.3/Auth/LoginController.php"     => app_path('Http/Controllers/Auth/LoginController.php'),
            ],
            'larasnap-auth-reg-controller' => [
                __DIR__."/Controllers/Publishable-7.x/7.10.3/Auth/RegisterController.php"  => app_path('Http/Controllers/Auth/RegisterController.php'),
            ],
        ];

        foreach ($publishable as $group => $paths) {
            $this->publishes($paths, $group);
        }
    }
	
	private function registerConsoleCommands(){
		$this->commands(InstallCommand::class);
	}

	private function bladeCanAccess(){
        Blade::if('canAccess', function ($screen_name) {
            // Get the required roles for the route(screen)
            $screenRoles = auth()->user()->getRequiredRoleForRoute($screen_name);
            // Check if a role is required for the route, and if so, ensure that the user has that role.
            if (auth()->user()->hasRole($screenRoles)) {
                return TRUE;
            }else{
                return FALSE;
            }
        });
        Blade::if('canAccessCategory', function ($screen_name) {
            $currentRoute = \Route::current();
            $parentCategoryID = $currentRoute->parameters['p_category'];
            $newScreenName = $screen_name .'.'. $parentCategoryID;
            //Check if new screen added on the DB    
            $isNewScreenExists = Screen::where('name', $newScreenName)->exists();
            if($isNewScreenExists){
                // Get the required roles for the route(new screen)
                $screenRoles = auth()->user()->getRequiredRoleForRoute($newScreenName);
            }else{
                // Get the required roles for the route(screen - argument passed)
                $screenRoles = auth()->user()->getRequiredRoleForRoute($screen_name);
            }
            // Check if a role is required for the route, and if so, ensure that the user has that role.
            if (auth()->user()->hasRole($screenRoles)) {
                return TRUE;
            }else{
                return FALSE;
            }
        });
    }
    
    private function bladeUserHasRole(){
        Blade::if('userHasRole', function ($roleName) {
            return userHasRole($roleName);
        });
    }
	
	private function bladeShowData(){
        Blade::if('showData', function ($module, $name) {
            return !restrictData($module, $name);
        });
    }
    
    private function customValidationRule(){
       Validator::extend('alpha_spaces', function ($attribute, $value) {
            return preg_match('/^[\pL\s]+$/u', $value);
        }, 'The :attribute may only contain letters & spaces.');
        
        Validator::extend('alpha_spaces_hyphens', function ($attribute, $value) {
            return preg_match('/^[\pL\s-]+$/u', $value);
        }, 'The :attribute may only contain letters, spaces & hyphens.');
    }
}
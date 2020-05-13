<?php

namespace LaraSnap\LaravelAdmin\Commands;

use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;
use LaraSnap\LaravelAdmin\LaravelAdminServiceProvider;

class InstallCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'larasnap:admin-install 
                                {--config : Publish LaraSnap Config} 
                                {--assets : Publish LaraSnap Assets}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Install the LaraSnap Admin Package';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle(Filesystem $filesystem){
       $config =  $this->option('config');
       $assets =  $this->option('assets');

		if($config){
			$this->handleConfig();
		}elseif($assets){
			$this->handleAssets();
		}else{
			$this->handleDefault($filesystem);
		}
    }
	
	public function handleDefault($filesystem){
		$this->comment('Please note: LaraSnap requires fresh Laravel installation!');
        $this->info('Starting installation process of LaraSnap...');
		$this->copyInitial();
		if(config('larasnap.admin_install.publish_config')){		
			$this->info('Publishing config ....');
			$this->publishConfig();
		}
		if(config('larasnap.admin_install.publish_views')){		
			$this->info('Publishing views to resource\views\vendor\larasnap ...');
			$this->publishViews();
		}
		if(config('larasnap.admin_install.publish_assets')){			
			$this->info('Publishing assets to public\vendor\larasnap ....');
			$this->publishAssets();
		}
		if(config('larasnap.admin_install.add_routes')){		
			$this->info('Adding LaraSnap routes to routes\web.php');
			$this->copyRoutes($filesystem);
		}
        $this->info('');
        $this->info('Installation was successful.');
	}
	
	public function handleConfig(){
		$this->info('Publishing config ....');
		$this->publishConfig();
		$this->info('Config published successfully!');
	}
	
	public function handleAssets(){
		$this->info('Publishing assets ....');
		$this->publishAssets();
		$this->info('Assets published successfully!');		
	}
	
	public function copyInitial(){
        //Migrations, Seeds
        if(config('larasnap.admin_install.publish_migrations_seeds')){	
            $this->info('Publishing Migrations & Seeds Files ...');
            $this->callSilent('vendor:publish', ['--provider' => LaravelAdminServiceProvider::class, '--tag' => 'larasnap-migrations', '--force' => true]);
            $this->callSilent('vendor:publish', ['--provider' => LaravelAdminServiceProvider::class, '--tag' => 'larasnap-seeds', '--force' => true]);
        }
        //Auth - Login
        if(config('larasnap.admin_install.publish_auth_login_controller')){	
            $this->info('Publishing Auth/LoginController ...');
            $this->callSilent('vendor:publish', ['--provider' => LaravelAdminServiceProvider::class, '--tag' => 'larasnap-auth-login-controller', '--force' => true]);
        }
        //Auth - Register
        if(config('larasnap.admin_install.publish_auth_registeration_controller')){	
            $this->info('Publishing Auth/RegisterController ...');
            $this->callSilent('vendor:publish', ['--provider' => LaravelAdminServiceProvider::class, '--tag' => 'larasnap-auth-reg-controller', '--force' => true]);
        }
	}
	
	public function publishConfig(){
		$this->callSilent('vendor:publish', ['--provider' => LaravelAdminServiceProvider::class, '--tag' => 'larasnap-config', '--force' => true]);
	}
	
	public function publishViews(){
		$this->callSilent('vendor:publish', ['--provider' => LaravelAdminServiceProvider::class, '--tag' => 'larasnap-views', '--force' => true]);
	}
	
	public function publishAssets(){
		$this->callSilent('vendor:publish', ['--provider' => LaravelAdminServiceProvider::class, '--tag' => 'larasnap-assets', '--force' => true]);
	}
	
	public function copyRoutes($filesystem){
		/*$routesContents = $filesystem->get(base_path('routes/web.php'));
          $filesystem->append(
                base_path('routes/web.php'),
                "\n\nRoute::group(['prefix' => 'admin'], function () {\n    \n});\n"
            );*/
            $routePath = __DIR__.'/../../routes/web-publish.txt'; 
            $routesContents = $filesystem->get($routePath);
            $filesystem->append(
                base_path('routes/web.php'),$routesContents);
	}
}

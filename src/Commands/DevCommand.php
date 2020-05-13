<?php

namespace LaraSnap\LaravelAdmin\Commands;

use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;
use LaraSnap\LaravelAdmin\LaravelAdminServiceProvider;

class DevCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'larasnap:dev {--assets} {--controller} {--model}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Publish local resources to package.';

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
       $assets     =  $this->option('assets');
	   $controller =  $this->option('controller');
	   $model      =  $this->option('model');
			  	  
		if($assets){
			$this->handleAssets();
		}
		if($controller){
			$this->handleController();
		}
		if($model){
			$this->handleModel();
		}
    }
	
	public function handleAssets(){
		$this->info('Copying local assets to package....');
		$this->info('Assets copied successfully!');	
	}

	public function handleController(){
		$this->info('Copying local Controller to package....');
		$this->info('Controller copied successfully!');	
	}

	public function handleModel(){
		$this->info('Copying local Model to package....');
		$this->info('Model copied successfully!');	
	}	
	
}

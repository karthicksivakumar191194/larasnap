<?php

namespace LaraSnap\LaravelAdmin\Models;

use LaraSnap\LaravelAdmin\Models\BaseModel;
use LaraSnap\LaravelAdmin\Traits\Filter;

class Menu extends BaseModel
{
    use Filter;

    //Eloquent models also contain a static boot method, which may provide a convenient place to register your event bindings.
    public static function boot()
    {
        parent::boot();

        //saved - model events
        static::saved(function ($model) {
            $model->removeMenuFromCache();
        });

        static::deleted(function ($model) {
            $model->removeMenuFromCache();
        });
    }

    public function items(){
        return $this->hasMany('LaraSnap\LaravelAdmin\Models\MenuItem');
    }

    public function parentItems(){
        return $this->hasMany('LaraSnap\LaravelAdmin\Models\MenuItem')->whereNull('parent_id');
    }
	
	 /**
     * Display menu.
     */
	 public function display($menuName, $type=null, $design = null){
	     //If the menu does not exist in the cache, the Closure passed to the remember method will be executed and its result will be placed in the cache.
         $menu = \Cache::remember('larasnap_menu_'.$menuName, \Carbon\Carbon::now()->addDays(30), function () use ($menuName) {
             return $this->where('name', '=', $menuName)
                 ->with(['parentItems.children' => function ($q) {
                     $q->orderBy('order');
                 }])->first();
         });

		 // Check for Menu Existence
         if (!isset($menu)) {
            return false;
        }
				
		$items = $menu->parentItems->sortBy('order'); 		

		if ($type == 'admin') {
            $blade = 'larasnap::menus.template.'.$type;
        } else {
            if (is_null($type)) {
                $blade = 'larasnap::menus.template.default';
			}elseif(!view()->exists('larasnap::menus.template.'.$type)){
                $blade = 'larasnap::menus.template.default';
            }else{
                $blade = 'larasnap::menus.template.'.$type;
            }
		}	

		 return new \Illuminate\Support\HtmlString(
            \Illuminate\Support\Facades\View::make($blade, ['items' => $items])->render()
        );	
					
	}

    public function removeMenuFromCache(){
        \Cache::forget('larasnap_menu_'.$this->name);
    }
	 
}

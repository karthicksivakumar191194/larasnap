<?php

namespace LaraSnap\LaravelAdmin\Models;

use LaraSnap\LaravelAdmin\Models\BaseModel;
use Illuminate\Support\Facades\Route;

class MenuItem extends BaseModel
{
    public static function boot()
    {
        parent::boot();

        static::created(function ($model) {
            $model->menu->removeMenuFromCache();
        });

        static::saved(function ($model) {
            $model->menu->removeMenuFromCache();
        });

        static::deleted(function ($model) {
            $model->menu->removeMenuFromCache();
        });
    }

    public function children(){
			return $this->hasMany('LaraSnap\LaravelAdmin\Models\MenuItem', 'parent_id')
				->with('children')
				->orderBy('order');
    }

    public function menu()
    {
        return $this->belongsTo('LaraSnap\LaravelAdmin\Models\Menu');
    }

    public function link($absolute = false){
        return $this->prepareLink($absolute, $this->route, $this->route_parameter, $this->url);
    }

    protected function prepareLink($absolute, $route, $parameters, $url){
        //json format eg - {"menu": 1}
        if (is_null($parameters)) {
            $parameters = [];
        }

        if (is_string($parameters)) {
            $parameters = json_decode($parameters, true);
        } elseif (is_array($parameters)) {
            $parameters = $parameters;
        } elseif (is_object($parameters)) {
            $parameters = json_decode(json_encode($parameters), true);
        }

        if (!is_null($route)) {
            if (!Route::has($route)) {
                return '#';
            }

            return route($route, $parameters, $absolute);
        }

        if ($absolute) {
            return url($url);
        }

        if (!is_null($url)) {
            return $url;
        }

        return '#';
    }

    public function getRouteParameterAttribute()
    {
        return json_decode($this->attributes['route_parameter']);
    }

    public function setRouteParameterAttribute($value)
    {
        if (is_array($value)) {
            $value = json_encode($value);
        }

        $this->attributes['route_parameter'] = $value;
    }
}

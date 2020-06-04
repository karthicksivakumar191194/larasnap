<?php

namespace LaraSnap\LaravelAdmin\Models;

use LaraSnap\LaravelAdmin\Models\BaseModel;
use LaraSnap\LaravelAdmin\Models\Role;
use LaraSnap\LaravelAdmin\Models\Module;
use LaraSnap\LaravelAdmin\Traits\Filter;

class Screen extends BaseModel
{
    use Filter;

    public function roles(){
		return $this->belongsToMany(Role::class, 'role_screen');
	}

    public function assignRole($role){
        return $this->roles()->save(Role::whereId($role)->firstOrFail());
    }
    
    public function module(){
		return $this->belongsTo(Module::class);
	}
}

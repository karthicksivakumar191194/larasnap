<?php

namespace LaraSnap\LaravelAdmin\Models;

use LaraSnap\LaravelAdmin\Models\BaseModel;
use LaraSnap\LaravelAdmin\Models\Permission;
use LaraSnap\LaravelAdmin\Models\Screen;
use LaraSnap\LaravelAdmin\Traits\Filter;

class Role extends BaseModel
{
    use Filter;

    public function permissions(){
        return $this->belongsToMany(Permission::class, 'permission_role');
    }

    public function assignPermission($permission){
        return $this->permissions()->save(Permission::whereId($permission)->firstOrFail());
    }

    public function screens(){
        return $this->belongsToMany(Screen::class, 'role_screen');
    }

    public function assignScreen($screen){
        return $this->screens()->save(Screen::whereId($screen)->firstOrFail());
    }
}

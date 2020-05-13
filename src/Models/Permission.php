<?php

namespace LaraSnap\LaravelAdmin\Models;

use LaraSnap\LaravelAdmin\Models\BaseModel;
use LaraSnap\LaravelAdmin\Models\Role;
use LaraSnap\LaravelAdmin\Traits\Filter;

class Permission extends BaseModel
{
    use Filter;

    public function roles(){
        return $this->belongsToMany(Role::class, 'permission_role');
    }
}

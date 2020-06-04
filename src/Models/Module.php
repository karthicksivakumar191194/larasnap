<?php

namespace LaraSnap\LaravelAdmin\Models;

use LaraSnap\LaravelAdmin\Models\BaseModel;
use LaraSnap\LaravelAdmin\Models\Screen;
use LaraSnap\LaravelAdmin\Traits\Filter;

class Module extends BaseModel
{
    use Filter;
    
    public function screens(){
        return $this->hasMany(Screen::class);
    }
}

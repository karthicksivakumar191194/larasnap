<?php

namespace LaraSnap\LaravelAdmin\Models;

use LaraSnap\LaravelAdmin\Models\BaseModel;
use LaraSnap\LaravelAdmin\Traits\Filter;

class Category extends BaseModel
{
    use Filter;

    public function parentCategory(){
        return $this->belongsTo('LaraSnap\LaravelAdmin\Models\Category', 'parent_category_id'); 
    }
    
    public function childCategory(){
        return $this->hasMany('LaraSnap\LaravelAdmin\Models\Category', 'parent_category_id'); 
    }
}

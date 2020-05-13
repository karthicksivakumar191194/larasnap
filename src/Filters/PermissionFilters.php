<?php
namespace LaraSnap\LaravelAdmin\Filters;

use Carbon\Carbon;
use DB;

class PermissionFilters extends Filters
{
    public function search($term = '') {
        if($term != '') {
            return $this->builder->where('label', 'LIKE', "%$term%");
        }
    }

}
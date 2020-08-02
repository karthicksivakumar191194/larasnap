<?php
namespace LaraSnap\LaravelAdmin\Filters;

use Carbon\Carbon;
use DB;

class UserFilters extends Filters
{
    public function sort_by($type){
        return $this->builder->orderBy('id', (!$type || $type == 'latestfirst') ? 'desc' : 'asc');
    }

    public function user_role($term){
        if($term != 'all'){
            if($term == 'no_role'){
                return $this->builder->doesntHave('roles');
            }else{
                return $this->builder->whereHas('roles', function ($query) use ($term) {
                    return $query->where('roles.id', $term);
                });
            }
        }
    }

    public function user_status($term){
        if($term != 'all'){
            return $this->builder->where('status', $term);
        }
    }

    public function search($term = '') {
        if($term != '') {
            return $this->builder->whereHas('userProfile', function ($query) use ($term) {
                return $query->where('first_name', 'LIKE', "%$term%")->orWhere('last_name', 'LIKE', "%$term%")->orWhere(DB::raw('CONCAT_WS(" ", first_name, last_name)'), 'like', "%$term%");
            });
        }
    }

}
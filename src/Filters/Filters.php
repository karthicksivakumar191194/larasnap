<?php
namespace LaraSnap\LaravelAdmin\Filters;

use Illuminate\Database\Eloquent\Builder;

class Filters
{
    protected $builder;

    public function apply(Builder $builder, $filter_request)
    {
        $this->builder = $builder;
        //on every loop, returns a query builder instance
        foreach ($filter_request as $name => $value) {
            if ( ! method_exists($this, $name)) {
                continue;
            }
            if (strlen($value)) {
                $this->$name($value);
            } else {
                $this->$name();
            }
        }
        return $this->builder;
    }
}
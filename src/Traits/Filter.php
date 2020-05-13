<?php

namespace LaraSnap\LaravelAdmin\Traits;

use Illuminate\Database\Eloquent\Builder;
use LaraSnap\LaravelAdmin\Filters\Filters;

trait Filter
{
    /**
     * Dynamic Scope - Scope a query to only include users of a given filter.
     *
     * @param  instance of \Illuminate\Database\Eloquent\Builder  $query
     * @param  Filters $filters - Needs to inherit \LaraSnap\LaravelAdmin\Filters\Filters, to make the parameter($filters) strictly accept only the child class of Filters we adding as 'Filters $filters'.
     * @param filter request values
     * @return \Illuminate\Database\Eloquent\Builder - return a query builder instance.
     */

    public function scopeFilter($query, Filters $filters, $filter_request)
    {
        return $filters->apply($query, $filter_request);
    }
}
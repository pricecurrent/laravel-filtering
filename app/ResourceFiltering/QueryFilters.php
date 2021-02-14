<?php

namespace App\ResourceFiltering;

use Illuminate\Support\Collection;
use Illuminate\Database\Eloquent\Builder;
use App\ResourceFiltering\ChecksShouldRun;
use App\ResourceFiltering\QueryFilterContract;

class QueryFilters extends Collection
{
    public function apply(Builder $query)
    {
        $this
            ->filter(function (QueryFilterContract $filter) {
                if ($filter instanceof ChecksShouldRun) {
                    return $filter->shouldRun();
                }

                return true;
            })
            ->each(function (QueryFilterContract $filter) use ($query) {
                $filter->apply($query);
            });
    }
}

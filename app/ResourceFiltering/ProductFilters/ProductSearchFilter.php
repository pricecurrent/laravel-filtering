<?php

namespace App\ResourceFiltering\ProductFilters;

use App\ResourceFiltering\ChecksShouldRun;
use App\ResourceFiltering\QueryFilterContract;

class ProductSearchFilter implements QueryFilterContract, ChecksShouldRun
{
    protected $value;

    public function __construct($value)
    {
        $this->value = $value;
    }

    public function apply($query)
    {
        $query->where('name', 'like', "%{$this->value}%");
    }

    public function shouldRun()
    {
        return (bool) $this->value;
    }
}

<?php

namespace App\ResourceFiltering\ProductFilters;

use App\ResourceFiltering\QueryFilterContract;

class ProductPriceRangeFilter implements QueryFilterContract
{
    protected $minPrice;
    protected $maxPrice;

    public function __construct($minPrice, $maxPrice)
    {
        $this->minPrice = $minPrice;
        $this->maxPrice = $maxPrice;
    }

    public function apply($query)
    {
        $query
            ->when($this->minPrice, function ($query) {
                $query->where('price', '>=', $this->minPrice);
            })
            ->when($this->maxPrice, function ($query) {
                $query->where('price', '<=', $this->maxPrice);
            });
    }
}

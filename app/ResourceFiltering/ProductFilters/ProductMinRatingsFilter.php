<?php

namespace App\ResourceFiltering\ProductFilters;

use App\Models\Rating;
use App\ResourceFiltering\QueryFilterContract;

class ProductMinRatingsFilter implements QueryFilterContract
{
    protected $value;

    public function __construct($value)
    {
        $this->value = $value;
    }

    public function apply($query)
    {
        if (! $this->value) {
            return;
        }
        $query->addSelect(['average_ratings' => Rating::query()
            ->selectRaw("AVG(`ratings`.`score`)")
            ->whereColumn('ratings.product_id', 'products.id')
            ->groupBy('ratings.product_id')
        ])
        ->having('average_ratings', '>=', $this->value);
    }
}

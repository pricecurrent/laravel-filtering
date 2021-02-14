<?php

namespace App\ResourceFiltering\ProductFilters;

use App\ResourceFiltering\QueryFilters;
use App\ResourceFiltering\ProductFilters\ProductSearchFilter;
use App\ResourceFiltering\ProductFilters\ProductMinRatingsFilter;
use App\ResourceFiltering\ProductFilters\ProductPriceRangeFilter;

class ProuctFiltersPreset
{
    public function getForMarketingMenu($request)
    {
        return new QueryFilters([
            new ProductSearchFilter($request->search),
            new ProductMinRatingsFilter($request->min_rating),
            new ProductPriceRangeFilter($request->min_price * 100, $request->max_price * 100),
        ]);
    }

    public function getForAdmin($request)
    {
        return new QueryFilters([
            new ProductSearchFilter($request->search),
            new ProductMinRatingsFilter($request->min_rating),
            new ProductPriceRangeFilter($request->min_price * 100, $request->max_price * 100),
        ]);
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Rating;
use App\Models\Product;
use Illuminate\Http\Request;
use App\ResourceFiltering\QueryFilters;
use App\ResourceFiltering\ProductFilters\ProductSearchFilter;
use App\ResourceFiltering\ProductFilters\ProuctFiltersPreset;
use App\ResourceFiltering\ProductFilters\ProductMinRatingsFilter;
use App\ResourceFiltering\ProductFilters\ProductPriceRangeFilter;

class ProductsController
{
    public function index(Request $request, ProuctFiltersPreset $preset)
    {
        $products = Product::filter($preset->getForMarketingMenu($request))->get();

        return response()->json(['data' => $products]);
    }
}

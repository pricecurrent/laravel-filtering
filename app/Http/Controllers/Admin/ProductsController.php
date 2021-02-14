<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\ResourceFiltering\ProductFilters\ProuctFiltersPreset;

class ProductsController
{
    public function index(Request $request, ProuctFiltersPreset $preset)
    {
        $products = Product::filter($preset->getForAdmin($request))->get();

        return response()->json(['data' => $products]);
    }
}

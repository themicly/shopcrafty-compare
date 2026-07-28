<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Themicly\Shopcrafty\Compare\Services\CompareService;

Route::get('/compare', function () {
    abort_unless((bool) settings('catalog.compare_enabled', true), 404);
    return view('compare::compare');
})->name('storefront.compare');

Route::post('/compare/toggle', function (Request $request, CompareService $compare) {
    abort_unless((bool) settings('catalog.compare_enabled', true), 404);
    $productId = (int) $request->integer('product_id');
    abort_unless($productId > 0, 422);

    return response()->json($compare->toggle($productId));
})->name('storefront.compare.toggle');

// Storefront routes for the Compare add-on.

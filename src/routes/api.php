<?php
use \Illuminate\Support\Facades\Route;

Route::prefix("api")->group(function () {
    Route::post("/aws/resolve", [\Shei\AwsMarketplaceTools\Controllers\AwsMarketplaceController::class, "resolveCustomer"]);
});

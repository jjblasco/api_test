<?php

use App\Http\Controllers\ParentsesisController;
use App\Http\Controllers\ShortUrlController;
use App\Http\Middleware\ValidateBearerToken;
use Illuminate\Support\Facades\Route;

Route::middleware([ValidateBearerToken::class])->group(function () {
    Route::post('/v1/short-urls', [ShortUrlController::class, 'getJson']);
    Route::post('check-order', [ParentsesisController::class, 'checkOrder']);
});

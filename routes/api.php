<?php

use App\Http\Controllers\ShortUrlController;
use App\Http\Middleware\ValidateBearerToken;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::post('/v1/short-urls', [ShortUrlController::class, 'getJson'])
        ->middleware([ValidateBearerToken::class]);

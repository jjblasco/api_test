<?php

use App\Http\Controllers\ShortUrlController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::post('/v1/short-urls', [ShortUrlController::class, 'getJson']);

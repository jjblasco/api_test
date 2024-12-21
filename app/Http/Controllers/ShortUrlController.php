<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class ShortUrlController extends Controller
{
    public function getJson(Request $request)
    {
        try {
            $validated = $request->validate([
                'url' => 'required|string',
            ],[
                'url.required' => 'la URL es requerida',
                'url.string' => 'la URL debe ser un texto'
            ]);

            return response()->json($validated);
        } catch (ValidationException $e) {
            return response()->json([
                'errors' => $e->errors(),
            ], 422);
        }
    }
}

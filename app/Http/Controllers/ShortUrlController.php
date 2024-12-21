<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Http;

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

            $url = $validated['url'];

            $response = Http::get('https://tinyurl.com/api-create.php', [
                'url' => $url
            ]);

            return response()->json([
                'url' => $response->body(),
            ]);

        } catch (ValidationException $e) {
            return response()->json([
                'errors' => $e->errors(),
            ], 422);
        }
    }
}

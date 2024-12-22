<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use App\Services\UrlShortenerService;

class ShortUrlController extends Controller
{

    private UrlShortenerService $urlShortenerService;

    public function __construct(UrlShortenerService $urlShortenerService)
    {
        $this->urlShortenerService = $urlShortenerService;
    }

    public function getJson(Request $request)
    {
        $token = $request->bearerToken();

        try {
            $validated = $request->validate([
                'url' => 'required|string|url',
            ],[
                'url.required' => 'la URL es requerida',
                'url.string' => 'la URL debe ser un texto',
                'url.url' => 'La URL debe tener un formato válido.',
            ]);

            $url = $validated['url'];

            $response = $this->urlShortenerService->shortByTiny($url);

            return response()->json([
                'url' => $response,
            ]);

        } catch (ValidationException $e) {
            return response()->json([
                'errors' => $e->errors(),
            ], 422);
        }
    }
}

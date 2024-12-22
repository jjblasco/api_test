<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use App\Services\UrlShortenerService;

/**
 * @OA\Info(title="API de Paréntesis y URL Shortener", version="1.0")
 * @OA\SecurityScheme(
 *     securityScheme="bearerAuth",
 *     type="http",
 *     scheme="bearer",
 *     bearerFormat="JWT",
 * )
 */

class ShortUrlController extends Controller
{

    private UrlShortenerService $urlShortenerService;

    public function __construct(UrlShortenerService $urlShortenerService)
    {
        $this->urlShortenerService = $urlShortenerService;
    }

    /**
     * @OA\Post(
     *     path="/api/v1/short-urls",
     *     tags={"Acortador de URL"},
     *     summary="Acorta una URL usando TinyURL",
     *     description="Este endpoint acorta una URL proporcionada utilizando el servicio de TinyURL.",
     *     operationId="shortenUrl",
     *     security={{"bearerAuth":{}}},
     *     @OA\RequestBody(
     *         required=true,
     *         description="URL a acortar",
     *         @OA\JsonContent(
     *             required={"url"},
     *             @OA\Property(property="url", type="string", example="https://www.example.com")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="La URL fue acortada con éxito",
     *         @OA\JsonContent(
     *             @OA\Property(property="url", type="string", example="https://tinyurl.com/xyz123")
     *         )
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Error al procesar la URL",
     *         @OA\JsonContent(
     *             @OA\Property(property="error", type="string", example="Error al acortar la URL.")
     *         )
     *     )
     * )
     */

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

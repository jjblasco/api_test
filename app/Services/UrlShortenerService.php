<?php
namespace App\Services;

use Illuminate\Support\Facades\Http;

class UrlShortenerService
{
    public function shortByTiny(string $url): string
    {
        $response = Http::get('https://tinyurl.com/api-create.php', [
            'url' => $url,
        ]);

        if ($response->successful()) {
            return $response->body();
        }

        throw new \Exception('No se pudo acortar la URL. Intenta nuevamente más tarde.');
    }
}

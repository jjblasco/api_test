<?php

return [
    'swagger' => [
        'title' => 'API de Paréntesis y URL Shortener',
        'description' => 'API para validar cadenas de paréntesis y acortar URLs',
        'version' => '1.0.0',
        'paths' => [
            base_path('app/Http/Controllers/ParenthesesController.php'),
            base_path('app/Http/Controllers/UrlShortenerController.php'),
        ],
        'securityDefinitions' => [
            'bearerAuth' => [
                'type' => 'http',
                'scheme' => 'bearer',
                'bearerFormat' => 'JWT',
            ],
        ],
    ]
];

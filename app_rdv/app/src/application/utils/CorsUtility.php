<?php

namespace toubeelib\application\utils;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class CorsUtility
{
    public static function handle($request, $response, $data) {
        $response = $response->withHeader('Access-Control-Allow-Origin', '*')
                             ->withHeader('Access-Control-Allow-Methods', 'GET, POST, OPTIONS')
                             ->withHeader('Access-Control-Allow-Headers', 'Content-Type, Authorization')
                             ->withHeader('Content-Type', 'application/json');

        if ($request->getMethod() === 'OPTIONS') {
            return $response->withStatus(204);
        }

        $responseContentJson = json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
        $response->getBody()->write($responseContentJson);

        return $response;
    }
}
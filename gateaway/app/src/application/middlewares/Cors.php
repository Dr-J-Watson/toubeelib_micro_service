<?php

namespace gateway\application\middlewares;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Server\RequestHandlerInterface as RequestHandler;
use Slim\Psr7\Factory\ResponseFactory;

class Cors
{
    public function __invoke(Request $rq, RequestHandler $next): Response {
        if (! $rq->hasHeader('Origin')) {
            $responseFactory = new ResponseFactory();
            $response = $responseFactory->createResponse(401);
            $response->getBody()->write(json_encode(['error' => 'missing Origin Header (cors)']));
            return $response->withHeader('Content-Type', 'application/json');
        }
        $response = $next->handle($rq);
        $response = $response
            ->withHeader('Access-Control-Allow-Origin', $rq->getHeader('Origin'))
            ->withHeader('Access-Control-Allow-Methods', 'POST, PUT, GET' )
            ->withHeader('Access-Control-Allow-Headers','Authorization' )
            ->withHeader('Access-Control-Max-Age', 3600)
            ->withHeader('Access-Control-Allow-Credentials', 'true');
        return $response;
    }
}
<?php

namespace gateway\application\middlewares;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Server\RequestHandlerInterface as RequestHandler;
use Slim\Psr7\Factory\ResponseFactory;

class Cors
{
    public function __invoke(Request $rq, RequestHandler $next): Response {
        $origin = $rq->getHeader('Origin');
        $origin = !empty($origin) ? $origin[0] : '*';

        if ($rq->getMethod() === 'OPTIONS') {
            $responseFactory = new ResponseFactory();
            $response = $responseFactory->createResponse(204);
            return $response
                ->withHeader('Access-Control-Allow-Origin', $origin)
                ->withHeader('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, OPTIONS')
                ->withHeader('Access-Control-Allow-Headers', 'Authorization, Content-Type, X-Requested-With')
                ->withHeader('Access-Control-Max-Age', '3600')
                ->withHeader('Access-Control-Allow-Credentials', 'true');
        }

        $response = $next->handle($rq);

        return $response
            ->withHeader('Access-Control-Allow-Origin', $origin)
            ->withHeader('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, OPTIONS')
            ->withHeader('Access-Control-Allow-Headers', 'Authorization, Content-Type, X-Requested-With')
            ->withHeader('Access-Control-Allow-Credentials', 'true');
    }
}
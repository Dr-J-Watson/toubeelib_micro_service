<?php

namespace gateway\application\middlewares;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Server\RequestHandlerInterface as RequestHandler;
use Slim\Psr7\Factory\ResponseFactory;

$token_line = $request->hasHeader('Authorization');
list($token) = sscanf($token_line, "Bearer %s");

try {
    $response = $this->auth_service->request('POST', '/tokens/validate', [
        'json' => ['token' => $token]
    ]);
} catch (ConnectException | ServerException $e) {
    // Handle connection or server exceptions
    throw new HttpInternalServerErrorException($request, "internal server error ({$e->getCode()}, {$e->getMessage()})");
} catch (ClientException $e) {
    match($e->getCode()) {
        401 => throw new HttpUnauthorizedException($request, "unauthorized ({$e->getCode()}, {$e->getMessage()})"),
    };
}

return $handler->handle($request);

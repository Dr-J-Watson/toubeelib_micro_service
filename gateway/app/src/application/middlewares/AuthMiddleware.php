<?php

namespace gateway\application\middlewares;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Server\RequestHandlerInterface as RequestHandler;
use Psr\Http\Message\ResponseInterface as Response;
use Slim\Exception\HttpUnauthorizedException;
use Slim\Exception\HttpInternalServerErrorException;
use GuzzleHttp\Exception\ConnectException;
use GuzzleHttp\Exception\ServerException;
use GuzzleHttp\Exception\ClientException;

class AuthMiddleware
{
    private Client $auth_client;

    public function __construct(Client $auth_client)
    {
        $this->auth_client = $auth_client;
    }

    public function __invoke(Request $request, RequestHandler $handler): Response
    {
        $token_line = $request->getHeaderLine('Authorization');
        list($token) = sscanf($token_line, "Bearer %s");

        if (!$token) {
            throw new HttpUnauthorizedException($request, "Token not provided");
        }

        try {
            // Vérifiez que le token n'est pas vide ou mal formé
            if (empty($token) || !is_string($token)) {
                throw new HttpUnauthorizedException($request, "Invalid token format");
            }

            echo "Before request\n";
            $response = $this->auth_client->request('POST', '/tokens/validate', [
                'json' => ['token' => $token]
            ]);
            echo "After request\n";


        } catch (ConnectException | ServerException $e) {
            throw new HttpInternalServerErrorException($request, "Internal server error ({$e->getCode()}, {$e->getMessage()})");
        } catch (ClientException $e) {
            if ($e->getCode() === 401) {
                throw new HttpUnauthorizedException($request, "Unauthorized ({$e->getCode()}, {$e->getMessage()})");
            }
        } catch (GuzzleException $e) {
            throw new HttpInternalServerErrorException($request, "Internal server error ({$e->getCode()}, {$e->getMessage()})");
        }

        return $handler->handle($request);
    }
}
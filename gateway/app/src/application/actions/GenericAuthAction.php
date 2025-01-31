<?php

namespace gateway\application\actions;

use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\ConnectException;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Exception\ServerException;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Exception\HttpForbiddenException;
use Slim\Exception\HttpInternalServerErrorException;
use Slim\Exception\HttpNotFoundException;
use Slim\Exception\HttpUnauthorizedException;
use Slim\Exception\HttpMethodNotAllowedException;
use gateway\core\repositoryInterfaces\RepositoryEntityNotFoundException;

class GenericAuthAction extends AbstractAction{

    private \GuzzleHttp\Client $auth_client;

    public function __construct(\GuzzleHttp\Client $auth_client)
    {
        $this->auth_client = $auth_client;
    }

    public function __invoke(Request $request, Response $response, $args): Response
    {
        $method = $request->getMethod();
        $path = $request->getUri()->getPath();
        $options = ['query' => $request->getQueryParams()];
        if ($method === 'POST' || $method === 'PUT' || $method === 'PATCH') {
            $options['json'] = $request->getParsedBody();
        }
        $auth = $request->getHeaderLine('Authorization');
        if (!empty($auth)) {
            $options['headers'] = ['Authorization' => $auth];
        }
        try {
            return $this->auth_client->request($method, $path, $options);
        } catch (ConnectException | ServerException $e) {
            throw new HttpInternalServerErrorException($request, $e->getMessage());
        } catch (ClientException $e ) {
            match($e->getCode()) {
                400 => throw new HttpInternalServerErrorException($request, $e->getMessage()),
                401 => throw new HttpUnauthorizedException($request, $e->getMessage()),
                403 => throw new HttpForbiddenException($request, $e->getMessage()),
                405 => throw new HttpMethodNotAllowedException($request, $e->getMessage()),
                500 => throw new HttpInternalServerErrorException($request, $e->getMessage()),
            };
        } catch (RepositoryEntityNotFoundException $e) {
            throw new HttpNotFoundException($request, $e->getMessage());
        } catch (GuzzleException $e) {
            throw new HttpInternalServerErrorException($request, $e->getMessage()); 
        }

    }
}

        
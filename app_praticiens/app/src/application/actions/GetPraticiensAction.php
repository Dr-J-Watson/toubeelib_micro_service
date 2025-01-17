<?php

namespace app_praticiens\application\actions;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Routing\RouteContext;
use app_praticiens\core\services\praticien\ServicePraticien;
use app_praticiens\application\renderer\JsonRenderer;

class GetPraticiensAction extends AbstractAction
{
    private ServicePraticien $servicePraticien;

    public function __construct(ServicePraticien $servicePraticien)
    {
        $this->servicePraticien = $servicePraticien;
    }

    public function __invoke(Request $rq, Response $rs, $args): Response
    {
        $nom = $rq->getQueryParams()['nom'] ?? '';
        $ville = $rq->getQueryParams()['ville'] ?? '';
        $specialite = $rq->getQueryParams()['specialite'] ?? '';
        $page = $rq->getQueryParams()['page'] ?? 1;

        $routeContext = RouteContext::fromRequest($rq);
        $routeParser = $routeContext->getRouteParser();
        $url = $routeParser->urlFor('getPraticiens');

        $praticiens = $this->servicePraticien->getPraticiens($nom, $ville, $specialite, $page);
        $urlQuerryParams = (strlen($nom)>0 ? '&nom=' . $nom : '') . (strlen($ville)>0 ? '&ville='.$ville: '') . (strlen($specialite) ? '&specialite=' . $specialite: '');
        $data = [
            'type' => 'collection',
            'count' => count($praticiens),
            'particiens' => $praticiens,
            'links' => [
                'self' => $url. '?page=' . $page .$urlQuerryParams,
                'next' => $url . '?page=' . ($page + 1). $urlQuerryParams,
                'prev' => $url . '?page=' . ($page<=1 ? 1 : $page - 1). $urlQuerryParams
            ]
        ];
        return JsonRenderer::render($rs, 200, $data);
    }
}
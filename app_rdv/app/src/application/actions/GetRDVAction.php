<?php

namespace app_rdv\application\actions;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Routing\RouteContext;
use app_rdv\application\renderer\JsonRenderer;
use app_rdv\core\services\rdv\ServiceRDVInterface;
use app_rdv\core\repositoryInterfaces\RDVRepositoryInterface;

class GetRDVAction extends AbstractAction{

    private ServiceRDVInterface $serviceRDV;

    public function __construct(ServiceRDVInterface $serviceRDV){
        $this->serviceRDV = $serviceRDV;
    }

    public function __invoke(Request $rq, Response $rs, $args): Response{
        
        try{
            $rdv = $this->serviceRDV->getRDVById($args['id']);

            $routeContext = RouteContext::fromRequest($rq);
            $routeParser = $routeContext->getRouteParser();

            $responseContent = [
                'type' => 'ressources',
                'rdv' => $rdv,
//                'links' => [
//                    'praticien' => $routeParser->urlFor('getPraticien', ['id' => $rdv->practicienID])
//                ]
            ];

            return JsonRenderer::render($rs, 200, $responseContent);

        }catch(\Exception $e){
            throw new \Exception("RDV not found: ".$e->getMessage(), 404);
        }
    }

}
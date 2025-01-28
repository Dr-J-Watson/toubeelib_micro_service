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

            $responseContent = [
                'type' => 'ressources',
                'rdv' => $rdv,
            ];

            return JsonRenderer::render($rs, 200, $responseContent);

        }catch(\Exception $e){
            return JsonRenderer::render($rs, 404, ['error' => $e->getMessage()]);
        }
    }

}
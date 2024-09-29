<?php

namespace toubeelib\application\actions;

use PHPUnit\Util\Json;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use toubeelib\application\renderer\JsonRenderer;
use toubeelib\core\services\rdv\ServiceRDVInterface;
use toubeelib\core\repositoryInterfaces\RDVRepositoryInterface;
use toubeelib\application\utils\CorsUtility;



class CancelRDVAction extends AbstractAction{

    private ServiceRDVInterface $serviceRDV;

    public function __construct(ServiceRDVInterface $serviceRDV){
        $this->serviceRDV = $serviceRDV;
    }

    public function __invoke(Request $rq, Response $rs, $args): Response{
        
        try{
            $rdv = $this->serviceRDV->cancelRDV($args['id']);
    
            $responseContent = [
                'type' => 'rdv',
                'data' => $rdv
            ];

            return JsonRenderer::render($rs, 200, $responseContent);

        }catch(\Exception $e){
            throw new \Exception("RDV not found", 404);
        }
    }

}
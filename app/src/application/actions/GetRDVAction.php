<?php

namespace toubeelib\application\actions;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use toubeelib\core\services\rdv\ServiceRDVInterface;
use toubeelib\core\repositoryInterfaces\RDVRepositoryInterface;
use toubeelib\application\utils\CorsUtility;

class GetRDVAction extends AbstractAction{

    private ServiceRDVInterface $serviceRDV;

    public function __construct(ServiceRDVInterface $serviceRDV){
        $this->serviceRDV = $serviceRDV;
    }

    public function __invoke(Request $rq, Response $rs, $args): Response{
        
        try{
            $rdv = $this->serviceRDV->getRDVById($args['id']);
            print(json_encode($rdv));
            return CorsUtility::handle($rq, $rs, json_encode($rdv));
        }
        catch(\Exception $e){
            return CorsUtility::handle($rq, $rs, $e, 500);
        }

    }

}
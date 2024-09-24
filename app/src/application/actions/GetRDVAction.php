<?php

namespace toubeelib\application\actions;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use toubeelib\core\services\rdv\ServiceRDVInterface;
use toubeelib\core\repositoryInterfaces\RDVRepositoryInterface;
use toubeelib\application\utils\CorsUtility;
use toubeelib\application\utils\JsonRenderer;


class GetRDVAction extends AbstractAction{

    private ServiceRDVInterface $serviceRDV;

    public function __construct(ServiceRDVInterface $serviceRDV){
        $this->serviceRDV = $serviceRDV;
    }

    public function __invoke(Request $rq, Response $rs, $args): Response{
        
        try{
            $rdv = $this->serviceRDV->getRDVById($args['id']);

            $rdvformated = [
                'ID' => $rdv->ID,
                'dateHeure' => $rdv->dateHeure,
                'duree' => $rdv->duree,
                'practicienID' => $rdv->practicienID,
                'patientID' => $rdv->patientID,
                'statut' => $rdv->statut,
                'type' => $rdv->type
            ];
    
            $responseContent = [
                'type' => 'rdv',
                'data' => $rdvformated
            ];
    
            return CorsUtility::handle($rq, $rs, $responseContent);

        }catch(\Exception $e){
            throw new \Exception("RDV not found", 404);
        }



        

    }

}
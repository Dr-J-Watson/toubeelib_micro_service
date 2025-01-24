<?php

namespace app_rdv\application\actions;

use Exception;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use app_rdv\application\renderer\JsonRenderer;
use app_rdv\core\services\rdv\ServiceRDVInterface;


class GetPraticienPlanningAction extends AbstractAction{
    private ServiceRDVInterface $serviceRDV;
    public function __construct(ServiceRDVInterface $serviceRDV){
        $this->serviceRDV = $serviceRDV;
    }

    /**
     * @throws Exception
     */
    public function __invoke(Request $rq, Response $rs, $args): Response{

        $pratitientID = $args['id'];
        //Note if the date is not provided, the default date is today
        $dateDebut = $rq->getQueryParams()['dateDebut'] ?? date('Y-m-d'); ;
        $dateFin = $rq->getQueryParams()['dateFin'] ?? date('Y-m-d', strtotime('+1 day'));
        try{
            $disponibility = $this->serviceRDV->getRDVByPraticien($pratitientID, $dateDebut, $dateFin);
            $data = [
                'praticienID' => $pratitientID,
                'dateDebut' => $dateDebut,
                'dateFin' => $dateFin,
                'planning' => $disponibility,
            ];
            return JsonRenderer::render($rs, 200, $data);
        }
        catch(Exception $e){
            throw new Exception("RDV not found", 404);
        }
    }



}
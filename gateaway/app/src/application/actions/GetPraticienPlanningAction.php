<?php

namespace toubeelib\application\actions;

use Exception;
use PHPUnit\TextUI\Output\Printer;
use PHPUnit\Util\Json;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use toubeelib\application\renderer\JsonRenderer;
use toubeelib\core\services\rdv\ServiceRDVInterface;


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
        $dateDebut = $rq->getQueryParams()['dateDebut'] ?? throw new Exception("dateDebut Query not found", 400);
        $dateFin = $rq->getQueryParams()['dateFin'] ?? throw new Exception("dateFin Query not found", 400) ;
        try{
            $disponibility = $this->serviceRDV->getRDVByPraticien($pratitientID, $dateDebut, $dateFin);
            $data = [
                'praticienID' => $pratitientID,
                'dateDebut' => $dateDebut,
                'dateFin' => $dateFin,
                'disponibility' => $disponibility,
            ];
            return JsonRenderer::render($rs, 200, $data);
        }
        catch(Exception $e){
            throw new Exception("RDV not found", 404);
        }
    }



}
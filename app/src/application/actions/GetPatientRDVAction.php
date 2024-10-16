<?php

namespace toubeelib\application\actions;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use toubeelib\core\services\rdv\ServiceRDVInterface;
use toubeelib\application\renderer\JsonRenderer;

class GetPatientRDVAction extends AbstractAction
{
    private ServiceRDVInterface $serviceRDV;

    public function __construct(ServiceRDVInterface $serviceRDV)
    {
        $this->serviceRDV = $serviceRDV;
    }

    public function __invoke(Request $rq, Response $rs, $args): Response
    {
        $patientId = $args['patient_id'];
        $rdvs = $this->serviceRDV->getRDVByPatient($patientId);
        $data = [
            'type' => 'collection',
            'rdvs' => $rdvs
        ];
        return JsonRenderer::render($rs, 200, $rdvs);
    }



}
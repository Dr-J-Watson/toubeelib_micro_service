<?php

namespace app_rdv\application\actions;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use toubeelib\application\renderer\JsonRenderer;
use toubeelib\core\services\rdv\ServiceRDVInterface;

class UpdateRDVCycleAction extends AbstractAction
{

    private ServiceRDVInterface $serviceRDV;

    public function __construct(ServiceRDVInterface $serviceRDV)
    {
        $this->serviceRDV = $serviceRDV;
    }

    // gérer le cycle de vie des rendez-vous (honoré, non honoré, payé),

    public function __invoke(Request $rq, Response $rs, $args): Response
    {
        $body = $rq->getParsedBody();
        $cycle = $body['cycle'] ?? throw new \Exception("cycle not found", 400);

        $rdvId = $args['id'] ?? throw new \Exception("rdv_id not found", 400);

        $rdv = $this->serviceRDV->updateRDVCycle($rdvId, $cycle);
        return JsonRenderer::render($rs, 200, $rdv);
    }
}
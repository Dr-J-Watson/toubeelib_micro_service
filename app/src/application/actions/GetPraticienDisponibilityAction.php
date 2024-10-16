<?php

namespace toubeelib\application\actions;


use toubeelib\application\actions\AbstractAction;
use toubeelib\application\renderer\JsonRenderer;
use toubeelib\core\services\rdv\ServiceRDVInterface;

class GetPraticienDisponibilityAction extends AbstractAction
{
    private ServiceRDVInterface $serviceRDV;

    public function __construct(ServiceRDVInterface $serviceRDV)
    {
        $this->serviceRDV = $serviceRDV;
    }

    public function __invoke(\Psr\Http\Message\ServerRequestInterface $rq, \Psr\Http\Message\ResponseInterface $rs, array $args): \Psr\Http\Message\ResponseInterface
    {
        $dispo = $this->serviceRDV->getPraticienDisponibillity($args['id'], $rq->getQueryParams()['dateDebut'], $rq->getQueryParams()['dateFin']);
        return JsonRenderer::render($rs, 200, $dispo);

    }
}

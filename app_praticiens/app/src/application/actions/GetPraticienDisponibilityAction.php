<?php

namespace app_praticiens\application\actions;

use app_praticiens\application\renderer\JsonRenderer;
use app_praticiens\core\services\rdv\ServiceRDVInterface;

class GetPraticienDisponibilityAction extends AbstractAction
{
    private ServiceRDVInterface $serviceRDV;

    public function __construct(ServiceRDVInterface $serviceRDV)
    {
        $this->serviceRDV = $serviceRDV;
    }

    public function __invoke(\Psr\Http\Message\ServerRequestInterface $rq, \Psr\Http\Message\ResponseInterface $rs, array $args): \Psr\Http\Message\ResponseInterface
    {
        // Utilisation du null coalescent pour éviter l'erreur Undefined array key en cas de non présence des paramètres
        // on definit les valeurs par défaut à la date d'auiourd'hui pour la date de début et +7 jours par rapport à la date de début pour la date de fin
        $dateDebut = $rq->getQueryParams()['dateDebut'] ?? date('Y-m-d');
        $dateFin = $rq->getQueryParams()['dateFin'] ?? date('Y-m-d', strtotime($dateDebut . ' +7 days'));

        // Passer les valeurs récupérées au service
        $dispo = $this->serviceRDV->getPraticienDisponibillity($args['id'], $dateDebut, $dateFin);

        return JsonRenderer::render($rs, 200, $dispo);
    }
}

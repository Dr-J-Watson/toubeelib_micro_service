<?php

namespace app_praticiens\application\actions;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use app_praticiens\core\services\praticien\ServicePraticien;
use app_praticiens\application\renderer\JsonRenderer;

class GetPraticienAction extends AbstractAction{
    private ServicePraticien $servicePraticien;
    public function __construct(ServicePraticien $servicePraticien){
        $this->servicePraticien = $servicePraticien;
    }


    public function __invoke(Request $rq, Response $rs, $args): Response{
        $praticienID = $args['id'];
        $praticien = $this->servicePraticien->getPraticien($praticienID);

        $data = [
            'type' => 'ressources',
            'praticien' => $praticien,
        ];
        return JsonRenderer::render($rs, 200, $data);
    }


}
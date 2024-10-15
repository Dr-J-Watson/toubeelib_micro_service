<?php

namespace toubeelib\application\actions;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use toubeelib\application\renderer\JsonRenderer;
use toubeelib\core\dto\InputRDVDTO;
use toubeelib\core\services\rdv\ServiceRDVInterface;
use Exception;

class CreateRDVAction extends AbstractAction
{

    private ServiceRDVInterface $serviceRDV;

    public function __construct(ServiceRDVInterface $serviceRDV)
    {
        $this->serviceRDV = $serviceRDV;
    }

    /**
     * @throws Exception
     */
    public function __invoke(Request $rq, Response $rs, $args): Response
    {
        $body = $rq->getParsedBody();
        $dateTime = isset($body['date_time']) ? \DateTimeImmutable::createFromFormat('Y-m-d H:i', $body['date_time']) : throw new Exception("date_ime not found", 400);
        $praticienId = $body['praticien_id'] ?? throw new \Exception("praticien_id not found", 400);
        $patientId = $body['patient_id'] ?? throw new Exception("patient_id not found", 400);
        $type = $body['type'] ?? throw new Exception("type not found", 400);
        $status = $body['status'] ?? throw new Exception("status not found", 400);

        if(!is_string($patientId) || !is_string($praticienId)){
            throw new Exception("Data must be of type string", 400);
        }
        $rdvInputDto = new InputRDVDTO($dateTime, $praticienId, $patientId, $type, $status);

        $rdv = $this->serviceRDV->createRDV($rdvInputDto);
        $rs = $rs->withHeader('Location', '/rdvs/' . $rdv->ID);
        return JsonRenderer::render($rs, 201, $rdv);
    }
}

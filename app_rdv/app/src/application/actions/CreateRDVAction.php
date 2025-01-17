<?php

namespace app_rdv\application\actions;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Respect\Validation\Validator;
use Slim\Routing\RouteContext;
use toubeelib\application\renderer\JsonRenderer;
use toubeelib\core\dto\InputRDVDTO;
use toubeelib\core\services\rdv\ServiceRDVInterface;
use Exception;
use Slim\Exception\HttpBadRequestException;

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

        $rdvInputValidator = Validator::key('date_time', Validator::stringType()->notEmpty())
            ->key('praticien_id', Validator::stringType()->notEmpty())
            ->key('patient_id', Validator::stringType()->notEmpty())
            ->key('type', Validator::stringType()->notEmpty())
            ->key('status', Validator::stringType()->notEmpty());
        try {
            $rdvInputValidator->assert($body);
        } catch (\Respect\Validation\Exceptions\NestedValidationException $e) {
            throw new HttpBadRequestException($rq, $e->getMessages());
        }

        $dateTime = isset($body['date_time']) ? \DateTimeImmutable::createFromFormat('Y-m-d H:i', $body['date_time']) : throw new Exception("date_time not found", 400);
        $praticienId = $body['praticien_id'] ?? throw new \Exception("praticien_id not found", 400);
        $patientId = $body['patient_id'] ?? throw new Exception("patient_id not found", 400);
        $type = $body['type'] ?? throw new Exception("type not found", 400);
        $status = $body['status'] ?? throw new Exception("status not found", 400);

        if(!is_string($patientId) || !is_string($praticienId)){
            throw new Exception("Data must be of type string", 400);
        }
        $rdvInputDto = new InputRDVDTO($dateTime, $praticienId, $patientId, $type, $status);

        $rdv = $this->serviceRDV->createRDV($rdvInputDto);

        $routeContext = RouteContext::fromRequest($rq);
        $routeParser = $routeContext->getRouteParser();

        $data = [
            'type' => 'ressources',
            'rdv' => $rdv,
            'links' => [
                'self' => $routeParser->urlFor('createRDV') . $rdv->ID,
                'praticien' => $routeParser->urlFor('getPraticien', ['id' => $rdv->praticienID])
            ]
        ];
        $rs = $rs->withHeader('Location', '/rdvs/' . $rdv->ID);
        return JsonRenderer::render($rs, 201, $data);
    }
}

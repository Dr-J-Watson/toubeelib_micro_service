<?php


namespace toubeelib\application\actions;

use Exception;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Routing\RouteContext;
use toubeelib\application\renderer\JsonRenderer;
use toubeelib\core\dto\InputPraticienDTO;
use toubeelib\core\services\praticien\ServicePraticien;
use toubeelib\core\services\praticien\ServicePraticienInterface;
use toubeelib\core\services\rdv\ServiceRDVInterface;


class CreatePraticienAction extends AbstractAction
{
    private ServicePraticienInterface $servicePraticien;

    public function __construct(ServicePraticienInterface $servicePraticien)
    {
        $this->servicePraticien = $servicePraticien;
    }

    /**
     * @throws Exception
     */
    public function __invoke(Request $rq, Response $rs, $args): Response
    {
        $body = $rq->getParsedBody();
        $nom = $body['nom'] ?? throw new Exception("nom not found", 400);
        $prenom = $body['prenom'] ?? throw new Exception("prenom not found", 400);
        $adresse = $body['adresse'] ?? throw new Exception("adresse not found", 400);
        $tel = $body['tel'] ?? throw new Exception("tel not found", 400);
        $specialiteId = $body['specialite'] ?? throw new Exception("specialite not found", 400);

        //validate the data
        if(!is_string($nom) || !is_string($prenom) || !is_string($adresse) || !is_string($tel) || !is_string($specialiteId)){
            throw new Exception("Data must be of type string", 400);
        }
        if(strlen($nom) > 255){
            throw new Exception("Name is too long", 400);
        }
        if(strlen($prenom) > 255){
            throw new Exception("First name is too long", 400);
        }
        //if(!preg_match("#^(\+33|0)[679][0-9]{8}$#", $tel)){
        //    throw new Exception("Invalid phone number", 400);
        //}

        $inputPratitienDto = new InputPraticienDTO($nom, $prenom, $adresse, $tel, $specialiteId);
        $praticien = $this->servicePraticien->createPraticien($inputPratitienDto);

        $routeContext = RouteContext::fromRequest($rq);
        $routeParser = $routeContext->getRouteParser();

            $data = [
                'type' => 'ressources',
                'praticien' => $praticien,
                'links' => [
                    'self' => $routeParser->urlFor('getPraticien', ['id' => $praticien->ID]),
                    'planning' => $routeParser->urlFor('getPraticienPlanning', ['id' => $praticien->ID]),
                    'dispobilite' => $routeParser->urlFor('getPraticienDisponibility', ['id' => $praticien->ID])
                ]
            ];

            $rs = $rs->withHeader('Location', $routeParser->urlFor('getPraticien', ['id' => $praticien->ID]));

            return JsonRenderer::render($rs, 201, $data);

    }
}
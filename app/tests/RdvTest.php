<?php declare(strict_types=1);

require_once __DIR__ . '/../vendor/autoload.php';

use PHPUnit\Framework\TestCase;
use toubeelib\core\dto\InputRDVDTO;
use toubeelib\core\services\rdv\ServiceRDV;
use toubeelib\infrastructure\repositories\ArrayRdvRepository;

class RdvTest extends TestCase{

    private $repo;
    private $service;

    protected function setUp(): void{
        $this->repo = new ArrayRdvRepository();
        $this->service = new ServiceRDV($this->repo);
    }
    
    public function testCreateRDVInvalideDate(){
       
        $s = new InputRDVDTO( \DateTimeImmutable::createFromFormat('Y-m-d H:i','2024-09-02 09:00'), 'pa1', 'p1', 'A', 'OK'); 
        $res = $this->service->createRDV($s);

        $this->expectException(Exeception::class);        
    }

    public function testCreateRDVOK(){

        $s = new InputRDVDTO( \DateTimeImmutable::createFromFormat('Y-m-d H:i','2024-11-02 10:00'), 'pa1', 'p1', 'A', 'OK');
        $res = $this->service->createRDV($s);

        $this->assertEquals('p1', $res->__get('patientID'));
        $this->assertEquals('pa1', $res->__get('practicienID'));
        $this->assertEquals('A', $res->__get('type'));
        $this->assertEquals('OK', $res->__get('statut'));
    }

    public function testCreateRDVInvalidPractitien(){

        $s = new InputRDVDTO( \DateTimeImmutable::createFromFormat('Y-m-d H:i','2024-11-02 10:00'), '22233244', 'p1', 'A', 'OK');
        $res = $this->service->createRDV($s);

        $this->expectException(Exception::class);

    }

    public function testCreateRDVNoDiponibilityPractitien(){

        $s = new InputRDVDTO( \DateTimeImmutable::createFromFormat('Y-m-d H:i','2024-11-02 10:00'), 'pas', 'p1', 'A', 'OK');
        $this->service->createRDV($s);

        $s2 = new InputRDVDTO( \DateTimeImmutable::createFromFormat('Y-m-d H:i','2024-11-02 10:00'), 'pas', 'p1', 'A', 'OK');
        $this->service->createRDV($s2);

        $this->expectException(Exception::class);

    }

    public function testCreateRDVInvalidType(){

        $s = new InputRDVDTO( \DateTimeImmutable::createFromFormat('Y-m-d H:i','2024-11-02 10:00'), '22233244', 'p1', 'D', 'OK');
        $res = $this->service->createRDV($s);

        $this->expectException(Exception::class);

    }

    public function testCancelRDV(){
        $s = new InputRDVDTO( \DateTimeImmutable::createFromFormat('Y-m-d H:i','2024-11-02 10:00'), 'toto', 'titi', 'A', 'OK');
        $res = $this->service->createRDV($s);

        $id = $res->__get('ID');
        $this->service->cancelRDV($id);
        $rdv = $this->repo->getRDVById($id);
        $rdvDTO = $rdv->toDTO();

        $this->assertEquals('CANCEL',$rdvDTO->__get('statut'));
    }
}
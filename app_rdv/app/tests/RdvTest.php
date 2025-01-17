<?php declare(strict_types=1);

require_once __DIR__ . '/../vendor/autoload.php';

use PHPUnit\Framework\TestCase;
use app_rdv\core\dto\InputRDVDTO;
use app_rdv\core\services\rdv\ServiceRDV;
use app_rdv\infrastructure\repositories\ArrayRdvRepository;
use Psr\Log\LoggerInterface;

class RdvTest extends TestCase{

    private $repo;
    private $service;
    private $logger;

    protected function setUp(): void{
        $this->repo = new ArrayRdvRepository();
        $this->logger = $this->createMock(LoggerInterface::class);
        $this->service = new ServiceRDV($this->repo, $this->logger);
    }


    public function testCreateRDVInvalideDate(){

        $s = new InputRDVDTO( \DateTimeImmutable::createFromFormat('Y-m-d H:i','2024-09-02 09:00'), 'pa1', 'p1', 'A', 'OK');
        $this->service->createRDV($s);

        $this->expectException(Exeception::class);
    }

    public function testCreateRDVOK(){

        $s = new InputRDVDTO( \DateTimeImmutable::createFromFormat('Y-m-d H:i','2024-11-02 10:00'), 'pa1', 'p1', 'A', 'OK');
        $res = $this->service->createRDV($s);

        $this->assertEquals('p1', $res->__get('patientID'));
        $this->assertEquals('pa1', $res->__get('praticienID'));
        $this->assertEquals('A', $res->__get('type'));
        $this->assertEquals('OK', $res->__get('statut'));
    }

    public function testCreateRDVInvalidPractitien(){

        $s = new InputRDVDTO( \DateTimeImmutable::createFromFormat('Y-m-d H:i','2024-11-02 10:00'), '22233244', 'p1', 'A', 'OK');
        $this->service->createRDV($s);

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
        $this->service->createRDV($s);

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

    public function testUpdateSpe(){
        $s = new InputRDVDTO( \DateTimeImmutable::createFromFormat('Y-m-d H:i','2024-11-02 10:00'), 'toto', 'titi', 'A', 'OK');
        $res = $this->service->createRDV($s);

        $s2 = new InputRDVDTO( \DateTimeImmutable::createFromFormat('Y-m-d H:i','2024-11-02 10:00'), 'toto', 'titi', 'B', 'OK');
        $res2 = $this->service->createRDV($s2);

        $this->service->updateRDV($res2);

        $this->assertEquals('B',$res2->__get('type'));
    }

    public function testUpdatePatient(){
        $s = new InputRDVDTO( \DateTimeImmutable::createFromFormat('Y-m-d H:i','2024-11-02 10:00'), 'toto', 'titi', 'A', 'OK');
        $res = $this->service->createRDV($s);

        $s2 = new InputRDVDTO( \DateTimeImmutable::createFromFormat('Y-m-d H:i','2024-11-02 10:00'), 'toto', 'tata', 'A', 'OK');
        $res2 = $this->service->createRDV($s2);

        $res2 = $this->service->updateRDV($res2);

        $this->assertEquals('tata',$res2->__get('patientID'));
    }

    public function testUpdatePraticien(){
        $s = new InputRDVDTO( \DateTimeImmutable::createFromFormat('Y-m-d H:i','2024-11-02 10:00'), 'toto', 'titi', 'A', 'OK');
        $res = $this->service->createRDV($s);

        $s2 = new InputRDVDTO( \DateTimeImmutable::createFromFormat('Y-m-d H:i','2024-11-02 10:00'), 'tata', 'titi', 'A', 'OK');
        $res2 = $this->service->createRDV($s2);

        $this->service->updateRDV($res2);

        $this->assertException(Exception::class);
    }


}

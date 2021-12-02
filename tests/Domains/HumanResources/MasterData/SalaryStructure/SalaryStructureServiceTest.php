<?php
namespace Tests\Domains\HumanResources\MasterData\SalaryStructure;

use App\Domains\HumanResources\MasterData\SalaryStructure\Contracts\SalaryStructureInterface;
use App\Domains\HumanResources\MasterData\SalaryStructure\Contracts\SalaryStructureRepositoryInterface;
use App\Domains\HumanResources\MasterData\SalaryStructure\Contracts\SalaryStructureServiceInterface;
use App\Domains\HumanResources\MasterData\SalaryStructure\SalaryStructureEloquent;
use App\Domains\HumanResources\MasterData\SalaryStructure\SalaryStructureService;
use Mockery as m;
use Tests\TestCase;

class SalaryStructureServiceTest extends TestCase
{
    private $repository;
    private $service;

    /**
     * Set up test.
     */
    protected function setUp()
    {
        parent::setUp();

        $this->repository = m::mock(SalaryStructureRepositoryInterface::class);
        $this->service = new SalaryStructureService(
            $this->repository
        );
    }

    /**
     * Callback after finish test.
     */
    protected function tearDown()
    {
        m::close();
    }

    /**
     * Test constructor.
     */
    public function testConstructor()
    {
        $this->assertInstanceOf(SalaryStructureServiceInterface::class, $this->service);
    }

    /**
     * Test create notes.
     */
    public function testCreate()
    {
        $object = m::mock(SalaryStructureInterface::class);
        $this->repository->shouldReceive('create')->with($object)->andReturn($object);
        $result = $this->service->create($object);
        $this->assertInstanceOf(SalaryStructureInterface::class, $result);
        $this->assertEquals($object, $result);
    }

    /**
     * Test delete notes.
     */
    public function testDelete()
    {
        $object = m::mock(SalaryStructureInterface::class);
        $this->repository->shouldReceive('delete')->with($object)->andReturn(true);
        $result = $this->service->delete($object);
        $this->assertTrue($result);
    }

    /**
     * Test update notes.
     */
    public function testUpdate()
    {
        $object = m::mock(SalaryStructureInterface::class);
        $this->repository->shouldReceive('update')->with($object)->andReturn($object);
        $result = $this->service->update($object);
        $this->assertEquals($object, $result);
    }
}

<?php
namespace Tests\Domains\Commons\ContractType;

use App\Domains\Commons\ContractType\Contracts\ContractTypeInterface;
use App\Domains\Commons\ContractType\Contracts\ContractTypeRepositoryInterface;
use App\Domains\Commons\ContractType\Contracts\ContractTypeServiceInterface;
use App\Domains\Commons\ContractType\ContractTypeEloquent;
use App\Domains\Commons\ContractType\ContractTypeService;
use Mockery as m;
use Tests\TestCase;

class ContractTypeServiceTest extends TestCase
{
    private $repository;
    private $service;

    /**
     * Set up test.
     */
    protected function setUp()
    {
        parent::setUp();

        $this->repository = m::mock(ContractTypeRepositoryInterface::class);
        $this->service = new ContractTypeService(
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
        $this->assertInstanceOf(ContractTypeServiceInterface::class, $this->service);
    }

    /**
     * Test create notes.
     */
    public function testCreate()
    {
        $object = m::mock(ContractTypeInterface::class);
        $this->repository->shouldReceive('create')->with($object)->andReturn($object);
        $result = $this->service->create($object);
        $this->assertInstanceOf(ContractTypeInterface::class, $result);
        $this->assertEquals($object, $result);
    }

    /**
     * Test delete notes.
     */
    public function testDelete()
    {
        $object = m::mock(ContractTypeInterface::class);
        $this->repository->shouldReceive('delete')->with($object)->andReturn(true);
        $result = $this->service->delete($object);
        $this->assertTrue($result);
    }

    /**
     * Test update notes.
     */
    public function testUpdate()
    {
        $object = m::mock(ContractTypeInterface::class);
        $this->repository->shouldReceive('update')->with($object)->andReturn($object);
        $result = $this->service->update($object);
        $this->assertEquals($object, $result);
    }
}

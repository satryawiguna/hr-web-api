<?php
namespace Tests\Domains\Commons\EmployeeLoanType;

use App\Domains\Commons\EmployeeLoanType\Contracts\EmployeeLoanTypeInterface;
use App\Domains\Commons\EmployeeLoanType\Contracts\EmployeeLoanTypeRepositoryInterface;
use App\Domains\Commons\EmployeeLoanType\Contracts\EmployeeLoanTypeServiceInterface;
use App\Domains\Commons\EmployeeLoanType\EmployeeLoanTypeEloquent;
use App\Domains\Commons\EmployeeLoanType\EmployeeLoanTypeService;
use Mockery as m;
use Tests\TestCase;

class EmployeeLoanTypeServiceTest extends TestCase
{
    private $repository;
    private $service;

    /**
     * Set up test.
     */
    protected function setUp()
    {
        parent::setUp();

        $this->repository = m::mock(EmployeeLoanTypeRepositoryInterface::class);
        $this->service = new EmployeeLoanTypeService(
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
        $this->assertInstanceOf(EmployeeLoanTypeServiceInterface::class, $this->service);
    }

    /**
     * Test create notes.
     */
    public function testCreate()
    {
        $object = m::mock(EmployeeLoanTypeInterface::class);
        $this->repository->shouldReceive('create')->with($object)->andReturn($object);
        $result = $this->service->create($object);
        $this->assertInstanceOf(EmployeeLoanTypeInterface::class, $result);
        $this->assertEquals($object, $result);
    }

    /**
     * Test delete notes.
     */
    public function testDelete()
    {
        $object = m::mock(EmployeeLoanTypeInterface::class);
        $this->repository->shouldReceive('delete')->with($object)->andReturn(true);
        $result = $this->service->delete($object);
        $this->assertTrue($result);
    }

    /**
     * Test update notes.
     */
    public function testUpdate()
    {
        $object = m::mock(EmployeeLoanTypeInterface::class);
        $this->repository->shouldReceive('update')->with($object)->andReturn($object);
        $result = $this->service->update($object);
        $this->assertEquals($object, $result);
    }
}

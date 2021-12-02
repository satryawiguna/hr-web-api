<?php
namespace Tests\Domains\HumanResources\Payroll\PayrollProcessType;

use App\Domains\HumanResources\Payroll\PayrollProcessType\Contracts\PayrollProcessTypeInterface;
use App\Domains\HumanResources\Payroll\PayrollProcessType\Contracts\PayrollProcessTypeRepositoryInterface;
use App\Domains\HumanResources\Payroll\PayrollProcessType\Contracts\PayrollProcessTypeServiceInterface;
use App\Domains\HumanResources\Payroll\PayrollProcessType\PayrollProcessTypeEloquent;
use App\Domains\HumanResources\Payroll\PayrollProcessType\PayrollProcessTypeService;
use Mockery as m;
use Tests\TestCase;

class PayrollProcessTypeServiceTest extends TestCase
{
    private $repository;
    private $service;

    /**
     * Set up test.
     */
    protected function setUp()
    {
        parent::setUp();

        $this->repository = m::mock(PayrollProcessTypeRepositoryInterface::class);
        $this->service = new PayrollProcessTypeService(
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
        $this->assertInstanceOf(PayrollProcessTypeServiceInterface::class, $this->service);
    }

    /**
     * Test create notes.
     */
    public function testCreate()
    {
        $object = m::mock(PayrollProcessTypeInterface::class);
        $this->repository->shouldReceive('create')->with($object)->andReturn($object);
        $result = $this->service->create($object);
        $this->assertInstanceOf(PayrollProcessTypeInterface::class, $result);
        $this->assertEquals($object, $result);
    }

    /**
     * Test delete notes.
     */
    public function testDelete()
    {
        $object = m::mock(PayrollProcessTypeInterface::class);
        $this->repository->shouldReceive('delete')->with($object)->andReturn(true);
        $result = $this->service->delete($object);
        $this->assertTrue($result);
    }

    /**
     * Test update notes.
     */
    public function testUpdate()
    {
        $object = m::mock(PayrollProcessTypeInterface::class);
        $this->repository->shouldReceive('update')->with($object)->andReturn($object);
        $result = $this->service->update($object);
        $this->assertEquals($object, $result);
    }
}

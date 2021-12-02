<?php
namespace Tests\Domains\HumanResources\Payroll;

use App\Domains\HumanResources\Payroll\Contracts\PayrollInterface;
use App\Domains\HumanResources\Payroll\Contracts\PayrollRepositoryInterface;
use App\Domains\HumanResources\Payroll\Contracts\PayrollServiceInterface;
use App\Domains\HumanResources\Payroll\PayrollEloquent;
use App\Domains\HumanResources\Payroll\PayrollService;
use Mockery as m;
use Tests\TestCase;

class PayrollServiceTest extends TestCase
{
    private $repository;
    private $service;

    /**
     * Set up test.
     */
    protected function setUp()
    {
        parent::setUp();

        $this->repository = m::mock(PayrollRepositoryInterface::class);
        $this->service = new PayrollService(
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
        $this->assertInstanceOf(PayrollServiceInterface::class, $this->service);
    }

    /**
     * Test create notes.
     */
    public function testCreate()
    {
        $object = m::mock(PayrollInterface::class);
        $this->repository->shouldReceive('create')->with($object)->andReturn($object);
        $result = $this->service->create($object);
        $this->assertInstanceOf(PayrollInterface::class, $result);
        $this->assertEquals($object, $result);
    }

    /**
     * Test delete notes.
     */
    public function testDelete()
    {
        $object = m::mock(PayrollInterface::class);
        $this->repository->shouldReceive('delete')->with($object)->andReturn(true);
        $result = $this->service->delete($object);
        $this->assertTrue($result);
    }

    /**
     * Test update notes.
     */
    public function testUpdate()
    {
        $object = m::mock(PayrollInterface::class);
        $this->repository->shouldReceive('update')->with($object)->andReturn($object);
        $result = $this->service->update($object);
        $this->assertEquals($object, $result);
    }
}

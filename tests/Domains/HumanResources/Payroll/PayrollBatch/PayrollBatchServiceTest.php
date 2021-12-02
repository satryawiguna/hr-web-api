<?php
namespace Tests\Domains\HumanResources\Payroll\PayrollBatch;

use App\Domains\HumanResources\Payroll\PayrollBatch\Contracts\PayrollBatchInterface;
use App\Domains\HumanResources\Payroll\PayrollBatch\Contracts\PayrollBatchRepositoryInterface;
use App\Domains\HumanResources\Payroll\PayrollBatch\Contracts\PayrollBatchServiceInterface;
use App\Domains\HumanResources\Payroll\PayrollBatch\PayrollBatchEloquent;
use App\Domains\HumanResources\Payroll\PayrollBatch\PayrollBatchService;
use Mockery as m;
use Tests\TestCase;

class PayrollBatchServiceTest extends TestCase
{
    private $repository;
    private $service;

    /**
     * Set up test.
     */
    protected function setUp()
    {
        parent::setUp();

        $this->repository = m::mock(PayrollBatchRepositoryInterface::class);
        $this->service = new PayrollBatchService(
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
        $this->assertInstanceOf(PayrollBatchServiceInterface::class, $this->service);
    }

    /**
     * Test create notes.
     */
    public function testCreate()
    {
        $object = m::mock(PayrollBatchInterface::class);
        $this->repository->shouldReceive('create')->with($object)->andReturn($object);
        $result = $this->service->create($object);
        $this->assertInstanceOf(PayrollBatchInterface::class, $result);
        $this->assertEquals($object, $result);
    }

    /**
     * Test delete notes.
     */
    public function testDelete()
    {
        $object = m::mock(PayrollBatchInterface::class);
        $this->repository->shouldReceive('delete')->with($object)->andReturn(true);
        $result = $this->service->delete($object);
        $this->assertTrue($result);
    }

    /**
     * Test update notes.
     */
    public function testUpdate()
    {
        $object = m::mock(PayrollBatchInterface::class);
        $this->repository->shouldReceive('update')->with($object)->andReturn($object);
        $result = $this->service->update($object);
        $this->assertEquals($object, $result);
    }
}

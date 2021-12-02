<?php
namespace Tests\Domains\HumanResources\Payroll\PayrollBatch;

use Mockery as m;
use Tests\TestCase;
use App\Infrastructures\HumanResources\Payroll\PayrollBatch\Contracts\EloquentPayrollBatchRepositoryInterface;
use App\Domains\HumanResources\Payroll\PayrollBatch\PayrollBatchRepository;
use App\Domains\HumanResources\Payroll\PayrollBatch\PayrollBatchEloquent;
use App\Domains\HumanResources\Payroll\PayrollBatch\Contracts\PayrollBatchInterface;
use App\Domains\HumanResources\Payroll\PayrollBatch\Contracts\PayrollBatchRepositoryInterface;

class PayrollBatchRepositoryTest extends TestCase
{
    private $eloquent;
    private $repository;

    protected function setUp()
    {
        parent::setUp();
        $this->eloquent = m::mock(EloquentPayrollBatchRepositoryInterface::class);
        $this->repository = new PayrollBatchRepository($this->eloquent);
    }

    protected function tearDown()
    {
        m::close();
    }

    public function testConstructor()
    {
        $this->assertInstanceOf(PayrollBatchRepositoryInterface::class, $this->repository);
    }

    /**
     * Test create PayrollBatch
     */
    public function testCreate()
    {
        $object = m::mock(PayrollBatchInterface::class);

        $data = ['name' => 1,'description' => 1,'created_by' => 1,'modified_by' => 1,];

        $object
            ->shouldReceive('getName')->andReturn($data['name'])
            ->shouldReceive('getDescription')->andReturn($data['description'])
            ->shouldReceive('getCreatedBy')->andReturn($data['created_by'])
            ->shouldReceive('getModifiedBy')->andReturn($data['modified_by']);

        $this->eloquent->shouldReceive('create')->with($data)->andReturn($object);

        $result = $this->repository->create($object);
        $this->assertInstanceOf(PayrollBatchInterface::class, $result);
        $this->assertEquals($object, $result);
    }

    /**
     * Test delete PayrollBatch
     */
    public function testDelete()
    {
        $note = m::mock(PayrollBatchInterface::class);
        $note->shouldReceive('getKey')->andReturn(1);
        $this->eloquent->shouldReceive('delete')->with(1)->andReturn(true);
        $result = $this->repository->delete($note);
        $this->assertTrue($result);
    }

    /**
     * Test Update PayrollBatch
     */
    public function testUpdate()
    {
        $id = 1;
        $data = ['name' => 1,'description' => 1,'created_by' => 1,'modified_by' => 1,];

        $object = m::mock(PayrollBatchInterface::class);
        $object->shouldReceive('getKey')->andReturn($id);

        $object
            ->shouldReceive('getName')->andReturn($data['name'])
            ->shouldReceive('getDescription')->andReturn($data['description'])
            ->shouldReceive('getCreatedBy')->andReturn($data['created_by'])
            ->shouldReceive('getModifiedBy')->andReturn($data['modified_by']);

        $this->eloquent->shouldReceive('update')->with($data, $id)->andReturn($object);

        $result = $this->repository->update($object);
        $this->assertEquals($object, $result);
    }
}

<?php
namespace Tests\Domains\HumanResources\Payroll;

use Mockery as m;
use Tests\TestCase;
use App\Infrastructures\HumanResources\Payroll\Contracts\EloquentPayrollRepositoryInterface;
use App\Domains\HumanResources\Payroll\PayrollRepository;
use App\Domains\HumanResources\Payroll\PayrollEloquent;
use App\Domains\HumanResources\Payroll\Contracts\PayrollInterface;
use App\Domains\HumanResources\Payroll\Contracts\PayrollRepositoryInterface;

class PayrollRepositoryTest extends TestCase
{
    private $eloquent;
    private $repository;

    protected function setUp()
    {
        parent::setUp();
        $this->eloquent = m::mock(EloquentPayrollRepositoryInterface::class);
        $this->repository = new PayrollRepository($this->eloquent);
    }

    protected function tearDown()
    {
        m::close();
    }

    public function testConstructor()
    {
        $this->assertInstanceOf(PayrollRepositoryInterface::class, $this->repository);
    }

    /**
     * Test create Payroll
     */
    public function testCreate()
    {
        $object = m::mock(PayrollInterface::class);

        $data = ['employee_id' => 1,'payroll_batch_id' => 1,'pay_period' => 1,'process_date' => 1,'payroll_process_type_id' => 1,'description' => 1,'created_by' => 1,'modified_by' => 1,];

        $object
            ->shouldReceive('getEmployeeId')->andReturn($data['employee_id'])
            ->shouldReceive('getPayrollBatchId')->andReturn($data['payroll_batch_id'])
            ->shouldReceive('getPayPeriod')->andReturn($data['pay_period'])
            ->shouldReceive('getProcessDate')->andReturn($data['process_date'])
            ->shouldReceive('getPayrollProcessTypeId')->andReturn($data['payroll_process_type_id'])
            ->shouldReceive('getDescription')->andReturn($data['description'])
            ->shouldReceive('getCreatedBy')->andReturn($data['created_by'])
            ->shouldReceive('getModifiedBy')->andReturn($data['modified_by']);

        $this->eloquent->shouldReceive('create')->with($data)->andReturn($object);

        $result = $this->repository->create($object);
        $this->assertInstanceOf(PayrollInterface::class, $result);
        $this->assertEquals($object, $result);
    }

    /**
     * Test delete Payroll
     */
    public function testDelete()
    {
        $note = m::mock(PayrollInterface::class);
        $note->shouldReceive('getKey')->andReturn(1);
        $this->eloquent->shouldReceive('delete')->with(1)->andReturn(true);
        $result = $this->repository->delete($note);
        $this->assertTrue($result);
    }

    /**
     * Test Update Payroll
     */
    public function testUpdate()
    {
        $id = 1;
        $data = ['employee_id' => 1,'payroll_batch_id' => 1,'pay_period' => 1,'process_date' => 1,'payroll_process_type_id' => 1,'description' => 1,'created_by' => 1,'modified_by' => 1,];

        $object = m::mock(PayrollInterface::class);
        $object->shouldReceive('getKey')->andReturn($id);

        $object
            ->shouldReceive('getEmployeeId')->andReturn($data['employee_id'])
            ->shouldReceive('getPayrollBatchId')->andReturn($data['payroll_batch_id'])
            ->shouldReceive('getPayPeriod')->andReturn($data['pay_period'])
            ->shouldReceive('getProcessDate')->andReturn($data['process_date'])
            ->shouldReceive('getPayrollProcessTypeId')->andReturn($data['payroll_process_type_id'])
            ->shouldReceive('getDescription')->andReturn($data['description'])
            ->shouldReceive('getCreatedBy')->andReturn($data['created_by'])
            ->shouldReceive('getModifiedBy')->andReturn($data['modified_by']);

        $this->eloquent->shouldReceive('update')->with($data, $id)->andReturn($object);

        $result = $this->repository->update($object);
        $this->assertEquals($object, $result);
    }
}

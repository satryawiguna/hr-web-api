<?php
namespace Tests\Domains\HumanResources\Payroll\PayrollBalanceFeed;

use Mockery as m;
use Tests\TestCase;
use App\Infrastructures\HumanResources\Payroll\PayrollBalanceFeed\Contracts\EloquentPayrollBalanceFeedRepositoryInterface;
use App\Domains\HumanResources\Payroll\PayrollBalanceFeed\PayrollBalanceFeedRepository;
use App\Domains\HumanResources\Payroll\PayrollBalanceFeed\PayrollBalanceFeedEloquent;
use App\Domains\HumanResources\Payroll\PayrollBalanceFeed\Contracts\PayrollBalanceFeedInterface;
use App\Domains\HumanResources\Payroll\PayrollBalanceFeed\Contracts\PayrollBalanceFeedRepositoryInterface;

class PayrollBalanceFeedRepositoryTest extends TestCase
{
    private $eloquent;
    private $repository;

    protected function setUp()
    {
        parent::setUp();
        $this->eloquent = m::mock(EloquentPayrollBalanceFeedRepositoryInterface::class);
        $this->repository = new PayrollBalanceFeedRepository($this->eloquent);
    }

    protected function tearDown()
    {
        m::close();
    }

    public function testConstructor()
    {
        $this->assertInstanceOf(PayrollBalanceFeedRepositoryInterface::class, $this->repository);
    }

    /**
     * Test create PayrollBalanceFeed
     */
    public function testCreate()
    {
        $object = m::mock(PayrollBalanceFeedInterface::class);

        $data = ['payroll_balance_id' => 1,'element_id' => 1,'element_value_id' => 1,'add_or_substract' => 1,'created_by' => 1,'modified_by' => 1,];

        $object
            ->shouldReceive('getPayrollBalanceId')->andReturn($data['payroll_balance_id'])
            ->shouldReceive('getElementId')->andReturn($data['element_id'])
            ->shouldReceive('getElementValueId')->andReturn($data['element_value_id'])
            ->shouldReceive('getAddOrSubstract')->andReturn($data['add_or_substract'])
            ->shouldReceive('getCreatedBy')->andReturn($data['created_by'])
            ->shouldReceive('getModifiedBy')->andReturn($data['modified_by']);

        $this->eloquent->shouldReceive('create')->with($data)->andReturn($object);

        $result = $this->repository->create($object);
        $this->assertInstanceOf(PayrollBalanceFeedInterface::class, $result);
        $this->assertEquals($object, $result);
    }

    /**
     * Test delete PayrollBalanceFeed
     */
    public function testDelete()
    {
        $note = m::mock(PayrollBalanceFeedInterface::class);
        $note->shouldReceive('getKey')->andReturn(1);
        $this->eloquent->shouldReceive('delete')->with(1)->andReturn(true);
        $result = $this->repository->delete($note);
        $this->assertTrue($result);
    }

    /**
     * Test Update PayrollBalanceFeed
     */
    public function testUpdate()
    {
        $id = 1;
        $data = ['payroll_balance_id' => 1,'element_id' => 1,'element_value_id' => 1,'add_or_substract' => 1,'created_by' => 1,'modified_by' => 1,];

        $object = m::mock(PayrollBalanceFeedInterface::class);
        $object->shouldReceive('getKey')->andReturn($id);

        $object
            ->shouldReceive('getPayrollBalanceId')->andReturn($data['payroll_balance_id'])
            ->shouldReceive('getElementId')->andReturn($data['element_id'])
            ->shouldReceive('getElementValueId')->andReturn($data['element_value_id'])
            ->shouldReceive('getAddOrSubstract')->andReturn($data['add_or_substract'])
            ->shouldReceive('getCreatedBy')->andReturn($data['created_by'])
            ->shouldReceive('getModifiedBy')->andReturn($data['modified_by']);

        $this->eloquent->shouldReceive('update')->with($data, $id)->andReturn($object);

        $result = $this->repository->update($object);
        $this->assertEquals($object, $result);
    }
}

<?php
namespace Tests\Domains\HumanResources\Payroll\PayrollBalance;

use Mockery as m;
use Tests\TestCase;
use App\Infrastructures\HumanResources\Payroll\PayrollBalance\Contracts\EloquentPayrollBalanceRepositoryInterface;
use App\Domains\HumanResources\Payroll\PayrollBalance\PayrollBalanceRepository;
use App\Domains\HumanResources\Payroll\PayrollBalance\PayrollBalanceEloquent;
use App\Domains\HumanResources\Payroll\PayrollBalance\Contracts\PayrollBalanceInterface;
use App\Domains\HumanResources\Payroll\PayrollBalance\Contracts\PayrollBalanceRepositoryInterface;

class PayrollBalanceRepositoryTest extends TestCase
{
    private $eloquent;
    private $repository;

    protected function setUp()
    {
        parent::setUp();
        $this->eloquent = m::mock(EloquentPayrollBalanceRepositoryInterface::class);
        $this->repository = new PayrollBalanceRepository($this->eloquent);
    }

    protected function tearDown()
    {
        m::close();
    }

    public function testConstructor()
    {
        $this->assertInstanceOf(PayrollBalanceRepositoryInterface::class, $this->repository);
    }

    /**
     * Test create PayrollBalance
     */
    public function testCreate()
    {
        $object = m::mock(PayrollBalanceInterface::class);

        $data = ['name' => 1,'slug' => 1,'created_by' => 1,'modified_by' => 1,];

        $object
            ->shouldReceive('getName')->andReturn($data['name'])
            ->shouldReceive('getSlug')->andReturn($data['slug'])
            ->shouldReceive('getCreatedBy')->andReturn($data['created_by'])
            ->shouldReceive('getModifiedBy')->andReturn($data['modified_by']);

        $this->eloquent->shouldReceive('create')->with($data)->andReturn($object);

        $result = $this->repository->create($object);
        $this->assertInstanceOf(PayrollBalanceInterface::class, $result);
        $this->assertEquals($object, $result);
    }

    /**
     * Test delete PayrollBalance
     */
    public function testDelete()
    {
        $note = m::mock(PayrollBalanceInterface::class);
        $note->shouldReceive('getKey')->andReturn(1);
        $this->eloquent->shouldReceive('delete')->with(1)->andReturn(true);
        $result = $this->repository->delete($note);
        $this->assertTrue($result);
    }

    /**
     * Test Update PayrollBalance
     */
    public function testUpdate()
    {
        $id = 1;
        $data = ['name' => 1,'slug' => 1,'created_by' => 1,'modified_by' => 1,];

        $object = m::mock(PayrollBalanceInterface::class);
        $object->shouldReceive('getKey')->andReturn($id);

        $object
            ->shouldReceive('getName')->andReturn($data['name'])
            ->shouldReceive('getSlug')->andReturn($data['slug'])
            ->shouldReceive('getCreatedBy')->andReturn($data['created_by'])
            ->shouldReceive('getModifiedBy')->andReturn($data['modified_by']);

        $this->eloquent->shouldReceive('update')->with($data, $id)->andReturn($object);

        $result = $this->repository->update($object);
        $this->assertEquals($object, $result);
    }
}

<?php
namespace Tests\Domains\HumanResources\Payroll\PayrollProcessType;

use Mockery as m;
use Tests\TestCase;
use App\Infrastructures\HumanResources\Payroll\PayrollProcessType\Contracts\EloquentPayrollProcessTypeRepositoryInterface;
use App\Domains\HumanResources\Payroll\PayrollProcessType\PayrollProcessTypeRepository;
use App\Domains\HumanResources\Payroll\PayrollProcessType\PayrollProcessTypeEloquent;
use App\Domains\HumanResources\Payroll\PayrollProcessType\Contracts\PayrollProcessTypeInterface;
use App\Domains\HumanResources\Payroll\PayrollProcessType\Contracts\PayrollProcessTypeRepositoryInterface;

class PayrollProcessTypeRepositoryTest extends TestCase
{
    private $eloquent;
    private $repository;

    protected function setUp()
    {
        parent::setUp();
        $this->eloquent = m::mock(EloquentPayrollProcessTypeRepositoryInterface::class);
        $this->repository = new PayrollProcessTypeRepository($this->eloquent);
    }

    protected function tearDown()
    {
        m::close();
    }

    public function testConstructor()
    {
        $this->assertInstanceOf(PayrollProcessTypeRepositoryInterface::class, $this->repository);
    }

    /**
     * Test create PayrollProcessType
     */
    public function testCreate()
    {
        $object = m::mock(PayrollProcessTypeInterface::class);

        $data = ['name' => 1,'slug' => 1,'description' => 1,'created_by' => 1,'modified_by' => 1,];

        $object
            ->shouldReceive('getName')->andReturn($data['name'])
            ->shouldReceive('getSlug')->andReturn($data['slug'])
            ->shouldReceive('getDescription')->andReturn($data['description'])
            ->shouldReceive('getCreatedBy')->andReturn($data['created_by'])
            ->shouldReceive('getModifiedBy')->andReturn($data['modified_by']);

        $this->eloquent->shouldReceive('create')->with($data)->andReturn($object);

        $result = $this->repository->create($object);
        $this->assertInstanceOf(PayrollProcessTypeInterface::class, $result);
        $this->assertEquals($object, $result);
    }

    /**
     * Test delete PayrollProcessType
     */
    public function testDelete()
    {
        $note = m::mock(PayrollProcessTypeInterface::class);
        $note->shouldReceive('getKey')->andReturn(1);
        $this->eloquent->shouldReceive('delete')->with(1)->andReturn(true);
        $result = $this->repository->delete($note);
        $this->assertTrue($result);
    }

    /**
     * Test Update PayrollProcessType
     */
    public function testUpdate()
    {
        $id = 1;
        $data = ['name' => 1,'slug' => 1,'description' => 1,'created_by' => 1,'modified_by' => 1,];

        $object = m::mock(PayrollProcessTypeInterface::class);
        $object->shouldReceive('getKey')->andReturn($id);

        $object
            ->shouldReceive('getName')->andReturn($data['name'])
            ->shouldReceive('getSlug')->andReturn($data['slug'])
            ->shouldReceive('getDescription')->andReturn($data['description'])
            ->shouldReceive('getCreatedBy')->andReturn($data['created_by'])
            ->shouldReceive('getModifiedBy')->andReturn($data['modified_by']);

        $this->eloquent->shouldReceive('update')->with($data, $id)->andReturn($object);

        $result = $this->repository->update($object);
        $this->assertEquals($object, $result);
    }
}

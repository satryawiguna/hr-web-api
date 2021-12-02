<?php
namespace Tests\Domains\HumanResources\Mutation\WorkUnitMutation;

use Mockery as m;
use Tests\TestCase;
use App\Infrastructures\HumanResources\Mutation\WorkUnitMutation\Contracts\EloquentWorkUnitMutationRepositoryInterface;
use App\Domains\HumanResources\Mutation\WorkUnitMutation\WorkUnitMutationRepository;
use App\Domains\HumanResources\Mutation\WorkUnitMutation\WorkUnitMutationEloquent;
use App\Domains\HumanResources\Mutation\WorkUnitMutation\Contracts\WorkUnitMutationInterface;
use App\Domains\HumanResources\Mutation\WorkUnitMutation\Contracts\WorkUnitMutationRepositoryInterface;

class WorkUnitMutationRepositoryTest extends TestCase
{
    private $eloquent;
    private $repository;

    protected function setUp()
    {
        parent::setUp();
        $this->eloquent = m::mock(EloquentWorkUnitMutationRepositoryInterface::class);
        $this->repository = new WorkUnitMutationRepository($this->eloquent);
    }

    protected function tearDown()
    {
        m::close();
    }

    public function testConstructor()
    {
        $this->assertInstanceOf(WorkUnitMutationRepositoryInterface::class, $this->repository);
    }

    /**
     * Test create WorkUnitMutation
     */
    public function testCreate()
    {
        $object = m::mock(WorkUnitMutationInterface::class);

        $data = ['employee_id' => 1,'work_unit_id' => 1,'mutation_date' => 1,'created_by' => 1,'modified_by' => 1,];

        $object
            ->shouldReceive('getEmployeeId')->andReturn($data['employee_id'])
            ->shouldReceive('getWorkUnitId')->andReturn($data['work_unit_id'])
            ->shouldReceive('getMutationDate')->andReturn($data['mutation_date'])
            ->shouldReceive('getCreatedBy')->andReturn($data['created_by'])
            ->shouldReceive('getModifiedBy')->andReturn($data['modified_by']);

        $this->eloquent->shouldReceive('create')->with($data)->andReturn($object);

        $result = $this->repository->create($object);
        $this->assertInstanceOf(WorkUnitMutationInterface::class, $result);
        $this->assertEquals($object, $result);
    }

    /**
     * Test delete WorkUnitMutation
     */
    public function testDelete()
    {
        $note = m::mock(WorkUnitMutationInterface::class);
        $note->shouldReceive('getKey')->andReturn(1);
        $this->eloquent->shouldReceive('delete')->with(1)->andReturn(true);
        $result = $this->repository->delete($note);
        $this->assertTrue($result);
    }

    /**
     * Test Update WorkUnitMutation
     */
    public function testUpdate()
    {
        $id = 1;
        $data = ['employee_id' => 1,'work_unit_id' => 1,'mutation_date' => 1,'created_by' => 1,'modified_by' => 1,];

        $object = m::mock(WorkUnitMutationInterface::class);
        $object->shouldReceive('getKey')->andReturn($id);

        $object
            ->shouldReceive('getEmployeeId')->andReturn($data['employee_id'])
            ->shouldReceive('getWorkUnitId')->andReturn($data['work_unit_id'])
            ->shouldReceive('getMutationDate')->andReturn($data['mutation_date'])
            ->shouldReceive('getCreatedBy')->andReturn($data['created_by'])
            ->shouldReceive('getModifiedBy')->andReturn($data['modified_by']);

        $this->eloquent->shouldReceive('update')->with($data, $id)->andReturn($object);

        $result = $this->repository->update($object);
        $this->assertEquals($object, $result);
    }
}

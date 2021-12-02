<?php
namespace Tests\Domains\HumanResources\Mutation\PositionMutation;

use Mockery as m;
use Tests\TestCase;
use App\Infrastructures\HumanResources\Mutation\PositionMutation\Contracts\EloquentPositionMutationRepositoryInterface;
use App\Domains\HumanResources\Mutation\PositionMutation\PositionMutationRepository;
use App\Domains\HumanResources\Mutation\PositionMutation\PositionMutationEloquent;
use App\Domains\HumanResources\Mutation\PositionMutation\Contracts\PositionMutationInterface;
use App\Domains\HumanResources\Mutation\PositionMutation\Contracts\PositionMutationRepositoryInterface;

class PositionMutationRepositoryTest extends TestCase
{
    private $eloquent;
    private $repository;

    protected function setUp()
    {
        parent::setUp();
        $this->eloquent = m::mock(EloquentPositionMutationRepositoryInterface::class);
        $this->repository = new PositionMutationRepository($this->eloquent);
    }

    protected function tearDown()
    {
        m::close();
    }

    public function testConstructor()
    {
        $this->assertInstanceOf(PositionMutationRepositoryInterface::class, $this->repository);
    }

    /**
     * Test create PositionMutation
     */
    public function testCreate()
    {
        $object = m::mock(PositionMutationInterface::class);

        $data = ['employee_id' => 1,'position_id' => 1,'mutation_date' => 1,'created_by' => 1,'modified_by' => 1,];

        $object
            ->shouldReceive('getEmployeeId')->andReturn($data['employee_id'])
            ->shouldReceive('getPositionId')->andReturn($data['position_id'])
            ->shouldReceive('getMutationDate')->andReturn($data['mutation_date'])
            ->shouldReceive('getCreatedBy')->andReturn($data['created_by'])
            ->shouldReceive('getModifiedBy')->andReturn($data['modified_by']);

        $this->eloquent->shouldReceive('create')->with($data)->andReturn($object);

        $result = $this->repository->create($object);
        $this->assertInstanceOf(PositionMutationInterface::class, $result);
        $this->assertEquals($object, $result);
    }

    /**
     * Test delete PositionMutation
     */
    public function testDelete()
    {
        $note = m::mock(PositionMutationInterface::class);
        $note->shouldReceive('getKey')->andReturn(1);
        $this->eloquent->shouldReceive('delete')->with(1)->andReturn(true);
        $result = $this->repository->delete($note);
        $this->assertTrue($result);
    }

    /**
     * Test Update PositionMutation
     */
    public function testUpdate()
    {
        $id = 1;
        $data = ['employee_id' => 1,'position_id' => 1,'mutation_date' => 1,'created_by' => 1,'modified_by' => 1,];

        $object = m::mock(PositionMutationInterface::class);
        $object->shouldReceive('getKey')->andReturn($id);

        $object
            ->shouldReceive('getEmployeeId')->andReturn($data['employee_id'])
            ->shouldReceive('getPositionId')->andReturn($data['position_id'])
            ->shouldReceive('getMutationDate')->andReturn($data['mutation_date'])
            ->shouldReceive('getCreatedBy')->andReturn($data['created_by'])
            ->shouldReceive('getModifiedBy')->andReturn($data['modified_by']);

        $this->eloquent->shouldReceive('update')->with($data, $id)->andReturn($object);

        $result = $this->repository->update($object);
        $this->assertEquals($object, $result);
    }
}

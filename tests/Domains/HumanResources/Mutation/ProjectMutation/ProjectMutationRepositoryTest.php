<?php
namespace Tests\Domains\HumanResources\Mutation\ProjectMutation;

use Mockery as m;
use Tests\TestCase;
use App\Infrastructures\HumanResources\Mutation\ProjectMutation\Contracts\EloquentProjectMutationRepositoryInterface;
use App\Domains\HumanResources\Mutation\ProjectMutation\ProjectMutationRepository;
use App\Domains\HumanResources\Mutation\ProjectMutation\ProjectMutationEloquent;
use App\Domains\HumanResources\Mutation\ProjectMutation\Contracts\ProjectMutationInterface;
use App\Domains\HumanResources\Mutation\ProjectMutation\Contracts\ProjectMutationRepositoryInterface;

class ProjectMutationRepositoryTest extends TestCase
{
    private $eloquent;
    private $repository;

    protected function setUp()
    {
        parent::setUp();
        $this->eloquent = m::mock(EloquentProjectMutationRepositoryInterface::class);
        $this->repository = new ProjectMutationRepository($this->eloquent);
    }

    protected function tearDown()
    {
        m::close();
    }

    public function testConstructor()
    {
        $this->assertInstanceOf(ProjectMutationRepositoryInterface::class, $this->repository);
    }

    /**
     * Test create ProjectMutation
     */
    public function testCreate()
    {
        $object = m::mock(ProjectMutationInterface::class);

        $data = [];

        $object;

        $this->eloquent->shouldReceive('create')->with($data)->andReturn($object);

        $result = $this->repository->create($object);
        $this->assertInstanceOf(ProjectMutationInterface::class, $result);
        $this->assertEquals($object, $result);
    }

    /**
     * Test delete ProjectMutation
     */
    public function testDelete()
    {
        $note = m::mock(ProjectMutationInterface::class);
        $note->shouldReceive('getKey')->andReturn(1);
        $this->eloquent->shouldReceive('delete')->with(1)->andReturn(true);
        $result = $this->repository->delete($note);
        $this->assertTrue($result);
    }

    /**
     * Test Update ProjectMutation
     */
    public function testUpdate()
    {
        $id = 1;
        $data = [];

        $object = m::mock(ProjectMutationInterface::class);
        $object->shouldReceive('getKey')->andReturn($id);

        $object;

        $this->eloquent->shouldReceive('update')->with($data, $id)->andReturn($object);

        $result = $this->repository->update($object);
        $this->assertEquals($object, $result);
    }
}

<?php
namespace Tests\Domains\HumanResources\Mutation\WorkUnitMutation;

use App\Domains\HumanResources\Mutation\WorkUnitMutation\Contracts\WorkUnitMutationInterface;
use App\Domains\HumanResources\Mutation\WorkUnitMutation\Contracts\WorkUnitMutationRepositoryInterface;
use App\Domains\HumanResources\Mutation\WorkUnitMutation\Contracts\WorkUnitMutationServiceInterface;
use App\Domains\HumanResources\Mutation\WorkUnitMutation\WorkUnitMutationEloquent;
use App\Domains\HumanResources\Mutation\WorkUnitMutation\WorkUnitMutationService;
use Mockery as m;
use Tests\TestCase;

class WorkUnitMutationServiceTest extends TestCase
{
    private $repository;
    private $service;

    /**
     * Set up test.
     */
    protected function setUp()
    {
        parent::setUp();

        $this->repository = m::mock(WorkUnitMutationRepositoryInterface::class);
        $this->service = new WorkUnitMutationService(
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
        $this->assertInstanceOf(WorkUnitMutationServiceInterface::class, $this->service);
    }

    /**
     * Test create notes.
     */
    public function testCreate()
    {
        $object = m::mock(WorkUnitMutationInterface::class);
        $this->repository->shouldReceive('create')->with($object)->andReturn($object);
        $result = $this->service->create($object);
        $this->assertInstanceOf(WorkUnitMutationInterface::class, $result);
        $this->assertEquals($object, $result);
    }

    /**
     * Test delete notes.
     */
    public function testDelete()
    {
        $object = m::mock(WorkUnitMutationInterface::class);
        $this->repository->shouldReceive('delete')->with($object)->andReturn(true);
        $result = $this->service->delete($object);
        $this->assertTrue($result);
    }

    /**
     * Test update notes.
     */
    public function testUpdate()
    {
        $object = m::mock(WorkUnitMutationInterface::class);
        $this->repository->shouldReceive('update')->with($object)->andReturn($object);
        $result = $this->service->update($object);
        $this->assertEquals($object, $result);
    }
}

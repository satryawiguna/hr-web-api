<?php
namespace Tests\Domains\HumanResources\Mutation\PositionMutation;

use App\Domains\HumanResources\Mutation\PositionMutation\Contracts\PositionMutationInterface;
use App\Domains\HumanResources\Mutation\PositionMutation\Contracts\PositionMutationRepositoryInterface;
use App\Domains\HumanResources\Mutation\PositionMutation\Contracts\PositionMutationServiceInterface;
use App\Domains\HumanResources\Mutation\PositionMutation\PositionMutationEloquent;
use App\Domains\HumanResources\Mutation\PositionMutation\PositionMutationService;
use Mockery as m;
use Tests\TestCase;

class PositionMutationServiceTest extends TestCase
{
    private $repository;
    private $service;

    /**
     * Set up test.
     */
    protected function setUp()
    {
        parent::setUp();

        $this->repository = m::mock(PositionMutationRepositoryInterface::class);
        $this->service = new PositionMutationService(
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
        $this->assertInstanceOf(PositionMutationServiceInterface::class, $this->service);
    }

    /**
     * Test create notes.
     */
    public function testCreate()
    {
        $object = m::mock(PositionMutationInterface::class);
        $this->repository->shouldReceive('create')->with($object)->andReturn($object);
        $result = $this->service->create($object);
        $this->assertInstanceOf(PositionMutationInterface::class, $result);
        $this->assertEquals($object, $result);
    }

    /**
     * Test delete notes.
     */
    public function testDelete()
    {
        $object = m::mock(PositionMutationInterface::class);
        $this->repository->shouldReceive('delete')->with($object)->andReturn(true);
        $result = $this->service->delete($object);
        $this->assertTrue($result);
    }

    /**
     * Test update notes.
     */
    public function testUpdate()
    {
        $object = m::mock(PositionMutationInterface::class);
        $this->repository->shouldReceive('update')->with($object)->andReturn($object);
        $result = $this->service->update($object);
        $this->assertEquals($object, $result);
    }
}

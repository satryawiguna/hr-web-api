<?php
namespace Tests\Domains\HumanResources\MasterData\WorkUnit;

use App\Domains\HumanResources\MasterData\WorkUnit\Contracts\WorkUnitInterface;
use App\Domains\HumanResources\MasterData\WorkUnit\Contracts\WorkUnitRepositoryInterface;
use App\Domains\HumanResources\MasterData\WorkUnit\Contracts\WorkUnitServiceInterface;
use App\Domains\HumanResources\MasterData\WorkUnit\WorkUnitEloquent;
use App\Domains\HumanResources\MasterData\WorkUnit\WorkUnitService;
use Mockery as m;
use Tests\TestCase;

class WorkUnitServiceTest extends TestCase
{
    private $repository;
    private $service;

    /**
     * Set up test.
     */
    protected function setUp()
    {
        parent::setUp();

        $this->repository = m::mock(WorkUnitRepositoryInterface::class);
        $this->service = new WorkUnitService(
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
        $this->assertInstanceOf(WorkUnitServiceInterface::class, $this->service);
    }

    /**
     * Test create notes.
     */
    public function testCreate()
    {
        $object = m::mock(WorkUnitInterface::class);
        $this->repository->shouldReceive('create')->with($object)->andReturn($object);
        $result = $this->service->create($object);
        $this->assertInstanceOf(WorkUnitInterface::class, $result);
        $this->assertEquals($object, $result);
    }

    /**
     * Test delete notes.
     */
    public function testDelete()
    {
        $object = m::mock(WorkUnitInterface::class);
        $this->repository->shouldReceive('delete')->with($object)->andReturn(true);
        $result = $this->service->delete($object);
        $this->assertTrue($result);
    }

    /**
     * Test update notes.
     */
    public function testUpdate()
    {
        $object = m::mock(WorkUnitInterface::class);
        $this->repository->shouldReceive('update')->with($object)->andReturn($object);
        $result = $this->service->update($object);
        $this->assertEquals($object, $result);
    }
}

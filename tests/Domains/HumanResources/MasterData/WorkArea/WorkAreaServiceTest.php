<?php
namespace Tests\Domains\HumanResources\MasterData\WorkArea;

use App\Domains\HumanResources\MasterData\WorkArea\Contracts\WorkAreaInterface;
use App\Domains\HumanResources\MasterData\WorkArea\Contracts\WorkAreaRepositoryInterface;
use App\Domains\HumanResources\MasterData\WorkArea\Contracts\WorkAreaServiceInterface;
use App\Domains\HumanResources\MasterData\WorkArea\WorkAreaEloquent;
use App\Domains\HumanResources\MasterData\WorkArea\WorkAreaService;
use Mockery as m;
use Tests\TestCase;

class WorkAreaServiceTest extends TestCase
{
    private $repository;
    private $service;

    /**
     * Set up test.
     */
    protected function setUp()
    {
        parent::setUp();

        $this->repository = m::mock(WorkAreaRepositoryInterface::class);
        $this->service = new WorkAreaService(
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
        $this->assertInstanceOf(WorkAreaServiceInterface::class, $this->service);
    }

    /**
     * Test create notes.
     */
    public function testCreate()
    {
        $object = m::mock(WorkAreaInterface::class);
        $this->repository->shouldReceive('create')->with($object)->andReturn($object);
        $result = $this->service->create($object);
        $this->assertInstanceOf(WorkAreaInterface::class, $result);
        $this->assertEquals($object, $result);
    }

    /**
     * Test delete notes.
     */
    public function testDelete()
    {
        $object = m::mock(WorkAreaInterface::class);
        $this->repository->shouldReceive('delete')->with($object)->andReturn(true);
        $result = $this->service->delete($object);
        $this->assertTrue($result);
    }

    /**
     * Test update notes.
     */
    public function testUpdate()
    {
        $object = m::mock(WorkAreaInterface::class);
        $this->repository->shouldReceive('update')->with($object)->andReturn($object);
        $result = $this->service->update($object);
        $this->assertEquals($object, $result);
    }
}

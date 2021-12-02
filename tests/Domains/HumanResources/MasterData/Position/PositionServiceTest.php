<?php
namespace Tests\Domains\HumanResources\MasterData\Position;

use App\Domains\HumanResources\MasterData\Position\Contracts\PositionInterface;
use App\Domains\HumanResources\MasterData\Position\Contracts\PositionRepositoryInterface;
use App\Domains\HumanResources\MasterData\Position\Contracts\PositionServiceInterface;
use App\Domains\HumanResources\MasterData\Position\PositionEloquent;
use App\Domains\HumanResources\MasterData\Position\PositionService;
use Mockery as m;
use Tests\TestCase;

class PositionServiceTest extends TestCase
{
    private $repository;
    private $service;

    /**
     * Set up test.
     */
    protected function setUp()
    {
        parent::setUp();

        $this->repository = m::mock(PositionRepositoryInterface::class);
        $this->service = new PositionService(
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
        $this->assertInstanceOf(PositionServiceInterface::class, $this->service);
    }

    /**
     * Test create notes.
     */
    public function testCreate()
    {
        $object = m::mock(PositionInterface::class);
        $this->repository->shouldReceive('create')->with($object)->andReturn($object);
        $result = $this->service->create($object);
        $this->assertInstanceOf(PositionInterface::class, $result);
        $this->assertEquals($object, $result);
    }

    /**
     * Test delete notes.
     */
    public function testDelete()
    {
        $object = m::mock(PositionInterface::class);
        $this->repository->shouldReceive('delete')->with($object)->andReturn(true);
        $result = $this->service->delete($object);
        $this->assertTrue($result);
    }

    /**
     * Test update notes.
     */
    public function testUpdate()
    {
        $object = m::mock(PositionInterface::class);
        $this->repository->shouldReceive('update')->with($object)->andReturn($object);
        $result = $this->service->update($object);
        $this->assertEquals($object, $result);
    }
}

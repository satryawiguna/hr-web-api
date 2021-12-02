<?php
namespace Tests\Infrastructures\HumanResources\Personal\Employee\OtherEquipment;

use App\Infrastructures\HumanResources\Personal\Employee\OtherEquipment\Contracts\OtherEquipmentInterface;
use App\Infrastructures\HumanResources\Personal\Employee\OtherEquipment\Contracts\OtherEquipmentRepositoryInterface;
use App\Infrastructures\HumanResources\Personal\Employee\OtherEquipment\Contracts\OtherEquipmentServiceInterface;
use App\Infrastructures\HumanResources\Personal\Employee\OtherEquipment\OtherEquipmentEloquent;
use App\Infrastructures\HumanResources\Personal\Employee\OtherEquipment\OtherEquipmentService;
use Mockery as m;
use Tests\TestCase;

class OtherEquipmentServiceTest extends TestCase
{
    private $repository;
    private $service;

    /**
     * Set up test.
     */
    protected function setUp()
    {
        parent::setUp();

        $this->repository = m::mock(OtherEquipmentRepositoryInterface::class);
        $this->service = new OtherEquipmentService(
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
        $this->assertInstanceOf(OtherEquipmentServiceInterface::class, $this->service);
    }

    /**
     * Test create notes.
     */
    public function testCreate()
    {
        $object = m::mock(OtherEquipmentInterface::class);
        $this->repository->shouldReceive('create')->with($object)->andReturn($object);
        $result = $this->service->create($object);
        $this->assertInstanceOf(OtherEquipmentInterface::class, $result);
        $this->assertEquals($object, $result);
    }

    /**
     * Test delete notes.
     */
    public function testDelete()
    {
        $object = m::mock(OtherEquipmentInterface::class);
        $this->repository->shouldReceive('delete')->with($object)->andReturn(true);
        $result = $this->service->delete($object);
        $this->assertTrue($result);
    }

    /**
     * Test update notes.
     */
    public function testUpdate()
    {
        $object = m::mock(OtherEquipmentInterface::class);
        $this->repository->shouldReceive('update')->with($object)->andReturn($object);
        $result = $this->service->update($object);
        $this->assertEquals($object, $result);
    }
}

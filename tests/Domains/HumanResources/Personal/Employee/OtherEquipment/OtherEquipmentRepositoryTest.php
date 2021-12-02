<?php
namespace Tests\Infrastructures\HumanResources\Personal\Employee\OtherEquipment;

use Mockery as m;
use Tests\TestCase;
use App\Infrastructures\HumanResources\Personal\Employee\OtherEquipment\Contracts\EloquentOtherEquipmentRepositoryInterface;
use App\Infrastructures\HumanResources\Personal\Employee\OtherEquipment\OtherEquipmentRepository;
use App\Infrastructures\HumanResources\Personal\Employee\OtherEquipment\OtherEquipmentEloquent;
use App\Infrastructures\HumanResources\Personal\Employee\OtherEquipment\Contracts\OtherEquipmentInterface;
use App\Infrastructures\HumanResources\Personal\Employee\OtherEquipment\Contracts\OtherEquipmentRepositoryInterface;

class OtherEquipmentRepositoryTest extends TestCase
{
    private $eloquent;
    private $repository;

    protected function setUp()
    {
        parent::setUp();
        $this->eloquent = m::mock(EloquentOtherEquipmentRepositoryInterface::class);
        $this->repository = new OtherEquipmentRepository($this->eloquent);
    }

    protected function tearDown()
    {
        m::close();
    }

    public function testConstructor()
    {
        $this->assertInstanceOf(OtherEquipmentRepositoryInterface::class, $this->repository);
    }

    /**
     * Test create OtherEquipment
     */
    public function testCreate()
    {
        $object = m::mock(OtherEquipmentInterface::class);

        $data = ['employee_id' => 1,'name' => 1,'description' => 1,'created_by' => 1,'modified_by' => 1,];

        $object
            ->shouldReceive('getEmployeeId')->andReturn($data['employee_id'])
            ->shouldReceive('getName')->andReturn($data['name'])
            ->shouldReceive('getDescription')->andReturn($data['description'])
            ->shouldReceive('getCreatedBy')->andReturn($data['created_by'])
            ->shouldReceive('getModifiedBy')->andReturn($data['modified_by']);

        $this->eloquent->shouldReceive('create')->with($data)->andReturn($object);

        $result = $this->repository->create($object);
        $this->assertInstanceOf(OtherEquipmentInterface::class, $result);
        $this->assertEquals($object, $result);
    }

    /**
     * Test delete OtherEquipment
     */
    public function testDelete()
    {
        $note = m::mock(OtherEquipmentInterface::class);
        $note->shouldReceive('getKey')->andReturn(1);
        $this->eloquent->shouldReceive('delete')->with(1)->andReturn(true);
        $result = $this->repository->delete($note);
        $this->assertTrue($result);
    }

    /**
     * Test Update OtherEquipment
     */
    public function testUpdate()
    {
        $id = 1;
        $data = ['employee_id' => 1,'name' => 1,'description' => 1,'created_by' => 1,'modified_by' => 1,];

        $object = m::mock(OtherEquipmentInterface::class);
        $object->shouldReceive('getKey')->andReturn($id);

        $object
            ->shouldReceive('getEmployeeId')->andReturn($data['employee_id'])
            ->shouldReceive('getName')->andReturn($data['name'])
            ->shouldReceive('getDescription')->andReturn($data['description'])
            ->shouldReceive('getCreatedBy')->andReturn($data['created_by'])
            ->shouldReceive('getModifiedBy')->andReturn($data['modified_by']);

        $this->eloquent->shouldReceive('update')->with($data, $id)->andReturn($object);

        $result = $this->repository->update($object);
        $this->assertEquals($object, $result);
    }
}

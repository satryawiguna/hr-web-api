<?php
namespace Tests\Domains\HumanResources\MasterData\Position;

use Mockery as m;
use Tests\TestCase;
use App\Infrastructures\HumanResources\MasterData\Position\Contracts\EloquentPositionRepositoryInterface;
use App\Domains\HumanResources\MasterData\Position\PositionRepository;
use App\Domains\HumanResources\MasterData\Position\PositionEloquent;
use App\Domains\HumanResources\MasterData\Position\Contracts\PositionInterface;
use App\Domains\HumanResources\MasterData\Position\Contracts\PositionRepositoryInterface;

class PositionRepositoryTest extends TestCase
{
    private $eloquent;
    private $repository;

    protected function setUp()
    {
        parent::setUp();
        $this->eloquent = m::mock(EloquentPositionRepositoryInterface::class);
        $this->repository = new PositionRepository($this->eloquent);
    }

    protected function tearDown()
    {
        m::close();
    }

    public function testConstructor()
    {
        $this->assertInstanceOf(PositionRepositoryInterface::class, $this->repository);
    }

    /**
     * Test create Position
     */
    public function testCreate()
    {
        $object = m::mock(PositionInterface::class);

        $data = ['parent_id' => 1,'company_id' => 1,'code' => 1,'name' => 1,'slug' => 1,'is_active' => 1,'created_by' => 1,'modified_by' => 1,];

        $object
            ->shouldReceive('getParentId')->andReturn($data['parent_id'])
            ->shouldReceive('getCompanyId')->andReturn($data['company_id'])
            ->shouldReceive('getCode')->andReturn($data['code'])
            ->shouldReceive('getName')->andReturn($data['name'])
            ->shouldReceive('getSlug')->andReturn($data['slug'])
            ->shouldReceive('getIsActive')->andReturn($data['is_active'])
            ->shouldReceive('getCreatedBy')->andReturn($data['created_by'])
            ->shouldReceive('getModifiedBy')->andReturn($data['modified_by']);

        $this->eloquent->shouldReceive('create')->with($data)->andReturn($object);

        $result = $this->repository->create($object);
        $this->assertInstanceOf(PositionInterface::class, $result);
        $this->assertEquals($object, $result);
    }

    /**
     * Test delete Position
     */
    public function testDelete()
    {
        $note = m::mock(PositionInterface::class);
        $note->shouldReceive('getKey')->andReturn(1);
        $this->eloquent->shouldReceive('delete')->with(1)->andReturn(true);
        $result = $this->repository->delete($note);
        $this->assertTrue($result);
    }

    /**
     * Test Update Position
     */
    public function testUpdate()
    {
        $id = 1;
        $data = ['parent_id' => 1,'company_id' => 1,'code' => 1,'name' => 1,'slug' => 1,'is_active' => 1,'created_by' => 1,'modified_by' => 1,];

        $object = m::mock(PositionInterface::class);
        $object->shouldReceive('getKey')->andReturn($id);

        $object
            ->shouldReceive('getParentId')->andReturn($data['parent_id'])
            ->shouldReceive('getCompanyId')->andReturn($data['company_id'])
            ->shouldReceive('getCode')->andReturn($data['code'])
            ->shouldReceive('getName')->andReturn($data['name'])
            ->shouldReceive('getSlug')->andReturn($data['slug'])
            ->shouldReceive('getIsActive')->andReturn($data['is_active'])
            ->shouldReceive('getCreatedBy')->andReturn($data['created_by'])
            ->shouldReceive('getModifiedBy')->andReturn($data['modified_by']);

        $this->eloquent->shouldReceive('update')->with($data, $id)->andReturn($object);

        $result = $this->repository->update($object);
        $this->assertEquals($object, $result);
    }
}

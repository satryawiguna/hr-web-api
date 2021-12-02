<?php
namespace Tests\Domains\Commons\Group;

use Mockery as m;
use Tests\TestCase;
use App\Infrastructures\Commons\Group\Contracts\EloquentGroupRepositoryInterface;
use App\Domains\Commons\Group\GroupRepository;
use App\Domains\Commons\Group\GroupEloquent;
use App\Domains\Commons\Group\Contracts\GroupInterface;
use App\Domains\Commons\Group\Contracts\GroupRepositoryInterface;

class GroupRepositoryTest extends TestCase
{
    private $eloquent;
    private $repository;

    protected function setUp()
    {
        parent::setUp();
        $this->eloquent = m::mock(EloquentGroupRepositoryInterface::class);
        $this->repository = new GroupRepository($this->eloquent);
    }

    protected function tearDown()
    {
        m::close();
    }

    public function testConstructor()
    {
        $this->assertInstanceOf(GroupRepositoryInterface::class, $this->repository);
    }

    /**
     * Test create Group
     */
    public function testCreate()
    {
        $object = m::mock(GroupInterface::class);

        $data = ['role_id' => 1,'name' => 1,'slug' => 1,'description' => 1,'is_active' => 1,'created_by' => 1,'modified_by' => 1,];

        $object
            ->shouldReceive('getRoleId')->andReturn($data['role_id'])
            ->shouldReceive('getName')->andReturn($data['name'])
            ->shouldReceive('getSlug')->andReturn($data['slug'])
            ->shouldReceive('getDescription')->andReturn($data['description'])
            ->shouldReceive('getIsActive')->andReturn($data['is_active'])
            ->shouldReceive('getCreatedBy')->andReturn($data['created_by'])
            ->shouldReceive('getModifiedBy')->andReturn($data['modified_by']);

        $this->eloquent->shouldReceive('create')->with($data)->andReturn($object);

        $result = $this->repository->create($object);
        $this->assertInstanceOf(GroupInterface::class, $result);
        $this->assertEquals($object, $result);
    }

    /**
     * Test delete Group
     */
    public function testDelete()
    {
        $note = m::mock(GroupInterface::class);
        $note->shouldReceive('getKey')->andReturn(1);
        $this->eloquent->shouldReceive('delete')->with(1)->andReturn(true);
        $result = $this->repository->delete($note);
        $this->assertTrue($result);
    }

    /**
     * Test Update Group
     */
    public function testUpdate()
    {
        $id = 1;
        $data = ['role_id' => 1,'name' => 1,'slug' => 1,'description' => 1,'is_active' => 1,'created_by' => 1,'modified_by' => 1,];

        $object = m::mock(GroupInterface::class);
        $object->shouldReceive('getKey')->andReturn($id);

        $object
            ->shouldReceive('getRoleId')->andReturn($data['role_id'])
            ->shouldReceive('getName')->andReturn($data['name'])
            ->shouldReceive('getSlug')->andReturn($data['slug'])
            ->shouldReceive('getDescription')->andReturn($data['description'])
            ->shouldReceive('getIsActive')->andReturn($data['is_active'])
            ->shouldReceive('getCreatedBy')->andReturn($data['created_by'])
            ->shouldReceive('getModifiedBy')->andReturn($data['modified_by']);

        $this->eloquent->shouldReceive('update')->with($data, $id)->andReturn($object);

        $result = $this->repository->update($object);
        $this->assertEquals($object, $result);
    }
}

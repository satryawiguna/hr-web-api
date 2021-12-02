<?php
namespace Tests\Domains\Commons\Role;

use Mockery as m;
use Tests\TestCase;
use App\Infrastructures\Commons\Role\Contracts\EloquentRoleRepositoryInterface;
use App\Domains\Commons\Role\RoleRepository;
use App\Domains\Commons\Role\RoleEloquent;
use App\Domains\Commons\Role\Contracts\RoleInterface;
use App\Domains\Commons\Role\Contracts\RoleRepositoryInterface;

class RoleRepositoryTest extends TestCase
{
    private $eloquent;
    private $repository;

    protected function setUp()
    {
        parent::setUp();
        $this->eloquent = m::mock(EloquentRoleRepositoryInterface::class);
        $this->repository = new RoleRepository($this->eloquent);
    }

    protected function tearDown()
    {
        m::close();
    }

    public function testConstructor()
    {
        $this->assertInstanceOf(RoleRepositoryInterface::class, $this->repository);
    }

    /**
     * Test create Role
     */
    public function testCreate()
    {
        $object = m::mock(RoleInterface::class);

        $data = ['name' => 1,'slug' => 1,'is_active' => 1,'created_by' => 1,'modified_by' => 1,];

        $object
            ->shouldReceive('getName')->andReturn($data['name'])
            ->shouldReceive('getSlug')->andReturn($data['slug'])
            ->shouldReceive('getIsActive')->andReturn($data['is_active'])
            ->shouldReceive('getCreatedBy')->andReturn($data['created_by'])
            ->shouldReceive('getModifiedBy')->andReturn($data['modified_by']);

        $this->eloquent->shouldReceive('create')->with($data)->andReturn($object);

        $result = $this->repository->create($object);
        $this->assertInstanceOf(RoleInterface::class, $result);
        $this->assertEquals($object, $result);
    }

    /**
     * Test delete Role
     */
    public function testDelete()
    {
        $note = m::mock(RoleInterface::class);
        $note->shouldReceive('getKey')->andReturn(1);
        $this->eloquent->shouldReceive('delete')->with(1)->andReturn(true);
        $result = $this->repository->delete($note);
        $this->assertTrue($result);
    }

    /**
     * Test Update Role
     */
    public function testUpdate()
    {
        $id = 1;
        $data = ['name' => 1,'slug' => 1,'is_active' => 1,'created_by' => 1,'modified_by' => 1,];

        $object = m::mock(RoleInterface::class);
        $object->shouldReceive('getKey')->andReturn($id);

        $object
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

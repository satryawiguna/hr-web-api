<?php
namespace Tests\Domains\Commons\Permission;

use Mockery as m;
use Tests\TestCase;
use App\Infrastructures\Commons\Permission\Contracts\EloquentPermissionRepositoryInterface;
use App\Domains\Commons\Permission\PermissionRepository;
use App\Domains\Commons\Permission\PermissionEloquent;
use App\Domains\Commons\Permission\Contracts\PermissionInterface;
use App\Domains\Commons\Permission\Contracts\PermissionRepositoryInterface;

class PermissionRepositoryTest extends TestCase
{
    private $eloquent;
    private $repository;

    protected function setUp()
    {
        parent::setUp();
        $this->eloquent = m::mock(EloquentPermissionRepositoryInterface::class);
        $this->repository = new PermissionRepository($this->eloquent);
    }

    protected function tearDown()
    {
        m::close();
    }

    public function testConstructor()
    {
        $this->assertInstanceOf(PermissionRepositoryInterface::class, $this->repository);
    }

    /**
     * Test create Permission
     */
    public function testCreate()
    {
        $object = m::mock(PermissionInterface::class);

        $data = ['name' => 1,'slug' => 1,'category' => 1,'type' => 1,'description' => 1,'is_active' => 1,'created_by' => 1,'modified_by' => 1,];

        $object
            ->shouldReceive('getName')->andReturn($data['name'])
            ->shouldReceive('getSlug')->andReturn($data['slug'])
            ->shouldReceive('getCategory')->andReturn($data['category'])
            ->shouldReceive('getType')->andReturn($data['type'])
            ->shouldReceive('getDescription')->andReturn($data['description'])
            ->shouldReceive('getIsActive')->andReturn($data['is_active'])
            ->shouldReceive('getCreatedBy')->andReturn($data['created_by'])
            ->shouldReceive('getModifiedBy')->andReturn($data['modified_by']);

        $this->eloquent->shouldReceive('create')->with($data)->andReturn($object);

        $result = $this->repository->create($object);
        $this->assertInstanceOf(PermissionInterface::class, $result);
        $this->assertEquals($object, $result);
    }

    /**
     * Test delete Permission
     */
    public function testDelete()
    {
        $note = m::mock(PermissionInterface::class);
        $note->shouldReceive('getKey')->andReturn(1);
        $this->eloquent->shouldReceive('delete')->with(1)->andReturn(true);
        $result = $this->repository->delete($note);
        $this->assertTrue($result);
    }

    /**
     * Test Update Permission
     */
    public function testUpdate()
    {
        $id = 1;
        $data = ['name' => 1,'slug' => 1,'category' => 1,'type' => 1,'description' => 1,'is_active' => 1,'created_by' => 1,'modified_by' => 1,];

        $object = m::mock(PermissionInterface::class);
        $object->shouldReceive('getKey')->andReturn($id);

        $object
            ->shouldReceive('getName')->andReturn($data['name'])
            ->shouldReceive('getSlug')->andReturn($data['slug'])
            ->shouldReceive('getCategory')->andReturn($data['category'])
            ->shouldReceive('getType')->andReturn($data['type'])
            ->shouldReceive('getDescription')->andReturn($data['description'])
            ->shouldReceive('getIsActive')->andReturn($data['is_active'])
            ->shouldReceive('getCreatedBy')->andReturn($data['created_by'])
            ->shouldReceive('getModifiedBy')->andReturn($data['modified_by']);

        $this->eloquent->shouldReceive('update')->with($data, $id)->andReturn($object);

        $result = $this->repository->update($object);
        $this->assertEquals($object, $result);
    }
}

<?php
namespace Tests\Domains\Commons\Access;

use Mockery as m;
use Tests\TestCase;
use App\Infrastructures\Commons\Access\Contracts\EloquentAccessRepositoryInterface;
use App\Domains\Commons\Access\AccessRepository;
use App\Domains\Commons\Access\AccessEloquent;
use App\Domains\Commons\Access\Contracts\AccessInterface;
use App\Domains\Commons\Access\Contracts\AccessRepositoryInterface;

class AccessRepositoryTest extends TestCase
{
    private $eloquent;
    private $repository;

    protected function setUp()
    {
        parent::setUp();
        $this->eloquent = m::mock(EloquentAccessRepositoryInterface::class);
        $this->repository = new AccessRepository($this->eloquent);
    }

    protected function tearDown()
    {
        m::close();
    }

    public function testConstructor()
    {
        $this->assertInstanceOf(AccessRepositoryInterface::class, $this->repository);
    }

    /**
     * Test create Access
     */
    public function testCreate()
    {
        $object = m::mock(AccessInterface::class);

        $data = ['name' => 1,'slug' => 1,'description' => 1,'is_active' => 1,'created_by' => 1,'modified_by' => 1,];

        $object
            ->shouldReceive('getName')->andReturn($data['name'])
            ->shouldReceive('getSlug')->andReturn($data['slug'])
            ->shouldReceive('getDescription')->andReturn($data['description'])
            ->shouldReceive('getIsActive')->andReturn($data['is_active'])
            ->shouldReceive('getCreatedBy')->andReturn($data['created_by'])
            ->shouldReceive('getModifiedBy')->andReturn($data['modified_by']);

        $this->eloquent->shouldReceive('create')->with($data)->andReturn($object);

        $result = $this->repository->create($object);
        $this->assertInstanceOf(AccessInterface::class, $result);
        $this->assertEquals($object, $result);
    }

    /**
     * Test delete Access
     */
    public function testDelete()
    {
        $note = m::mock(AccessInterface::class);
        $note->shouldReceive('getKey')->andReturn(1);
        $this->eloquent->shouldReceive('delete')->with(1)->andReturn(true);
        $result = $this->repository->delete($note);
        $this->assertTrue($result);
    }

    /**
     * Test Update Access
     */
    public function testUpdate()
    {
        $id = 1;
        $data = ['name' => 1,'slug' => 1,'description' => 1,'is_active' => 1,'created_by' => 1,'modified_by' => 1,];

        $object = m::mock(AccessInterface::class);
        $object->shouldReceive('getKey')->andReturn($id);

        $object
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

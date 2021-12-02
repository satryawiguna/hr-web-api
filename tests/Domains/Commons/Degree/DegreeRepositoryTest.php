<?php
namespace Tests\Domains\Commons\Degree;

use Mockery as m;
use Tests\TestCase;
use App\Infrastructures\Commons\Degree\Contracts\EloquentDegreeRepositoryInterface;
use App\Domains\Commons\Degree\DegreeRepository;
use App\Domains\Commons\Degree\DegreeEloquent;
use App\Domains\Commons\Degree\Contracts\DegreeInterface;
use App\Domains\Commons\Degree\Contracts\DegreeRepositoryInterface;

class DegreeRepositoryTest extends TestCase
{
    private $eloquent;
    private $repository;

    protected function setUp()
    {
        parent::setUp();
        $this->eloquent = m::mock(EloquentDegreeRepositoryInterface::class);
        $this->repository = new DegreeRepository($this->eloquent);
    }

    protected function tearDown()
    {
        m::close();
    }

    public function testConstructor()
    {
        $this->assertInstanceOf(DegreeRepositoryInterface::class, $this->repository);
    }

    /**
     * Test create Degree
     */
    public function testCreate()
    {
        $object = m::mock(DegreeInterface::class);

        $data = ['name' => 1,'slug' => 1,'is_active' => 1,'created_by' => 1,'modified_by' => 1,];

        $object
            ->shouldReceive('getName')->andReturn($data['name'])
            ->shouldReceive('getSlug')->andReturn($data['slug'])
            ->shouldReceive('getIsActive')->andReturn($data['is_active'])
            ->shouldReceive('getCreatedBy')->andReturn($data['created_by'])
            ->shouldReceive('getModifiedBy')->andReturn($data['modified_by']);

        $this->eloquent->shouldReceive('create')->with($data)->andReturn($object);

        $result = $this->repository->create($object);
        $this->assertInstanceOf(DegreeInterface::class, $result);
        $this->assertEquals($object, $result);
    }

    /**
     * Test delete Degree
     */
    public function testDelete()
    {
        $note = m::mock(DegreeInterface::class);
        $note->shouldReceive('getKey')->andReturn(1);
        $this->eloquent->shouldReceive('delete')->with(1)->andReturn(true);
        $result = $this->repository->delete($note);
        $this->assertTrue($result);
    }

    /**
     * Test Update Degree
     */
    public function testUpdate()
    {
        $id = 1;
        $data = ['name' => 1,'slug' => 1,'is_active' => 1,'created_by' => 1,'modified_by' => 1,];

        $object = m::mock(DegreeInterface::class);
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

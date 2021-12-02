<?php
namespace Tests\Domains\Commons\Gender;

use Mockery as m;
use Tests\TestCase;
use App\Infrastructures\Commons\Gender\Contracts\EloquentGenderRepositoryInterface;
use App\Domains\Commons\Gender\GenderRepository;
use App\Domains\Commons\Gender\GenderEloquent;
use App\Domains\Commons\Gender\Contracts\GenderInterface;
use App\Domains\Commons\Gender\Contracts\GenderRepositoryInterface;

class GenderRepositoryTest extends TestCase
{
    private $eloquent;
    private $repository;

    protected function setUp()
    {
        parent::setUp();
        $this->eloquent = m::mock(EloquentGenderRepositoryInterface::class);
        $this->repository = new GenderRepository($this->eloquent);
    }

    protected function tearDown()
    {
        m::close();
    }

    public function testConstructor()
    {
        $this->assertInstanceOf(GenderRepositoryInterface::class, $this->repository);
    }

    /**
     * Test create Gender
     */
    public function testCreate()
    {
        $object = m::mock(GenderInterface::class);

        $data = ['name' => 1,'slug' => 1,'is_active' => 1,'created_by' => 1,'modified_by' => 1,];

        $object
            ->shouldReceive('getName')->andReturn($data['name'])
            ->shouldReceive('getSlug')->andReturn($data['slug'])
            ->shouldReceive('getIsActive')->andReturn($data['is_active'])
            ->shouldReceive('getCreatedBy')->andReturn($data['created_by'])
            ->shouldReceive('getModifiedBy')->andReturn($data['modified_by']);

        $this->eloquent->shouldReceive('create')->with($data)->andReturn($object);

        $result = $this->repository->create($object);
        $this->assertInstanceOf(GenderInterface::class, $result);
        $this->assertEquals($object, $result);
    }

    /**
     * Test delete Gender
     */
    public function testDelete()
    {
        $note = m::mock(GenderInterface::class);
        $note->shouldReceive('getKey')->andReturn(1);
        $this->eloquent->shouldReceive('delete')->with(1)->andReturn(true);
        $result = $this->repository->delete($note);
        $this->assertTrue($result);
    }

    /**
     * Test Update Gender
     */
    public function testUpdate()
    {
        $id = 1;
        $data = ['name' => 1,'slug' => 1,'is_active' => 1,'created_by' => 1,'modified_by' => 1,];

        $object = m::mock(GenderInterface::class);
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

<?php
namespace Tests\Domains\Commons\Commons\Religion;

use Mockery as m;
use Tests\TestCase;
use App\Infrastructures\Commons\Religion\Contracts\EloquentReligionRepositoryInterface;
use App\Domains\Commons\Religion\ReligionRepository;
use App\Domains\Commons\Religion\ReligionEloquent;
use App\Domains\Commons\Religion\Contracts\ReligionInterface;
use App\Domains\Commons\Religion\Contracts\ReligionRepositoryInterface;

class ReligionRepositoryTest extends TestCase
{
    private $eloquent;
    private $repository;

    protected function setUp()
    {
        parent::setUp();
        $this->eloquent = m::mock(EloquentReligionRepositoryInterface::class);
        $this->repository = new ReligionRepository($this->eloquent);
    }

    protected function tearDown()
    {
        m::close();
    }

    public function testConstructor()
    {
        $this->assertInstanceOf(ReligionRepositoryInterface::class, $this->repository);
    }

    /**
     * Test create Religion
     */
    public function testCreate()
    {
        $object = m::mock(ReligionInterface::class);

        $data = ['name' => 1,'is_active' => 1,];

        $object
            ->shouldReceive('getName')->andReturn($data['name'])
            ->shouldReceive('getIsActive')->andReturn($data['is_active']);

        $this->eloquent->shouldReceive('create')->with($data)->andReturn($object);

        $result = $this->repository->create($object);
        $this->assertInstanceOf(ReligionInterface::class, $result);
        $this->assertEquals($object, $result);
    }

    /**
     * Test delete Religion
     */
    public function testDelete()
    {
        $note = m::mock(ReligionInterface::class);
        $note->shouldReceive('getKey')->andReturn(1);
        $this->eloquent->shouldReceive('delete')->with(1)->andReturn(true);
        $result = $this->repository->delete($note);
        $this->assertTrue($result);
    }

    /**
     * Test Update Religion
     */
    public function testUpdate()
    {
        $id = 1;
        $data = ['name' => 1,'is_active' => 1,];

        $object = m::mock(ReligionInterface::class);
        $object->shouldReceive('getKey')->andReturn($id);

        $object
            ->shouldReceive('getName')->andReturn($data['name'])
            ->shouldReceive('getIsActive')->andReturn($data['is_active']);

        $this->eloquent->shouldReceive('update')->with($data, $id)->andReturn($object);

        $result = $this->repository->update($object);
        $this->assertEquals($object, $result);
    }
}

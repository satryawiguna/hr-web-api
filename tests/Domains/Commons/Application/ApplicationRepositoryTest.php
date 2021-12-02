<?php
namespace Tests\Domains\Commons\Application;

use Mockery as m;
use Tests\TestCase;
use App\Infrastructures\Commons\Application\Contracts\EloquentApplicationRepositoryInterface;
use App\Domains\Commons\Application\ApplicationRepository;
use App\Domains\Commons\Application\ApplicationEloquent;
use App\Domains\Commons\Application\Contracts\ApplicationInterface;
use App\Domains\Commons\Application\Contracts\ApplicationRepositoryInterface;

class ApplicationRepositoryTest extends TestCase
{
    private $eloquent;
    private $repository;

    protected function setUp()
    {
        parent::setUp();
        $this->eloquent = m::mock(EloquentApplicationRepositoryInterface::class);
        $this->repository = new ApplicationRepository($this->eloquent);
    }

    protected function tearDown()
    {
        m::close();
    }

    public function testConstructor()
    {
        $this->assertInstanceOf(ApplicationRepositoryInterface::class, $this->repository);
    }

    /**
     * Test create Application
     */
    public function testCreate()
    {
        $object = m::mock(ApplicationInterface::class);

        $data = ['name' => 1,'is_active' => 1,'created_by' => 1,'modified_by' => 1,];

        $object
            ->shouldReceive('getName')->andReturn($data['name'])
            ->shouldReceive('getIsActive')->andReturn($data['is_active'])
            ->shouldReceive('getCreatedBy')->andReturn($data['created_by'])
            ->shouldReceive('getModifiedBy')->andReturn($data['modified_by']);

        $this->eloquent->shouldReceive('create')->with($data)->andReturn($object);

        $result = $this->repository->create($object);
        $this->assertInstanceOf(ApplicationInterface::class, $result);
        $this->assertEquals($object, $result);
    }

    /**
     * Test delete Application
     */
    public function testDelete()
    {
        $note = m::mock(ApplicationInterface::class);
        $note->shouldReceive('getKey')->andReturn(1);
        $this->eloquent->shouldReceive('delete')->with(1)->andReturn(true);
        $result = $this->repository->delete($note);
        $this->assertTrue($result);
    }

    /**
     * Test Update Application
     */
    public function testUpdate()
    {
        $id = 1;
        $data = ['name' => 1,'is_active' => 1,'created_by' => 1,'modified_by' => 1,];

        $object = m::mock(ApplicationInterface::class);
        $object->shouldReceive('getKey')->andReturn($id);

        $object
            ->shouldReceive('getName')->andReturn($data['name'])
            ->shouldReceive('getIsActive')->andReturn($data['is_active'])
            ->shouldReceive('getCreatedBy')->andReturn($data['created_by'])
            ->shouldReceive('getModifiedBy')->andReturn($data['modified_by']);

        $this->eloquent->shouldReceive('update')->with($data, $id)->andReturn($object);

        $result = $this->repository->update($object);
        $this->assertEquals($object, $result);
    }
}

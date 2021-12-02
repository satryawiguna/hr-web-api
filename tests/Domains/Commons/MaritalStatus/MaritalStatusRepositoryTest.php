<?php
namespace Tests\Domains\Commons\MaritalStatus;

use Mockery as m;
use Tests\TestCase;
use App\Infrastructures\Commons\MaritalStatus\Contracts\EloquentMaritalStatusRepositoryInterface;
use App\Domains\Commons\MaritalStatus\MaritalStatusRepository;
use App\Domains\Commons\MaritalStatus\MaritalStatusEloquent;
use App\Domains\Commons\MaritalStatus\Contracts\MaritalStatusInterface;
use App\Domains\Commons\MaritalStatus\Contracts\MaritalStatusRepositoryInterface;

class StatusRepositoryTest extends TestCase
{
    private $eloquent;
    private $repository;

    protected function setUp()
    {
        parent::setUp();
        $this->eloquent = m::mock(EloquentMaritalStatusRepositoryInterface::class);
        $this->repository = new MaritalStatusRepository($this->eloquent);
    }

    protected function tearDown()
    {
        m::close();
    }

    public function testConstructor()
    {
        $this->assertInstanceOf(MaritalStatusRepositoryInterface::class, $this->repository);
    }

    /**
     * Test create MaritalStatus
     */
    public function testCreate()
    {
        $object = m::mock(MaritalStatusInterface::class);

        $data = ['name' => 1,'slug' => 1,'is_active' => 1,'created_by' => 1,'modified_by' => 1,];

        $object
            ->shouldReceive('getName')->andReturn($data['name'])
            ->shouldReceive('getSlug')->andReturn($data['slug'])
            ->shouldReceive('getIsActive')->andReturn($data['is_active'])
            ->shouldReceive('getCreatedBy')->andReturn($data['created_by'])
            ->shouldReceive('getModifiedBy')->andReturn($data['modified_by']);

        $this->eloquent->shouldReceive('create')->with($data)->andReturn($object);

        $result = $this->repository->create($object);
        $this->assertInstanceOf(MaritalStatusInterface::class, $result);
        $this->assertEquals($object, $result);
    }

    /**
     * Test delete MaritalStatus
     */
    public function testDelete()
    {
        $note = m::mock(MaritalStatusInterface::class);
        $note->shouldReceive('getKey')->andReturn(1);
        $this->eloquent->shouldReceive('delete')->with(1)->andReturn(true);
        $result = $this->repository->delete($note);
        $this->assertTrue($result);
    }

    /**
     * Test Update MaritalStatus
     */
    public function testUpdate()
    {
        $id = 1;
        $data = ['name' => 1,'slug' => 1,'is_active' => 1,'created_by' => 1,'modified_by' => 1,];

        $object = m::mock(MaritalStatusInterface::class);
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

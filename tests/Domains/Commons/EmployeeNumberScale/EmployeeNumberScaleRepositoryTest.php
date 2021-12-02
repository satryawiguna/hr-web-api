<?php
namespace Tests\Domains\Commons\EmployeeNumberScale;

use Mockery as m;
use Tests\TestCase;
use App\Infrastructures\Commons\EmployeeNumberScale\Contracts\EloquentEmployeeNumberScaleRepositoryInterface;
use App\Domains\Commons\EmployeeNumberScale\EmployeeNumberScaleRepository;
use App\Domains\Commons\EmployeeNumberScale\EmployeeNumberScaleEloquent;
use App\Domains\Commons\EmployeeNumberScale\Contracts\EmployeeNumberScaleInterface;
use App\Domains\Commons\EmployeeNumberScale\Contracts\EmployeeNumberScaleRepositoryInterface;

class EmployeeNumberScaleRepositoryTest extends TestCase
{
    private $eloquent;
    private $repository;

    protected function setUp()
    {
        parent::setUp();
        $this->eloquent = m::mock(EloquentEmployeeNumberScaleRepositoryInterface::class);
        $this->repository = new EmployeeNumberScaleRepository($this->eloquent);
    }

    protected function tearDown()
    {
        m::close();
    }

    public function testConstructor()
    {
        $this->assertInstanceOf(EmployeeNumberScaleRepositoryInterface::class, $this->repository);
    }

    /**
     * Test create EmployeeNumberScale
     */
    public function testCreate()
    {
        $object = m::mock(EmployeeNumberScaleInterface::class);

        $data = ['name' => 1,'slug' => 1,'is_active' => 1,'created_by' => 1,'modified_by' => 1,];

        $object
            ->shouldReceive('getName')->andReturn($data['name'])
            ->shouldReceive('getSlug')->andReturn($data['slug'])
            ->shouldReceive('getIsActive')->andReturn($data['is_active'])
            ->shouldReceive('getCreatedBy')->andReturn($data['created_by'])
            ->shouldReceive('getModifiedBy')->andReturn($data['modified_by']);

        $this->eloquent->shouldReceive('create')->with($data)->andReturn($object);

        $result = $this->repository->create($object);
        $this->assertInstanceOf(EmployeeNumberScaleInterface::class, $result);
        $this->assertEquals($object, $result);
    }

    /**
     * Test delete EmployeeNumberScale
     */
    public function testDelete()
    {
        $note = m::mock(EmployeeNumberScaleInterface::class);
        $note->shouldReceive('getKey')->andReturn(1);
        $this->eloquent->shouldReceive('delete')->with(1)->andReturn(true);
        $result = $this->repository->delete($note);
        $this->assertTrue($result);
    }

    /**
     * Test Update EmployeeNumberScale
     */
    public function testUpdate()
    {
        $id = 1;
        $data = ['name' => 1,'slug' => 1,'is_active' => 1,'created_by' => 1,'modified_by' => 1,];

        $object = m::mock(EmployeeNumberScaleInterface::class);
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

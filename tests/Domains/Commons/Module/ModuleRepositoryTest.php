<?php
namespace Tests\Domains\Commons\Module;

use Mockery as m;
use Tests\TestCase;
use App\Infrastructures\Commons\Module\Contracts\EloquentModuleRepositoryInterface;
use App\Domains\Commons\Module\ModuleRepository;
use App\Domains\Commons\Module\ModuleEloquent;
use App\Domains\Commons\Module\Contracts\ModuleInterface;
use App\Domains\Commons\Module\Contracts\ModuleRepositoryInterface;

class ModuleRepositoryTest extends TestCase
{
    private $eloquent;
    private $repository;

    protected function setUp()
    {
        parent::setUp();
        $this->eloquent = m::mock(EloquentModuleRepositoryInterface::class);
        $this->repository = new ModuleRepository($this->eloquent);
    }

    protected function tearDown()
    {
        m::close();
    }

    public function testConstructor()
    {
        $this->assertInstanceOf(ModuleRepositoryInterface::class, $this->repository);
    }

    /**
     * Test create Module
     */
    public function testCreate()
    {
        $object = m::mock(ModuleInterface::class);

        $data = ['application_id' => 1,'name' => 1,'slug' => 1,'is_active' => 1,'created_by' => 1,'modified_by' => 1,];

        $object
            ->shouldReceive('getApplicationId')->andReturn($data['application_id'])
            ->shouldReceive('getName')->andReturn($data['name'])
            ->shouldReceive('getSlug')->andReturn($data['slug'])
            ->shouldReceive('getIsActive')->andReturn($data['is_active'])
            ->shouldReceive('getCreatedBy')->andReturn($data['created_by'])
            ->shouldReceive('getModifiedBy')->andReturn($data['modified_by']);

        $this->eloquent->shouldReceive('create')->with($data)->andReturn($object);

        $result = $this->repository->create($object);
        $this->assertInstanceOf(ModuleInterface::class, $result);
        $this->assertEquals($object, $result);
    }

    /**
     * Test delete Module
     */
    public function testDelete()
    {
        $note = m::mock(ModuleInterface::class);
        $note->shouldReceive('getKey')->andReturn(1);
        $this->eloquent->shouldReceive('delete')->with(1)->andReturn(true);
        $result = $this->repository->delete($note);
        $this->assertTrue($result);
    }

    /**
     * Test Update Module
     */
    public function testUpdate()
    {
        $id = 1;
        $data = ['application_id' => 1,'name' => 1,'slug' => 1,'is_active' => 1,'created_by' => 1,'modified_by' => 1,];

        $object = m::mock(ModuleInterface::class);
        $object->shouldReceive('getKey')->andReturn($id);

        $object
            ->shouldReceive('getApplicationId')->andReturn($data['application_id'])
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

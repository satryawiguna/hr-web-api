<?php
namespace Tests\Domains\HumanResources\MasterData\SalaryStructure;

use Mockery as m;
use Tests\TestCase;
use App\Infrastructures\HumanResources\MasterData\SalaryStructure\Contracts\EloquentSalaryStructureRepositoryInterface;
use App\Domains\HumanResources\MasterData\SalaryStructure\SalaryStructureRepository;
use App\Domains\HumanResources\MasterData\SalaryStructure\SalaryStructureEloquent;
use App\Domains\HumanResources\MasterData\SalaryStructure\Contracts\SalaryStructureInterface;
use App\Domains\HumanResources\MasterData\SalaryStructure\Contracts\SalaryStructureRepositoryInterface;

class SalaryStructureRepositoryTest extends TestCase
{
    private $eloquent;
    private $repository;

    protected function setUp()
    {
        parent::setUp();
        $this->eloquent = m::mock(EloquentSalaryStructureRepositoryInterface::class);
        $this->repository = new SalaryStructureRepository($this->eloquent);
    }

    protected function tearDown()
    {
        m::close();
    }

    public function testConstructor()
    {
        $this->assertInstanceOf(SalaryStructureRepositoryInterface::class, $this->repository);
    }

    /**
     * Test create SalaryStructure
     */
    public function testCreate()
    {
        $object = m::mock(SalaryStructureInterface::class);

        $data = ['company_id' => 1,'type' => 1,'name' => 1,'slug' => 1,'is_active' => 1,'created_by' => 1,'modified_by' => 1,];

        $object
            ->shouldReceive('getCompanyId')->andReturn($data['company_id'])
            ->shouldReceive('getType')->andReturn($data['type'])
            ->shouldReceive('getName')->andReturn($data['name'])
            ->shouldReceive('getSlug')->andReturn($data['slug'])
            ->shouldReceive('getIsActive')->andReturn($data['is_active'])
            ->shouldReceive('getCreatedBy')->andReturn($data['created_by'])
            ->shouldReceive('getModifiedBy')->andReturn($data['modified_by']);

        $this->eloquent->shouldReceive('create')->with($data)->andReturn($object);

        $result = $this->repository->create($object);
        $this->assertInstanceOf(SalaryStructureInterface::class, $result);
        $this->assertEquals($object, $result);
    }

    /**
     * Test delete SalaryStructure
     */
    public function testDelete()
    {
        $note = m::mock(SalaryStructureInterface::class);
        $note->shouldReceive('getKey')->andReturn(1);
        $this->eloquent->shouldReceive('delete')->with(1)->andReturn(true);
        $result = $this->repository->delete($note);
        $this->assertTrue($result);
    }

    /**
     * Test Update SalaryStructure
     */
    public function testUpdate()
    {
        $id = 1;
        $data = ['company_id' => 1,'type' => 1,'name' => 1,'slug' => 1,'is_active' => 1,'created_by' => 1,'modified_by' => 1,];

        $object = m::mock(SalaryStructureInterface::class);
        $object->shouldReceive('getKey')->andReturn($id);

        $object
            ->shouldReceive('getCompanyId')->andReturn($data['company_id'])
            ->shouldReceive('getType')->andReturn($data['type'])
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

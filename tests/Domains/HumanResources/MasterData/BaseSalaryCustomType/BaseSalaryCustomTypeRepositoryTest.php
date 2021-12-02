<?php
namespace Tests\Domains\HumanResources\MasterData\BaseSalaryCustomType;

use Mockery as m;
use Tests\TestCase;
use App\Infrastructures\HumanResources\MasterData\BaseSalaryCustomType\Contracts\EloquentBaseSalaryCustomTypeRepositoryInterface;
use App\Domains\HumanResources\MasterData\BaseSalaryCustomType\BaseSalaryCustomTypeRepository;
use App\Domains\HumanResources\MasterData\BaseSalaryCustomType\BaseSalaryCustomTypeEloquent;
use App\Domains\HumanResources\MasterData\BaseSalaryCustomType\Contracts\BaseSalaryCustomTypeInterface;
use App\Domains\HumanResources\MasterData\BaseSalaryCustomType\Contracts\BaseSalaryCustomTypeRepositoryInterface;

class BaseSalaryCustomTypeRepositoryTest extends TestCase
{
    private $eloquent;
    private $repository;

    protected function setUp()
    {
        parent::setUp();
        $this->eloquent = m::mock(EloquentBaseSalaryCustomTypeRepositoryInterface::class);
        $this->repository = new BaseSalaryCustomTypeRepository($this->eloquent);
    }

    protected function tearDown()
    {
        m::close();
    }

    public function testConstructor()
    {
        $this->assertInstanceOf(BaseSalaryCustomTypeRepositoryInterface::class, $this->repository);
    }

    /**
     * Test create BaseSalaryCustomType
     */
    public function testCreate()
    {
        $object = m::mock(BaseSalaryCustomTypeInterface::class);

        $data = ['company_id' => 1,'name' => 1,'slug' => 1,'is_active' => 1,'created_by' => 1,'modified_by' => 1,];

        $object
            ->shouldReceive('getCompanyId')->andReturn($data['company_id'])
            ->shouldReceive('getName')->andReturn($data['name'])
            ->shouldReceive('getSlug')->andReturn($data['slug'])
            ->shouldReceive('getIsActive')->andReturn($data['is_active'])
            ->shouldReceive('getCreatedBy')->andReturn($data['created_by'])
            ->shouldReceive('getModifiedBy')->andReturn($data['modified_by']);

        $this->eloquent->shouldReceive('create')->with($data)->andReturn($object);

        $result = $this->repository->create($object);
        $this->assertInstanceOf(BaseSalaryCustomTypeInterface::class, $result);
        $this->assertEquals($object, $result);
    }

    /**
     * Test delete BaseSalaryCustomType
     */
    public function testDelete()
    {
        $note = m::mock(BaseSalaryCustomTypeInterface::class);
        $note->shouldReceive('getKey')->andReturn(1);
        $this->eloquent->shouldReceive('delete')->with(1)->andReturn(true);
        $result = $this->repository->delete($note);
        $this->assertTrue($result);
    }

    /**
     * Test Update BaseSalaryCustomType
     */
    public function testUpdate()
    {
        $id = 1;
        $data = ['company_id' => 1,'name' => 1,'slug' => 1,'is_active' => 1,'created_by' => 1,'modified_by' => 1,];

        $object = m::mock(BaseSalaryCustomTypeInterface::class);
        $object->shouldReceive('getKey')->andReturn($id);

        $object
            ->shouldReceive('getCompanyId')->andReturn($data['company_id'])
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

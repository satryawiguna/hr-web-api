<?php
namespace Tests\Domains\Commons\ContractType;

use Mockery as m;
use Tests\TestCase;
use App\Infrastructures\Commons\ContractType\Contracts\EloquentContractTypeRepositoryInterface;
use App\Domains\Commons\ContractType\ContractTypeRepository;
use App\Domains\Commons\ContractType\ContractTypeEloquent;
use App\Domains\Commons\ContractType\Contracts\ContractTypeInterface;
use App\Domains\Commons\ContractType\Contracts\ContractTypeRepositoryInterface;

class ContractTypeRepositoryTest extends TestCase
{
    private $eloquent;
    private $repository;

    protected function setUp()
    {
        parent::setUp();
        $this->eloquent = m::mock(EloquentContractTypeRepositoryInterface::class);
        $this->repository = new ContractTypeRepository($this->eloquent);
    }

    protected function tearDown()
    {
        m::close();
    }

    public function testConstructor()
    {
        $this->assertInstanceOf(ContractTypeRepositoryInterface::class, $this->repository);
    }

    /**
     * Test create ContractType
     */
    public function testCreate()
    {
        $object = m::mock(ContractTypeInterface::class);

        $data = ['name' => 1,'slug' => 1,'is_active' => 1,'created_by' => 1,'modified_by' => 1,];

        $object
            ->shouldReceive('getName')->andReturn($data['name'])
            ->shouldReceive('getSlug')->andReturn($data['slug'])
            ->shouldReceive('getIsActive')->andReturn($data['is_active'])
            ->shouldReceive('getCreatedBy')->andReturn($data['created_by'])
            ->shouldReceive('getModifiedBy')->andReturn($data['modified_by']);

        $this->eloquent->shouldReceive('create')->with($data)->andReturn($object);

        $result = $this->repository->create($object);
        $this->assertInstanceOf(ContractTypeInterface::class, $result);
        $this->assertEquals($object, $result);
    }

    /**
     * Test delete ContractType
     */
    public function testDelete()
    {
        $note = m::mock(ContractTypeInterface::class);
        $note->shouldReceive('getKey')->andReturn(1);
        $this->eloquent->shouldReceive('delete')->with(1)->andReturn(true);
        $result = $this->repository->delete($note);
        $this->assertTrue($result);
    }

    /**
     * Test Update ContractType
     */
    public function testUpdate()
    {
        $id = 1;
        $data = ['name' => 1,'slug' => 1,'is_active' => 1,'created_by' => 1,'modified_by' => 1,];

        $object = m::mock(ContractTypeInterface::class);
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

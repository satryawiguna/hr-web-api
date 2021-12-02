<?php
namespace Tests\Domains\Commons\EmployeeLoanType;

use Mockery as m;
use Tests\TestCase;
use App\Infrastructures\Commons\EmployeeLoanType\Contracts\EloquentEmployeeLoanTypeRepositoryInterface;
use App\Domains\Commons\EmployeeLoanType\EmployeeLoanTypeRepository;
use App\Domains\Commons\EmployeeLoanType\EmployeeLoanTypeEloquent;
use App\Domains\Commons\EmployeeLoanType\Contracts\EmployeeLoanTypeInterface;
use App\Domains\Commons\EmployeeLoanType\Contracts\EmployeeLoanTypeRepositoryInterface;

class EmployeeLoanTypeRepositoryTest extends TestCase
{
    private $eloquent;
    private $repository;

    protected function setUp()
    {
        parent::setUp();
        $this->eloquent = m::mock(EloquentEmployeeLoanTypeRepositoryInterface::class);
        $this->repository = new EmployeeLoanTypeRepository($this->eloquent);
    }

    protected function tearDown()
    {
        m::close();
    }

    public function testConstructor()
    {
        $this->assertInstanceOf(EmployeeLoanTypeRepositoryInterface::class, $this->repository);
    }

    /**
     * Test create EmployeeLoanType
     */
    public function testCreate()
    {
        $object = m::mock(EmployeeLoanTypeInterface::class);

        $data = ['name' => 1,'slug' => 1,'description' => 1,'is_active' => 1,'created_by' => 1,'modified_by' => 1,];

        $object
            ->shouldReceive('getName')->andReturn($data['name'])
            ->shouldReceive('getSlug')->andReturn($data['slug'])
            ->shouldReceive('getDescription')->andReturn($data['description'])
            ->shouldReceive('getIsActive')->andReturn($data['is_active'])
            ->shouldReceive('getCreatedBy')->andReturn($data['created_by'])
            ->shouldReceive('getModifiedBy')->andReturn($data['modified_by']);

        $this->eloquent->shouldReceive('create')->with($data)->andReturn($object);

        $result = $this->repository->create($object);
        $this->assertInstanceOf(EmployeeLoanTypeInterface::class, $result);
        $this->assertEquals($object, $result);
    }

    /**
     * Test delete EmployeeLoanType
     */
    public function testDelete()
    {
        $note = m::mock(EmployeeLoanTypeInterface::class);
        $note->shouldReceive('getKey')->andReturn(1);
        $this->eloquent->shouldReceive('delete')->with(1)->andReturn(true);
        $result = $this->repository->delete($note);
        $this->assertTrue($result);
    }

    /**
     * Test Update EmployeeLoanType
     */
    public function testUpdate()
    {
        $id = 1;
        $data = ['name' => 1,'slug' => 1,'description' => 1,'is_active' => 1,'created_by' => 1,'modified_by' => 1,];

        $object = m::mock(EmployeeLoanTypeInterface::class);
        $object->shouldReceive('getKey')->andReturn($id);

        $object
            ->shouldReceive('getName')->andReturn($data['name'])
            ->shouldReceive('getSlug')->andReturn($data['slug'])
            ->shouldReceive('getDescription')->andReturn($data['description'])
            ->shouldReceive('getIsActive')->andReturn($data['is_active'])
            ->shouldReceive('getCreatedBy')->andReturn($data['created_by'])
            ->shouldReceive('getModifiedBy')->andReturn($data['modified_by']);

        $this->eloquent->shouldReceive('update')->with($data, $id)->andReturn($object);

        $result = $this->repository->update($object);
        $this->assertEquals($object, $result);
    }
}

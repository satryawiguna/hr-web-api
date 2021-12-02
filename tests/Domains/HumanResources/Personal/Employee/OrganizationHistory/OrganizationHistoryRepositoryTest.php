<?php
namespace Tests\Domains\HumanResources\Personal\Employee\OrganizationHistory;

use Mockery as m;
use Tests\TestCase;
use App\Infrastructures\HumanResources\Personal\Employee\OrganizationHistory\Contracts\EloquentOrganizationHistoryRepositoryInterface;
use App\Domains\HumanResources\Personal\Employee\OrganizationHistory\OrganizationHistoryRepository;
use App\Domains\HumanResources\Personal\Employee\OrganizationHistory\OrganizationHistoryEloquent;
use App\Domains\HumanResources\Personal\Employee\OrganizationHistory\Contracts\OrganizationHistoryInterface;
use App\Domains\HumanResources\Personal\Employee\OrganizationHistory\Contracts\OrganizationHistoryRepositoryInterface;

class OrganizationHistoryRepositoryTest extends TestCase
{
    private $eloquent;
    private $repository;

    protected function setUp()
    {
        parent::setUp();
        $this->eloquent = m::mock(EloquentOrganizationHistoryRepositoryInterface::class);
        $this->repository = new OrganizationHistoryRepository($this->eloquent);
    }

    protected function tearDown()
    {
        m::close();
    }

    public function testConstructor()
    {
        $this->assertInstanceOf(OrganizationHistoryRepositoryInterface::class, $this->repository);
    }

    /**
     * Test create OrganizationHistory
     */
    public function testCreate()
    {
        $object = m::mock(OrganizationHistoryInterface::class);

        $data = ['employee_id' => 1,'name' => 1,'date' => 1,'activity' => 1,'created_by' => 1,'modified_by' => 1,];

        $object
            ->shouldReceive('getEmployeeId')->andReturn($data['employee_id'])
            ->shouldReceive('getName')->andReturn($data['name'])
            ->shouldReceive('getDate')->andReturn($data['date'])
            ->shouldReceive('getActivity')->andReturn($data['activity'])
            ->shouldReceive('getCreatedBy')->andReturn($data['created_by'])
            ->shouldReceive('getModifiedBy')->andReturn($data['modified_by']);

        $this->eloquent->shouldReceive('create')->with($data)->andReturn($object);

        $result = $this->repository->create($object);
        $this->assertInstanceOf(OrganizationHistoryInterface::class, $result);
        $this->assertEquals($object, $result);
    }

    /**
     * Test delete OrganizationHistory
     */
    public function testDelete()
    {
        $note = m::mock(OrganizationHistoryInterface::class);
        $note->shouldReceive('getKey')->andReturn(1);
        $this->eloquent->shouldReceive('delete')->with(1)->andReturn(true);
        $result = $this->repository->delete($note);
        $this->assertTrue($result);
    }

    /**
     * Test Update OrganizationHistory
     */
    public function testUpdate()
    {
        $id = 1;
        $data = ['employee_id' => 1,'name' => 1,'date' => 1,'activity' => 1,'created_by' => 1,'modified_by' => 1,];

        $object = m::mock(OrganizationHistoryInterface::class);
        $object->shouldReceive('getKey')->andReturn($id);

        $object
            ->shouldReceive('getEmployeeId')->andReturn($data['employee_id'])
            ->shouldReceive('getName')->andReturn($data['name'])
            ->shouldReceive('getDate')->andReturn($data['date'])
            ->shouldReceive('getActivity')->andReturn($data['activity'])
            ->shouldReceive('getCreatedBy')->andReturn($data['created_by'])
            ->shouldReceive('getModifiedBy')->andReturn($data['modified_by']);

        $this->eloquent->shouldReceive('update')->with($data, $id)->andReturn($object);

        $result = $this->repository->update($object);
        $this->assertEquals($object, $result);
    }
}

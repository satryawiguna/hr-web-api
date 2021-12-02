<?php
namespace Tests\Domains\HumanResources\Personal\Employee\FormalEducationHistory;

use Mockery as m;
use Tests\TestCase;
use App\Infrastructures\HumanResources\Personal\Employee\FormalEducationHistory\Contracts\EloquentFormalEducationHistoryRepositoryInterface;
use App\Domains\HumanResources\Personal\Employee\FormalEducationHistory\FormalEducationHistoryRepository;
use App\Domains\HumanResources\Personal\Employee\FormalEducationHistory\FormalEducationHistoryEloquent;
use App\Domains\HumanResources\Personal\Employee\FormalEducationHistory\Contracts\FormalEducationHistoryInterface;
use App\Domains\HumanResources\Personal\Employee\FormalEducationHistory\Contracts\FormalEducationHistoryRepositoryInterface;

class FormalEducationHistoryRepositoryTest extends TestCase
{
    private $eloquent;
    private $repository;

    protected function setUp()
    {
        parent::setUp();
        $this->eloquent = m::mock(EloquentFormalEducationHistoryRepositoryInterface::class);
        $this->repository = new FormalEducationHistoryRepository($this->eloquent);
    }

    protected function tearDown()
    {
        m::close();
    }

    public function testConstructor()
    {
        $this->assertInstanceOf(FormalEducationHistoryRepositoryInterface::class, $this->repository);
    }

    /**
     * Test create FormalEducationHistory
     */
    public function testCreate()
    {
        $object = m::mock(FormalEducationHistoryInterface::class);

        $data = ['employee_id' => 1,'degree_id' => 1,'major_id' => 1,'name' => 1,'start_date' => 1,'end_date' => 1,'created_by' => 1,'modified_by' => 1,];

        $object
            ->shouldReceive('getEmployeeId')->andReturn($data['employee_id'])
            ->shouldReceive('getDegreeId')->andReturn($data['degree_id'])
            ->shouldReceive('getMajorId')->andReturn($data['major_id'])
            ->shouldReceive('getName')->andReturn($data['name'])
            ->shouldReceive('getStartDate')->andReturn($data['start_date'])
            ->shouldReceive('getEndDate')->andReturn($data['end_date'])
            ->shouldReceive('getCreatedBy')->andReturn($data['created_by'])
            ->shouldReceive('getModifiedBy')->andReturn($data['modified_by']);

        $this->eloquent->shouldReceive('create')->with($data)->andReturn($object);

        $result = $this->repository->create($object);
        $this->assertInstanceOf(FormalEducationHistoryInterface::class, $result);
        $this->assertEquals($object, $result);
    }

    /**
     * Test delete FormalEducationHistory
     */
    public function testDelete()
    {
        $note = m::mock(FormalEducationHistoryInterface::class);
        $note->shouldReceive('getKey')->andReturn(1);
        $this->eloquent->shouldReceive('delete')->with(1)->andReturn(true);
        $result = $this->repository->delete($note);
        $this->assertTrue($result);
    }

    /**
     * Test Update FormalEducationHistory
     */
    public function testUpdate()
    {
        $id = 1;
        $data = ['employee_id' => 1,'degree_id' => 1,'major_id' => 1,'name' => 1,'start_date' => 1,'end_date' => 1,'created_by' => 1,'modified_by' => 1,];

        $object = m::mock(FormalEducationHistoryInterface::class);
        $object->shouldReceive('getKey')->andReturn($id);

        $object
            ->shouldReceive('getEmployeeId')->andReturn($data['employee_id'])
            ->shouldReceive('getDegreeId')->andReturn($data['degree_id'])
            ->shouldReceive('getMajorId')->andReturn($data['major_id'])
            ->shouldReceive('getName')->andReturn($data['name'])
            ->shouldReceive('getStartDate')->andReturn($data['start_date'])
            ->shouldReceive('getEndDate')->andReturn($data['end_date'])
            ->shouldReceive('getCreatedBy')->andReturn($data['created_by'])
            ->shouldReceive('getModifiedBy')->andReturn($data['modified_by']);

        $this->eloquent->shouldReceive('update')->with($data, $id)->andReturn($object);

        $result = $this->repository->update($object);
        $this->assertEquals($object, $result);
    }
}

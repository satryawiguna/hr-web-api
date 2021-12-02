<?php
namespace Tests\Domains\HumanResources\Personal\Employee\WorkCompetence;

use Mockery as m;
use Tests\TestCase;
use App\Infrastructures\HumanResources\Personal\Employee\WorkCompetence\Contracts\EloquentWorkCompetenceRepositoryInterface;
use App\Domains\HumanResources\Personal\Employee\WorkCompetence\WorkCompetenceRepository;
use App\Domains\HumanResources\Personal\Employee\WorkCompetence\WorkCompetenceEloquent;
use App\Domains\HumanResources\Personal\Employee\WorkCompetence\Contracts\WorkCompetenceInterface;
use App\Domains\HumanResources\Personal\Employee\WorkCompetence\Contracts\WorkCompetenceRepositoryInterface;

class WorkCompetenceRepositoryTest extends TestCase
{
    private $eloquent;
    private $repository;

    protected function setUp()
    {
        parent::setUp();
        $this->eloquent = m::mock(EloquentWorkCompetenceRepositoryInterface::class);
        $this->repository = new WorkCompetenceRepository($this->eloquent);
    }

    protected function tearDown()
    {
        m::close();
    }

    public function testConstructor()
    {
        $this->assertInstanceOf(WorkCompetenceRepositoryInterface::class, $this->repository);
    }

    /**
     * Test create WorkCompetence
     */
    public function testCreate()
    {
        $object = m::mock(WorkCompetenceInterface::class);

        $data = ['employee_id' => 1,'competence_id' => 1,'reference_number' => 1,'date' => 1,'time_vaidity' => 1,'created_by' => 1,'modified_by' => 1,];

        $object
            ->shouldReceive('getEmployeeId')->andReturn($data['employee_id'])
            ->shouldReceive('getCompetenceId')->andReturn($data['competence_id'])
            ->shouldReceive('getReferenceNumber')->andReturn($data['reference_number'])
            ->shouldReceive('getDate')->andReturn($data['date'])
            ->shouldReceive('getTimeVaidity')->andReturn($data['time_vaidity'])
            ->shouldReceive('getCreatedBy')->andReturn($data['created_by'])
            ->shouldReceive('getModifiedBy')->andReturn($data['modified_by']);

        $this->eloquent->shouldReceive('create')->with($data)->andReturn($object);

        $result = $this->repository->create($object);
        $this->assertInstanceOf(WorkCompetenceInterface::class, $result);
        $this->assertEquals($object, $result);
    }

    /**
     * Test delete WorkCompetence
     */
    public function testDelete()
    {
        $note = m::mock(WorkCompetenceInterface::class);
        $note->shouldReceive('getKey')->andReturn(1);
        $this->eloquent->shouldReceive('delete')->with(1)->andReturn(true);
        $result = $this->repository->delete($note);
        $this->assertTrue($result);
    }

    /**
     * Test Update WorkCompetence
     */
    public function testUpdate()
    {
        $id = 1;
        $data = ['employee_id' => 1,'competence_id' => 1,'reference_number' => 1,'date' => 1,'time_vaidity' => 1,'created_by' => 1,'modified_by' => 1,];

        $object = m::mock(WorkCompetenceInterface::class);
        $object->shouldReceive('getKey')->andReturn($id);

        $object
            ->shouldReceive('getEmployeeId')->andReturn($data['employee_id'])
            ->shouldReceive('getCompetenceId')->andReturn($data['competence_id'])
            ->shouldReceive('getReferenceNumber')->andReturn($data['reference_number'])
            ->shouldReceive('getDate')->andReturn($data['date'])
            ->shouldReceive('getTimeVaidity')->andReturn($data['time_vaidity'])
            ->shouldReceive('getCreatedBy')->andReturn($data['created_by'])
            ->shouldReceive('getModifiedBy')->andReturn($data['modified_by']);

        $this->eloquent->shouldReceive('update')->with($data, $id)->andReturn($object);

        $result = $this->repository->update($object);
        $this->assertEquals($object, $result);
    }
}

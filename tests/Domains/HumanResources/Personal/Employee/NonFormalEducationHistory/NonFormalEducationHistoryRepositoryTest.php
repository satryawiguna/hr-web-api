<?php
namespace Tests\Domains\HumanResources\Personal\Employee\NonFormalEducationHistory;

use Mockery as m;
use Tests\TestCase;
use App\Infrastructures\NonFormalEducationHistory\Contracts\EloquentNonFormalEducationHistoryRepositoryInterface;
use App\Domains\HumanResources\Personal\Employee\NonFormalEducationHistory\NonFormalEducationHistoryRepository;
use App\Domains\HumanResources\Personal\Employee\NonFormalEducationHistory\NonFormalEducationHistoryEloquent;
use App\Domains\HumanResources\Personal\Employee\NonFormalEducationHistory\Contracts\NonFormalEducationHistoryInterface;
use App\Domains\HumanResources\Personal\Employee\NonFormalEducationHistory\Contracts\NonFormalEducationHistoryRepositoryInterface;

class NonFormalEducationHistoryRepositoryTest extends TestCase
{
    private $eloquent;
    private $repository;

    protected function setUp()
    {
        parent::setUp();
        $this->eloquent = m::mock(EloquentNonFormalEducationHistoryRepositoryInterface::class);
        $this->repository = new NonFormalEducationHistoryRepository($this->eloquent);
    }

    protected function tearDown()
    {
        m::close();
    }

    public function testConstructor()
    {
        $this->assertInstanceOf(NonFormalEducationHistoryRepositoryInterface::class, $this->repository);
    }

    /**
     * Test create NonFormalEducationHistory
     */
    public function testCreate()
    {
        $object = m::mock(NonFormalEducationHistoryInterface::class);

        $data = ['employee_id' => 1,'type' => 1,'name' => 1,'date' => 1,'duration' => 1,'organizer' => 1,'created_by' => 1,'modified_by' => 1,];

        $object
            ->shouldReceive('getEmployeeId')->andReturn($data['employee_id'])
            ->shouldReceive('getType')->andReturn($data['type'])
            ->shouldReceive('getName')->andReturn($data['name'])
            ->shouldReceive('getDate')->andReturn($data['date'])
            ->shouldReceive('getDuration')->andReturn($data['duration'])
            ->shouldReceive('getOrganizer')->andReturn($data['organizer'])
            ->shouldReceive('getCreatedBy')->andReturn($data['created_by'])
            ->shouldReceive('getModifiedBy')->andReturn($data['modified_by']);

        $this->eloquent->shouldReceive('create')->with($data)->andReturn($object);

        $result = $this->repository->create($object);
        $this->assertInstanceOf(NonFormalEducationHistoryInterface::class, $result);
        $this->assertEquals($object, $result);
    }

    /**
     * Test delete NonFormalEducationHistory
     */
    public function testDelete()
    {
        $note = m::mock(NonFormalEducationHistoryInterface::class);
        $note->shouldReceive('getKey')->andReturn(1);
        $this->eloquent->shouldReceive('delete')->with(1)->andReturn(true);
        $result = $this->repository->delete($note);
        $this->assertTrue($result);
    }

    /**
     * Test Update NonFormalEducationHistory
     */
    public function testUpdate()
    {
        $id = 1;
        $data = ['employee_id' => 1,'type' => 1,'name' => 1,'date' => 1,'duration' => 1,'organizer' => 1,'created_by' => 1,'modified_by' => 1,];

        $object = m::mock(NonFormalEducationHistoryInterface::class);
        $object->shouldReceive('getKey')->andReturn($id);

        $object
            ->shouldReceive('getEmployeeId')->andReturn($data['employee_id'])
            ->shouldReceive('getType')->andReturn($data['type'])
            ->shouldReceive('getName')->andReturn($data['name'])
            ->shouldReceive('getDate')->andReturn($data['date'])
            ->shouldReceive('getDuration')->andReturn($data['duration'])
            ->shouldReceive('getOrganizer')->andReturn($data['organizer'])
            ->shouldReceive('getCreatedBy')->andReturn($data['created_by'])
            ->shouldReceive('getModifiedBy')->andReturn($data['modified_by']);

        $this->eloquent->shouldReceive('update')->with($data, $id)->andReturn($object);

        $result = $this->repository->update($object);
        $this->assertEquals($object, $result);
    }
}

<?php
namespace Tests\Domains\RegistrationLetter;

use Mockery as m;
use Tests\TestCase;
use App\Infrastructures\RegistrationLetter\Contracts\EloquentRegistrationLetterRepositoryInterface;
use App\Domains\RegistrationLetter\RegistrationLetterRepository;
use App\Domains\RegistrationLetter\RegistrationLetterEloquent;
use App\Domains\RegistrationLetter\Contracts\RegistrationLetterInterface;
use App\Domains\RegistrationLetter\Contracts\RegistrationLetterRepositoryInterface;

class RegistrationLetterRepositoryTest extends TestCase
{
    private $eloquent;
    private $repository;

    protected function setUp()
    {
        parent::setUp();
        $this->eloquent = m::mock(EloquentRegistrationLetterRepositoryInterface::class);
        $this->repository = new RegistrationLetterRepository($this->eloquent);
    }

    protected function tearDown()
    {
        m::close();
    }

    public function testConstructor()
    {
        $this->assertInstanceOf(RegistrationLetterRepositoryInterface::class, $this->repository);
    }

    /**
     * Test create RegistrationLetter
     */
    public function testCreate()
    {
        $object = m::mock(RegistrationLetterInterface::class);

        $data = ['employee_id' => 1,'letter_type_id' => 1,'reference_number' => 1,'start_date' => 1,'end_date' => 1,'description' => 1,'created_by' => 1,'modified_by' => 1,];

        $object
            ->shouldReceive('getEmployeeId')->andReturn($data['employee_id'])
            ->shouldReceive('getLetterTypeId')->andReturn($data['letter_type_id'])
            ->shouldReceive('getReferenceNumber')->andReturn($data['reference_number'])
            ->shouldReceive('getStartDate')->andReturn($data['start_date'])
            ->shouldReceive('getEndDate')->andReturn($data['end_date'])
            ->shouldReceive('getDescription')->andReturn($data['description'])
            ->shouldReceive('getCreatedBy')->andReturn($data['created_by'])
            ->shouldReceive('getModifiedBy')->andReturn($data['modified_by']);

        $this->eloquent->shouldReceive('create')->with($data)->andReturn($object);

        $result = $this->repository->create($object);
        $this->assertInstanceOf(RegistrationLetterInterface::class, $result);
        $this->assertEquals($object, $result);
    }

    /**
     * Test delete RegistrationLetter
     */
    public function testDelete()
    {
        $note = m::mock(RegistrationLetterInterface::class);
        $note->shouldReceive('getKey')->andReturn(1);
        $this->eloquent->shouldReceive('delete')->with(1)->andReturn(true);
        $result = $this->repository->delete($note);
        $this->assertTrue($result);
    }

    /**
     * Test Update RegistrationLetter
     */
    public function testUpdate()
    {
        $id = 1;
        $data = ['employee_id' => 1,'letter_type_id' => 1,'reference_number' => 1,'start_date' => 1,'end_date' => 1,'description' => 1,'created_by' => 1,'modified_by' => 1,];

        $object = m::mock(RegistrationLetterInterface::class);
        $object->shouldReceive('getKey')->andReturn($id);

        $object
            ->shouldReceive('getEmployeeId')->andReturn($data['employee_id'])
            ->shouldReceive('getLetterTypeId')->andReturn($data['letter_type_id'])
            ->shouldReceive('getReferenceNumber')->andReturn($data['reference_number'])
            ->shouldReceive('getStartDate')->andReturn($data['start_date'])
            ->shouldReceive('getEndDate')->andReturn($data['end_date'])
            ->shouldReceive('getDescription')->andReturn($data['description'])
            ->shouldReceive('getCreatedBy')->andReturn($data['created_by'])
            ->shouldReceive('getModifiedBy')->andReturn($data['modified_by']);

        $this->eloquent->shouldReceive('update')->with($data, $id)->andReturn($object);

        $result = $this->repository->update($object);
        $this->assertEquals($object, $result);
    }
}

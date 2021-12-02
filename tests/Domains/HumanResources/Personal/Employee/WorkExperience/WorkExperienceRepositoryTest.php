<?php
namespace Tests\Domains\HumanResources\Personal\Employee\WorkExperience;

use Mockery as m;
use Tests\TestCase;
use App\Infrastructures\HumanResources\Personal\Employee\WorkExperience\Contracts\EloquentWorkExperienceRepositoryInterface;
use App\Domains\HumanResources\Personal\Employee\WorkExperience\WorkExperienceRepository;
use App\Domains\HumanResources\Personal\Employee\WorkExperience\WorkExperienceEloquent;
use App\Domains\HumanResources\Personal\Employee\WorkExperience\Contracts\WorkExperienceInterface;
use App\Domains\HumanResources\Personal\Employee\WorkExperience\Contracts\WorkExperienceRepositoryInterface;

class WorkExperienceRepositoryTest extends TestCase
{
    private $eloquent;
    private $repository;

    protected function setUp()
    {
        parent::setUp();
        $this->eloquent = m::mock(EloquentWorkExperienceRepositoryInterface::class);
        $this->repository = new WorkExperienceRepository($this->eloquent);
    }

    protected function tearDown()
    {
        m::close();
    }

    public function testConstructor()
    {
        $this->assertInstanceOf(WorkExperienceRepositoryInterface::class, $this->repository);
    }

    /**
     * Test create WorkExperience
     */
    public function testCreate()
    {
        $object = m::mock(WorkExperienceInterface::class);

        $data = ['company_id' => 1,'company' => 1,'business' => 1,'position' => 1,'date' => 1,'created_by' => 1,'modified_by' => 1,];

        $object
            ->shouldReceive('getCompanyId')->andReturn($data['company_id'])
            ->shouldReceive('getCompany')->andReturn($data['company'])
            ->shouldReceive('getBusiness')->andReturn($data['business'])
            ->shouldReceive('getPosition')->andReturn($data['position'])
            ->shouldReceive('getDate')->andReturn($data['date'])
            ->shouldReceive('getCreatedBy')->andReturn($data['created_by'])
            ->shouldReceive('getModifiedBy')->andReturn($data['modified_by']);

        $this->eloquent->shouldReceive('create')->with($data)->andReturn($object);

        $result = $this->repository->create($object);
        $this->assertInstanceOf(WorkExperienceInterface::class, $result);
        $this->assertEquals($object, $result);
    }

    /**
     * Test delete WorkExperience
     */
    public function testDelete()
    {
        $note = m::mock(WorkExperienceInterface::class);
        $note->shouldReceive('getKey')->andReturn(1);
        $this->eloquent->shouldReceive('delete')->with(1)->andReturn(true);
        $result = $this->repository->delete($note);
        $this->assertTrue($result);
    }

    /**
     * Test Update WorkExperience
     */
    public function testUpdate()
    {
        $id = 1;
        $data = ['company_id' => 1,'company' => 1,'business' => 1,'position' => 1,'date' => 1,'created_by' => 1,'modified_by' => 1,];

        $object = m::mock(WorkExperienceInterface::class);
        $object->shouldReceive('getKey')->andReturn($id);

        $object
            ->shouldReceive('getCompanyId')->andReturn($data['company_id'])
            ->shouldReceive('getCompany')->andReturn($data['company'])
            ->shouldReceive('getBusiness')->andReturn($data['business'])
            ->shouldReceive('getPosition')->andReturn($data['position'])
            ->shouldReceive('getDate')->andReturn($data['date'])
            ->shouldReceive('getCreatedBy')->andReturn($data['created_by'])
            ->shouldReceive('getModifiedBy')->andReturn($data['modified_by']);

        $this->eloquent->shouldReceive('update')->with($data, $id)->andReturn($object);

        $result = $this->repository->update($object);
        $this->assertEquals($object, $result);
    }
}

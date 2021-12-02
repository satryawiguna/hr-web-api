<?php
namespace Tests\Domains\Vacancy;

use Mockery as m;
use Tests\TestCase;
use App\Infrastructures\Vacancy\Contracts\EloquentVacancyRepositoryInterface;
use App\Domains\Vacancy\VacancyRepository;
use App\Domains\Vacancy\VacancyEloquent;
use App\Domains\Vacancy\Contracts\VacancyInterface;
use App\Domains\Vacancy\Contracts\VacancyRepositoryInterface;

class VacancyRepositoryTest extends TestCase
{
    private $eloquent;
    private $repository;

    protected function setUp()
    {
        parent::setUp();
        $this->eloquent = m::mock(EloquentVacancyRepositoryInterface::class);
        $this->repository = new VacancyRepository($this->eloquent);
    }

    protected function tearDown()
    {
        m::close();
    }

    public function testConstructor()
    {
        $this->assertInstanceOf(VacancyRepositoryInterface::class, $this->repository);
    }

    /**
     * Test create Vacancy
     */
    public function testCreate()
    {
        $object = m::mock(VacancyInterface::class);

        $data = ['company_id' => 1,'position_id' => 1,'degree_id' => 1,'publish_date' => 1,'expired_date' => 1,'intro' => 1,'description' => 1,'responsibility' => 1,'requirement' => 1,'career' => 1,'salary' => 1,'facility_and_allowance' => 1,'expertise' => 1,'placement' => 1,'work_time' => 1,'work_type' => 1,'language' => 1,'apperance' => 1,'is_active' => 1,'created_by' => 1,'modified_by' => 1,];

        $object
            ->shouldReceive('getCompanyId')->andReturn($data['company_id'])
            ->shouldReceive('getPositionId')->andReturn($data['position_id'])
            ->shouldReceive('getDegreeId')->andReturn($data['degree_id'])
            ->shouldReceive('getPublishDate')->andReturn($data['publish_date'])
            ->shouldReceive('getExpiredDate')->andReturn($data['expired_date'])
            ->shouldReceive('getIntro')->andReturn($data['intro'])
            ->shouldReceive('getDescription')->andReturn($data['description'])
            ->shouldReceive('getResponsibility')->andReturn($data['responsibility'])
            ->shouldReceive('getRequirement')->andReturn($data['requirement'])
            ->shouldReceive('getCareer')->andReturn($data['career'])
            ->shouldReceive('getSalary')->andReturn($data['salary'])
            ->shouldReceive('getFacilityAndAllowance')->andReturn($data['facility_and_allowance'])
            ->shouldReceive('getExpertise')->andReturn($data['expertise'])
            ->shouldReceive('getPlacement')->andReturn($data['placement'])
            ->shouldReceive('getWorkTime')->andReturn($data['work_time'])
            ->shouldReceive('getWorkType')->andReturn($data['work_type'])
            ->shouldReceive('getLanguage')->andReturn($data['language'])
            ->shouldReceive('getApperance')->andReturn($data['apperance'])
            ->shouldReceive('getIsActive')->andReturn($data['is_active'])
            ->shouldReceive('getCreatedBy')->andReturn($data['created_by'])
            ->shouldReceive('getModifiedBy')->andReturn($data['modified_by']);

        $this->eloquent->shouldReceive('create')->with($data)->andReturn($object);

        $result = $this->repository->create($object);
        $this->assertInstanceOf(VacancyInterface::class, $result);
        $this->assertEquals($object, $result);
    }

    /**
     * Test delete Vacancy
     */
    public function testDelete()
    {
        $note = m::mock(VacancyInterface::class);
        $note->shouldReceive('getKey')->andReturn(1);
        $this->eloquent->shouldReceive('delete')->with(1)->andReturn(true);
        $result = $this->repository->delete($note);
        $this->assertTrue($result);
    }

    /**
     * Test Update Vacancy
     */
    public function testUpdate()
    {
        $id = 1;
        $data = ['company_id' => 1,'position_id' => 1,'degree_id' => 1,'publish_date' => 1,'expired_date' => 1,'intro' => 1,'description' => 1,'responsibility' => 1,'requirement' => 1,'career' => 1,'salary' => 1,'facility_and_allowance' => 1,'expertise' => 1,'placement' => 1,'work_time' => 1,'work_type' => 1,'language' => 1,'apperance' => 1,'is_active' => 1,'created_by' => 1,'modified_by' => 1,];

        $object = m::mock(VacancyInterface::class);
        $object->shouldReceive('getKey')->andReturn($id);

        $object
            ->shouldReceive('getCompanyId')->andReturn($data['company_id'])
            ->shouldReceive('getPositionId')->andReturn($data['position_id'])
            ->shouldReceive('getDegreeId')->andReturn($data['degree_id'])
            ->shouldReceive('getPublishDate')->andReturn($data['publish_date'])
            ->shouldReceive('getExpiredDate')->andReturn($data['expired_date'])
            ->shouldReceive('getIntro')->andReturn($data['intro'])
            ->shouldReceive('getDescription')->andReturn($data['description'])
            ->shouldReceive('getResponsibility')->andReturn($data['responsibility'])
            ->shouldReceive('getRequirement')->andReturn($data['requirement'])
            ->shouldReceive('getCareer')->andReturn($data['career'])
            ->shouldReceive('getSalary')->andReturn($data['salary'])
            ->shouldReceive('getFacilityAndAllowance')->andReturn($data['facility_and_allowance'])
            ->shouldReceive('getExpertise')->andReturn($data['expertise'])
            ->shouldReceive('getPlacement')->andReturn($data['placement'])
            ->shouldReceive('getWorkTime')->andReturn($data['work_time'])
            ->shouldReceive('getWorkType')->andReturn($data['work_type'])
            ->shouldReceive('getLanguage')->andReturn($data['language'])
            ->shouldReceive('getApperance')->andReturn($data['apperance'])
            ->shouldReceive('getIsActive')->andReturn($data['is_active'])
            ->shouldReceive('getCreatedBy')->andReturn($data['created_by'])
            ->shouldReceive('getModifiedBy')->andReturn($data['modified_by']);

        $this->eloquent->shouldReceive('update')->with($data, $id)->andReturn($object);

        $result = $this->repository->update($object);
        $this->assertEquals($object, $result);
    }
}

<?php
namespace Tests\Domains\Applicant;

use Mockery as m;
use Tests\TestCase;
use App\Infrastructures\Applicant\Contracts\EloquentApplicantRepositoryInterface;
use App\Domains\Applicant\ApplicantRepository;
use App\Domains\Applicant\ApplicantEloquent;
use App\Domains\Applicant\Contracts\ApplicantInterface;
use App\Domains\Applicant\Contracts\ApplicantRepositoryInterface;

class ApplicantRepositoryTest extends TestCase
{
    private $eloquent;
    private $repository;

    protected function setUp()
    {
        parent::setUp();
        $this->eloquent = m::mock(EloquentApplicantRepositoryInterface::class);
        $this->repository = new ApplicantRepository($this->eloquent);
    }

    protected function tearDown()
    {
        m::close();
    }

    public function testConstructor()
    {
        $this->assertInstanceOf(ApplicantRepositoryInterface::class, $this->repository);
    }

    /**
     * Test create Applicant
     */
    public function testCreate()
    {
        $object = m::mock(ApplicantInterface::class);

        $data = ['vacancy_id' => 1,'gender_id' => 1,'religion_id' => 1,'marital_status_id' => 1,'nik' => 1,'first_name' => 1,'last_name' => 1,'country' => 1,'state_or_province' => 1,'city' => 1,'address' => 1,'postcode' => 1,'citizen' => 1,'birth_date' => 1,'birth_place' => 1,'age' => 1,'weight' => 1,'height' => 1,'phone' => 1,'mobile' => 1,'email' => 1,'linkedin' => 1,'website' => 1,'photo' => 1,'created_by' => 1,'modified_by' => 1,];

        $object
            ->shouldReceive('getVacancyId')->andReturn($data['vacancy_id'])
            ->shouldReceive('getGenderId')->andReturn($data['gender_id'])
            ->shouldReceive('getReligionId')->andReturn($data['religion_id'])
            ->shouldReceive('getMaritalStatusId')->andReturn($data['marital_status_id'])
            ->shouldReceive('getNik')->andReturn($data['nik'])
            ->shouldReceive('getFirstName')->andReturn($data['first_name'])
            ->shouldReceive('getLastName')->andReturn($data['last_name'])
            ->shouldReceive('getCountry')->andReturn($data['country'])
            ->shouldReceive('getStateOrProvince')->andReturn($data['state_or_province'])
            ->shouldReceive('getCity')->andReturn($data['city'])
            ->shouldReceive('getAddress')->andReturn($data['address'])
            ->shouldReceive('getPostcode')->andReturn($data['postcode'])
            ->shouldReceive('getCitizen')->andReturn($data['citizen'])
            ->shouldReceive('getBirthDate')->andReturn($data['birth_date'])
            ->shouldReceive('getBirthPlace')->andReturn($data['birth_place'])
            ->shouldReceive('getAge')->andReturn($data['age'])
            ->shouldReceive('getWeight')->andReturn($data['weight'])
            ->shouldReceive('getHeight')->andReturn($data['height'])
            ->shouldReceive('getPhone')->andReturn($data['phone'])
            ->shouldReceive('getMobile')->andReturn($data['mobile'])
            ->shouldReceive('getEmail')->andReturn($data['email'])
            ->shouldReceive('getLinkedin')->andReturn($data['linkedin'])
            ->shouldReceive('getWebsite')->andReturn($data['website'])
            ->shouldReceive('getPhoto')->andReturn($data['photo'])
            ->shouldReceive('getCreatedBy')->andReturn($data['created_by'])
            ->shouldReceive('getModifiedBy')->andReturn($data['modified_by']);

        $this->eloquent->shouldReceive('create')->with($data)->andReturn($object);

        $result = $this->repository->create($object);
        $this->assertInstanceOf(ApplicantInterface::class, $result);
        $this->assertEquals($object, $result);
    }

    /**
     * Test delete Applicant
     */
    public function testDelete()
    {
        $note = m::mock(ApplicantInterface::class);
        $note->shouldReceive('getKey')->andReturn(1);
        $this->eloquent->shouldReceive('delete')->with(1)->andReturn(true);
        $result = $this->repository->delete($note);
        $this->assertTrue($result);
    }

    /**
     * Test Update Applicant
     */
    public function testUpdate()
    {
        $id = 1;
        $data = ['vacancy_id' => 1,'gender_id' => 1,'religion_id' => 1,'marital_status_id' => 1,'nik' => 1,'first_name' => 1,'last_name' => 1,'country' => 1,'state_or_province' => 1,'city' => 1,'address' => 1,'postcode' => 1,'citizen' => 1,'birth_date' => 1,'birth_place' => 1,'age' => 1,'weight' => 1,'height' => 1,'phone' => 1,'mobile' => 1,'email' => 1,'linkedin' => 1,'website' => 1,'photo' => 1,'created_by' => 1,'modified_by' => 1,];

        $object = m::mock(ApplicantInterface::class);
        $object->shouldReceive('getKey')->andReturn($id);

        $object
            ->shouldReceive('getVacancyId')->andReturn($data['vacancy_id'])
            ->shouldReceive('getGenderId')->andReturn($data['gender_id'])
            ->shouldReceive('getReligionId')->andReturn($data['religion_id'])
            ->shouldReceive('getMaritalStatusId')->andReturn($data['marital_status_id'])
            ->shouldReceive('getNik')->andReturn($data['nik'])
            ->shouldReceive('getFirstName')->andReturn($data['first_name'])
            ->shouldReceive('getLastName')->andReturn($data['last_name'])
            ->shouldReceive('getCountry')->andReturn($data['country'])
            ->shouldReceive('getStateOrProvince')->andReturn($data['state_or_province'])
            ->shouldReceive('getCity')->andReturn($data['city'])
            ->shouldReceive('getAddress')->andReturn($data['address'])
            ->shouldReceive('getPostcode')->andReturn($data['postcode'])
            ->shouldReceive('getCitizen')->andReturn($data['citizen'])
            ->shouldReceive('getBirthDate')->andReturn($data['birth_date'])
            ->shouldReceive('getBirthPlace')->andReturn($data['birth_place'])
            ->shouldReceive('getAge')->andReturn($data['age'])
            ->shouldReceive('getWeight')->andReturn($data['weight'])
            ->shouldReceive('getHeight')->andReturn($data['height'])
            ->shouldReceive('getPhone')->andReturn($data['phone'])
            ->shouldReceive('getMobile')->andReturn($data['mobile'])
            ->shouldReceive('getEmail')->andReturn($data['email'])
            ->shouldReceive('getLinkedin')->andReturn($data['linkedin'])
            ->shouldReceive('getWebsite')->andReturn($data['website'])
            ->shouldReceive('getPhoto')->andReturn($data['photo'])
            ->shouldReceive('getCreatedBy')->andReturn($data['created_by'])
            ->shouldReceive('getModifiedBy')->andReturn($data['modified_by']);

        $this->eloquent->shouldReceive('update')->with($data, $id)->andReturn($object);

        $result = $this->repository->update($object);
        $this->assertEquals($object, $result);
    }
}

<?php
namespace Tests\Domains\HumanResources\Personal\Employee;

use Mockery as m;
use Tests\TestCase;
use App\Infrastructures\HumanResources\Personal\Employee\Contracts\EloquentEmployeeRepositoryInterface;
use App\Domains\HumanResources\Personal\Employee\EmployeeRepository;
use App\Domains\HumanResources\Personal\Employee\EmployeeEloquent;
use App\Domains\HumanResources\Personal\Employee\Contracts\EmployeeInterface;
use App\Domains\HumanResources\Personal\Employee\Contracts\EmployeeRepositoryInterface;

class EmployeeRepositoryTest extends TestCase
{
    private $eloquent;
    private $repository;

    protected function setUp()
    {
        parent::setUp();
        $this->eloquent = m::mock(EloquentEmployeeRepositoryInterface::class);
        $this->repository = new EmployeeRepository($this->eloquent);
    }

    protected function tearDown()
    {
        m::close();
    }

    public function testConstructor()
    {
        $this->assertInstanceOf(EmployeeRepositoryInterface::class, $this->repository);
    }

    /**
     * Test create Employee
     */
    public function testCreate()
    {
        $object = m::mock(EmployeeInterface::class);

        $data = ['company_id' => 1,'gender_id' => 1,'religion_id' => 1,'marital_status_id' => 1,'bank_id' => 1,'nik' => 1,'first_name' => 1,'last_name' => 1,'birth_place' => 1,'birth_date' => 1,'address' => 1,'identity_number' => 1,'identity_date' => 1,'identity_address' => 1,'has_drive_license_a' => 1,'drive_license_a_number' => 1,'drive_license_a_date' => 1,'has_drive_license_c' => 1,'drive_license_c_number' => 1,'drive_license_c_date' => 1,'phone' => 1,'mobile' => 1,'email' => 1,'mate_as' => 1,'mate_firat_name' => 1,'mate_last_name' => 1,'mate_birth_place' => 1,'mate_birth_date' => 1,'has_npwp' => 1,'npwp_number' => 1,'npwp_date' => 1,'npwp_status' => 1,'has_employment_bpjs' => 1,'employment_bpjs_number' => 1,'employment_bpjs_date' => 1,'employment_bpjs_class' => 1,'has_wellness_bpjs' => 1,'wellness_bpjs_number' => 1,'wellness_bpjs_date' => 1,'wellness_bpjs_class' => 1,'mate_wellness_bpjs_number' => 1,'mate_wellness_bpjs_date' => 1,'mate_wellness_bpjs_class' => 1,'dplk_number' => 1,'collective_number' => 1,'english_ability' => 1,'computer_ability' => 1,'other_ability' => 1,'account_number' => 1,];

        $object
            ->shouldReceive('getCompanyId')->andReturn($data['company_id'])
            ->shouldReceive('getGenderId')->andReturn($data['gender_id'])
            ->shouldReceive('getReligionId')->andReturn($data['religion_id'])
            ->shouldReceive('getMaritalStatusId')->andReturn($data['marital_status_id'])
            ->shouldReceive('getBankId')->andReturn($data['bank_id'])
            ->shouldReceive('getNik')->andReturn($data['nik'])
            ->shouldReceive('getFirstName')->andReturn($data['first_name'])
            ->shouldReceive('getLastName')->andReturn($data['last_name'])
            ->shouldReceive('getBirthPlace')->andReturn($data['birth_place'])
            ->shouldReceive('getBirthDate')->andReturn($data['birth_date'])
            ->shouldReceive('getAddress')->andReturn($data['address'])
            ->shouldReceive('getIdentityNumber')->andReturn($data['identity_number'])
            ->shouldReceive('getIdentityDate')->andReturn($data['identity_date'])
            ->shouldReceive('getIdentityAddress')->andReturn($data['identity_address'])
            ->shouldReceive('getHasDriveLicenseA')->andReturn($data['has_drive_license_a'])
            ->shouldReceive('getDriveLicenseANumber')->andReturn($data['drive_license_a_number'])
            ->shouldReceive('getDriveLicenseADate')->andReturn($data['drive_license_a_date'])
            ->shouldReceive('getHasDriveLicenseC')->andReturn($data['has_drive_license_c'])
            ->shouldReceive('getDriveLicenseCNumber')->andReturn($data['drive_license_c_number'])
            ->shouldReceive('getDriveLicenseCDate')->andReturn($data['drive_license_c_date'])
            ->shouldReceive('getPhone')->andReturn($data['phone'])
            ->shouldReceive('getMobile')->andReturn($data['mobile'])
            ->shouldReceive('getEmail')->andReturn($data['email'])
            ->shouldReceive('getMateAs')->andReturn($data['mate_as'])
            ->shouldReceive('getMateFiratName')->andReturn($data['mate_firat_name'])
            ->shouldReceive('getMateLastName')->andReturn($data['mate_last_name'])
            ->shouldReceive('getMateBirthPlace')->andReturn($data['mate_birth_place'])
            ->shouldReceive('getMateBirthDate')->andReturn($data['mate_birth_date'])
            ->shouldReceive('getHasNpwp')->andReturn($data['has_npwp'])
            ->shouldReceive('getNpwpNumber')->andReturn($data['npwp_number'])
            ->shouldReceive('getNpwpDate')->andReturn($data['npwp_date'])
            ->shouldReceive('getNpwpStatus')->andReturn($data['npwp_status'])
            ->shouldReceive('getHasEmploymentBpjs')->andReturn($data['has_employment_bpjs'])
            ->shouldReceive('getEmploymentBpjsNumber')->andReturn($data['employment_bpjs_number'])
            ->shouldReceive('getEmploymentBpjsDate')->andReturn($data['employment_bpjs_date'])
            ->shouldReceive('getEmploymentBpjsClass')->andReturn($data['employment_bpjs_class'])
            ->shouldReceive('getHasWellnessBpjs')->andReturn($data['has_wellness_bpjs'])
            ->shouldReceive('getWellnessBpjsNumber')->andReturn($data['wellness_bpjs_number'])
            ->shouldReceive('getWellnessBpjsDate')->andReturn($data['wellness_bpjs_date'])
            ->shouldReceive('getWellnessBpjsClass')->andReturn($data['wellness_bpjs_class'])
            ->shouldReceive('getMateWellnessBpjsNumber')->andReturn($data['mate_wellness_bpjs_number'])
            ->shouldReceive('getMateWellnessBpjsDate')->andReturn($data['mate_wellness_bpjs_date'])
            ->shouldReceive('getMateWellnessBpjsClass')->andReturn($data['mate_wellness_bpjs_class'])
            ->shouldReceive('getDplkNumber')->andReturn($data['dplk_number'])
            ->shouldReceive('getCollectiveNumber')->andReturn($data['collective_number'])
            ->shouldReceive('getEnglishAbility')->andReturn($data['english_ability'])
            ->shouldReceive('getComputerAbility')->andReturn($data['computer_ability'])
            ->shouldReceive('getOtherAbility')->andReturn($data['other_ability'])
            ->shouldReceive('getAccountNumber')->andReturn($data['account_number']);

        $this->eloquent->shouldReceive('create')->with($data)->andReturn($object);

        $result = $this->repository->create($object);
        $this->assertInstanceOf(EmployeeInterface::class, $result);
        $this->assertEquals($object, $result);
    }

    /**
     * Test delete Employee
     */
    public function testDelete()
    {
        $note = m::mock(EmployeeInterface::class);
        $note->shouldReceive('getKey')->andReturn(1);
        $this->eloquent->shouldReceive('delete')->with(1)->andReturn(true);
        $result = $this->repository->delete($note);
        $this->assertTrue($result);
    }

    /**
     * Test Update Employee
     */
    public function testUpdate()
    {
        $id = 1;
        $data = ['company_id' => 1,'gender_id' => 1,'religion_id' => 1,'marital_status_id' => 1,'bank_id' => 1,'nik' => 1,'first_name' => 1,'last_name' => 1,'birth_place' => 1,'birth_date' => 1,'address' => 1,'identity_number' => 1,'identity_date' => 1,'identity_address' => 1,'has_drive_license_a' => 1,'drive_license_a_number' => 1,'drive_license_a_date' => 1,'has_drive_license_c' => 1,'drive_license_c_number' => 1,'drive_license_c_date' => 1,'phone' => 1,'mobile' => 1,'email' => 1,'mate_as' => 1,'mate_firat_name' => 1,'mate_last_name' => 1,'mate_birth_place' => 1,'mate_birth_date' => 1,'has_npwp' => 1,'npwp_number' => 1,'npwp_date' => 1,'npwp_status' => 1,'has_employment_bpjs' => 1,'employment_bpjs_number' => 1,'employment_bpjs_date' => 1,'employment_bpjs_class' => 1,'has_wellness_bpjs' => 1,'wellness_bpjs_number' => 1,'wellness_bpjs_date' => 1,'wellness_bpjs_class' => 1,'mate_wellness_bpjs_number' => 1,'mate_wellness_bpjs_date' => 1,'mate_wellness_bpjs_class' => 1,'dplk_number' => 1,'collective_number' => 1,'english_ability' => 1,'computer_ability' => 1,'other_ability' => 1,'account_number' => 1,];

        $object = m::mock(EmployeeInterface::class);
        $object->shouldReceive('getKey')->andReturn($id);

        $object
            ->shouldReceive('getCompanyId')->andReturn($data['company_id'])
            ->shouldReceive('getGenderId')->andReturn($data['gender_id'])
            ->shouldReceive('getReligionId')->andReturn($data['religion_id'])
            ->shouldReceive('getMaritalStatusId')->andReturn($data['marital_status_id'])
            ->shouldReceive('getBankId')->andReturn($data['bank_id'])
            ->shouldReceive('getNik')->andReturn($data['nik'])
            ->shouldReceive('getFirstName')->andReturn($data['first_name'])
            ->shouldReceive('getLastName')->andReturn($data['last_name'])
            ->shouldReceive('getBirthPlace')->andReturn($data['birth_place'])
            ->shouldReceive('getBirthDate')->andReturn($data['birth_date'])
            ->shouldReceive('getAddress')->andReturn($data['address'])
            ->shouldReceive('getIdentityNumber')->andReturn($data['identity_number'])
            ->shouldReceive('getIdentityDate')->andReturn($data['identity_date'])
            ->shouldReceive('getIdentityAddress')->andReturn($data['identity_address'])
            ->shouldReceive('getHasDriveLicenseA')->andReturn($data['has_drive_license_a'])
            ->shouldReceive('getDriveLicenseANumber')->andReturn($data['drive_license_a_number'])
            ->shouldReceive('getDriveLicenseADate')->andReturn($data['drive_license_a_date'])
            ->shouldReceive('getHasDriveLicenseC')->andReturn($data['has_drive_license_c'])
            ->shouldReceive('getDriveLicenseCNumber')->andReturn($data['drive_license_c_number'])
            ->shouldReceive('getDriveLicenseCDate')->andReturn($data['drive_license_c_date'])
            ->shouldReceive('getPhone')->andReturn($data['phone'])
            ->shouldReceive('getMobile')->andReturn($data['mobile'])
            ->shouldReceive('getEmail')->andReturn($data['email'])
            ->shouldReceive('getMateAs')->andReturn($data['mate_as'])
            ->shouldReceive('getMateFiratName')->andReturn($data['mate_firat_name'])
            ->shouldReceive('getMateLastName')->andReturn($data['mate_last_name'])
            ->shouldReceive('getMateBirthPlace')->andReturn($data['mate_birth_place'])
            ->shouldReceive('getMateBirthDate')->andReturn($data['mate_birth_date'])
            ->shouldReceive('getHasNpwp')->andReturn($data['has_npwp'])
            ->shouldReceive('getNpwpNumber')->andReturn($data['npwp_number'])
            ->shouldReceive('getNpwpDate')->andReturn($data['npwp_date'])
            ->shouldReceive('getNpwpStatus')->andReturn($data['npwp_status'])
            ->shouldReceive('getHasEmploymentBpjs')->andReturn($data['has_employment_bpjs'])
            ->shouldReceive('getEmploymentBpjsNumber')->andReturn($data['employment_bpjs_number'])
            ->shouldReceive('getEmploymentBpjsDate')->andReturn($data['employment_bpjs_date'])
            ->shouldReceive('getEmploymentBpjsClass')->andReturn($data['employment_bpjs_class'])
            ->shouldReceive('getHasWellnessBpjs')->andReturn($data['has_wellness_bpjs'])
            ->shouldReceive('getWellnessBpjsNumber')->andReturn($data['wellness_bpjs_number'])
            ->shouldReceive('getWellnessBpjsDate')->andReturn($data['wellness_bpjs_date'])
            ->shouldReceive('getWellnessBpjsClass')->andReturn($data['wellness_bpjs_class'])
            ->shouldReceive('getMateWellnessBpjsNumber')->andReturn($data['mate_wellness_bpjs_number'])
            ->shouldReceive('getMateWellnessBpjsDate')->andReturn($data['mate_wellness_bpjs_date'])
            ->shouldReceive('getMateWellnessBpjsClass')->andReturn($data['mate_wellness_bpjs_class'])
            ->shouldReceive('getDplkNumber')->andReturn($data['dplk_number'])
            ->shouldReceive('getCollectiveNumber')->andReturn($data['collective_number'])
            ->shouldReceive('getEnglishAbility')->andReturn($data['english_ability'])
            ->shouldReceive('getComputerAbility')->andReturn($data['computer_ability'])
            ->shouldReceive('getOtherAbility')->andReturn($data['other_ability'])
            ->shouldReceive('getAccountNumber')->andReturn($data['account_number']);

        $this->eloquent->shouldReceive('update')->with($data, $id)->andReturn($object);

        $result = $this->repository->update($object);
        $this->assertEquals($object, $result);
    }
}

<?php


namespace App\Domains\HumanResources\Personal\Employee\Contracts\Request;


use App\Core\Services\Request\AuditableRequest;

class CreateEmployeeRequest extends AuditableRequest
{
    public $company_id;

    public $nip;

    public $full_name;

    public $nick_name;

    public $gender_id;

    public $religion_id;

    public $birth_place;

    public $birth_date;

    public $address;

    public $phone;

    public $mobile;

    public $email;

    public $identity_number;

    public $identity_expired_date;

    public $identity_address;

    public $has_drive_license_a;

    public $drive_license_a_number;

    public $drive_license_a_date;

    public $has_drive_license_b;

    public $drive_license_b_number;

    public $drive_license_b_date;

    public $has_drive_license_c;

    public $drive_license_c_number;

    public $drive_license_c_date;

    public $marital_status_id;

    public $mate_as;

    public $mate_full_name;

    public $mate_nick_name;

    public $mate_birth_place;

    public $mate_birth_date;

    public $mate_occupation;

    public $office_id;

    public $work_area_id;

    public $has_npwp;

    public $npwp_number;

    public $npwp_date;

    public $npwp_status;

    public $has_bpjs_tenaga_kerja;

    public $bpjs_tenaga_kerja_number;

    public $bpjs_tenaga_kerja_date;

    public $bpjs_tenaga_kerja_class;

    public $has_bpjs_kesehatan;

    public $bpjs_kesehatan_number;

    public $bpjs_kesehatan_date;

    public $bpjs_kesehatan_class;

    public $has_mate_bpjs_kesehatan;

    public $mate_bpjs_kesehatan_number;

    public $mate_bpjs_kesehatan_date;

    public $mate_bpjs_kesehatan_class;

    public $dplk_number;

    public $collective_number;

    public $english_ability;

    public $computer_ability;

    public $other_ability;

    public $bank_id;

    public $account_number;

    public $join_date;

    public $work_status;

    public $work_type;

    // Many to many
    public $media_libraries;

    // Has many
    public $childs;

    public $formal_educations;

    public $non_formal_educations;

    public $organizations;

    public $other_equipments;

    public $work_competences;

    public $work_experiences;

    /**
     * @return mixed
     */
    public function getCompanyId()
    {
        return $this->company_id;
    }

    /**
     * @param mixed $company_id
     */
    public function setCompanyId($company_id): void
    {
        $this->company_id = $company_id;
    }

    /**
     * @return mixed
     */
    public function getNip()
    {
        return $this->nip;
    }

    /**
     * @param mixed $nip
     */
    public function setNip($nip): void
    {
        $this->nip = $nip;
    }

    /**
     * @return mixed
     */
    public function getFullName()
    {
        return $this->full_name;
    }

    /**
     * @param mixed $full_name
     */
    public function setFullName($full_name): void
    {
        $this->full_name = $full_name;
    }

    /**
     * @return mixed
     */
    public function getNickName()
    {
        return $this->nick_name;
    }

    /**
     * @param mixed $nick_name
     */
    public function setNickName($nick_name): void
    {
        $this->nick_name = $nick_name;
    }

    /**
     * @return mixed
     */
    public function getGenderId()
    {
        return $this->gender_id;
    }

    /**
     * @param mixed $gender_id
     */
    public function setGenderId($gender_id): void
    {
        $this->gender_id = $gender_id;
    }

    /**
     * @return mixed
     */
    public function getReligionId()
    {
        return $this->religion_id;
    }

    /**
     * @param mixed $religion_id
     */
    public function setReligionId($religion_id): void
    {
        $this->religion_id = $religion_id;
    }

    /**
     * @return mixed
     */
    public function getBirthPlace()
    {
        return $this->birth_place;
    }

    /**
     * @param mixed $birth_place
     */
    public function setBirthPlace($birth_place): void
    {
        $this->birth_place = $birth_place;
    }

    /**
     * @return mixed
     */
    public function getBirthDate()
    {
        return $this->birth_date;
    }

    /**
     * @param mixed $birth_date
     */
    public function setBirthDate($birth_date): void
    {
        $this->birth_date = $birth_date;
    }

    /**
     * @return mixed
     */
    public function getAddress()
    {
        return $this->address;
    }

    /**
     * @param mixed $address
     */
    public function setAddress($address): void
    {
        $this->address = $address;
    }

    /**
     * @return mixed
     */
    public function getPhone()
    {
        return $this->phone;
    }

    /**
     * @param mixed $phone
     */
    public function setPhone($phone): void
    {
        $this->phone = $phone;
    }

    /**
     * @return mixed
     */
    public function getMobile()
    {
        return $this->mobile;
    }

    /**
     * @param mixed $mobile
     */
    public function setMobile($mobile): void
    {
        $this->mobile = $mobile;
    }

    /**
     * @return mixed
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param mixed $email
     */
    public function setEmail($email): void
    {
        $this->email = $email;
    }

    /**
     * @return mixed
     */
    public function getIdentityNumber()
    {
        return $this->identity_number;
    }

    /**
     * @param mixed $identity_number
     */
    public function setIdentityNumber($identity_number): void
    {
        $this->identity_number = $identity_number;
    }

    /**
     * @return mixed
     */
    public function getIdentityExpiredDate()
    {
        return $this->identity_expired_date;
    }

    /**
     * @param mixed $identity_expired_date
     */
    public function setIdentityExpiredDate($identity_expired_date): void
    {
        $this->identity_expired_date = $identity_expired_date;
    }

    /**
     * @return mixed
     */
    public function getIdentityAddress()
    {
        return $this->identity_address;
    }

    /**
     * @param mixed $identity_address
     */
    public function setIdentityAddress($identity_address): void
    {
        $this->identity_address = $identity_address;
    }

    /**
     * @return mixed
     */
    public function getHasDriveLicenseA()
    {
        return $this->has_drive_license_a;
    }

    /**
     * @param mixed $has_drive_license_a
     */
    public function setHasDriveLicenseA($has_drive_license_a): void
    {
        $this->has_drive_license_a = $has_drive_license_a;
    }

    /**
     * @return mixed
     */
    public function getDriveLicenseANumber()
    {
        return $this->drive_license_a_number;
    }

    /**
     * @param mixed $drive_license_a_number
     */
    public function setDriveLicenseANumber($drive_license_a_number): void
    {
        $this->drive_license_a_number = $drive_license_a_number;
    }

    /**
     * @return mixed
     */
    public function getDriveLicenseADate()
    {
        return $this->drive_license_a_date;
    }

    /**
     * @param mixed $drive_license_a_date
     */
    public function setDriveLicenseADate($drive_license_a_date): void
    {
        $this->drive_license_a_date = $drive_license_a_date;
    }

    /**
     * @return mixed
     */
    public function getHasDriveLicenseB()
    {
        return $this->has_drive_license_b;
    }

    /**
     * @param mixed $has_drive_license_b
     */
    public function setHasDriveLicenseB($has_drive_license_b): void
    {
        $this->has_drive_license_b = $has_drive_license_b;
    }

    /**
     * @return mixed
     */
    public function getDriveLicenseBNumber()
    {
        return $this->drive_license_b_number;
    }

    /**
     * @param mixed $drive_license_b_number
     */
    public function setDriveLicenseBNumber($drive_license_b_number): void
    {
        $this->drive_license_b_number = $drive_license_b_number;
    }

    /**
     * @return mixed
     */
    public function getDriveLicenseBDate()
    {
        return $this->drive_license_b_date;
    }

    /**
     * @param mixed $drive_license_b_date
     */
    public function setDriveLicenseBDate($drive_license_b_date): void
    {
        $this->drive_license_b_date = $drive_license_b_date;
    }

    /**
     * @return mixed
     */
    public function getHasDriveLicenseC()
    {
        return $this->has_drive_license_c;
    }

    /**
     * @param mixed $has_drive_license_c
     */
    public function setHasDriveLicenseC($has_drive_license_c): void
    {
        $this->has_drive_license_c = $has_drive_license_c;
    }

    /**
     * @return mixed
     */
    public function getDriveLicenseCNumber()
    {
        return $this->drive_license_c_number;
    }

    /**
     * @param mixed $drive_license_c_number
     */
    public function setDriveLicenseCNumber($drive_license_c_number): void
    {
        $this->drive_license_c_number = $drive_license_c_number;
    }

    /**
     * @return mixed
     */
    public function getDriveLicenseCDate()
    {
        return $this->drive_license_c_date;
    }

    /**
     * @param mixed $drive_license_c_date
     */
    public function setDriveLicenseCDate($drive_license_c_date): void
    {
        $this->drive_license_c_date = $drive_license_c_date;
    }

    /**
     * @return mixed
     */
    public function getMaritalStatusId()
    {
        return $this->marital_status_id;
    }

    /**
     * @param mixed $marital_status_id
     */
    public function setMaritalStatusId($marital_status_id): void
    {
        $this->marital_status_id = $marital_status_id;
    }

    /**
     * @return mixed
     */
    public function getMateAs()
    {
        return $this->mate_as;
    }

    /**
     * @param mixed $mate_as
     */
    public function setMateAs($mate_as): void
    {
        $this->mate_as = $mate_as;
    }

    /**
     * @return mixed
     */
    public function getMateFullName()
    {
        return $this->mate_full_name;
    }

    /**
     * @param mixed $mate_full_name
     */
    public function setMateFullName($mate_full_name): void
    {
        $this->mate_full_name = $mate_full_name;
    }

    /**
     * @return mixed
     */
    public function getMateNickName()
    {
        return $this->mate_nick_name;
    }

    /**
     * @param mixed $mate_nick_name
     */
    public function setMateNickName($mate_nick_name): void
    {
        $this->mate_nick_name = $mate_nick_name;
    }

    /**
     * @return mixed
     */
    public function getMateBirthPlace()
    {
        return $this->mate_birth_place;
    }

    /**
     * @param mixed $mate_birth_place
     */
    public function setMateBirthPlace($mate_birth_place): void
    {
        $this->mate_birth_place = $mate_birth_place;
    }

    /**
     * @return mixed
     */
    public function getMateBirthDate()
    {
        return $this->mate_birth_date;
    }

    /**
     * @param mixed $mate_birth_date
     */
    public function setMateBirthDate($mate_birth_date): void
    {
        $this->mate_birth_date = $mate_birth_date;
    }

    /**
     * @return mixed
     */
    public function getMateOccupation()
    {
        return $this->mate_occupation;
    }

    /**
     * @param mixed $mate_occupation
     */
    public function setMateOccupation($mate_occupation): void
    {
        $this->mate_occupation = $mate_occupation;
    }

    /**
     * @return mixed
     */
    public function getOfficeId()
    {
        return $this->office_id;
    }

    /**
     * @param mixed $office_id
     */
    public function setOfficeId($office_id): void
    {
        $this->office_id = $office_id;
    }

    /**
     * @return mixed
     */
    public function getWorkAreaId()
    {
        return $this->work_area_id;
    }

    /**
     * @param mixed $work_area_id
     */
    public function setWorkAreaId($work_area_id): void
    {
        $this->work_area_id = $work_area_id;
    }

    /**
     * @return mixed
     */
    public function getHasNpwp()
    {
        return $this->has_npwp;
    }

    /**
     * @param mixed $has_npwp
     */
    public function setHasNpwp($has_npwp): void
    {
        $this->has_npwp = $has_npwp;
    }

    /**
     * @return mixed
     */
    public function getNpwpNumber()
    {
        return $this->npwp_number;
    }

    /**
     * @param mixed $npwp_number
     */
    public function setNpwpNumber($npwp_number): void
    {
        $this->npwp_number = $npwp_number;
    }

    /**
     * @return mixed
     */
    public function getNpwpDate()
    {
        return $this->npwp_date;
    }

    /**
     * @param mixed $npwp_date
     */
    public function setNpwpDate($npwp_date): void
    {
        $this->npwp_date = $npwp_date;
    }

    /**
     * @return mixed
     */
    public function getNpwpStatus()
    {
        return $this->npwp_status;
    }

    /**
     * @param mixed $npwp_status
     */
    public function setNpwpStatus($npwp_status): void
    {
        $this->npwp_status = $npwp_status;
    }

    /**
     * @return mixed
     */
    public function getHasBpjsTenagaKerja()
    {
        return $this->has_bpjs_tenaga_kerja;
    }

    /**
     * @param mixed $has_bpjs_tenaga_kerja
     */
    public function setHasBpjsTenagaKerja($has_bpjs_tenaga_kerja): void
    {
        $this->has_bpjs_tenaga_kerja = $has_bpjs_tenaga_kerja;
    }

    /**
     * @return mixed
     */
    public function getBpjsTenagaKerjaNumber()
    {
        return $this->bpjs_tenaga_kerja_number;
    }

    /**
     * @param mixed $bpjs_tenaga_kerja_number
     */
    public function setBpjsTenagaKerjaNumber($bpjs_tenaga_kerja_number): void
    {
        $this->bpjs_tenaga_kerja_number = $bpjs_tenaga_kerja_number;
    }

    /**
     * @return mixed
     */
    public function getBpjsTenagaKerjaDate()
    {
        return $this->bpjs_tenaga_kerja_date;
    }

    /**
     * @param mixed $bpjs_tenaga_kerja_date
     */
    public function setBpjsTenagaKerjaDate($bpjs_tenaga_kerja_date): void
    {
        $this->bpjs_tenaga_kerja_date = $bpjs_tenaga_kerja_date;
    }

    /**
     * @return mixed
     */
    public function getBpjsTenagaKerjaClass()
    {
        return $this->bpjs_tenaga_kerja_class;
    }

    /**
     * @param mixed $bpjs_tenaga_kerja_class
     */
    public function setBpjsTenagaKerjaClass($bpjs_tenaga_kerja_class): void
    {
        $this->bpjs_tenaga_kerja_class = $bpjs_tenaga_kerja_class;
    }

    /**
     * @return mixed
     */
    public function getHasBpjsKesehatan()
    {
        return $this->has_bpjs_kesehatan;
    }

    /**
     * @param mixed $has_bpjs_kesehatan
     */
    public function setHasBpjsKesehatan($has_bpjs_kesehatan): void
    {
        $this->has_bpjs_kesehatan = $has_bpjs_kesehatan;
    }

    /**
     * @return mixed
     */
    public function getBpjsKesehatanNumber()
    {
        return $this->bpjs_kesehatan_number;
    }

    /**
     * @param mixed $bpjs_kesehatan_number
     */
    public function setBpjsKesehatanNumber($bpjs_kesehatan_number): void
    {
        $this->bpjs_kesehatan_number = $bpjs_kesehatan_number;
    }

    /**
     * @return mixed
     */
    public function getBpjsKesehatanDate()
    {
        return $this->bpjs_kesehatan_date;
    }

    /**
     * @param mixed $bpjs_kesehatan_date
     */
    public function setBpjsKesehatanDate($bpjs_kesehatan_date): void
    {
        $this->bpjs_kesehatan_date = $bpjs_kesehatan_date;
    }

    /**
     * @return mixed
     */
    public function getBpjsKesehatanClass()
    {
        return $this->bpjs_kesehatan_class;
    }

    /**
     * @param mixed $bpjs_kesehatan_class
     */
    public function setBpjsKesehatanClass($bpjs_kesehatan_class): void
    {
        $this->bpjs_kesehatan_class = $bpjs_kesehatan_class;
    }

    /**
     * @return mixed
     */
    public function getHasMateBpjsKesehatan()
    {
        return $this->has_mate_bpjs_kesehatan;
    }

    /**
     * @param mixed $has_mate_bpjs_kesehatan
     */
    public function setHasMateBpjsKesehatan($has_mate_bpjs_kesehatan): void
    {
        $this->has_mate_bpjs_kesehatan = $has_mate_bpjs_kesehatan;
    }

    /**
     * @return mixed
     */
    public function getMateBpjsKesehatanNumber()
    {
        return $this->mate_bpjs_kesehatan_number;
    }

    /**
     * @param mixed $mate_bpjs_kesehatan_number
     */
    public function setMateBpjsKesehatanNumber($mate_bpjs_kesehatan_number): void
    {
        $this->mate_bpjs_kesehatan_number = $mate_bpjs_kesehatan_number;
    }

    /**
     * @return mixed
     */
    public function getMateBpjsKesehatanDate()
    {
        return $this->mate_bpjs_kesehatan_date;
    }

    /**
     * @param mixed $mate_bpjs_kesehatan_date
     */
    public function setMateBpjsKesehatanDate($mate_bpjs_kesehatan_date): void
    {
        $this->mate_bpjs_kesehatan_date = $mate_bpjs_kesehatan_date;
    }

    /**
     * @return mixed
     */
    public function getMateBpjsKesehatanClass()
    {
        return $this->mate_bpjs_kesehatan_class;
    }

    /**
     * @param mixed $mate_bpjs_kesehatan_class
     */
    public function setMateBpjsKesehatanClass($mate_bpjs_kesehatan_class): void
    {
        $this->mate_bpjs_kesehatan_class = $mate_bpjs_kesehatan_class;
    }

    /**
     * @return mixed
     */
    public function getDplkNumber()
    {
        return $this->dplk_number;
    }

    /**
     * @param mixed $dplk_number
     */
    public function setDplkNumber($dplk_number): void
    {
        $this->dplk_number = $dplk_number;
    }

    /**
     * @return mixed
     */
    public function getCollectiveNumber()
    {
        return $this->collective_number;
    }

    /**
     * @param mixed $collective_number
     */
    public function setCollectiveNumber($collective_number): void
    {
        $this->collective_number = $collective_number;
    }

    /**
     * @return mixed
     */
    public function getEnglishAbility()
    {
        return $this->english_ability;
    }

    /**
     * @param mixed $english_ability
     */
    public function setEnglishAbility($english_ability): void
    {
        $this->english_ability = $english_ability;
    }

    /**
     * @return mixed
     */
    public function getComputerAbility()
    {
        return $this->computer_ability;
    }

    /**
     * @param mixed $computer_ability
     */
    public function setComputerAbility($computer_ability): void
    {
        $this->computer_ability = $computer_ability;
    }

    /**
     * @return mixed
     */
    public function getOtherAbility()
    {
        return $this->other_ability;
    }

    /**
     * @param mixed $other_ability
     */
    public function setOtherAbility($other_ability): void
    {
        $this->other_ability = $other_ability;
    }

    /**
     * @return mixed
     */
    public function getBankId()
    {
        return $this->bank_id;
    }

    /**
     * @param mixed $bank_id
     */
    public function setBankId($bank_id): void
    {
        $this->bank_id = $bank_id;
    }

    /**
     * @return mixed
     */
    public function getAccountNumber()
    {
        return $this->account_number;
    }

    /**
     * @param mixed $account_number
     */
    public function setAccountNumber($account_number): void
    {
        $this->account_number = $account_number;
    }

    /**
     * @return mixed
     */
    public function getJoinDate()
    {
        return $this->join_date;
    }

    /**
     * @param mixed $join_date
     */
    public function setJoinDate($join_date): void
    {
        $this->join_date = $join_date;
    }

    /**
     * @return mixed
     */
    public function getWorkStatus()
    {
        return $this->work_status;
    }

    /**
     * @param mixed $work_status
     */
    public function setWorkStatus($work_status): void
    {
        $this->work_status = $work_status;
    }

    /**
     * @return mixed
     */
    public function getWorkType()
    {
        return $this->work_type;
    }

    /**
     * @param mixed $work_type
     */
    public function setWorkType($work_type): void
    {
        $this->work_type = $work_type;
    }

    /**
     * @return mixed
     */
    public function getMediaLibraries()
    {
        return $this->media_libraries;
    }

    /**
     * @param mixed $media_libraries
     */
    public function setMediaLibraries($media_libraries): void
    {
        $this->media_libraries = $media_libraries;
    }

    /**
     * @return mixed
     */
    public function getChilds()
    {
        return $this->childs;
    }

    /**
     * @param mixed $childs
     */
    public function setChilds($childs): void
    {
        $this->childs = $childs;
    }

    /**
     * @return mixed
     */
    public function getFormalEducations()
    {
        return $this->formal_educations;
    }

    /**
     * @param mixed $formal_educations
     */
    public function setFormalEducations($formal_educations): void
    {
        $this->formal_educations = $formal_educations;
    }

    /**
     * @return mixed
     */
    public function getNonFormalEducations()
    {
        return $this->non_formal_educations;
    }

    /**
     * @param mixed $non_formal_educations
     */
    public function setNonFormalEducations($non_formal_educations): void
    {
        $this->non_formal_educations = $non_formal_educations;
    }

    /**
     * @return mixed
     */
    public function getOrganizations()
    {
        return $this->organizations;
    }

    /**
     * @param mixed $organizations
     */
    public function setOrganizations($organizations): void
    {
        $this->organizations = $organizations;
    }

    /**
     * @return mixed
     */
    public function getOtherEquipments()
    {
        return $this->other_equipments;
    }

    /**
     * @param mixed $other_equipments
     */
    public function setOtherEquipments($other_equipments): void
    {
        $this->other_equipments = $other_equipments;
    }

    /**
     * @return mixed
     */
    public function getWorkCompetences()
    {
        return $this->work_competences;
    }

    /**
     * @param mixed $work_competences
     */
    public function setWorkCompetences($work_competences): void
    {
        $this->work_competences = $work_competences;
    }

    /**
     * @return mixed
     */
    public function getWorkExperiences()
    {
        return $this->work_experiences;
    }

    /**
     * @param mixed $work_experiences
     */
    public function setWorkExperiences($work_experiences): void
    {
        $this->work_experiences = $work_experiences;
    }
}
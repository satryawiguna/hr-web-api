<?php
namespace App\Domains\HumanResources\Personal\Employee\Contracts;

use App\Domains\Contracts\BaseEntityInterface;

interface EmployeeInterface extends BaseEntityInterface
{
    //<editor-fold desc="#constanta">

    const TABLE_NAME = 'employees';
    const MORPH_NAME = 'employees';

    //</editor-fold>


    //<editor-fold desc="#property">

    /**
     * Get company_id.
     *
     * @return mixed
     */
    public function getCompanyId();
    
    /**
     * Set company_id.
     *
     * @param $company_id
     *
     * @return mixed
     */
    public function setCompanyId($company_id);

    /**
     * Get nip.
     *
     * @return mixed
     */
    public function getNip();
    
    /**
     * Set nip.
     *
     * @param $nip
     *
     * @return mixed
     */
    public function setNip($nip);

    /**
     * Get full_name.
     *
     * @return mixed
     */
    public function getFullName();
    
    /**
     * Set full_name.
     *
     * @param $full_name
     *
     * @return mixed
     */
    public function setFullName($full_name);

    /**
     * Get nick_name.
     *
     * @return mixed
     */
    public function getNickName();
    
    /**
     * Set nick_name.
     *
     * @param $nick_name
     *
     * @return mixed
     */
    public function setNickName($nick_name);

    /**
     * Get gender_id.
     *
     * @return mixed
     */
    public function getGenderId();

    /**
     * Set gender_id.
     *
     * @param $gender_id
     *
     * @return mixed
     */
    public function setGenderId($gender_id);

    /**
     * Get religion_id.
     *
     * @return mixed
     */
    public function getReligionId();

    /**
     * Set religion_id.
     *
     * @param $religion_id
     *
     * @return mixed
     */
    public function setReligionId($religion_id);

    /**
     * Get birth_place.
     *
     * @return mixed
     */
    public function getBirthPlace();
    
    /**
     * Set birth_place.
     *
     * @param $birth_place
     *
     * @return mixed
     */
    public function setBirthPlace($birth_place);

    /**
     * Get birth_date.
     *
     * @return mixed
     */
    public function getBirthDate();
    
    /**
     * Set birth_date.
     *
     * @param $birth_date
     *
     * @return mixed
     */
    public function setBirthDate($birth_date);

    /**
     * Get address.
     *
     * @return mixed
     */
    public function getAddress();
    
    /**
     * Set address.
     *
     * @param $address
     *
     * @return mixed
     */
    public function setAddress($address);

    /**
     * Get phone.
     *
     * @return mixed
     */
    public function getPhone();

    /**
     * Set phone.
     *
     * @param $phone
     *
     * @return mixed
     */
    public function setPhone($phone);

    /**
     * Get mobile.
     *
     * @return mixed
     */
    public function getMobile();

    /**
     * Set mobile.
     *
     * @param $mobile
     *
     * @return mixed
     */
    public function setMobile($mobile);

    /**
     * Get email.
     *
     * @return mixed
     */
    public function getEmail();

    /**
     * Set email.
     *
     * @param $email
     *
     * @return mixed
     */
    public function setEmail($email);

    /**
     * Get identity_number.
     *
     * @return mixed
     */
    public function getIdentityNumber();

    /**
     * Set identity_number.
     *
     * @param $identity_number
     *
     * @return mixed
     */
    public function setIdentityNumber($identity_number);

    /**
     * Get identity_expired_date.
     *
     * @return mixed
     */
    public function getIdentityExpiredDate();

    /**
     * Set identity_expired_date.
     *
     * @param $identity_expired_date
     *
     * @return mixed
     */
    public function setIdentityExpiredDate($identity_expired_date);

    /**
     * Get identity_address.
     *
     * @return mixed
     */
    public function getIdentityAddress();

    /**
     * Set identity_address.
     *
     * @param $identity_address
     *
     * @return mixed
     */
    public function setIdentityAddress($identity_address);

    /**
     * Get has_drive_license_a.
     *
     * @return mixed
     */
    public function getHasDriveLicenseA();

    /**
     * Set has_drive_license_a.
     *
     * @param $has_drive_license_a
     *
     * @return mixed
     */
    public function setHasDriveLicenseA($has_drive_license_a);

    /**
     * Get drive_license_a_number.
     *
     * @return mixed
     */
    public function getDriveLicenseANumber();

    /**
     * Set drive_license_a_number.
     *
     * @param $drive_license_a_number
     *
     * @return mixed
     */
    public function setDriveLicenseANumber($drive_license_a_number);

    /**
     * Get drive_license_a_date.
     *
     * @return mixed
     */
    public function getDriveLicenseADate();

    /**
     * Set drive_license_a_date.
     *
     * @param $drive_license_a_date
     *
     * @return mixed
     */
    public function setDriveLicenseADate($drive_license_a_date);

    /**
     * Get has_drive_license_b.
     *
     * @return mixed
     */
    public function getHasDriveLicenseB();

    /**
     * Set has_drive_license_b.
     *
     * @param $has_drive_license_b
     *
     * @return mixed
     */
    public function setHasDriveLicenseB($has_drive_license_b);

    /**
     * Get drive_license_b_number.
     *
     * @return mixed
     */
    public function getDriveLicenseBNumber();

    /**
     * Set drive_license_b_number.
     *
     * @param $drive_license_b_number
     *
     * @return mixed
     */
    public function setDriveLicenseBNumber($drive_license_b_number);

    /**
     * Get drive_license_b_date.
     *
     * @return mixed
     */
    public function getDriveLicenseBDate();

    /**
     * Set drive_license_b_date.
     *
     * @param $drive_license_b_date
     *
     * @return mixed
     */
    public function setDriveLicenseBDate($drive_license_b_date);

    /**
     * Get has_drive_license_c.
     *
     * @return mixed
     */
    public function getHasDriveLicenseC();

    /**
     * Set has_drive_license_c.
     *
     * @param $has_drive_license_c
     *
     * @return mixed
     */
    public function setHasDriveLicenseC($has_drive_license_c);

    /**
     * Get drive_license_c_number.
     *
     * @return mixed
     */
    public function getDriveLicenseCNumber();

    /**
     * Set drive_license_c_number.
     *
     * @param $drive_license_c_number
     *
     * @return mixed
     */
    public function setDriveLicenseCNumber($drive_license_c_number);

    /**
     * Get drive_license_c_date.
     *
     * @return mixed
     */
    public function getDriveLicenseCDate();

    /**
     * Set drive_license_c_date.
     *
     * @param $drive_license_c_date
     *
     * @return mixed
     */
    public function setDriveLicenseCDate($drive_license_c_date);

    /**
     * Get marital_status_id.
     *
     * @return mixed
     */
    public function getMaritalStatusId();

    /**
     * Set marital_status_id.
     *
     * @param $marital_status_id
     *
     * @return mixed
     */
    public function setMaritalStatusId($marital_status_id);

    /**
     * Get mate_as.
     *
     * @return mixed
     */
    public function getMateAs();
    
    /**
     * Set mate_as.
     *
     * @param $mate_as
     *
     * @return mixed
     */
    public function setMateAs($mate_as);

    /**
     * Get mate_full_name.
     *
     * @return mixed
     */
    public function getMateFullName();
    
    /**
     * Set mate_full_name.
     *
     * @param $mate_full_name
     *
     * @return mixed
     */
    public function setMateFullName($mate_full_name);

    /**
     * Get mate_nick_name.
     *
     * @return mixed
     */
    public function getMateNickName();
    
    /**
     * Set mate_nick_name.
     *
     * @param $mate_nick_name
     *
     * @return mixed
     */
    public function setMateNickName($mate_nick_name);

    /**
     * Get mate_birth_place.
     *
     * @return mixed
     */
    public function getMateBirthPlace();
    
    /**
     * Set mate_birth_place.
     *
     * @param $mate_birth_place
     *
     * @return mixed
     */
    public function setMateBirthPlace($mate_birth_place);

    /**
     * Get mate_birth_date.
     *
     * @return mixed
     */
    public function getMateBirthDate();
    
    /**
     * Set mate_birth_date.
     *
     * @param $mate_birth_date
     *
     * @return mixed
     */
    public function setMateBirthDate($mate_birth_date);

    /**
     * Get mate_occupation.
     *
     * @return mixed
     */
    public function getMateOccupation();

    /**
     * Set mate_occupation.
     *
     * @param $mate_occupation
     *
     * @return mixed
     */
    public function setMateOccupation($mate_occupation);

    /**
     * Get office.
     *
     * @return mixed
     */
    public function getOfficeId();

    /**
     * Set office.
     *
     * @param $office_id
     *
     * @return mixed
     */
    public function setOfficeId($office_id);

    /**
     * Get work_area.
     *
     * @return mixed
     */
    public function getWorkAreaId();

    /**
     * Set work_area.
     *
     * @param $work_area_id
     *
     * @return mixed
     */
    public function setWorkAreaId($work_area_id);

    /**
     * Get has_npwp.
     *
     * @return mixed
     */
    public function getHasNpwp();
    
    /**
     * Set has_npwp.
     *
     * @param $has_npwp
     *
     * @return mixed
     */
    public function setHasNpwp($has_npwp);

    /**
     * Get npwp_number.
     *
     * @return mixed
     */
    public function getNpwpNumber();
    
    /**
     * Set npwp_number.
     *
     * @param $npwp_number
     *
     * @return mixed
     */
    public function setNpwpNumber($npwp_number);

    /**
     * Get npwp_date.
     *
     * @return mixed
     */
    public function getNpwpDate();
    
    /**
     * Set npwp_date.
     *
     * @param $npwp_date
     *
     * @return mixed
     */
    public function setNpwpDate($npwp_date);

    /**
     * Get npwp_status.
     *
     * @return mixed
     */
    public function getNpwpStatus();
    
    /**
     * Set npwp_status.
     *
     * @param $npwp_status
     *
     * @return mixed
     */
    public function setNpwpStatus($npwp_status);

    /**
     * Get has_bpjs_tenaga_kerja.
     *
     * @return mixed
     */
    public function getHasBpjsTenagaKerja();
    
    /**
     * Set has_bpjs_tenaga_kerja.
     *
     * @param $has_bpjs_tenaga_kerja
     *
     * @return mixed
     */
    public function setHasBpjsTenagaKerja($has_bpjs_tenaga_kerja);

    /**
     * Get bpjs_tenaga_kerja_number.
     *
     * @return mixed
     */
    public function getBpjsTenagaKerjaNumber();
    
    /**
     * Set bpjs_tenaga_kerja_number.
     *
     * @param $bpjs_tenaga_kerja_number
     *
     * @return mixed
     */
    public function setBpjsTenagaKerjaNumber($bpjs_tenaga_kerja_number);

    /**
     * Get bpjs_tenaga_kerja_date.
     *
     * @return mixed
     */
    public function getBpjsTenagaKerjaDate();
    
    /**
     * Set bpjs_tenaga_kerja_date.
     *
     * @param $bpjs_tenaga_kerja_date
     *
     * @return mixed
     */
    public function setBpjsTenagaKerjaDate($bpjs_tenaga_kerja_date);

    /**
     * Get bpjs_tenaga_kerja_class.
     *
     * @return mixed
     */
    public function getBpjsTenagaKerjaClass();
    
    /**
     * Set bpjs_tenaga_kerja_class.
     *
     * @param $bpjs_tenaga_kerja_class
     *
     * @return mixed
     */
    public function setBpjsTenagaKerjaClass($bpjs_tenaga_kerja_class);

    /**
     * Get has_bpjs_kesehatan.
     *
     * @return mixed
     */
    public function getHasBpjsKesehatan();
    
    /**
     * Set has_bpjs_kesehatan.
     *
     * @param $has_bpjs_kesehatan
     *
     * @return mixed
     */
    public function setHasBpjsKesehatan($has_bpjs_kesehatan);

    /**
     * Get bpjs_kesehatan_number.
     *
     * @return mixed
     */
    public function getBpjsKesehatanNumber();
    
    /**
     * Set bpjs_kesehatan_number.
     *
     * @param $bpjs_kesehatan_number
     *
     * @return mixed
     */
    public function setBpjsKesehatanNumber($bpjs_kesehatan_number);

    /**
     * Get bpjs_kesehatan_date.
     *
     * @return mixed
     */
    public function getBpjsKesehatanDate();
    
    /**
     * Set bpjs_kesehatan_date.
     *
     * @param $bpjs_kesehatan_date
     *
     * @return mixed
     */
    public function setBpjsKesehatanDate($bpjs_kesehatan_date);

    /**
     * Get bpjs_kesehatan_class.
     *
     * @return mixed
     */
    public function getBpjsKesehatanClass();
    
    /**
     * Set bpjs_kesehatan_class.
     *
     * @param $bpjs_kesehatan_class
     *
     * @return mixed
     */
    public function setBpjsKesehatanClass($bpjs_kesehatan_class);

    /**
     * Get has_mate_bpjs_kesehatan.
     *
     * @return mixed
     */
    public function getHasMateBpjsKesehatan();

    /**
     * Set has_mate_bpjs_kesehatan.
     *
     * @param $has_mate_bpjs_kesehatan
     *
     * @return mixed
     */
    public function setHasMateBpjsKesehatan($has_mate_bpjs_kesehatan);

    /**
     * Get mate_bpjs_kesehatan_number.
     *
     * @return mixed
     */
    public function getMateBpjsKesehatanNumber();
    
    /**
     * Set mate_bpjs_kesehatan_number.
     *
     * @param $mate_bpjs_kesehatan_number
     *
     * @return mixed
     */
    public function setMateBpjsKesehatanNumber($mate_bpjs_kesehatan_number);

    /**
     * Get mate_bpjs_kesehatan_date.
     *
     * @return mixed
     */
    public function getMateBpjsKesehatanDate();
    
    /**
     * Set mate_bpjs_kesehatan_date.
     *
     * @param $mate_bpjs_kesehatan_date
     *
     * @return mixed
     */
    public function setMateBpjsKesehatanDate($mate_bpjs_kesehatan_date);

    /**
     * Get mate_bpjs_kesehatan_class.
     *
     * @return mixed
     */
    public function getMateBpjsKesehatanClass();
    
    /**
     * Set mate_bpjs_kesehatan_class.
     *
     * @param $mate_bpjs_kesehatan_class
     *
     * @return mixed
     */
    public function setMateBpjsKesehatanClass($mate_bpjs_kesehatan_class);

    /**
     * Get dplk_number.
     *
     * @return mixed
     */
    public function getDplkNumber();
    
    /**
     * Set dplk_number.
     *
     * @param $dplk_number
     *
     * @return mixed
     */
    public function setDplkNumber($dplk_number);

    /**
     * Get collective_number.
     *
     * @return mixed
     */
    public function getCollectiveNumber();
    
    /**
     * Set collective_number.
     *
     * @param $collective_number
     *
     * @return mixed
     */
    public function setCollectiveNumber($collective_number);

    /**
     * Get english_ability.
     *
     * @return mixed
     */
    public function getEnglishAbility();
    
    /**
     * Set english_ability.
     *
     * @param $english_ability
     *
     * @return mixed
     */
    public function setEnglishAbility($english_ability);

    /**
     * Get computer_ability.
     *
     * @return mixed
     */
    public function getComputerAbility();
    
    /**
     * Set computer_ability.
     *
     * @param $computer_ability
     *
     * @return mixed
     */
    public function setComputerAbility($computer_ability);

    /**
     * Get other_ability.
     *
     * @return mixed
     */
    public function getOtherAbility();
    
    /**
     * Set other_ability.
     *
     * @param $other_ability
     *
     * @return mixed
     */
    public function setOtherAbility($other_ability);

    /**
     * Get bank_id.
     *
     * @return mixed
     */
    public function getBankId();

    /**
     * Set bank_id.
     *
     * @param $bank_id
     *
     * @return mixed
     */
    public function setBankId($bank_id);

    /**
     * Get account_number.
     *
     * @return mixed
     */
    public function getAccountNumber();
    
    /**
     * Set account_number.
     *
     * @param $account_number
     *
     * @return mixed
     */
    public function setAccountNumber($account_number);

    /**
     * Get join_date.
     *
     * @return mixed
     */
    public function getJoinDate();

    /**
     * Set join_date.
     *
     * @param $join_date
     *
     * @return mixed
     */
    public function setJoinDate($join_date);

    /**
     * Get work_status.
     *
     * @return mixed
     */
    public function getWorkStatus();

    /**
     * Set work_status.
     *
     * @param $work_status
     *
     * @return mixed
     */
    public function setWorkStatus($work_status);

    /**
     * Get work_type.
     *
     * @return mixed
     */
    public function getWorkType();

    /**
     * Set work_type.
     *
     * @param $work_type
     *
     * @return mixed
     */
    public function setWorkType($work_type);

    /**
     * Get created_by.
     *
     * @return mixed
     */
    public function getCreatedBy();

    /**
     * Set created_by.
     *
     * @param $created_by
     *
     * @return mixed
     */
    public function setCreatedBy($created_by);

    /**
     * Get modified_by.
     *
     * @return mixed
     */
    public function getModifiedBy();

    /**
     * Set modified_by.
     *
     * @param $modified_by
     *
     * @return mixed
     */
    public function setModifiedBy($modified_by);


    //</editor-fold>


    //<editor-fold desc="#public (method)">


    //<editor-fold desc="#belongs to relation">

    /**
     * @return mixed
     */
    public function company();

    /**
     * @return mixed
     */
    public function gender();

    /**
     * @return mixed
     */
    public function religion();

    /**
     * @return mixed
     */
    public function maritalStatus();

    /**
     * @return mixed
     */
    public function office();

    /**
     * @return mixed
     */
    public function workArea();

    /**
     * @return mixed
     */
    public function bank();

    //</editor-fold>


    //<editor-fold desc="#has many relation">

    /**
     * @return mixed
     */
    public function projectMutations();

    /**
     * @return mixed
     */
    public function workUnitMutations();

    /**
     * @return mixed
     */
    public function positionMutations();

    /**
     * @return mixed
     */
    public function workCompetences();

   /**
     * @return mixed
     */
    public function formalEducationHistories();

    /**
     * @return mixed
     */
    public function nonFormalEducationHistories();

    /**
     * @return mixed
     */
    public function organizationHistories();

    /**
     * @return mixed
     */
    public function workExperiences();

    /**
     * @return mixed
     */
    public function workAgreementLetters();

    /**
     * @return mixed
     */
    public function registrationLetters();

    /**
     * @return mixed
     */
    public function terminations();

    /**
     * @return mixed
     */
    public function otherEquipments();

    /**
     * @return mixed
     */
    public function elementEntries();

    /**
     * @return mixed
     */
    public function childs();

    //</editor-fold>


    //<editor-fold desc="#polimorphism many to many relation">

    /**
     * @return mixed
     */
    public function morphMediaLibraries();

    //</editor-fold>


    //</editor-fold>
}

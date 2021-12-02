<?php

namespace App\Domains\HumanResources\Personal\Employee;

use App\Domains\Commons\Bank\BankEloquent;
use App\Domains\Commons\Company\CompanyEloquent;
use App\Domains\HumanResources\Element\ElementEntry\ElementEntryEloquent;
use App\Domains\HumanResources\Mutation\PositionMutation\PositionMutationEloquent;
use App\Domains\HumanResources\Mutation\ProjectMutation\ProjectMutationEloquent;
use App\Domains\HumanResources\Mutation\WorkUnitMutation\WorkUnitMutationEloquent;
use App\Domains\HumanResources\Personal\Employee\Child\ChildEloquent;
use App\Domains\HumanResources\Personal\Employee\Contracts\EmployeeInterface;
use App\Domains\HumanResources\Personal\Employee\FormalEducationHistory\FormalEducationHistoryEloquent;
use App\Domains\Commons\Gender\GenderEloquent;
use App\Domains\Commons\MaritalStatus\MaritalStatusEloquent;
use App\Domains\HumanResources\Personal\Employee\NonFormalEducationHistory\NonFormalEducationHistoryEloquent;
use App\Domains\Commons\Office\OfficeEloquent;
use App\Domains\HumanResources\Personal\Employee\OrganizationHistory\OrganizationHistoryEloquent;
use App\Domains\HumanResources\Termination\TerminationEloquent;
use App\Domains\MediaLibrary\MediaLibraryEloquent;
use App\Infrastructures\HumanResources\Personal\Employee\OtherEquipment\OtherEquipmentEloquent;
use App\Domains\RegistrationLetter\RegistrationLetterEloquent;
use App\Domains\Commons\Religion\ReligionEloquent;
use App\Domains\WorkAgreementLetter\WorkAgreementLetterEloquent;
use App\Domains\HumanResources\MasterData\WorkArea\WorkAreaEloquent;
use App\Domains\HumanResources\Personal\Employee\WorkCompetence\WorkCompetenceEloquent;
use App\Domains\HumanResources\Personal\Employee\WorkExperience\WorkExperienceEloquent;
use App\Infrastructures\EloquentAbstract;
use Askedio\SoftCascade\Traits\SoftCascadeTrait;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @OA\Schema(
 *     description="Employee eloquent",
 *     title="Employee eloquent",
 *     required={"company_id", "nip", "full_name", "nick_name", "gender_id", "religion_id", "birth_place", "birth_date",
 *     "address", "phone", "mobile", "email", "identity_number", "identity_date", "identity_address", "marital_status_id",
 *     "office_id", "work_area_id", "has_npwp", "npwp_number", "npwp_date", "npwp_status", "has_bpjs_tenaga_kerja",
 *     "bpjs_tenaga_kerja_number", "bpjs_tenaga_kerja_date", "bpjs_tenaga_kerja_class", "has_bpjs_kesehatan", "bpjs_kesehatan_number",
 *     "bpjs_kesehatan_date", "bpjs_kesehatan_class", "dplk_number", "collective_number", "english_ability",
 *     "computer_ability", "other_ability", "bank_id", "account_number", "join_date", "work_status"}
 * )
 * EmployeeEloquent.
 */
class EmployeeEloquent extends EloquentAbstract implements EmployeeInterface
{
    use SoftDeletes, SoftCascadeTrait;

    /**
     * @OA\Property(
     *     property="company_id",
     *     description="Company id property",
     *     type="integer",
     *     format="int64",
     *     example=1
     * )
     *
     * @var integer
     */

    /**
     * @OA\Property(
     *     property="nip",
     *     description="Nip property",
     *     type="string"
     * )
     *
     * @var string
     */

    /**
     * @OA\Property(
     *     property="full_name",
     *     description="Full name property",
     *     type="string"
     * )
     *
     * @var string
     */

    /**
     * @OA\Property(
     *     property="nick_name",
     *     description="Nick name property",
     *     type="string"
     * )
     *
     * @var string
     */

    /**
     * @OA\Property(
     *     property="gender_id",
     *     description="Gender id property",
     *     type="integer",
     *     format="int64",
     *     example=1
     * )
     *
     * @var integer
     */

    /**
     * @OA\Property(
     *     property="religion_id",
     *     description="Religion id property",
     *     type="integer",
     *     format="int64",
     *     example=1
     * )
     *
     * @var integer
     */

    /**
     * @OA\Property(
     *     property="birth_place",
     *     description="Birth place property",
     *     type="string"
     * )
     *
     * @var string
     */

    /**
     * @OA\Property(
     *     property="birth_date",
     *     description="Birth date property",
     *     type="string",
     *     format="date-time",
     *     example="2020-01-01 00:00:00"
     * )
     *
     * @var string
     */

    /**
     * @OA\Property(
     *     property="address",
     *     description="Address property",
     *     type="string"
     * )
     *
     * @var string
     */

    /**
     * @OA\Property(
     *     property="phone",
     *     description="Phone property",
     *     type="string"
     * )
     *
     * @var string
     */

    /**
     * @OA\Property(
     *     property="mobile",
     *     description="Mobile property",
     *     type="string"
     * )
     *
     * @var string
     */

    /**
     * @OA\Property(
     *     property="email",
     *     description="Email property",
     *     type="string"
     * )
     *
     * @var string
     */

    /**
     * @OA\Property(
     *     property="identity_number",
     *     description="Identity number property",
     *     type="string"
     * )
     *
     * @var string
     */

    /**
     * @OA\Property(
     *     property="identity_expired_date",
     *     description="Identity expired date property",
     *     type="string",
     *     format="date-time",
     *     example="2020-01-01 00:00:00"
     * )
     *
     * @var string
     */

    /**
     * @OA\Property(
     *     property="identity_address",
     *     description="Identity address property",
     *     type="string"
     * )
     *
     * @var
     */

    /**
     * @OA\Property(
     *     property="has_drive_license_a",
     *     description="Has drive license a property",
     *     type="boolean"
     * )
     *
     * @var
     */

    /**
     * @OA\Property(
     *     property="drive_license_a_number",
     *     description="Drive license a number property",
     *     type="string"
     * )
     *
     * @var
     */

    /**
     * @OA\Property(
     *     property="drive_license_a_date",
     *     description="Drive license a date property",
     *     type="string",
     *     format="date-time",
     *     example="2020-01-01 00:00:00"
     * )
     *
     * @var string
     */

    /**
     * @OA\Property(
     *     property="has_drive_license_b",
     *     description="Has drive license b property",
     *     type="boolean"
     * )
     *
     * @var
     */

    /**
     * @OA\Property(
     *     property="drive_license_b_number",
     *     description="Drive license b number property",
     *     type="string"
     * )
     *
     * @var
     */

    /**
     * @OA\Property(
     *     property="drive_license_b_date",
     *     description="Drive license b date property",
     *     type="string",
     *     format="date-time",
     *     example="2020-01-01 00:00:00"
     * )
     *
     * @var string
     */

    /**
     * @OA\Property(
     *     property="has_drive_license_c",
     *     description="Has drive license c property",
     *     type="boolean"
     * )
     *
     * @var
     */

    /**
     * @OA\Property(
     *     property="drive_license_c_number",
     *     description="Drive license c number property",
     *     type="string"
     * )
     *
     * @var
     */

    /**
     * @OA\Property(
     *     property="drive_license_c_date",
     *     description="Drive license c date property",
     *     type="string",
     *     format="date-time",
     *     example="2020-01-01 00:00:00"
     * )
     *
     * @var string
     */

    /**
     * @OA\Property(
     *     property="marital_status_id",
     *     description="Marital status id property",
     *     type="integer",
     *     format="int64",
     *     example=1
     * )
     *
     * @var integer
     */

    /**
     * @OA\Property(
     *     property="mate_as",
     *     description="Mate as property",
     *     type="string",
     *     enum={"HUSBAND","WIFE"},
     *     default=""
     * )
     *
     * @var string
     */

    /**
     * @OA\Property(
     *     property="mate_full_name",
     *     description="Mate full name property",
     *     type="string"
     * )
     *
     * @var string
     */

    /**
     * @OA\Property(
     *     property="mate_nick_name",
     *     description="Mate nick name property",
     *     type="string"
     * )
     *
     * @var string
     */

    /**
     * @OA\Property(
     *     property="mate_birth_place",
     *     description="Mate birth place property",
     *     type="string"
     * )
     *
     * @var string
     */

    /**
     * @OA\Property(
     *     property="mate_birth_date",
     *     description="Mate birth date property",
     *     type="string",
     *     format="date-time",
     *     example="2020-01-01 00:00:00"
     * )
     *
     * @var string
     */

    /**
     * @OA\Property(
     *     property="mate_occupation",
     *     description="Mate occupation property",
     *     type="string"
     * )
     *
     * @var string
     */

    /**
     * @OA\Property(
     *     property="office_id",
     *     description="Office id property",
     *     type="integer",
     *     format="int64",
     *     example=1
     * )
     *
     * @var integer
     */

    /**
     * @OA\Property(
     *     property="work_area_id",
     *     description="Work area id property",
     *     type="integer",
     *     format="int64",
     *     example=1
     * )
     *
     * @var integer
     */

    /**
     * @OA\Property(
     *     property="has_npwp",
     *     description="Has npwp property",
     *     type="boolean"
     * )
     *
     * @var
     */

    /**
     * @OA\Property(
     *     property="npwp_number",
     *     description="NPWP number property",
     *     type="string"
     * )
     *
     * @var string
     */

    /**
     * @OA\Property(
     *     property="npwp_date",
     *     description="NPWP date property",
     *     type="string",
     *     format="date-time",
     *     example="2020-01-01 00:00:00"
     * )
     *
     * @var string
     */

    /**
     * @OA\Property(
     *     property="npwp_status",
     *     description="NPWP status property",
     *     type="string",
     *     enum={"TK/0","TK/1","TK/2","TK/3","K/0","K/1","K/2","K/3","KI/1","KI/2","KI/3"},
     *     default=""
     * )
     *
     * @var string
     */

    /**
     * @OA\Property(
     *     property="has_bpjs_tenaga_kerja",
     *     description="Has BPJS tenaga kerja property",
     *     type="boolean"
     * )
     *
     * @var
     */

    /**
     * @OA\Property(
     *     property="bpjs_tenaga_kerja_number",
     *     description="BPJS tenaga kerja number property",
     *     type="string"
     * )
     *
     * @var string
     */

    /**
     * @OA\Property(
     *     property="bpjs_tenaga_kerja_date",
     *     description="BPJS tenaga kerja date property",
     *     type="string",
     *     format="date-time",
     *     example="2020-01-01 00:00:00"
     * )
     *
     * @var string
     */

    /**
     * @OA\Property(
     *     property="bpjs_tenaga_kerja_class",
     *     description="BPJS tenaga kerja class property",
     *     type="string",
     *     enum={"I","II","III"},
     *     default=""
     * )
     *
     * @var string
     */

    /**
     * @OA\Property(
     *     property="has_bpjs_kesehatan",
     *     description="Has BPJS kesehatan property",
     *     type="boolean"
     * )
     *
     * @var boolean
     */

    /**
     * @OA\Property(
     *     property="bpjs_kesehatan_number",
     *     description="BPJS kesehatan number property",
     *     type="string"
     * )
     *
     * @var string
     */

    /**
     * @OA\Property(
     *     property="bpjs_kesehatan_date",
     *     description="BPJS kesehatan date property",
     *     type="string",
     *     format="date-time",
     *     example="2020-01-01 00:00:00"
     * )
     *
     * @var string
     */

    /**
     * @OA\Property(
     *     property="bpjs_kesehatan_class",
     *     description="BPJS kesehatan class property",
     *     type="string",
     *     enum={"I","II","III"},
     *     default=""
     * )
     *
     * @var string
     */

    /**
     * @OA\Property(
     *     property="has_mate_bpjs_kesehatan",
     *     description="Has mate BPJS kesehatan property",
     *     type="boolean"
     * )
     *
     * @var boolean
     */

    /**
     * @OA\Property(
     *     property="mate_bpjs_kesehatan_number",
     *     description="Mate BPJS kesehatan number property",
     *     type="string"
     * )
     *
     * @var string
     */

    /**
     * @OA\Property(
     *     property="mate_bpjs_kesehatan_date",
     *     description="Mate BPJS kesehatan date property",
     *     type="string",
     *     format="date-time",
     *     example="2020-01-01 00:00:00"
     * )
     *
     * @var string
     */

    /**
     * @OA\Property(
     *     property="mate_bpjs_kesehatan_class",
     *     description="Mate BPJS kesehatan class property",
     *     type="string",
     *     enum={"I","II","III"},
     *     default=""
     * )
     *
     * @var string
     */

    /**
     * @OA\Property(
     *     property="dplk_number",
     *     description="DPLK number property",
     *     type="string"
     * )
     *
     * @var string
     */

    /**
     * @OA\Property(
     *     property="collective_number",
     *     description="Collective property",
     *     type="string"
     * )
     *
     * @var string
     */

    /**
     * @OA\Property(
     *     property="english_ability",
     *     description="English ability property",
     *     type="string"
     * )
     *
     * @var string
     */

    /**
     * @OA\Property(
     *     property="computer_ability",
     *     description="Computer ability property",
     *     type="string"
     * )
     *
     * @var string
     */

    /**
     * @OA\Property(
     *     property="other_ability",
     *     description="Other ability property",
     *     type="string"
     * )
     *
     * @var string
     */

    /**
     * @OA\Property(
     *     property="bank_id",
     *     description="Bank id property",
     *     type="integer",
     *     format="int64",
     *     example=1
     * )
     *
     * @var integer
     */

    /**
     * @OA\Property(
     *     property="account_number",
     *     description="Account number property",
     *     type="string"
     * )
     *
     * @var string
     */

    /**
     * @OA\Property(
     *     property="join_date",
     *     description="Join date property",
     *     type="string",
     *     format="date-time",
     *     example="2020-01-01 00:00:00"
     * )
     *
     * @var string
     */

    /**
     * @OA\Property(
     *     property="work_status",
     *     description="Work status property",
     *     type="string",
     *     enum={"FULL_TIME","PART_TIME"},
     *     default=""
     * )
     *
     * @var string
     */

    /**
     * @OA\Property(
     *     property="work_type",
     *     description="Work type property",
     *     type="string",
     *     enum={"PERMANENT","CONTRACT"},
     *     default=""
     * )
     *
     * @var string
     */


    //<editor-fold desc="#field">

    /**
     * Table name.
     *
     * @var string
     */
    protected $table = EmployeeInterface::TABLE_NAME;

    protected $primaryKey = 'id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'company_id',
        'nip',
        'full_name',
        'nick_name',
        'gender_id',
        'religion_id',
        'birth_place',
        'birth_date',
        'address',
        'phone',
        'email',
        'mobile',
        'identity_number',
        'identity_expired_date',
        'identity_address',
        'has_drive_license_a',
        'drive_license_a_number',
        'drive_license_a_date',
        'has_drive_license_b',
        'drive_license_b_number',
        'drive_license_b_date',
        'has_drive_license_c',
        'drive_license_c_number',
        'drive_license_c_date',
        'marital_status_id',
        'mate_as',
        'mate_full_name',
        'mate_nick_name',
        'mate_birth_place',
        'mate_birth_date',
        'mate_occupation',
        'office_id',
        'work_area_id',
        'has_npwp',
        'npwp_number',
        'npwp_date',
        'npwp_status',
        'has_bpjs_tenaga_kerja',
        'bpjs_tenaga_kerja_number',
        'bpjs_tenaga_kerja_date',
        'bpjs_tenaga_kerja_class',
        'has_bpjs_kesehatan',
        'bpjs_kesehatan_number',
        'bpjs_kesehatan_date',
        'bpjs_kesehatan_class',
        'has_mate_bpjs_kesehatan',
        'mate_bpjs_kesehatan_number',
        'mate_bpjs_kesehatan_date',
        'mate_bpjs_kesehatan_class',
        'dplk_number',
        'collective_number',
        'english_ability',
        'computer_ability',
        'other_ability',
        'bank_id',
        'account_number',
        'join_date',
        'work_status',
        'work_type',
        'created_by',
        'modified_by'
    ];

    protected $searchable = [
        'company_id',
        'nik',
        'full_name',
        'nick_name',
        'gender_id',
        'religion_id',
        'birth_place',
        'birth_date',
        'address',
        'phone',
        'email',
        'mobile',
        'identity_number',
        'identity_address',
        'has_drive_license_a',
        'drive_license_a_number',
        'drive_license_a_date',
        'has_drive_license_b',
        'drive_license_b_number',
        'drive_license_b_date',
        'has_drive_license_c',
        'drive_license_c_number',
        'drive_license_c_date',
        'marital_status_id',
        'mate_as',
        'mate_full_name',
        'mate_nick_name',
        'mate_birth_place',
        'mate_birth_date',
        'mate_occupation',
        'office_id',
        'work_area_id',
        'has_npwp',
        'npwp_number',
        'npwp_date',
        'npwp_status',
        'has_bpjs_tenaga_kerja',
        'bpjs_tenaga_kerja_number',
        'bpjs_tenaga_kerja_date',
        'bpjs_tenaga_kerja_class',
        'has_bpjs_kesehatan',
        'bpjs_kesehatan_number',
        'bpjs_kesehatan_date',
        'bpjs_kesehatan_class',
        'has_mate_bpjs_kesehatan',
        'mate_bpjs_kesehatan_number',
        'mate_bpjs_kesehatan_date',
        'mate_bpjs_kesehatan_class',
        'dplk_number',
        'collective_number',
        'english_ability',
        'computer_ability',
        'other_ability',
        'bank_id',
        'account_number',
        'join_date',
        'work_status',
        'created_by',
        'modified_by'
    ];

    protected $orderable = [
        'company_id',
        'nip',
        'full_name',
        'nick_name',
        'gender_id',
        'religion_id',
        'birth_place',
        'birth_date',
        'address',
        'phone',
        'email',
        'mobile',
        'identity_number',
        'identity_address',
        'has_drive_license_a',
        'drive_license_a_number',
        'drive_license_a_date',
        'has_drive_license_b',
        'drive_license_b_number',
        'drive_license_b_date',
        'has_drive_license_c',
        'drive_license_c_number',
        'drive_license_c_date',
        'marital_status_id',
        'mate_as',
        'mate_full_name',
        'mate_nick_name',
        'mate_birth_place',
        'mate_birth_date',
        'mate_occupation',
        'office_id',
        'work_area_id',
        'has_npwp',
        'npwp_number',
        'npwp_date',
        'npwp_status',
        'has_bpjs_tenaga_kerja',
        'bpjs_tenaga_kerja_number',
        'bpjs_tenaga_kerja_date',
        'bpjs_tenaga_kerja_class',
        'has_bpjs_kesehatan',
        'bpjs_kesehatan_number',
        'bpjs_kesehatan_date',
        'bpjs_kesehatan_class',
        'has_mate_bpjs_kesehatan',
        'mate_bpjs_kesehatan_number',
        'mate_bpjs_kesehatan_date',
        'mate_bpjs_kesehatan_class',
        'dplk_number',
        'collective_number',
        'english_ability',
        'computer_ability',
        'other_ability',
        'bank_id',
        'account_number',
        'join_date',
        'work_status',
        'work_type',
        'created_by',
        'modified_by'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [];

    protected $dates = [
        'deleted_at'
    ];

    //If employee deleted these data related would be delete by cascade
    protected $softCascade = ['child', 'formalEducationHistory', 'nonFormalEducationHistory', 'organizationHistory', 'workExperience', 'workAgreementLetter', 'registrationLetter', 'termination', 'otherEquipment', 'positionMutations', 'workUnitMutations', 'projectMutation', 'workCompetence', 'elementEntry'];

    //</editor-fold>


    //<editor-fold desc="#property">

    /**
     * {@inheritdoc}
     */
    public function getCompanyId()
    {
        return $this->company_id;
    }

    /**
     * {@inheritdoc}
     */
    public function setCompanyId($company_id)
    {
        $this->company_id = $company_id;
        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getNip()
    {
        return $this->nip;
    }

    /**
     * {@inheritdoc}
     */
    public function setNip($nip)
    {
        $this->nip = $nip;
        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getFullName()
    {
        return $this->full_name;
    }

    /**
     * {@inheritdoc}
     */
    public function setFullName($full_name)
    {
        $this->full_name = $full_name;
        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getNickName()
    {
        return $this->nick_name;
    }

    /**
     * {@inheritdoc}
     */
    public function setNickName($nick_name)
    {
        $this->nick_name = $nick_name;
        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getGenderId()
    {
        return $this->gender_id;
    }

    /**
     * {@inheritdoc}
     */
    public function setGenderId($gender_id)
    {
        $this->gender_id = $gender_id;
        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getReligionId()
    {
        return $this->religion_id;
    }

    /**
     * {@inheritdoc}
     */
    public function setReligionId($religion_id)
    {
        $this->religion_id = $religion_id;
        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getBirthPlace()
    {
        return $this->birth_place;
    }

    /**
     * {@inheritdoc}
     */
    public function setBirthPlace($birth_place)
    {
        $this->birth_place = $birth_place;
        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getBirthDate()
    {
        return $this->birth_date;
    }

    /**
     * {@inheritdoc}
     */
    public function setBirthDate($birth_date)
    {
        $this->birth_date = $birth_date;
        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getAddress()
    {
        return $this->address;
    }

    /**
     * {@inheritdoc}
     */
    public function setAddress($address)
    {
        $this->address = $address;
        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getPhone()
    {
        return $this->phone;
    }

    /**
     * {@inheritdoc}
     */
    public function setPhone($phone)
    {
        $this->phone = $phone;
        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getMobile()
    {
        return $this->mobile;
    }

    /**
     * {@inheritdoc}
     */
    public function setMobile($mobile)
    {
        $this->mobile = $mobile;
        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * {@inheritdoc}
     */
    public function setEmail($email)
    {
        $this->email = $email;
        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getIdentityNumber()
    {
        return $this->identity_number;
    }

    /**
     * {@inheritdoc}
     */
    public function setIdentityNumber($identity_number)
    {
        $this->identity_number = $identity_number;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getIdentityExpiredDate()
    {
        return $this->identity_expired_date;
    }

    /**
     * @param $identity_expired_date
     * @return $this|mixed
     */
    public function setIdentityExpiredDate($identity_expired_date)
    {
        $this->identity_expired_date = $identity_expired_date;
        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getIdentityAddress()
    {
        return $this->identity_address;
    }

    /**
     * {@inheritdoc}
     */
    public function setIdentityAddress($identity_address)
    {
        $this->identity_address = $identity_address;
        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getHasDriveLicenseA()
    {
        return $this->has_drive_license_a;
    }

    /**
     * {@inheritdoc}
     */
    public function setHasDriveLicenseA($has_drive_license_a)
    {
        $this->has_drive_license_a = $has_drive_license_a;
        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getDriveLicenseANumber()
    {
        return $this->drive_license_a_number;
    }

    /**
     * {@inheritdoc}
     */
    public function setDriveLicenseANumber($drive_license_a_number)
    {
        $this->drive_license_a_number = $drive_license_a_number;
        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getDriveLicenseADate()
    {
        return $this->drive_license_a_date;
    }

    /**
     * {@inheritdoc}
     */
    public function setDriveLicenseADate($drive_license_a_date)
    {
        $this->drive_license_a_date = $drive_license_a_date;
        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getHasDriveLicenseB()
    {
        return $this->has_drive_license_b;
    }

    /**
     * {@inheritdoc}
     */
    public function setHasDriveLicenseB($has_drive_license_b)
    {
        $this->has_drive_license_b = $has_drive_license_b;
        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getDriveLicenseBNumber()
    {
        return $this->drive_license_b_number;
    }

    /**
     * {@inheritdoc}
     */
    public function setDriveLicenseBNumber($drive_license_b_number)
    {
        $this->drive_license_b_number = $drive_license_b_number;
        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getDriveLicenseBDate()
    {
        return $this->drive_license_b_date;
    }

    /**
     * {@inheritdoc}
     */
    public function setDriveLicenseBDate($drive_license_b_date)
    {
        $this->drive_license_b_date = $drive_license_b_date;
        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getHasDriveLicenseC()
    {
        return $this->has_drive_license_c;
    }

    /**
     * {@inheritdoc}
     */
    public function setHasDriveLicenseC($has_drive_license_c)
    {
        $this->has_drive_license_c = $has_drive_license_c;
        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getDriveLicenseCNumber()
    {
        return $this->drive_license_c_number;
    }

    /**
     * {@inheritdoc}
     */
    public function setDriveLicenseCNumber($drive_license_c_number)
    {
        $this->drive_license_c_number = $drive_license_c_number;
        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getDriveLicenseCDate()
    {
        return $this->drive_license_c_date;
    }

    /**
     * {@inheritdoc}
     */
    public function setDriveLicenseCDate($drive_license_c_date)
    {
        $this->drive_license_c_date = $drive_license_c_date;
        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getMaritalStatusId()
    {
        return $this->marital_status_id;
    }

    /**
     * {@inheritdoc}
     */
    public function setMaritalStatusId($marital_status_id)
    {
        $this->marital_status_id = $marital_status_id;
        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getMateAs()
    {
        return $this->mate_as;
    }

    /**
     * {@inheritdoc}
     */
    public function setMateAs($mate_as)
    {
        $this->mate_as = $mate_as;
        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getMateFullName()
    {
        return $this->mate_full_name;
    }

    /**
     * {@inheritdoc}
     */
    public function setMateFullName($mate_full_name)
    {
        $this->mate_full_name = $mate_full_name;
        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getMateNickName()
    {
        return $this->mate_nick_name;
    }

    /**
     * {@inheritdoc}
     */
    public function setMateNickName($mate_nick_name)
    {
        $this->mate_nick_name = $mate_nick_name;
        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getMateBirthPlace()
    {
        return $this->mate_birth_place;
    }

    /**
     * {@inheritdoc}
     */
    public function setMateBirthPlace($mate_birth_place)
    {
        $this->mate_birth_place = $mate_birth_place;
        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getMateBirthDate()
    {
        return $this->mate_birth_date;
    }

    /**
     * {@inheritdoc}
     */
    public function setMateBirthDate($mate_birth_date)
    {
        $this->mate_birth_date = $mate_birth_date;
        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getMateOccupation()
    {
        return $this->mate_occupation;
    }

    /**
     * {@inheritdoc}
     */
    public function setMateOccupation($mate_occupation)
    {
        $this->mate_occupation = $mate_occupation;
        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getOfficeId()
    {
        return $this->office_id;
    }

    /**
     * {@inheritdoc}
     */
    public function setOfficeId($office_id)
    {
        $this->office_id = $office_id;
        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getWorkAreaId()
    {
        return $this->work_area_id;
    }

    /**
     * {@inheritdoc}
     */
    public function setWorkAreaId($work_area_id)
    {
        $this->work_area_id = $work_area_id;
        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getHasNpwp()
    {
        return $this->has_npwp;
    }

    /**
     * {@inheritdoc}
     */
    public function setHasNpwp($has_npwp)
    {
        $this->has_npwp = $has_npwp;
        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getNpwpNumber()
    {
        return $this->npwp_number;
    }

    /**
     * {@inheritdoc}
     */
    public function setNpwpNumber($npwp_number)
    {
        $this->npwp_number = $npwp_number;
        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getNpwpDate()
    {
        return $this->npwp_date;
    }

    /**
     * {@inheritdoc}
     */
    public function setNpwpDate($npwp_date)
    {
        $this->npwp_date = $npwp_date;
        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getNpwpStatus()
    {
        return $this->npwp_status;
    }

    /**
     * {@inheritdoc}
     */
    public function setNpwpStatus($npwp_status)
    {
        $this->npwp_status = $npwp_status;
        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getHasBpjsTenagaKerja()
    {
        return $this->has_bpjs_tenaga_kerja;
    }

    /**
     * {@inheritdoc}
     */
    public function setHasBpjsTenagaKerja($has_bpjs_tenaga_kerja)
    {
        $this->has_bpjs_tenaga_kerja = $has_bpjs_tenaga_kerja;
        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getBpjsTenagaKerjaNumber()
    {
        return $this->bpjs_tenaga_kerja_number;
    }

    /**
     * {@inheritdoc}
     */
    public function setBpjsTenagaKerjaNumber($bpjs_tenaga_kerja_number)
    {
        $this->bpjs_tenaga_kerja_number = $bpjs_tenaga_kerja_number;
        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getBpjsTenagaKerjaDate()
    {
        return $this->bpjs_tenaga_kerja_date;
    }

    /**
     * {@inheritdoc}
     */
    public function setBpjsTenagaKerjaDate($bpjs_tenaga_kerja_date)
    {
        $this->bpjs_tenaga_kerja_date = $bpjs_tenaga_kerja_date;
        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getBpjsTenagaKerjaClass()
    {
        return $this->bpjs_tenaga_kerja_class;
    }

    /**
     * {@inheritdoc}
     */
    public function setBpjsTenagaKerjaClass($bpjs_tenaga_kerja_class)
    {
        $this->bpjs_tenaga_kerja_class = $bpjs_tenaga_kerja_class;
        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getHasBpjsKesehatan()
    {
        return $this->has_bpjs_kesehatan;
    }

    /**
     * {@inheritdoc}
     */
    public function setHasBpjsKesehatan($has_bpjs_kesehatan)
    {
        $this->has_bpjs_kesehatan = $has_bpjs_kesehatan;
        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getBpjsKesehatanNumber()
    {
        return $this->bpjs_kesehatan_number;
    }

    /**
     * {@inheritdoc}
     */
    public function setBpjsKesehatanNumber($bpjs_kesehatan_number)
    {
        $this->bpjs_kesehatan_number = $bpjs_kesehatan_number;
        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getBpjsKesehatanDate()
    {
        return $this->bpjs_kesehatan_date;
    }

    /**
     * {@inheritdoc}
     */
    public function setBpjsKesehatanDate($bpjs_kesehatan_date)
    {
        $this->bpjs_kesehatan_date = $bpjs_kesehatan_date;
        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getBpjsKesehatanClass()
    {
        return $this->bpjs_kesehatan_class;
    }

    /**
     * {@inheritdoc}
     */
    public function setBpjsKesehatanClass($bpjs_kesehatan_class)
    {
        $this->bpjs_kesehatan_class = $bpjs_kesehatan_class;
        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getHasMateBpjsKesehatan()
    {
        return $this->has_mate_bpjs_kesehatan;
    }

    /**
     * {@inheritdoc}
     */
    public function setHasMateBpjsKesehatan($has_mate_bpjs_kesehatan)
    {
        $this->has_mate_bpjs_kesehatan = $has_mate_bpjs_kesehatan;
        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getMateBpjsKesehatanNumber()
    {
        return $this->mate_bpjs_kesehatan_number;
    }

    /**
     * {@inheritdoc}
     */
    public function setMateBpjsKesehatanNumber($mate_bpjs_kesehatan_number)
    {
        $this->mate_bpjs_kesehatan_number = $mate_bpjs_kesehatan_number;
        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getMateBpjsKesehatanDate()
    {
        return $this->mate_bpjs_kesehatan_date;
    }

    /**
     * {@inheritdoc}
     */
    public function setMateBpjsKesehatanDate($mate_bpjs_kesehatan_date)
    {
        $this->mate_bpjs_kesehatan_date = $mate_bpjs_kesehatan_date;
        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getMateBpjsKesehatanClass()
    {
        return $this->mate_bpjs_kesehatan_class;
    }

    /**
     * {@inheritdoc}
     */
    public function setMateBpjsKesehatanClass($mate_bpjs_kesehatan_class)
    {
        $this->mate_bpjs_kesehatan_class = $mate_bpjs_kesehatan_class;
        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getDplkNumber()
    {
        return $this->dplk_number;
    }

    /**
     * {@inheritdoc}
     */
    public function setDplkNumber($dplk_number)
    {
        $this->dplk_number = $dplk_number;
        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getCollectiveNumber()
    {
        return $this->collective_number;
    }

    /**
     * {@inheritdoc}
     */
    public function setCollectiveNumber($collective_number)
    {
        $this->collective_number = $collective_number;
        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getEnglishAbility()
    {
        return $this->english_ability;
    }

    /**
     * {@inheritdoc}
     */
    public function setEnglishAbility($english_ability)
    {
        $this->english_ability = $english_ability;
        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getComputerAbility()
    {
        return $this->computer_ability;
    }

    /**
     * {@inheritdoc}
     */
    public function setComputerAbility($computer_ability)
    {
        $this->computer_ability = $computer_ability;
        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getOtherAbility()
    {
        return $this->other_ability;
    }

    /**
     * {@inheritdoc}
     */
    public function setOtherAbility($other_ability)
    {
        $this->other_ability = $other_ability;
        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getBankId()
    {
        return $this->bank_id;
    }

    /**
     * {@inheritdoc}
     */
    public function setBankId($bank_id)
    {
        $this->bank_id = $bank_id;
        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getAccountNumber()
    {
        return $this->account_number;
    }

    /**
     * {@inheritdoc}
     */
    public function setAccountNumber($account_number)
    {
        $this->account_number = $account_number;
        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getJoinDate()
    {
        return $this->join_date;
    }

    /**
     * {@inheritdoc}
     */
    public function setJoinDate($join_date)
    {
        $this->join_date = $join_date;
        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getWorkStatus()
    {
        return $this->work_status;
    }

    /**
     * {@inheritdoc}
     */
    public function setWorkStatus($work_status)
    {
        $this->work_status = $work_status;
        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getWorkType()
    {
        return $this->work_type;
    }

    /**
     * {@inheritdoc}
     */
    public function setWorkType($work_type)
    {
        $this->work_type = $work_type;
        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getCreatedBy()
    {
        return $this->created_by;
    }

    /**
     * {@inheritdoc}
     */
    public function setCreatedBy($created_by)
    {
        $this->created_by = $created_by;
        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getModifiedBy()
    {
        return $this->modified_by;
    }

    /**
     * {@inheritdoc}
     */
    public function setModifiedBy($modified_by)
    {
        $this->modified_by = $modified_by;
        return $this;
    }


    //</editor-fold


    //<editor-fold desc="#public (method)">


    //<editor-fold desc="#belongs to relation">

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo|mixed
     */
    public function company()
    {
        return $this->belongsTo(CompanyEloquent::class, 'company_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo|mixed
     */
    public function gender()
    {
        return $this->belongsTo(GenderEloquent::class, 'gender_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo|mixed
     */
    public function religion()
    {
        return $this->belongsTo(ReligionEloquent::class, 'religion_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo|mixed
     */
    public function maritalStatus()
    {
        return $this->belongsTo(MaritalStatusEloquent::class, 'marital_status_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function Office()
    {
        return $this->belongsTo(OfficeEloquent::class, 'office_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo|mixed
     */
    public function workArea()
    {
        return $this->belongsTo(WorkAreaEloquent::class, 'work_area_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo|mixed
     */
    public function bank()
    {
        return $this->belongsTo(BankEloquent::class, 'bank_id');
    }

    //</editor-fold>


    //<editor-fold desc="#has many relation">

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany|mixed
     */
    public function projectMutations()
    {
        return $this->hasMany(ProjectMutationEloquent::class, 'employee_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany|mixed
     */
    public function workUnitMutations()
    {
        return $this->hasMany(WorkUnitMutationEloquent::class, 'employee_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany|mixed
     */
    public function positionMutations()
    {
        return $this->hasMany(PositionMutationEloquent::class, 'employee_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany|mixed
     */
    public function workCompetences()
    {
        return $this->hasMany(WorkCompetenceEloquent::class, 'employee_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany|mixed
     */
    public function formalEducationHistories()
    {
        return $this->hasMany(FormalEducationHistoryEloquent::class, 'employee_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany|mixed
     */
    public function nonFormalEducationHistories()
    {
        return $this->hasMany(NonFormalEducationHistoryEloquent::class, 'employee_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function organizationHistories()
    {
        return $this->hasMany(OrganizationHistoryEloquent::class, 'employee_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany|mixed
     */
    public function workExperiences()
    {
        return $this->hasMany(WorkExperienceEloquent::class, 'employee_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany|mixed
     */
    public function workAgreementLetters()
    {
        return $this->hasMany(WorkAgreementLetterEloquent::class, 'employee_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function registrationLetters()
    {
        return $this->hasMany(RegistrationLetterEloquent::class, 'employee_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany|mixed
     */
    public function terminations()
    {
        return $this->hasMany(TerminationEloquent::class, 'employee_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany|mixed
     */
    public function otherEquipments()
    {
        return $this->hasMany(OtherEquipmentEloquent::class, 'employee_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function childs()
    {
        return $this->hasMany(ChildEloquent::class, 'employee_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany|mixed
     */
    public function elementEntries()
    {
        return $this->hasMany(ElementEntryEloquent::class, 'employee_id');
    }

    //</editor-fold>


    //<editor-fold desc="#polimorphism many to many relation">

    public function morphMediaLibraries()
    {
        return $this->morphToMany(MediaLibraryEloquent::class,
            'media_libraryable',
            'media_libraryables',
            'media_libraryable_id',
            'media_library_id');
    }

    //</editor-fold>


    //</editor-fold>
}

/**
 * @OA\Schema(
 *     schema="CreateEmployeeEloquent",
 *     description="Create employee eloquent",
 *     title="Create employee eloquent",
 *     required={"company_id", "nip", "full_name", "nick_name", "gender_id", "religion_id", "birth_place", "birth_date",
 *     "address", "phone", "mobile", "email", "identity_number", "identity_expired_date", "identity_address", "marital_status_id",
 *     "office_id", "work_area_id", "has_npwp", "npwp_number", "npwp_date", "npwp_status", "has_bpjs_tenaga_kerja",
 *     "bpjs_tenaga_kerja_number", "bpjs_tenaga_kerja_date", "bpjs_tenaga_kerja_class", "has_bpjs_kesehatan", "bpjs_kesehatan_number",
 *     "bpjs_kesehatan_date", "bpjs_kesehatan_class", "dplk_number", "collective_number", "english_ability",
 *     "computer_ability", "other_ability", "bank_id", "account_number", "join_date", "work_status", "work_type"},
 *     @OA\Property(property="company_id", ref="#/components/schemas/EmployeeEloquent/properties/company_id"),
 *     @OA\Property(property="nip", ref="#/components/schemas/EmployeeEloquent/properties/nip"),
 *     @OA\Property(property="full_name", ref="#/components/schemas/EmployeeEloquent/properties/full_name"),
 *     @OA\Property(property="nick_name", ref="#/components/schemas/EmployeeEloquent/properties/nick_name"),
 *     @OA\Property(property="gender_id", ref="#/components/schemas/EmployeeEloquent/properties/gender_id"),
 *     @OA\Property(property="religion_id", ref="#/components/schemas/EmployeeEloquent/properties/religion_id"),
 *     @OA\Property(property="birth_place", ref="#/components/schemas/EmployeeEloquent/properties/birth_place"),
 *     @OA\Property(property="birth_date", ref="#/components/schemas/EmployeeEloquent/properties/birth_date"),
 *     @OA\Property(property="address", ref="#/components/schemas/EmployeeEloquent/properties/address"),
 *     @OA\Property(property="phone", ref="#/components/schemas/EmployeeEloquent/properties/phone"),
 *     @OA\Property(property="mobile", ref="#/components/schemas/EmployeeEloquent/properties/mobile"),
 *     @OA\Property(property="email", ref="#/components/schemas/EmployeeEloquent/properties/email"),
 *     @OA\Property(property="identity_number", ref="#/components/schemas/EmployeeEloquent/properties/identity_number"),
 *     @OA\Property(property="identity_expired_date", ref="#/components/schemas/EmployeeEloquent/properties/identity_expired_date"),
 *     @OA\Property(property="identity_address", ref="#/components/schemas/EmployeeEloquent/properties/identity_address"),
 *     @OA\Property(property="has_drive_license_a", ref="#/components/schemas/EmployeeEloquent/properties/has_drive_license_a"),
 *     @OA\Property(property="drive_license_a_number", ref="#/components/schemas/EmployeeEloquent/properties/drive_license_a_number"),
 *     @OA\Property(property="drive_license_a_date", ref="#/components/schemas/EmployeeEloquent/properties/drive_license_a_date"),
 *     @OA\Property(property="has_drive_license_b", ref="#/components/schemas/EmployeeEloquent/properties/has_drive_license_b"),
 *     @OA\Property(property="drive_license_b_number", ref="#/components/schemas/EmployeeEloquent/properties/drive_license_b_number"),
 *     @OA\Property(property="drive_license_b_date", ref="#/components/schemas/EmployeeEloquent/properties/drive_license_b_date"),
 *     @OA\Property(property="has_drive_license_c", ref="#/components/schemas/EmployeeEloquent/properties/has_drive_license_c"),
 *     @OA\Property(property="drive_license_c_number", ref="#/components/schemas/EmployeeEloquent/properties/drive_license_c_number"),
 *     @OA\Property(property="drive_license_c_date", ref="#/components/schemas/EmployeeEloquent/properties/drive_license_c_date"),
 *     @OA\Property(property="marital_status_id", ref="#/components/schemas/EmployeeEloquent/properties/marital_status_id"),
 *     @OA\Property(property="mate_as", ref="#/components/schemas/EmployeeEloquent/properties/mate_as"),
 *     @OA\Property(property="mate_full_name", ref="#/components/schemas/EmployeeEloquent/properties/mate_full_name"),
 *     @OA\Property(property="mate_nick_name", ref="#/components/schemas/EmployeeEloquent/properties/mate_nick_name"),
 *     @OA\Property(property="mate_birth_place", ref="#/components/schemas/EmployeeEloquent/properties/mate_birth_place"),
 *     @OA\Property(property="mate_birth_date", ref="#/components/schemas/EmployeeEloquent/properties/mate_birth_date"),
 *     @OA\Property(property="mate_occupation", ref="#/components/schemas/EmployeeEloquent/properties/mate_occupation"),
 *     @OA\Property(property="office_id", ref="#/components/schemas/EmployeeEloquent/properties/office_id"),
 *     @OA\Property(property="work_area_id", ref="#/components/schemas/EmployeeEloquent/properties/work_area_id"),
 *     @OA\Property(property="has_npwp", ref="#/components/schemas/EmployeeEloquent/properties/has_npwp"),
 *     @OA\Property(property="npwp_number", ref="#/components/schemas/EmployeeEloquent/properties/npwp_number"),
 *     @OA\Property(property="npwp_date", ref="#/components/schemas/EmployeeEloquent/properties/npwp_date"),
 *     @OA\Property(property="npwp_status", ref="#/components/schemas/EmployeeEloquent/properties/npwp_status"),
 *     @OA\Property(property="has_bpjs_tenaga_kerja", ref="#/components/schemas/EmployeeEloquent/properties/has_bpjs_tenaga_kerja"),
 *     @OA\Property(property="bpjs_tenaga_kerja_number", ref="#/components/schemas/EmployeeEloquent/properties/bpjs_tenaga_kerja_number"),
 *     @OA\Property(property="bpjs_tenaga_kerja_date", ref="#/components/schemas/EmployeeEloquent/properties/bpjs_tenaga_kerja_date"),
 *     @OA\Property(property="bpjs_tenaga_kerja_class", ref="#/components/schemas/EmployeeEloquent/properties/bpjs_tenaga_kerja_class"),
 *     @OA\Property(property="has_bpjs_kesehatan", ref="#/components/schemas/EmployeeEloquent/properties/has_bpjs_kesehatan"),
 *     @OA\Property(property="bpjs_kesehatan_number", ref="#/components/schemas/EmployeeEloquent/properties/bpjs_kesehatan_number"),
 *     @OA\Property(property="bpjs_kesehatan_date", ref="#/components/schemas/EmployeeEloquent/properties/bpjs_kesehatan_date"),
 *     @OA\Property(property="bpjs_kesehatan_class", ref="#/components/schemas/EmployeeEloquent/properties/bpjs_kesehatan_class"),
 *     @OA\Property(property="has_mate_bpjs_kesehatan", ref="#/components/schemas/EmployeeEloquent/properties/has_mate_bpjs_kesehatan"),
 *     @OA\Property(property="mate_bpjs_kesehatan_number", ref="#/components/schemas/EmployeeEloquent/properties/mate_bpjs_kesehatan_number"),
 *     @OA\Property(property="mate_bpjs_kesehatan_date", ref="#/components/schemas/EmployeeEloquent/properties/mate_bpjs_kesehatan_date"),
 *     @OA\Property(property="mate_bpjs_kesehatan_class", ref="#/components/schemas/EmployeeEloquent/properties/mate_bpjs_kesehatan_class"),
 *     @OA\Property(property="dplk_number", ref="#/components/schemas/EmployeeEloquent/properties/dplk_number"),
 *     @OA\Property(property="collective_number", ref="#/components/schemas/EmployeeEloquent/properties/collective_number"),
 *     @OA\Property(property="english_ability", ref="#/components/schemas/EmployeeEloquent/properties/english_ability"),
 *     @OA\Property(property="computer_ability", ref="#/components/schemas/EmployeeEloquent/properties/computer_ability"),
 *     @OA\Property(property="other_ability", ref="#/components/schemas/EmployeeEloquent/properties/other_ability"),
 *     @OA\Property(property="bank_id", ref="#/components/schemas/EmployeeEloquent/properties/bank_id"),
 *     @OA\Property(property="account_number", ref="#/components/schemas/EmployeeEloquent/properties/account_number"),
 *     @OA\Property(property="join_date", ref="#/components/schemas/EmployeeEloquent/properties/join_date"),
 *     @OA\Property(property="work_status", ref="#/components/schemas/EmployeeEloquent/properties/work_status"),
 *     @OA\Property(property="work_type", ref="#/components/schemas/EmployeeEloquent/properties/work_type"),
 * )
 */

/**
 * @OA\Schema(
 *     schema="UpdateEmployeeEloquent",
 *     description="Update employee eloquent",
 *     title="Update employee eloquent",
 *     required={"id", "company_id", "nip", "full_name", "nick_name", "gender_id", "religion_id", "birth_place", "birth_date",
 *     "address", "phone", "mobile", "email", "identity_number", "identity_expired_date", "identity_address", "marital_status_id",
 *     "office_id", "work_area_id", "has_npwp", "npwp_number", "npwp_date", "npwp_status", "has_bpjs_tenaga_kerja",
 *     "bpjs_tenaga_kerja_number", "bpjs_tenaga_kerja_date", "bpjs_tenaga_kerja_class", "has_bpjs_kesehatan", "bpjs_kesehatan_number",
 *     "bpjs_kesehatan_date", "bpjs_kesehatan_class", "dplk_number", "collective_number", "english_ability",
 *     "computer_ability", "other_ability", "bank_id", "account_number", "join_date", "work_status", "work_type"},
 *     allOf={
 *          @OA\Schema(
 *              @OA\Property(
 *                   property="id",
 *                   type="integer",
 *                   format="int64",
 *                   description="Id property",
 *                   example=1
 *              )
 *          ),
 *          @OA\Schema(ref="#/components/schemas/CreateEmployeeEloquent")
 *     }
 * )
 */



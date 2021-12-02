<?php
namespace App\Http\Controllers\API\v1\HumanResources\Personal\Employee;


use App\Core\Services\Response\BooleanResponse;
use App\Core\Services\Response\ObjectResponse;
use App\Domains\Commons\Bank\Contracts\BankInterface;
use App\Domains\Commons\Company\Contracts\CompanyInterface;
use App\Domains\HumanResources\Personal\Employee\Child\Contracts\ChildServiceInterface;
use App\Domains\HumanResources\Personal\Employee\Contracts\EmployeeServiceInterface;
use App\Domains\Commons\Gender\Contracts\GenderInterface;
use App\Domains\Commons\MaritalStatus\Contracts\MaritalStatusInterface;
use App\Domains\Commons\Office\Contracts\OfficeInterface;
use App\Domains\Commons\Religion\Contracts\ReligionInterface;
use App\Domains\HumanResources\MasterData\WorkArea\Contracts\WorkAreaInterface;
use App\Domains\HumanResources\Personal\Employee\Contracts\Request\CreateEmployeeRequest;
use App\Domains\HumanResources\Personal\Employee\Contracts\Request\EditEmployeeRequest;
use App\Domains\HumanResources\Personal\Employee\FormalEducationHistory\Contracts\FormalEducationHistoryServiceInterface;
use App\Domains\HumanResources\Personal\Employee\NonFormalEducationHistory\Contracts\NonFormalEducationHistoryServiceInterface;
use App\Domains\HumanResources\Personal\Employee\OrganizationHistory\Contracts\OrganizationHistoryServiceInterface;
use App\Domains\HumanResources\Personal\Employee\WorkCompetence\Contracts\WorkCompetenceServiceInterface;
use App\Domains\HumanResources\Personal\Employee\WorkExperience\Contracts\WorkExperienceServiceInterface;
use App\Exports\HumanResources\Personal\EmployeeExport;
use App\Helpers\Common;
use App\Helpers\DateTimeRange;
use App\Http\Controllers\BaseController;
use App\Infrastructures\HumanResources\Personal\Employee\OtherEquipment\Contracts\OtherEquipmentServiceInterface;
use DateTime;
use Exception;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Facades\Excel;
use Barryvdh\DomPDF\Facade as PDF;

class EmployeeController extends Controller
{
    use BaseController;


    //<editor-fold desc="#field">

    private $_employeeServiceInterface;
    private $_childServiceInterface;
    private $_formalEducationHistoryServiceInterface;
    private $_nonFormalEducationHistoryServiceInterface;
    private $_organizationHistoryServiceInterface;
    private $_otherEquipmentServiceInterface;
    private $_workCompetenceServiceInterface;
    private $_workExperienceServiceInterface;

    //</editor-fold>


    //<editor-fold desc="#constructor">

    /**
     * EmployeeController constructor.
     * @param EmployeeServiceInterface $employeeServiceInterface
     * @param ChildServiceInterface $childServiceInterface
     * @param FormalEducationHistoryServiceInterface $formalEducationHistoryServiceInterface
     * @param NonFormalEducationHistoryServiceInterface $nonFormalEducationHistoryServiceInterface
     * @param OrganizationHistoryServiceInterface $organizationHistoryServiceInterface
     * @param OtherEquipmentServiceInterface $otherEquipmentServiceInterface
     * @param WorkCompetenceServiceInterface $workCompetenceServiceInterface
     * @param WorkExperienceServiceInterface $workExperienceServiceInterface
     */
    public function __construct(EmployeeServiceInterface $employeeServiceInterface,
                                ChildServiceInterface $childServiceInterface,
                                FormalEducationHistoryServiceInterface $formalEducationHistoryServiceInterface,
                                NonFormalEducationHistoryServiceInterface $nonFormalEducationHistoryServiceInterface,
                                OrganizationHistoryServiceInterface $organizationHistoryServiceInterface,
                                OtherEquipmentServiceInterface $otherEquipmentServiceInterface,
                                WorkCompetenceServiceInterface $workCompetenceServiceInterface,
                                WorkExperienceServiceInterface $workExperienceServiceInterface)
    {
        $this->_employeeServiceInterface = $employeeServiceInterface;
        $this->_childServiceInterface = $childServiceInterface;
        $this->_formalEducationHistoryServiceInterface = $formalEducationHistoryServiceInterface;
        $this->_nonFormalEducationHistoryServiceInterface = $nonFormalEducationHistoryServiceInterface;
        $this->_organizationHistoryServiceInterface = $organizationHistoryServiceInterface;
        $this->_otherEquipmentServiceInterface = $otherEquipmentServiceInterface;
        $this->_workCompetenceServiceInterface = $workCompetenceServiceInterface;
        $this->_workExperienceServiceInterface = $workExperienceServiceInterface;
    }

    //</editor-fold>


    //<editor-fold desc="#public (method)">

    /**
     * @OA\Get(
     *     path="/employee/list",
     *     operationId="getEmployeeList",
     *     summary="Get list of employee",
     *     tags={"Employee"},
     *     description="Get list of employee",
     *     security={
     *          {
     *              "apiKey": {"*"}
     *          }
     *     },
     *     @OA\Parameter(
     *          name="company_id",
     *          in="query",
     *          description="Company id parameter",
     *          required=false,
     *          @OA\Schema(
     *              type="integer",
     *              format="int64",
     *              example=1
     *          )
     *     ),
     *     @OA\Parameter(
     *          name="gender_id",
     *          in="query",
     *          description="Gender id parameter",
     *          required=false,
     *          @OA\Schema(
     *              type="integer",
     *              format="int64",
     *              example=1
     *          )
     *     ),
     *     @OA\Parameter(
     *          name="religion_id",
     *          in="query",
     *          description="Religion id parameter",
     *          required=false,
     *          @OA\Schema(
     *              type="integer",
     *              format="int64",
     *              example=1
     *          )
     *     ),
     *     @OA\Parameter(
     *          name="start_birth_date",
     *          in="query",
     *          description="Start birth date parameter",
     *          required=false,
     *          @OA\Schema(
     *              type="string",
     *              format="date-time",
     *              example="2020-01-01 00:00:00"
     *          )
     *     ),
     *     @OA\Parameter(
     *          name="end_birth_date",
     *          in="query",
     *          description="End birth date parameter",
     *          required=false,
     *          @OA\Schema(
     *              type="string",
     *              format="date-time",
     *              example="2020-01-01 00:00:00"
     *          )
     *     ),
     *     @OA\Parameter(
     *          name="start_identity_expired_date",
     *          in="query",
     *          description="Start identity expired date parameter",
     *          required=false,
     *          @OA\Schema(
     *              type="string",
     *              format="date-time",
     *              example="2020-01-01 00:00:00"
     *          )
     *     ),
     *     @OA\Parameter(
     *          name="end_identity_expired_date",
     *          in="query",
     *          description="End identity expired date parameter",
     *          required=false,
     *          @OA\Schema(
     *              type="string",
     *              format="date-time",
     *              example="2020-01-01 00:00:00"
     *          )
     *     ),
     *     @OA\Parameter(
     *          name="start_drive_license_a_date",
     *          in="query",
     *          description="Start drive license a date parameter",
     *          required=false,
     *          @OA\Schema(
     *              type="string",
     *              format="date-time",
     *              example="2020-01-01 00:00:00"
     *          )
     *     ),
     *     @OA\Parameter(
     *          name="end_drive_license_a_date",
     *          in="query",
     *          description="End drive license a date parameter",
     *          required=false,
     *          @OA\Schema(
     *              type="string",
     *              format="date-time",
     *              example="2020-01-01 00:00:00"
     *          )
     *     ),
     *     @OA\Parameter(
     *          name="start_drive_license_b_date",
     *          in="query",
     *          description="Start drive license b date parameter",
     *          required=false,
     *          @OA\Schema(
     *              type="string",
     *              format="date-time",
     *              example="2020-01-01 00:00:00"
     *          )
     *     ),
     *     @OA\Parameter(
     *          name="end_drive_license_b_date",
     *          in="query",
     *          description="End drive license b date parameter",
     *          required=false,
     *          @OA\Schema(
     *              type="string",
     *              format="date-time",
     *              example="2020-01-01 00:00:00"
     *          )
     *     ),
     *     @OA\Parameter(
     *          name="start_drive_license_c_date",
     *          in="query",
     *          description="Start drive license c date parameter",
     *          required=false,
     *          @OA\Schema(
     *              type="string",
     *              format="date-time",
     *              example="2020-01-01 00:00:00"
     *          )
     *     ),
     *     @OA\Parameter(
     *          name="end_drive_license_c_date",
     *          in="query",
     *          description="End drive license c date parameter",
     *          required=false,
     *          @OA\Schema(
     *              type="string",
     *              format="date-time",
     *              example="2020-01-01 00:00:00"
     *          )
     *     ),
     *     @OA\Parameter(
     *          name="marital_status_id",
     *          in="query",
     *          description="Marital status id parameter",
     *          required=false,
     *          @OA\Schema(
     *              type="integer",
     *              format="int64",
     *              example=1
     *          )
     *     ),
     *     @OA\Parameter(
     *          name="mate_as",
     *          in="query",
     *          description="Mate as parameter",
     *          required=false,
     *          @OA\Schema(
     *              type="string",
     *              enum={"HUSBAND","WIFE"},
     *              default=""
     *          )
     *     ),
     *     @OA\Parameter(
     *          name="start_mate_birth_date",
     *          in="query",
     *          description="Start mate birth date parameter",
     *          required=false,
     *          @OA\Schema(
     *              type="string",
     *              format="date-time",
     *              example="2020-01-01 00:00:00"
     *          )
     *     ),
     *     @OA\Parameter(
     *          name="end_mate_birth_date",
     *          in="query",
     *          description="End mate birth date parameter",
     *          required=false,
     *          @OA\Schema(
     *              type="string",
     *              format="date-time",
     *              example="2020-01-01 00:00:00"
     *          )
     *     ),
     *     @OA\Parameter(
     *          name="office_id",
     *          in="query",
     *          description="Office id parameter",
     *          required=false,
     *          @OA\Schema(
     *              type="integer",
     *              format="int64",
     *              example=1
     *          )
     *     ),
     *     @OA\Parameter(
     *          name="work_area_id",
     *          in="query",
     *          description="Work area id parameter",
     *          required=false,
     *          @OA\Schema(
     *              type="integer",
     *              format="int64",
     *              example=1
     *          )
     *     ),
     *     @OA\Parameter(
     *          name="start_npwp_date",
     *          in="query",
     *          description="Start npwp date parameter",
     *          required=false,
     *          @OA\Schema(
     *              type="string",
     *              format="date-time",
     *              example="2020-01-01 00:00:00"
     *          )
     *     ),
     *     @OA\Parameter(
     *          name="end_npwp_date",
     *          in="query",
     *          description="End npwp date parameter",
     *          required=false,
     *          @OA\Schema(
     *              type="string",
     *              format="date-time",
     *              example="2020-01-01 00:00:00"
     *          )
     *     ),
     *     @OA\Parameter(
     *          name="npwp_status",
     *          in="query",
     *          description="NPWP status parameter",
     *          required=false,
     *          @OA\Schema(
     *              type="string",
     *              enum={"TK/0","TK/1","TK/2","TK/3","K/0","K/1","K/2","K/3","KI/0","KI/1","KI/2","KI/3"},
     *              default=""
     *          )
     *     ),
     *     @OA\Parameter(
     *          name="start_bpjs_tenaga_kerja_date",
     *          in="query",
     *          description="Start bpjs tenaga kerja date parameter",
     *          required=false,
     *          @OA\Schema(
     *              type="string",
     *              format="date-time",
     *              example="2020-01-01 00:00:00"
     *          )
     *     ),
     *     @OA\Parameter(
     *          name="end_bpjs_tenaga_kerja_date",
     *          in="query",
     *          description="End bpjs tenaga kerja date parameter",
     *          required=false,
     *          @OA\Schema(
     *              type="string",
     *              format="date-time",
     *              example="2020-01-01 00:00:00"
     *          )
     *     ),
     *     @OA\Parameter(
     *          name="bpjs_tenaga_kerja_class",
     *          in="query",
     *          description="BPJS tenaga kerja class parameter",
     *          required=false,
     *          @OA\Schema(
     *              type="string",
     *              enum={"I","II","III"},
     *              default=""
     *          )
     *     ),
     *     @OA\Parameter(
     *          name="start_bpjs_kesehatan_date",
     *          in="query",
     *          description="Start bpjs kesehatan date parameter",
     *          required=false,
     *          @OA\Schema(
     *              type="string",
     *              format="date-time",
     *              example="2020-01-01 00:00:00"
     *          )
     *     ),
     *     @OA\Parameter(
     *          name="end_bpjs_kesehatan_date",
     *          in="query",
     *          description="End bpjs kesehatan date parameter",
     *          required=false,
     *          @OA\Schema(
     *              type="string",
     *              format="date-time",
     *              example="2020-01-01 00:00:00"
     *          )
     *     ),
     *     @OA\Parameter(
     *          name="bpjs_kesehatan_class",
     *          in="query",
     *          description="BPJS kesehatan class parameter",
     *          required=false,
     *          @OA\Schema(
     *              type="string",
     *              enum={"I","II","III"},
     *              default=""
     *          )
     *     ),
     *     @OA\Parameter(
     *          name="start_mate_bpjs_kesehatan_date",
     *          in="query",
     *          description="Start mate bpjs kesehatan date parameter",
     *          required=false,
     *          @OA\Schema(
     *              type="string",
     *              format="date-time",
     *              example="2020-01-01 00:00:00"
     *          )
     *     ),
     *     @OA\Parameter(
     *          name="end_mate_bpjs_kesehatan_date",
     *          in="query",
     *          description="End mate bpjs kesehatan date parameter",
     *          required=false,
     *          @OA\Schema(
     *              type="string",
     *              format="date-time",
     *              example="2020-01-01 00:00:00"
     *          )
     *     ),
     *     @OA\Parameter(
     *          name="mate_bpjs_kesehatan_class",
     *          in="query",
     *          description="Mate bpjs kesehatan class parameter",
     *          required=false,
     *          @OA\Schema(
     *              type="string",
     *              enum={"I","II","III"},
     *              default=""
     *          )
     *     ),
     *     @OA\Parameter(
     *          name="bank_id",
     *          in="query",
     *          description="Bank id parameter",
     *          required=false,
     *          @OA\Schema(
     *              type="integer",
     *              format="int64",
     *              example=1
     *          )
     *     ),
     *     @OA\Parameter(
     *          name="start_join_date",
     *          in="query",
     *          description="Start birth date parameter",
     *          required=false,
     *          @OA\Schema(
     *              type="string",
     *              format="date-time",
     *              example="2020-01-01 00:00:00"
     *          )
     *     ),
     *     @OA\Parameter(
     *          name="end_join_date",
     *          in="query",
     *          description="End birth date parameter",
     *          required=false,
     *          @OA\Schema(
     *              type="string",
     *              format="date-time",
     *              example="2020-01-01 00:00:00"
     *          )
     *     ),
     *     @OA\Parameter(
     *          name="work_status",
     *          in="query",
     *          description="Work status parameter",
     *          required=false,
     *          @OA\Schema(
     *              type="string",
     *              enum={"FULL_TIME", "PART_TIME"},
     *              default=""
     *          )
     *     ),
     *     @OA\Parameter(
     *          name="work_type",
     *          in="query",
     *          description="Work type parameter",
     *          required=false,
     *          @OA\Schema(
     *              type="string",
     *              enum={"PERMANENT", "CONTRACT"},
     *              default=""
     *          )
     *     ),
     *     @OA\Parameter(
     *          name="degree_id",
     *          in="query",
     *          description="Degree id parameter",
     *          required=false,
     *          @OA\Schema(
     *              type="integer",
     *              format="int64",
     *              example=1
     *          )
     *     ),
     *     @OA\Parameter(
     *          name="major_id",
     *          in="query",
     *          description="Major id parameter",
     *          required=false,
     *          @OA\Schema(
     *              type="integer",
     *              format="int64",
     *              example=1
     *          )
     *     ),
     *     @OA\Parameter(
     *          name="competence_id",
     *          in="query",
     *          description="Competence id parameter",
     *          required=false,
     *          @OA\Schema(
     *              type="integer",
     *              format="int64",
     *              example=1
     *          )
     *     ),
     *     @OA\Parameter(
     *          name="position_id",
     *          in="query",
     *          description="Position id parameter",
     *          required=false,
     *          @OA\Schema(
     *              type="integer",
     *              format="int64",
     *              example=1
     *          )
     *     ),
     *     @OA\Parameter(
     *          name="project_id",
     *          in="query",
     *          description="Project id parameter",
     *          required=false,
     *          @OA\Schema(
     *              type="integer",
     *              format="int64",
     *              example=1
     *          )
     *     ),
     *     @OA\Parameter(
     *          name="work_unit_id",
     *          in="query",
     *          description="Work unit id parameter",
     *          required=false,
     *          @OA\Schema(
     *              type="integer",
     *              format="int64",
     *              example=1
     *          )
     *     ),
     *     @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *          @OA\JsonContent()
     *     ),
     *     @OA\Response(
     *          response=400,
     *          description="Bad request",
     *          @OA\JsonContent()
     *     ),
     *     @OA\Response(
     *          response=401,
     *          description="Unauthenticated",
     *          @OA\JsonContent()
     *     )
     * )
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getEmployeeList(Request $request)
    {
        $companyId = $request->get('company_id');
        $genderId = $request->get('gender_id');
        $religionId = $request->get('religion_id');

        $rangeBirthDate = new DateTimeRange($request->get('start_birth_date'), $request->get('end_birth_date'));
        $rangeIdentityExpiredDate = new DateTimeRange($request->get('start_identity_expired_date'), $request->get('end_identity_expired_date'));
        $rangeDriveLicenseADate = new DateTimeRange($request->get('start_drive_license_a_date'), $request->get('end_drive_license_a_date'));
        $rangeDriveLicenseBDate = new DateTimeRange($request->get('start_drive_license_b_date'), $request->get('end_drive_license_b_date'));
        $rangeDriveLicenseCDate = new DateTimeRange($request->get('start_drive_license_c_date'), $request->get('end_drive_license_c_date'));

        $maritalStatusId = $request->get('marital_status_id');

        $mateAs = $request->get('mate_as');
        $rangeMateBirthDate = new DateTimeRange($request->get('start_mate_birth_date'), $request->get('end_mate_birth_date'));

        $officeId = $request->get('office_id');
        $workAreaId = $request->get('work_area_id');

        $rangeNPWPDate = new DateTimeRange($request->get('start_npwp_date'), $request->get('end_npwp_date'));
        $npwpStatus = $request->get('npwp_status');
        $rangeBPJSTenagaKerjaDate = new DateTimeRange($request->get('start_bpjs_tenaga_kerja_date'), $request->get('end_bpjs_tenaga_kerja_date'));
        $bpjsTenagaKerjaClass = $request->get('bpjs_tenaga_kerja_class');
        $rangeBPJSKesehatanDate = new DateTimeRange($request->get('start_bpjs_kesehatan_date'), $request->get('end_bpjs_kesehatan_date'));
        $bpjsKesehatanClass = $request->get('bpjs_kesehatan_class');
        $rangeMateBPJSKesehatanDate = new DateTimeRange($request->get('start_mate_bpjs_kesehatan_date'), $request->get('end_mate_bpjs_kesehatan_date'));
        $mateBPJSKesehatanClass = $request->get('bpjs_mate_kesehatan_class');

        $bankId = $request->get('bank_id');

        $rangeJoinDate = new DateTimeRange($request->get('start_join_date'), $request->get('end_join_date'));
        $workStatus = $request->get('work_status');
        $workType = $request->get('work_type');

        $degreeId = $request->get('degree_id');
        $majorId = $request->get('major_id');
        $competenceId = $request->get('competence_id');
        $positionId = $request->get('position_id');
        $projectId = $request->get('project_id');
        $workUnitId = $request->get('work_unit_id');

        return $this->getListJson([$this->_employeeServiceInterface, 'employeeList'],
            function (Collection $entities) {
                $rowJsonData = new Collection();

                foreach ($entities as $entity) {
                    $rowJsonData->push([
                        'id' => $entity->id,
                        'company' => Common::isDataExist($entity->company) ? $this->getCompanyObject($entity->company) : null,
                        'nip' => $entity->nip,
                        'full_name' => $entity->full_name,
                        'nick_name' => $entity->nick_name,
                        'gender' => Common::isDataExist($entity->gender) ? $this->getGenderObject($entity->gender) : null,
                        'religion'=> Common::isDataExist($entity->religion) ? $this->getReligionObject($entity->religion) : null,
                        'birth_place' => $entity->birth_place,
                        'birth_date' => $entity->birth_date,
                        'address' => $entity->address,
                        'phone' => $entity->phone,
                        'email' => $entity->email,
                        'mobile' => $entity->mobile,
                        'identity_number' => $entity->identity_number,
                        'identity_expired_date' => $entity->identity_expired_date,
                        'identity_address' => $entity->identity_address,
                        'has_drive_license_a' => $entity->has_drive_license_a,
                        'drive_license_a_number' => $entity->drive_license_a_number,
                        'drive_license_a_date' => $entity->drive_license_a_date,
                        'has_drive_license_b' => $entity->has_drive_license_b,
                        'drive_license_b_number' => $entity->drive_license_b_number,
                        'drive_license_b_date' => $entity->drive_license_b_date,
                        'has_drive_license_c' => $entity->has_drive_license_c,
                        'drive_license_c_number' => $entity->drive_license_c_number,
                        'drive_license_c_date' => $entity->drive_license_c_date,
                        'marital_status'=> Common::isDataExist($entity->maritalStatus) ? $this->getMaritalStatusObject($entity->maritalStatus) : null,
                        'mate_as' => $entity->mate_as,
                        'mate_full_name' => $entity->mate_full_name,
                        'mate_nick_name' => $entity->mate_nick_name,
                        'mate_birth_place' => $entity->mate_birth_place,
                        'mate_birth_date' => $entity->mate_birth_date,
                        'mate_occupation' => $entity->mate_occupation,
                        'office'=> Common::isDataExist($entity->office) ? $this->getOfficeObject($entity->office) : null,
                        'work_area'=> Common::isDataExist($entity->workArea) ? $this->getWorkAreaObject($entity->workArea) : null,
                        'has_npwp' => $entity->has_npwp,
                        'npwp_number' => $entity->npwp_number,
                        'npwp_date' => $entity->npwp_date,
                        'npwp_status' => $entity->npwp_status,
                        'has_bpjs_tenaga_kerja' => $entity->has_bpjs_tenaga_kerja,
                        'bpjs_tenaga_kerja_number' => $entity->bpjs_tenaga_kerja_number,
                        'bpjs_tenaga_kerja_date' => $entity->bpjs_tenaga_kerja_date,
                        'bpjs_tenaga_kerja_class' => $entity->bpjs_tenaga_kerja_class,
                        'has_bpjs_kesehatan' => $entity->has_bpjs_kesehatan,
                        'bpjs_kesehatan_number' => $entity->bpjs_kesehatan_number,
                        'bpjs_kesehatan_date' => $entity->bpjs_kesehatan_date,
                        'bpjs_kesehatan_class' => $entity->bpjs_kesehatan_class,

                        'has_mate_bpjs_kesehatan' => $entity->has_mate_bpjs_kesehatan,
                        'mate_bpjs_kesehatan_number' => $entity->mate_bpjs_kesehatan_number,
                        'mate_bpjs_kesehatan_date' => $entity->mate_bpjs_kesehatan_date,
                        'mate_bpjs_kesehatan_class' => $entity->mate_bpjs_kesehatan_class,

                        'dplk_number' => $entity->dplk_number,
                        'collective_number' => $entity->collective_number,
                        'english_ability' => $entity->english_ability,
                        'computer_ability' => $entity->computer_ability,
                        'other_ability' => $entity->other_ability,
                        'bank'=> Common::isDataExist($entity->bank) ? $this->getBankObject($entity->bank) : null,
                        'account_number' => $entity->account_number,
                        'join_date' => $entity->join_date,
                        'work_status' => $entity->work_status,
                        'work_type' => $entity->work_type,

                        'created_by' => $entity->created_by,
                        'modified_by' => $entity->modified_by,

                        'work_unit_mutations' => $entity->workUnitMutations,
                        'media_libraries' => $entity->mediaLibraries
                    ]);
                }

                return $rowJsonData;
            }, $companyId, $genderId, $religionId, $rangeBirthDate, $rangeIdentityExpiredDate,
            $rangeDriveLicenseADate, $rangeDriveLicenseBDate, $rangeDriveLicenseCDate, $maritalStatusId, $mateAs,
            $rangeMateBirthDate, $officeId, $workAreaId, $rangeNPWPDate, $npwpStatus,
            $rangeBPJSTenagaKerjaDate, $bpjsTenagaKerjaClass, $rangeBPJSKesehatanDate, $bpjsKesehatanClass, $rangeMateBPJSKesehatanDate,
            $mateBPJSKesehatanClass, $bankId, $rangeJoinDate, $workStatus, $workType, $degreeId, $majorId,
            $competenceId, $positionId, $projectId, $workUnitId);
    }

    /**
     * @OA\Get(
     *     path="/employee/terminated/list/",
     *     operationId="getEmployeeTerminatedList",
     *     summary="Get list of terminated employee",
     *     tags={"Employee"},
     *     description="Get list of terminated employee",
     *     security={
     *          {
     *              "apiKey": {"*"}
     *          }
     *     },
     *     @OA\Parameter(
     *          name="company_id",
     *          in="query",
     *          description="Company id parameter",
     *          required=false,
     *          @OA\Schema(
     *              type="integer",
     *              format="int64",
     *              example=1
     *          )
     *     ),
     *     @OA\Parameter(
     *          name="office_id",
     *          in="query",
     *          description="Office id parameter",
     *          required=false,
     *          @OA\Schema(
     *              type="integer",
     *              format="int64",
     *              example=1
     *          )
     *     ),
     *     @OA\Parameter(
     *          name="start_termination_date",
     *          in="query",
     *          description="Start termination date parameter",
     *          required=false,
     *          @OA\Schema(
     *              type="string",
     *              format="date-time",
     *              example="2020-01-01 00:00:00"
     *          )
     *     ),
     *     @OA\Parameter(
     *          name="end_termination_date",
     *          in="query",
     *          description="End termination date parameter",
     *          required=false,
     *          @OA\Schema(
     *              type="string",
     *              format="date-time",
     *              example="2020-01-01 00:00:00"
     *          )
     *     ),
     *     @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *          @OA\JsonContent()
     *     ),
     *     @OA\Response(
     *          response=400,
     *          description="Bad request",
     *          @OA\JsonContent()
     *     ),
     *     @OA\Response(
     *          response=401,
     *          description="Unauthenticated",
     *          @OA\JsonContent()
     *     )
     * )
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getEmployeeTerminatedList(Request $request)
    {
        $companyId = $request->get('company_id');
        $officeId = $request->get('office_id');
        $rangeTerminationDate = new DateTimeRange($request->get('start_termination_date'), $request->get('end_termination_date'));

        return $this->getListJsonEmployeeTerminated($companyId, $officeId, $rangeTerminationDate,
            [$this->_employeeServiceInterface, 'employeeTerminatedList'],
            function (Collection $entities) {
                $rowJsonData = new Collection();

                foreach ($entities as $entity) {
                    $rowJsonData->push([
                        'id' => $entity->id,
                        'company' => Common::isDataExist($entity->company) ? $this->getCompanyObject($entity->company) : null,
                        'nip' => $entity->nip,
                        'full_name' => $entity->full_name,
                        'nick_name' => $entity->nick_name,
                        'gender' => Common::isDataExist($entity->gender) ? $this->getGenderObject($entity->gender) : null,
                        'religion'=> Common::isDataExist($entity->religion) ? $this->getReligionObject($entity->religion) : null,
                        'birth_place' => $entity->birth_place,
                        'birth_date' => $entity->birth_date,
                        'address' => $entity->address,
                        'phone' => $entity->phone,
                        'email' => $entity->email,
                        'mobile' => $entity->mobile,
                        'identity_number' => $entity->identity_number,
                        'identity_expired_date' => $entity->identity_expired_date,
                        'identity_address' => $entity->identity_address,
                        'has_drive_license_a' => $entity->has_drive_license_a,
                        'drive_license_a_number' => $entity->drive_license_a_number,
                        'drive_license_a_date' => $entity->drive_license_a_date,
                        'has_drive_license_b' => $entity->has_drive_license_b,
                        'drive_license_b_number' => $entity->drive_license_b_number,
                        'drive_license_b_date' => $entity->drive_license_b_date,
                        'has_drive_license_c' => $entity->has_drive_license_c,
                        'drive_license_c_number' => $entity->drive_license_c_number,
                        'drive_license_c_date' => $entity->drive_license_c_date,
                        'marital_status'=> Common::isDataExist($entity->maritalStatus) ? $this->getMaritalStatusObject($entity->maritalStatus) : null,
                        'mate_as' => $entity->mate_as,
                        'mate_first_name' => $entity->mate_first_name,
                        'mate_last_name' => $entity->mate_last_name,
                        'mate_birth_place' => $entity->mate_birth_place,
                        'mate_birth_date' => $entity->mate_birth_date,
                        'mate_occupation' => $entity->mate_occupation,
                        'office'=> Common::isDataExist($entity->office) ? $this->getOfficeObject($entity->office) : null,
                        'work_area'=> Common::isDataExist($entity->workArea) ? $this->getWorkAreaObject($entity->workArea) : null,
                        'has_npwp' => $entity->has_npwp,
                        'npwp_number' => $entity->npwp_number,
                        'npwp_date' => $entity->npwp_date,
                        'npwp_status' => $entity->npwp_status,
                        'has_bpjs_tenaga_kerja' => $entity->has_bpjs_tenaga_kerja,
                        'bpjs_tenaga_kerja_number' => $entity->bpjs_tenaga_kerja_number,
                        'bpjs_tenaga_kerja_date' => $entity->bpjs_tenaga_kerja_date,
                        'bpjs_tenaga_kerja_class' => $entity->bpjs_tenaga_kerja_class,
                        'has_bpjs_kesehatan' => $entity->has_bpjs_kesehatan,
                        'bpjs_kesehatan_number' => $entity->bpjs_kesehatan_number,
                        'bpjs_kesehatan_date' => $entity->bpjs_kesehatan_date,
                        'bpjs_kesehatan_class' => $entity->bpjs_kesehatan_class,
                        'dplk_number' => $entity->dplk_number,
                        'collective_number' => $entity->collective_number,
                        'english_ability' => $entity->english_ability,
                        'computer_ability' => $entity->computer_ability,
                        'other_ability' => $entity->other_ability,
                        'bank'=> Common::isDataExist($entity->bank) ? $this->getBankObject($entity->bank) : null,
                        'account_number' => $entity->account_number,
                        'join_date' => $entity->join_date,
                        'work_status' => $entity->work_status,
                        'work_type' => $entity->work_type,
                        'created_by' => $entity->created_by,
                        'modified_by' => $entity->modified_by,

                        'media_libraries' => $entity->mediaLibraries
                    ]);
                }

                return $rowJsonData;
            });
    }

    /**
     * @OA\Get(
     *     path="/employee/birth-day/list",
     *     operationId="getEmployeeBirthDayList",
     *     summary="Get list of birth day employee",
     *     tags={"Employee"},
     *     description="Get list of birth day employee",
     *     security={
     *          {
     *              "apiKey": {"*"}
     *          }
     *     },
     *     @OA\Parameter(
     *          name="company_id",
     *          in="query",
     *          description="Company id parameter",
     *          required=false,
     *          @OA\Schema(
     *              type="integer",
     *              format="int64",
     *              example=1
     *          )
     *     ),
     *     @OA\Parameter(
     *          name="office_id",
     *          in="query",
     *          description="Office id parameter",
     *          required=false,
     *          @OA\Schema(
     *              type="integer",
     *              format="int64",
     *              example=1
     *          )
     *     ),
     *     @OA\Parameter(
     *          name="month",
     *          in="query",
     *          description="Month parameter",
     *          required=false,
     *          @OA\Schema(
     *              type="integer",
     *              format="int32",
     *              example=1
     *          )
     *     ),
     *     @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *          @OA\JsonContent()
     *     ),
     *     @OA\Response(
     *          response=400,
     *          description="Bad request",
     *          @OA\JsonContent()
     *     ),
     *     @OA\Response(
     *          response=401,
     *          description="Unauthenticated",
     *          @OA\JsonContent()
     *     )
     * )
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getEmployeeBirthDayList(Request $request)
    {
        $companyId = $request->get('company_id');
        $officeId = $request->get('office_id');
        $month = $request->get('month');

        return $this->getListJsonEmployeeBithday($companyId, $officeId, $month,
            [$this->_employeeServiceInterface, 'employeeBirthDayList'],
            function (Collection $entities) {
                $rowJsonData = new Collection();

                foreach ($entities as $entity) {
                    $rowJsonData->push([
                        'id' => $entity->id,
                        'company' => Common::isDataExist($entity->company) ? $this->getCompanyObject($entity->company) : null,
                        'nip' => $entity->nip,
                        'full_name' => $entity->full_name,
                        'nick_name' => $entity->nick_name,
                        'gender' => Common::isDataExist($entity->gender) ? $this->getGenderObject($entity->gender) : null,
                        'religion'=> Common::isDataExist($entity->religion) ? $this->getReligionObject($entity->religion) : null,
                        'birth_place' => $entity->birth_place,
                        'birth_date' => $entity->birth_date,
                        'address' => $entity->address,
                        'phone' => $entity->phone,
                        'email' => $entity->email,
                        'mobile' => $entity->mobile,
                        'identity_number' => $entity->identity_number,
                        'identity_address' => $entity->identity_address,
                        'has_drive_license_a' => $entity->has_drive_license_a,
                        'drive_license_a_number' => $entity->drive_license_a_number,
                        'drive_license_a_date' => $entity->drive_license_a_date,
                        'has_drive_license_b' => $entity->has_drive_license_b,
                        'drive_license_b_number' => $entity->drive_license_b_number,
                        'drive_license_b_date' => $entity->drive_license_b_date,
                        'has_drive_license_c' => $entity->has_drive_license_c,
                        'drive_license_c_number' => $entity->drive_license_c_number,
                        'drive_license_c_date' => $entity->drive_license_c_date,
                        'marital_status'=> Common::isDataExist($entity->maritalStatus) ? $this->getMaritalStatusObject($entity->maritalStatus) : null,
                        'mate_as' => $entity->mate_as,
                        'mate_first_name' => $entity->mate_first_name,
                        'mate_last_name' => $entity->mate_last_name,
                        'mate_birth_place' => $entity->mate_birth_place,
                        'mate_birth_date' => $entity->mate_birth_date,
                        'mate_occupation' => $entity->mate_occupation,
                        'office'=> Common::isDataExist($entity->office) ? $this->getOfficeObject($entity->office) : null,
                        'work_area'=> Common::isDataExist($entity->workArea) ? $this->getWorkAreaObject($entity->workArea) : null,
                        'has_npwp' => $entity->has_npwp,
                        'npwp_number' => $entity->npwp_number,
                        'npwp_date' => $entity->npwp_date,
                        'npwp_status' => $entity->npwp_status,
                        'has_bpjs_tenaga_kerja' => $entity->has_bpjs_tenaga_kerja,
                        'bpjs_tenaga_kerja_number' => $entity->bpjs_tenaga_kerja_number,
                        'bpjs_tenaga_kerja_date' => $entity->bpjs_tenaga_kerja_date,
                        'bpjs_tenaga_kerja_class' => $entity->bpjs_tenaga_kerja_class,
                        'has_bpjs_kesehatan' => $entity->has_bpjs_kesehatan,
                        'bpjs_kesehatan_number' => $entity->bpjs_kesehatan_number,
                        'bpjs_kesehatan_date' => $entity->bpjs_kesehatan_date,
                        'bpjs_kesehatan_class' => $entity->bpjs_kesehatan_class,
                        'dplk_number' => $entity->dplk_number,
                        'collective_number' => $entity->collective_number,
                        'english_ability' => $entity->english_ability,
                        'computer_ability' => $entity->computer_ability,
                        'other_ability' => $entity->other_ability,
                        'bank'=> Common::isDataExist($entity->bank) ? $this->getBankObject($entity->bank) : null,
                        'account_number' => $entity->account_number,
                        'join_date' => $entity->join_date,
                        'work_status' => $entity->work_status,
                        'created_by' => $entity->created_by,
                        'modified_by' => $entity->modified_by,

                        'media_libraries' => $entity->mediaLibraries
                    ]);
                }

                return $rowJsonData;
            });
    }



    /**
     * @OA\Post(
     *     path="/employee/list-search",
     *     operationId="postEmployeeListSearch",
     *     summary="Get list of employee with query search",
     *     tags={"Employee"},
     *     description="Get list of employee with query search",
     *     security={
     *          {
     *              "apiKey": {"*"}
     *          }
     *     },
     *     @OA\RequestBody(
     *          required=true,
     *          @OA\MediaType(
     *              mediaType="application/json",
     *              @OA\Schema(
     *                  @OA\Property(
     *                      property="query",
     *                      description="Query property (Keyword would be filter nik, full name, nick name, birth place, address, phone, mobile, email, identity number, identity address, drive license a number, drive license b number, drive license c number, npwp number, bpjs tenaga kerja number, bpjs kesehatan number, mate bpjs kesehatan number, dplk number, collective number, account number)",
     *                      type="string"
     *                  ),
     *                  @OA\Property(property="company_id", ref="#/components/schemas/EmployeeEloquent/properties/company_id"),
     *                  @OA\Property(property="gender_id", ref="#/components/schemas/EmployeeEloquent/properties/gender_id"),
     *                  @OA\Property(property="religion_id", ref="#/components/schemas/EmployeeEloquent/properties/religion_id"),
     *                  @OA\Property(
     *                      property="start_birth_date",
     *                      description="Start birth date property",
     *                      type="string",
     *                      format="date-time",
     *                      example="2020-01-01 00:00:00"
     *                  ),
     *                  @OA\Property(
     *                      property="end_birth_date",
     *                      description="End birth date property",
     *                      type="string",
     *                      format="date-time",
     *                      example="2020-01-01 00:00:00"
     *                  ),
     *                  @OA\Property(
     *                      property="start_identity_expired_date",
     *                      description="Start identity expired date property",
     *                      type="string",
     *                      format="date-time",
     *                      example="2020-01-01 00:00:00"
     *                  ),
     *                  @OA\Property(
     *                      property="end_identity_expired_date",
     *                      description="End identity expired date property",
     *                      type="string",
     *                      format="date-time",
     *                      example="2020-01-01 00:00:00"
     *                  ),
     *                  @OA\Property(
     *                      property="start_drive_license_a_date",
     *                      description="Start drive license a date property",
     *                      type="string",
     *                      format="date-time",
     *                      example="2020-01-01 00:00:00"
     *                  ),
     *                  @OA\Property(
     *                      property="end_drive_license_a_date",
     *                      description="End drive license a date property",
     *                      type="string",
     *                      format="date-time",
     *                      example="2020-01-01 00:00:00"
     *                  ),
     *                  @OA\Property(
     *                      property="start_drive_license_b_date",
     *                      description="Start drive license b date property",
     *                      type="string",
     *                      format="date-time",
     *                      example="2020-01-01 00:00:00"
     *                  ),
     *                  @OA\Property(
     *                      property="end_drive_license_b_date",
     *                      description="End drive license b date property",
     *                      type="string",
     *                      format="date-time",
     *                      example="2020-01-01 00:00:00"
     *                  ),
     *                  @OA\Property(
     *                      property="start_drive_license_c_date",
     *                      description="Start drive license c date property",
     *                      type="string",
     *                      format="date-time",
     *                      example="2020-01-01 00:00:00"
     *                  ),
     *                  @OA\Property(
     *                      property="end_drive_license_c_date",
     *                      description="End drive license c date property",
     *                      type="string",
     *                      format="date-time",
     *                      example="2020-01-01 00:00:00"
     *                  ),
     *                  @OA\Property(property="marital_status_id", ref="#/components/schemas/EmployeeEloquent/properties/marital_status_id"),
     *                  @OA\Property(property="mate_as", ref="#/components/schemas/EmployeeEloquent/properties/mate_as"),
     *                  @OA\Property(
     *                      property="start_mate_birth_date",
     *                      description="Start mate birth date property",
     *                      type="string",
     *                      format="date-time",
     *                      example="2020-01-01 00:00:00"
     *                  ),
     *                  @OA\Property(
     *                      property="end_mate_birth_date",
     *                      description="End mate birth date property",
     *                      type="string",
     *                      format="date-time",
     *                      example="2020-01-01 00:00:00"
     *                  ),
     *                  @OA\Property(property="office_id", ref="#/components/schemas/EmployeeEloquent/properties/office_id"),
     *                  @OA\Property(property="work_area_id", ref="#/components/schemas/EmployeeEloquent/properties/work_area_id"),
     *                  @OA\Property(
     *                      property="start_npwp_date",
     *                      description="Start npwp date property",
     *                      type="string",
     *                      format="date-time",
     *                      example="2020-01-01 00:00:00"
     *                  ),
     *                  @OA\Property(
     *                      property="end_npwp_date",
     *                      description="End npwp date property",
     *                      type="string",
     *                      format="date-time",
     *                      example="2020-01-01 00:00:00"
     *                  ),
     *                  @OA\Property(property="npwp_status", ref="#/components/schemas/EmployeeEloquent/properties/npwp_status"),
     *                  @OA\Property(
     *                      property="start_bpjs_tenaga_kerja_date",
     *                      description="Start bpjs tenaga kerja date property",
     *                      type="string",
     *                      format="date-time",
     *                      example="2020-01-01 00:00:00"
     *                  ),
     *                  @OA\Property(
     *                      property="end_bpjs_tenaga_kerja_date",
     *                      description="End bpjs tenaga kerja date property",
     *                      type="string",
     *                      format="date-time",
     *                      example="2020-01-01 00:00:00"
     *                  ),
     *                  @OA\Property(property="bpjs_tenaga_kerja_class", ref="#/components/schemas/EmployeeEloquent/properties/bpjs_tenaga_kerja_class"),
     *                  @OA\Property(
     *                      property="start_bpjs_kesehatan_date",
     *                      description="Start bpjs kesehatan date property",
     *                      type="string",
     *                      format="date-time",
     *                      example="2020-01-01 00:00:00"
     *                  ),
     *                  @OA\Property(
     *                      property="end_bpjs_kesehatan_date",
     *                      description="End bpjs kesehatan date property",
     *                      type="string",
     *                      format="date-time",
     *                      example="2020-01-01 00:00:00"
     *                  ),
     *                  @OA\Property(property="bpjs_kesehatan_class", ref="#/components/schemas/EmployeeEloquent/properties/bpjs_kesehatan_class"),
     *                  @OA\Property(
     *                      property="start_mate_bpjs_kesehatan_date",
     *                      description="Start mate bpjs kesehatan date property",
     *                      type="string",
     *                      format="date-time",
     *                      example="2020-01-01 00:00:00"
     *                  ),
     *                  @OA\Property(
     *                      property="end_mate_bpjs_kesehatan_date",
     *                      description="End mate bpjs kesehatan date property",
     *                      type="string",
     *                      format="date-time",
     *                      example="2020-01-01 00:00:00"
     *                  ),
     *                  @OA\Property(property="mate_bpjs_kesehatan_class", ref="#/components/schemas/EmployeeEloquent/properties/mate_bpjs_kesehatan_class"),
     *                  @OA\Property(property="bank_id", ref="#/components/schemas/EmployeeEloquent/properties/bank_id"),
     *                  @OA\Property(
     *                      property="start_join_date",
     *                      description="Start join date property",
     *                      type="string",
     *                      format="date-time",
     *                      example="2020-01-01 00:00:00"
     *                  ),
     *                  @OA\Property(
     *                      property="end_join_date",
     *                      description="End join date property",
     *                      type="string",
     *                      format="date-time",
     *                      example="2020-01-01 00:00:00"
     *                  ),
     *                  @OA\Property(property="work_status", ref="#/components/schemas/EmployeeEloquent/properties/work_status"),
     *                  @OA\Property(property="work_type", ref="#/components/schemas/EmployeeEloquent/properties/work_type"),
     *                  @OA\Property(property="degree_id", ref="#/components/schemas/FormalEducationHistoryEloquent/properties/degree_id"),
     *                  @OA\Property(property="major_id", ref="#/components/schemas/FormalEducationHistoryEloquent/properties/major_id"),
     *                  @OA\Property(property="competence_id", ref="#/components/schemas/WorkCompetenceEloquent/properties/competence_id"),
     *                  @OA\Property(property="position_id", ref="#/components/schemas/PositionMutationEloquent/properties/position_id"),
     *                  @OA\Property(property="project_id", ref="#/components/schemas/ProjectMutationEloquent/properties/project_id"),
     *                  @OA\Property(property="work_unit_id", ref="#/components/schemas/WorkUnitMutationEloquent/properties/work_unit_id"),
     *              )
     *          )
     *     ),
     *     @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *          @OA\JsonContent()
     *     ),
     *     @OA\Response(
     *          response=400,
     *          description="Bad request",
     *          @OA\JsonContent()
     *     ),
     *     @OA\Response(
     *          response=401,
     *          description="Unauthenticated",
     *          @OA\JsonContent()
     *     )
     * )
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function postEmployeeListSearch(Request $request)
    {
        $companyId = $request->input('company_id');
        $genderId = $request->input('gender_id');
        $religionId = $request->input('religion_id');

        $rangeBirthDate = new DateTimeRange($request->input('start_birth_date'), $request->input('end_birth_date'));
        $rangeIdentityExpiredDate = new DateTimeRange($request->input('start_identity_expired_date'), $request->input('end_identity_expired_date'));
        $rangeDriveLicenseADate = new DateTimeRange($request->input('start_drive_license_a_date'), $request->input('end_drive_license_a_date'));
        $rangeDriveLicenseBDate = new DateTimeRange($request->input('start_drive_license_b_date'), $request->input('end_drive_license_b_date'));
        $rangeDriveLicenseCDate = new DateTimeRange($request->input('start_drive_license_c_date'), $request->input('end_drive_license_c_date'));

        $maritalStatusId = $request->input('marital_status_id');

        $mateAs = $request->input('mate_as');
        $rangeMateBirthDate = new DateTimeRange($request->input('start_mate_birth_date'), $request->input('end_mate_birth_date'));

        $officeId = $request->input('office_id');
        $workAreaId = $request->input('work_area_id');

        $rangeNPWPDate = new DateTimeRange($request->input('start_npwp_date'), $request->input('end_npwp_date'));
        $npwpStatus = $request->input('npwp_status');
        $rangeBPJSTenagaKerjaDate = new DateTimeRange($request->input('start_bpjs_tenaga_kerja_date'), $request->input('end_bpjs_tenaga_kerja_date'));
        $bpjsTenagaKerjaClass = $request->input('bpjs_tenaga_kerja_class');
        $rangeBPJSKesehatanDate = new DateTimeRange($request->input('start_bpjs_kesehatan_date'), $request->input('end_bpjs_kesehatan_date'));
        $bpjsKesehatanClass = $request->input('bpjs_kesehatan_class');
        $rangeMateBPJSKesehatanDate = new DateTimeRange($request->input('start_mate_bpjs_kesehatan_date'), $request->input('end_mate_bpjs_kesehatan_date'));
        $mateBPJSKesehatanClass = $request->input('bpjs_mate_kesehatan_class');

        $bankId = $request->input('bank_id');

        $rangeJoinDate = new DateTimeRange($request->input('start_join_date'), $request->input('end_join_date'));
        $workStatus = $request->input('work_status');
        $workType = $request->input('work_type');

        $degreeId = $request->input('degree_id');
        $majorId = $request->input('major_id');
        $competenceId = $request->input('competence_id');
        $positionId = $request->input('position_id');
        $projectId = $request->input('project_id');
        $workUnitId = $request->input('work_unit_id');

        return $this->getListSearchJson($request,
            [$this->_employeeServiceInterface, 'employeeListSearch'],
            function (Collection $entities) {
                $rowJsonData = new Collection();

                foreach ($entities as $entity) {
                    $rowJsonData->push([
                        'id' => $entity->id,
                        'company' => Common::isDataExist($entity->company) ? $this->getCompanyObject($entity->company) : null,
                        'nip' => $entity->nip,
                        'full_name' => $entity->full_name,
                        'nick_name' => $entity->nick_name,
                        'gender' => Common::isDataExist($entity->gender) ? $this->getGenderObject($entity->gender) : null,
                        'religion'=> Common::isDataExist($entity->religion) ? $this->getReligionObject($entity->religion) : null,
                        'birth_place' => $entity->birth_place,
                        'birth_date' => $entity->birth_date,
                        'address' => $entity->address,
                        'phone' => $entity->phone,
                        'email' => $entity->email,
                        'mobile' => $entity->mobile,
                        'identity_number' => $entity->identity_number,
                        'identity_expired_date' => $entity->identity_expired_date,
                        'identity_address' => $entity->identity_address,
                        'has_drive_license_a' => $entity->has_drive_license_a,
                        'drive_license_a_number' => $entity->drive_license_a_number,
                        'drive_license_a_date' => $entity->drive_license_a_date,
                        'has_drive_license_b' => $entity->has_drive_license_b,
                        'drive_license_b_number' => $entity->drive_license_b_number,
                        'drive_license_b_date' => $entity->drive_license_b_date,
                        'has_drive_license_c' => $entity->has_drive_license_c,
                        'drive_license_c_number' => $entity->drive_license_c_number,
                        'drive_license_c_date' => $entity->drive_license_c_date,
                        'marital_status'=> Common::isDataExist($entity->maritalStatus) ? $this->getMaritalStatusObject($entity->maritalStatus) : null,
                        'mate_as' => $entity->mate_as,
                        'mate_first_name' => $entity->mate_first_name,
                        'mate_last_name' => $entity->mate_last_name,
                        'mate_birth_place' => $entity->mate_birth_place,
                        'mate_birth_date' => $entity->mate_birth_date,
                        'mate_occupation' => $entity->mate_occupation,
                        'office'=> Common::isDataExist($entity->office) ? $this->getOfficeObject($entity->office) : null,
                        'work_area'=> Common::isDataExist($entity->workArea) ? $this->getWorkAreaObject($entity->workArea) : null,
                        'has_npwp' => $entity->has_npwp,
                        'npwp_number' => $entity->npwp_number,
                        'npwp_date' => $entity->npwp_date,
                        'npwp_status' => $entity->npwp_status,
                        'has_bpjs_tenaga_kerja' => $entity->has_bpjs_tenaga_kerja,
                        'bpjs_tenaga_kerja_number' => $entity->bpjs_tenaga_kerja_number,
                        'bpjs_tenaga_kerja_date' => $entity->bpjs_tenaga_kerja_date,
                        'bpjs_tenaga_kerja_class' => $entity->bpjs_tenaga_kerja_class,
                        'has_bpjs_kesehatan' => $entity->has_bpjs_kesehatan,
                        'bpjs_kesehatan_number' => $entity->bpjs_kesehatan_number,
                        'bpjs_kesehatan_date' => $entity->bpjs_kesehatan_date,
                        'bpjs_kesehatan_class' => $entity->bpjs_kesehatan_class,

                        'has_mate_bpjs_kesehatan' => $entity->has_mate_bpjs_kesehatan,
                        'mate_bpjs_kesehatan_number' => $entity->mate_bpjs_kesehatan_number,
                        'mate_bpjs_kesehatan_date' => $entity->mate_bpjs_kesehatan_date,
                        'mate_bpjs_kesehatan_class' => $entity->mate_bpjs_kesehatan_class,

                        'dplk_number' => $entity->dplk_number,
                        'collective_number' => $entity->collective_number,
                        'english_ability' => $entity->english_ability,
                        'computer_ability' => $entity->computer_ability,
                        'other_ability' => $entity->other_ability,
                        'bank'=> Common::isDataExist($entity->bank) ? $this->getBankObject($entity->bank) : null,
                        'account_number' => $entity->account_number,
                        'join_date' => $entity->join_date,
                        'work_status' => $entity->work_status,
                        'work_type' => $entity->work_type,

                        'created_by' => $entity->created_by,
                        'modified_by' => $entity->modified_by,

                        'work_unit_mutations' => $entity->workUnitMutations,
                        'media_libraries' => $entity->mediaLibraries
                    ]);
                }

                return $rowJsonData;
            }, $companyId, $genderId, $religionId, $rangeBirthDate, $rangeIdentityExpiredDate,
            $rangeDriveLicenseADate, $rangeDriveLicenseBDate, $rangeDriveLicenseCDate, $maritalStatusId, $mateAs,
            $rangeMateBirthDate, $officeId, $workAreaId, $rangeNPWPDate, $npwpStatus,
            $rangeBPJSTenagaKerjaDate, $bpjsTenagaKerjaClass, $rangeBPJSKesehatanDate, $bpjsKesehatanClass, $rangeMateBPJSKesehatanDate,
            $mateBPJSKesehatanClass, $bankId, $rangeJoinDate, $workStatus, $workType, $degreeId, $majorId,
            $competenceId, $positionId, $projectId, $workUnitId);
    }

    /**
     * @OA\Post(
     *     path="/employee/terminated/list-search",
     *     operationId="postEmployeeTerminatedListSearch",
     *     summary="Get list of terminated employee with query search",
     *     tags={"Employee"},
     *     description="Get list of terminated employee with query search",
     *     security={
     *          {
     *              "apiKey": {"*"}
     *          }
     *     },
     *     @OA\RequestBody(
     *          required=true,
     *          @OA\MediaType(
     *              mediaType="application/json",
     *              @OA\Schema(
     *                  @OA\Property(
     *                      property="query",
     *                      description="Query property (Keyword would be filter nik, full name, nick name, birth place, address, phone, mobile, email, identity number, identity address, drive license a number, drive license b number, drive license c number, npwp number, bpjs tenaga kerja number, bpjs kesehatan number, mate bpjs kesehatan number, dplk number, collective number, account number)",
     *                      type="string"
     *                  ),
     *                  @OA\Property(property="company_id", ref="#/components/schemas/EmployeeEloquent/properties/company_id"),
     *                  @OA\Property(property="office_id", ref="#/components/schemas/EmployeeEloquent/properties/office_id"),
     *                  @OA\Property(
     *                      property="start_termination_date",
     *                      description="Start termination date parameter",
     *                      type="string",
     *                      format="date-time",
     *                      example="2020-01-01 00:00:00"
     *                  ),
     *                  @OA\Property(
     *                      property="end_termination_date",
     *                      description="End termination date parameter",
     *                      type="string",
     *                      format="date-time",
     *                      example="2020-01-01 00:00:00"
     *                  ),
     *              )
     *          )
     *     ),
     *     @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *          @OA\JsonContent()
     *     ),
     *     @OA\Response(
     *          response=400,
     *          description="Bad request",
     *          @OA\JsonContent()
     *     ),
     *     @OA\Response(
     *          response=401,
     *          description="Unauthenticated",
     *          @OA\JsonContent()
     *     )
     * )
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function postEmployeeTerminatedListSearch(Request $request)
    {
        $companyId = $request->input('company_id');
        $officeId = $request->input('office_id');
        $rangeTerminationDate = new DateTimeRange($request->input('start_termination_date'), $request->input('end_termination_date'));

        return $this->getListSearchJsonEmployeeTerminated($request, $companyId, $officeId, $rangeTerminationDate,
            [$this->_employeeServiceInterface, 'employeeTerminatedListSearch'],
            function (Collection $entities) {
                $rowJsonData = new Collection();

                foreach ($entities as $entity) {
                    $rowJsonData->push([
                        'id' => $entity->id,
                        'company' => Common::isDataExist($entity->company) ? $this->getCompanyObject($entity->company) : null,
                        'nip' => $entity->nip,
                        'full_name' => $entity->full_name,
                        'nick_name' => $entity->nick_name,
                        'gender' => Common::isDataExist($entity->gender) ? $this->getGenderObject($entity->gender) : null,
                        'religion'=> Common::isDataExist($entity->religion) ? $this->getReligionObject($entity->religion) : null,
                        'birth_place' => $entity->birth_place,
                        'birth_date' => $entity->birth_date,
                        'address' => $entity->address,
                        'phone' => $entity->phone,
                        'email' => $entity->email,
                        'mobile' => $entity->mobile,
                        'identity_number' => $entity->identity_number,
                        'identity_expired_date' => $entity->identity_expired_date,
                        'identity_address' => $entity->identity_address,
                        'has_drive_license_a' => $entity->has_drive_license_a,
                        'drive_license_a_number' => $entity->drive_license_a_number,
                        'drive_license_a_date' => $entity->drive_license_a_date,
                        'has_drive_license_b' => $entity->has_drive_license_b,
                        'drive_license_b_number' => $entity->drive_license_b_number,
                        'drive_license_b_date' => $entity->drive_license_b_date,
                        'has_drive_license_c' => $entity->has_drive_license_c,
                        'drive_license_c_number' => $entity->drive_license_c_number,
                        'drive_license_c_date' => $entity->drive_license_c_date,
                        'marital_status'=> Common::isDataExist($entity->maritalStatus) ? $this->getMaritalStatusObject($entity->maritalStatus) : null,
                        'mate_as' => $entity->mate_as,
                        'mate_first_name' => $entity->mate_first_name,
                        'mate_last_name' => $entity->mate_last_name,
                        'mate_birth_place' => $entity->mate_birth_place,
                        'mate_birth_date' => $entity->mate_birth_date,
                        'mate_occupation' => $entity->mate_occupation,
                        'office'=> Common::isDataExist($entity->office) ? $this->getOfficeObject($entity->office) : null,
                        'work_area'=> Common::isDataExist($entity->workArea) ? $this->getWorkAreaObject($entity->workArea) : null,
                        'has_npwp' => $entity->has_npwp,
                        'npwp_number' => $entity->npwp_number,
                        'npwp_date' => $entity->npwp_date,
                        'npwp_status' => $entity->npwp_status,
                        'has_bpjs_tenaga_kerja' => $entity->has_bpjs_tenaga_kerja,
                        'bpjs_tenaga_kerja_number' => $entity->bpjs_tenaga_kerja_number,
                        'bpjs_tenaga_kerja_date' => $entity->bpjs_tenaga_kerja_date,
                        'bpjs_tenaga_kerja_class' => $entity->bpjs_tenaga_kerja_class,
                        'has_bpjs_kesehatan' => $entity->has_bpjs_kesehatan,
                        'bpjs_kesehatan_number' => $entity->bpjs_kesehatan_number,
                        'bpjs_kesehatan_date' => $entity->bpjs_kesehatan_date,
                        'bpjs_kesehatan_class' => $entity->bpjs_kesehatan_class,
                        'dplk_number' => $entity->dplk_number,
                        'collective_number' => $entity->collective_number,
                        'english_ability' => $entity->english_ability,
                        'computer_ability' => $entity->computer_ability,
                        'other_ability' => $entity->other_ability,
                        'bank'=> Common::isDataExist($entity->bank) ? $this->getBankObject($entity->bank) : null,
                        'account_number' => $entity->account_number,
                        'join_date' => $entity->join_date,
                        'work_status' => $entity->work_status,
                        'work_type' => $entity->work_type,
                        'created_by' => $entity->created_by,
                        'modified_by' => $entity->modified_by,
                        'media_libraries' => $entity->mediaLibraries
                    ]);
                }

                return $rowJsonData;
            });
    }

    /**
     * @OA\Post(
     *     path="/employee/birth-day/list-search",
     *     operationId="postEmployeeBirthDayListSearch",
     *     summary="Get list of birth day employee with query search",
     *     tags={"Employee"},
     *     description="Get list of birth day employee with query search",
     *     security={
     *          {
     *              "apiKey": {"*"}
     *          }
     *     },
     *     @OA\RequestBody(
     *          required=true,
     *          @OA\MediaType(
     *              mediaType="application/json",
     *              @OA\Schema(
     *                  @OA\Property(
     *                      property="query",
     *                      description="Query property (Keyword would be filter nik, full name, nick name, birth place, address, phone, mobile, email, identity number, identity address, drive license a number, drive license b number, drive license c number, npwp number, bpjs tenaga kerja number, bpjs kesehatan number, mate bpjs kesehatan number, dplk number, collective number, account number)",
     *                      type="string"
     *                  ),
     *                  @OA\Property(property="company_id", ref="#/components/schemas/EmployeeEloquent/properties/company_id"),
     *                  @OA\Property(property="office_id", ref="#/components/schemas/EmployeeEloquent/properties/office_id"),
     *                  @OA\Property(
     *                      property="month",
     *                      description="Month parameter",
     *                      type="integer",
     *                      format="int32",
     *                      example=1
     *                  )
     *              )
     *          )
     *     ),
     *     @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *          @OA\JsonContent()
     *     ),
     *     @OA\Response(
     *          response=400,
     *          description="Bad request",
     *          @OA\JsonContent()
     *     ),
     *     @OA\Response(
     *          response=401,
     *          description="Unauthenticated",
     *          @OA\JsonContent()
     *     )
     * )
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function postEmployeeBirthDayListSearch(Request $request)
    {
        $companyId = $request->input('company_id');
        $officeId = $request->input('office_id');
        $month = $request->input('month');

        return $this->getListSearchJsonEmployeeBithday($request, $companyId, $officeId, $month,
            [$this->_employeeServiceInterface, 'employeeBirthDayListSearch'],
            function (Collection $entities) {
                $rowJsonData = new Collection();

                foreach ($entities as $entity) {
                    $rowJsonData->push([
                        'id' => $entity->id,
                        'company' => Common::isDataExist($entity->company) ? $this->getCompanyObject($entity->company) : null,
                        'nip' => $entity->nip,
                        'full_name' => $entity->full_name,
                        'nick_name' => $entity->nick_name,
                        'gender' => Common::isDataExist($entity->gender) ? $this->getGenderObject($entity->gender) : null,
                        'religion'=> Common::isDataExist($entity->religion) ? $this->getReligionObject($entity->religion) : null,
                        'birth_place' => $entity->birth_place,
                        'birth_date' => $entity->birth_date,
                        'address' => $entity->address,
                        'phone' => $entity->phone,
                        'email' => $entity->email,
                        'mobile' => $entity->mobile,
                        'identity_number' => $entity->identity_number,
                        'identity_expired_date' => $entity->identity_expired_date,
                        'identity_address' => $entity->identity_address,
                        'has_drive_license_a' => $entity->has_drive_license_a,
                        'drive_license_a_number' => $entity->drive_license_a_number,
                        'drive_license_a_date' => $entity->drive_license_a_date,
                        'has_drive_license_b' => $entity->has_drive_license_b,
                        'drive_license_b_number' => $entity->drive_license_b_number,
                        'drive_license_b_date' => $entity->drive_license_b_date,
                        'has_drive_license_c' => $entity->has_drive_license_c,
                        'drive_license_c_number' => $entity->drive_license_c_number,
                        'drive_license_c_date' => $entity->drive_license_c_date,
                        'marital_status'=> Common::isDataExist($entity->maritalStatus) ? $this->getMaritalStatusObject($entity->maritalStatus) : null,
                        'mate_as' => $entity->mate_as,
                        'mate_first_name' => $entity->mate_first_name,
                        'mate_last_name' => $entity->mate_last_name,
                        'mate_birth_place' => $entity->mate_birth_place,
                        'mate_birth_date' => $entity->mate_birth_date,
                        'mate_occupation' => $entity->mate_occupation,
                        'office'=> Common::isDataExist($entity->office) ? $this->getOfficeObject($entity->office) : null,
                        'work_area'=> Common::isDataExist($entity->workArea) ? $this->getWorkAreaObject($entity->workArea) : null,
                        'has_npwp' => $entity->has_npwp,
                        'npwp_number' => $entity->npwp_number,
                        'npwp_date' => $entity->npwp_date,
                        'npwp_status' => $entity->npwp_status,
                        'has_bpjs_tenaga_kerja' => $entity->has_bpjs_tenaga_kerja,
                        'bpjs_tenaga_kerja_number' => $entity->bpjs_tenaga_kerja_number,
                        'bpjs_tenaga_kerja_date' => $entity->bpjs_tenaga_kerja_date,
                        'bpjs_tenaga_kerja_class' => $entity->bpjs_tenaga_kerja_class,
                        'has_bpjs_kesehatan' => $entity->has_bpjs_kesehatan,
                        'bpjs_kesehatan_number' => $entity->bpjs_kesehatan_number,
                        'bpjs_kesehatan_date' => $entity->bpjs_kesehatan_date,
                        'bpjs_kesehatan_class' => $entity->bpjs_kesehatan_class,
                        'dplk_number' => $entity->dplk_number,
                        'collective_number' => $entity->collective_number,
                        'english_ability' => $entity->english_ability,
                        'computer_ability' => $entity->computer_ability,
                        'other_ability' => $entity->other_ability,
                        'bank'=> Common::isDataExist($entity->bank) ? $this->getBankObject($entity->bank) : null,
                        'account_number' => $entity->account_number,
                        'join_date' => $entity->join_date,
                        'work_status' => $entity->work_status,
                        'work_type' => $entity->work_type,
                        'created_by' => $entity->created_by,
                        'modified_by' => $entity->modified_by,
                        'media_libraries' => $entity->mediaLibraries
                    ]);
                }

                return $rowJsonData;
            });
    }



    /**
     * @OA\Post(
     *     path="/employee/page-search",
     *     operationId="postEmployeePageSearch",
     *     summary="Get list of employee with query and page parameter search",
     *     tags={"Employee"},
     *     description="Get list of employee with query and page parameter search",
     *     security={
     *          {
     *              "apiKey": {"*"}
     *          }
     *     },
     *     @OA\RequestBody(
     *          required=true,
     *          @OA\MediaType(
     *              mediaType="application/json",
     *              @OA\Schema(
     *                  allOf={
     *                      @OA\Schema(
     *                          @OA\Property(
     *                              property="query",
     *                              description="Query property (Keyword would be filter nik, full name, nick name, birth place, address, phone, mobile, email, identity number, identity address, drive license a number, drive license b number, drive license c number, npwp number, bpjs tenaga kerja number, bpjs kesehatan number, mate bpjs kesehatan number, dplk number, collective number, account number)",
     *                              type="object",
     *                              @OA\Property(
     *                                  property="value",
     *                                  type="string",
     *                                  example="keyword"
     *                              )
     *                          ),
     *                          @OA\Property(property="company_id", ref="#/components/schemas/EmployeeEloquent/properties/company_id"),
     *                          @OA\Property(property="gender_id", ref="#/components/schemas/EmployeeEloquent/properties/gender_id"),
     *                          @OA\Property(property="religion_id", ref="#/components/schemas/EmployeeEloquent/properties/religion_id"),
     *                          @OA\Property(
     *                              property="start_birth_date",
     *                              description="Start birth date property",
     *                              type="string",
     *                              format="date-time",
     *                              example="2020-01-01 00:00:00"
     *                          ),
     *                          @OA\Property(
     *                              property="end_birth_date",
     *                              description="End birth date property",
     *                              type="string",
     *                              format="date-time",
     *                              example="2020-01-01 00:00:00"
     *                          ),
     *                          @OA\Property(
     *                              property="start_identity_expired_date",
     *                              description="Start identity expired date property",
     *                              type="string",
     *                              format="date-time",
     *                              example="2020-01-01 00:00:00"
     *                          ),
     *                          @OA\Property(
     *                              property="end_identity_expired_date",
     *                              description="End identity expired date property",
     *                              type="string",
     *                              format="date-time",
     *                              example="2020-01-01 00:00:00"
     *                          ),
     *                          @OA\Property(
     *                              property="start_drive_license_a_date",
     *                              description="Start drive license a date property",
     *                              type="string",
     *                              format="date-time",
     *                              example="2020-01-01 00:00:00"
     *                          ),
     *                          @OA\Property(
     *                              property="end_drive_license_a_date",
     *                              description="End drive license a date property",
     *                              type="string",
     *                              format="date-time",
     *                              example="2020-01-01 00:00:00"
     *                          ),
     *                          @OA\Property(
     *                              property="start_drive_license_b_date",
     *                              description="Start drive license b date property",
     *                              type="string",
     *                              format="date-time",
     *                              example="2020-01-01 00:00:00"
     *                          ),
     *                          @OA\Property(
     *                              property="end_drive_license_b_date",
     *                              description="End drive license b date property",
     *                              type="string",
     *                              format="date-time",
     *                              example="2020-01-01 00:00:00"
     *                          ),
     *                          @OA\Property(
     *                              property="start_drive_license_c_date",
     *                              description="Start drive license c date property",
     *                              type="string",
     *                              format="date-time",
     *                              example="2020-01-01 00:00:00"
     *                          ),
     *                          @OA\Property(
     *                              property="end_drive_license_c_date",
     *                              description="End drive license c date property",
     *                              type="string",
     *                              format="date-time",
     *                              example="2020-01-01 00:00:00"
     *                          ),
     *                          @OA\Property(property="marital_status_id", ref="#/components/schemas/EmployeeEloquent/properties/marital_status_id"),
     *                          @OA\Property(property="mate_as", ref="#/components/schemas/EmployeeEloquent/properties/mate_as"),
     *                          @OA\Property(
     *                              property="start_mate_birth_date",
     *                              description="Start mate birth date property",
     *                              type="string",
     *                              format="date-time",
     *                              example="2020-01-01 00:00:00"
     *                          ),
     *                          @OA\Property(
     *                              property="end_mate_birth_date",
     *                              description="End mate birth date property",
     *                              type="string",
     *                              format="date-time",
     *                              example="2020-01-01 00:00:00"
     *                          ),
     *                          @OA\Property(property="office_id", ref="#/components/schemas/EmployeeEloquent/properties/office_id"),
     *                          @OA\Property(property="work_area_id", ref="#/components/schemas/EmployeeEloquent/properties/work_area_id"),
     *                          @OA\Property(
     *                              property="start_npwp_date",
     *                              description="Start npwp date property",
     *                              type="string",
     *                              format="date-time",
     *                              example="2020-01-01 00:00:00"
     *                          ),
     *                          @OA\Property(
     *                              property="end_npwp_date",
     *                              description="End npwp date property",
     *                              type="string",
     *                              format="date-time",
     *                              example="2020-01-01 00:00:00"
     *                          ),
     *                          @OA\Property(property="npwp_status", ref="#/components/schemas/EmployeeEloquent/properties/npwp_status"),
     *                          @OA\Property(
     *                              property="start_bpjs_tenaga_kerja_date",
     *                              description="Start bpjs tenaga kerja date property",
     *                              type="string",
     *                              format="date-time",
     *                              example="2020-01-01 00:00:00"
     *                          ),
     *                          @OA\Property(
     *                              property="end_bpjs_tenaga_kerja_date",
     *                              description="End bpjs tenaga kerja date property",
     *                              type="string",
     *                              format="date-time",
     *                              example="2020-01-01 00:00:00"
     *                          ),
     *                          @OA\Property(property="bpjs_tenaga_kerja_class", ref="#/components/schemas/EmployeeEloquent/properties/bpjs_tenaga_kerja_class"),
     *                          @OA\Property(
     *                              property="start_bpjs_kesehatan_date",
     *                              description="Start bpjs kesehatan date property",
     *                              type="string",
     *                              format="date-time",
     *                              example="2020-01-01 00:00:00"
     *                          ),
     *                          @OA\Property(
     *                              property="end_bpjs_kesehatan_date",
     *                              description="End bpjs kesehatan date property",
     *                              type="string",
     *                              format="date-time",
     *                              example="2020-01-01 00:00:00"
     *                          ),
     *                          @OA\Property(property="bpjs_kesehatan_class", ref="#/components/schemas/EmployeeEloquent/properties/bpjs_kesehatan_class"),
     *                          @OA\Property(
     *                              property="start_mate_bpjs_kesehatan_date",
     *                              description="Start mate bpjs kesehatan date property",
     *                              type="string",
     *                              format="date-time",
     *                              example="2020-01-01 00:00:00"
     *                          ),
     *                          @OA\Property(
     *                              property="end_mate_bpjs_kesehatan_date",
     *                              description="End mate bpjs kesehatan date property",
     *                              type="string",
     *                              format="date-time",
     *                              example="2020-01-01 00:00:00"
     *                          ),
     *                          @OA\Property(property="mate_bpjs_kesehatan_class", ref="#/components/schemas/EmployeeEloquent/properties/mate_bpjs_kesehatan_class"),
     *                          @OA\Property(property="bank_id", ref="#/components/schemas/EmployeeEloquent/properties/bank_id"),
     *                          @OA\Property(
     *                              property="start_join_date",
     *                              description="Start join date property",
     *                              type="string",
     *                              format="date-time",
     *                              example="2020-01-01 00:00:00"
     *                          ),
     *                          @OA\Property(
     *                              property="end_join_date",
     *                              description="End join date property",
     *                              type="string",
     *                              format="date-time",
     *                              example="2020-01-01 00:00:00"
     *                          ),
     *                          @OA\Property(property="work_status", ref="#/components/schemas/EmployeeEloquent/properties/work_status"),
     *                          @OA\Property(property="work_type", ref="#/components/schemas/EmployeeEloquent/properties/work_type"),
     *                          @OA\Property(property="degree_id", ref="#/components/schemas/FormalEducationHistoryEloquent/properties/degree_id"),
     *                          @OA\Property(property="major_id", ref="#/components/schemas/FormalEducationHistoryEloquent/properties/major_id"),
     *                          @OA\Property(property="competence_id", ref="#/components/schemas/WorkCompetenceEloquent/properties/competence_id"),
     *                          @OA\Property(property="position_id", ref="#/components/schemas/PositionMutationEloquent/properties/position_id"),
     *                          @OA\Property(property="project_id", ref="#/components/schemas/ProjectMutationEloquent/properties/project_id"),
     *                          @OA\Property(property="work_unit_id", ref="#/components/schemas/WorkUnitMutationEloquent/properties/work_unit_id"),
     *                      ),
     *                      @OA\Schema(ref="#/components/schemas/PagedSearchParameter")
     *                  }
     *              )
     *          )
     *     ),
     *     @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *          @OA\JsonContent()
     *     ),
     *     @OA\Response(
     *          response=400,
     *          description="Bad request",
     *          @OA\JsonContent()
     *     ),
     *     @OA\Response(
     *          response=401,
     *          description="Unauthenticated",
     *          @OA\JsonContent()
     *     )
     * )
     *
     * @param Request $request
     * @return mixed
     */
    public function postEmployeePageSearch(Request $request)
    {
        $companyId = $request->input('company_id');
        $genderId = $request->input('gender_id');
        $religionId = $request->input('religion_id');

        $rangeBirthDate = new DateTimeRange($request->input('start_birth_date'), $request->input('end_birth_date'));
        $rangeIdentityExpiredDate = new DateTimeRange($request->input('start_identity_expired_date'), $request->input('end_identity_expired_date'));
        $rangeDriveLicenseADate = new DateTimeRange($request->input('start_drive_license_a_date'), $request->input('end_drive_license_a_date'));
        $rangeDriveLicenseBDate = new DateTimeRange($request->input('start_drive_license_b_date'), $request->input('end_drive_license_b_date'));
        $rangeDriveLicenseCDate = new DateTimeRange($request->input('start_drive_license_c_date'), $request->input('end_drive_license_c_date'));

        $maritalStatusId = $request->input('marital_status_id');

        $mateAs = $request->input('mate_as');
        $rangeMateBirthDate = new DateTimeRange($request->input('start_mate_birth_date'), $request->input('end_mate_birth_date'));

        $officeId = $request->input('office_id');
        $workAreaId = $request->input('work_area_id');

        $rangeNPWPDate = new DateTimeRange($request->input('start_npwp_date'), $request->input('end_npwp_date'));
        $npwpStatus = $request->input('npwp_status');
        $rangeBPJSTenagaKerjaDate = new DateTimeRange($request->input('start_bpjs_tenaga_kerja_date'), $request->input('end_bpjs_tenaga_kerja_date'));
        $bpjsTenagaKerjaClass = $request->input('bpjs_tenaga_kerja_class');
        $rangeBPJSKesehatanDate = new DateTimeRange($request->input('start_bpjs_kesehatan_date'), $request->input('end_bpjs_kesehatan_date'));
        $bpjsKesehatanClass = $request->input('bpjs_kesehatan_class');
        $rangeMateBPJSKesehatanDate = new DateTimeRange($request->input('start_mate_bpjs_kesehatan_date'), $request->input('end_mate_bpjs_kesehatan_date'));
        $mateBPJSKesehatanClass = $request->input('bpjs_mate_kesehatan_class');

        $bankId = $request->input('bank_id');

        $rangeJoinDate = new DateTimeRange($request->input('start_join_date'), $request->input('end_join_date'));
        $workStatus = $request->input('work_status');
        $workType = $request->input('work_type');

        $degreeId = $request->input('degree_id');
        $majorId = $request->input('major_id');
        $competenceId = $request->input('competence_id');
        $positionId = $request->input('position_id');
        $projectId = $request->input('project_id');
        $workUnitId = $request->input('work_unit_id');

        return $this->getPagedSearchJson($request,
            [$this->_employeeServiceInterface, 'employeePageSearch'],
            function (Collection $entities) {
                $rowJsonData = new Collection();

                foreach ($entities as $entity) {
                    $rowJsonData->push([
                        'id' => $entity->id,
                        'company' => Common::isDataExist($entity->company) ? $this->getCompanyObject($entity->company) : null,
                        'nip' => $entity->nip,
                        'full_name' => $entity->full_name,
                        'nick_name' => $entity->nick_name,
                        'gender' => Common::isDataExist($entity->gender) ? $this->getGenderObject($entity->gender) : null,
                        'religion'=> Common::isDataExist($entity->religion) ? $this->getReligionObject($entity->religion) : null,
                        'birth_place' => $entity->birth_place,
                        'birth_date' => $entity->birth_date,
                        'address' => $entity->address,
                        'phone' => $entity->phone,
                        'email' => $entity->email,
                        'mobile' => $entity->mobile,
                        'identity_number' => $entity->identity_number,
                        'identity_expired_date' => $entity->identity_expired_date,
                        'identity_address' => $entity->identity_address,
                        'has_drive_license_a' => $entity->has_drive_license_a,
                        'drive_license_a_number' => $entity->drive_license_a_number,
                        'drive_license_a_date' => $entity->drive_license_a_date,
                        'has_drive_license_b' => $entity->has_drive_license_b,
                        'drive_license_b_number' => $entity->drive_license_b_number,
                        'drive_license_b_date' => $entity->drive_license_b_date,
                        'has_drive_license_c' => $entity->has_drive_license_c,
                        'drive_license_c_number' => $entity->drive_license_c_number,
                        'drive_license_c_date' => $entity->drive_license_c_date,
                        'marital_status'=> Common::isDataExist($entity->maritalStatus) ? $this->getMaritalStatusObject($entity->maritalStatus) : null,
                        'mate_as' => $entity->mate_as,
                        'mate_full_name' => $entity->mate_full_name,
                        'mate_nick_name' => $entity->mate_nick_name,
                        'mate_birth_place' => $entity->mate_birth_place,
                        'mate_birth_date' => $entity->mate_birth_date,
                        'mate_occupation' => $entity->mate_occupation,
                        'office'=> Common::isDataExist($entity->office) ? $this->getOfficeObject($entity->office) : null,
                        'work_area'=> Common::isDataExist($entity->workArea) ? $this->getWorkAreaObject($entity->workArea) : null,
                        'has_npwp' => $entity->has_npwp,
                        'npwp_number' => $entity->npwp_number,
                        'npwp_date' => $entity->npwp_date,
                        'npwp_status' => $entity->npwp_status,
                        'has_bpjs_tenaga_kerja' => $entity->has_bpjs_tenaga_kerja,
                        'bpjs_tenaga_kerja_number' => $entity->bpjs_tenaga_kerja_number,
                        'bpjs_tenaga_kerja_date' => $entity->bpjs_tenaga_kerja_date,
                        'bpjs_tenaga_kerja_class' => $entity->bpjs_tenaga_kerja_class,
                        'has_bpjs_kesehatan' => $entity->has_bpjs_kesehatan,
                        'bpjs_kesehatan_number' => $entity->bpjs_kesehatan_number,
                        'bpjs_kesehatan_date' => $entity->bpjs_kesehatan_date,
                        'bpjs_kesehatan_class' => $entity->bpjs_kesehatan_class,

                        'has_mate_bpjs_kesehatan' => $entity->has_mate_bpjs_kesehatan,
                        'mate_bpjs_kesehatan_number' => $entity->mate_bpjs_kesehatan_number,
                        'mate_bpjs_kesehatan_date' => $entity->mate_bpjs_kesehatan_date,
                        'mate_bpjs_kesehatan_class' => $entity->mate_bpjs_kesehatan_class,

                        'dplk_number' => $entity->dplk_number,
                        'collective_number' => $entity->collective_number,
                        'english_ability' => $entity->english_ability,
                        'computer_ability' => $entity->computer_ability,
                        'other_ability' => $entity->other_ability,
                        'bank'=> Common::isDataExist($entity->bank) ? $this->getBankObject($entity->bank) : null,
                        'account_number' => $entity->account_number,
                        'join_date' => $entity->join_date,
                        'work_status' => $entity->work_status,
                        'work_type' => $entity->work_type,

                        'created_by' => $entity->created_by,
                        'modified_by' => $entity->modified_by,

                        'work_unit_mutations' => $entity->workUnitMutations,
                        'media_libraries' => $entity->morphMediaLibraries
                    ]);
                }

                return $rowJsonData;
            }, $companyId, $genderId, $religionId, $rangeBirthDate, $rangeIdentityExpiredDate,
            $rangeDriveLicenseADate, $rangeDriveLicenseBDate, $rangeDriveLicenseCDate, $maritalStatusId, $mateAs,
            $rangeMateBirthDate, $officeId, $workAreaId, $rangeNPWPDate, $npwpStatus,
            $rangeBPJSTenagaKerjaDate, $bpjsTenagaKerjaClass, $rangeBPJSKesehatanDate, $bpjsKesehatanClass, $rangeMateBPJSKesehatanDate,
            $mateBPJSKesehatanClass, $bankId, $rangeJoinDate, $workStatus, $workType, $degreeId, $majorId,
            $competenceId, $positionId, $projectId, $workUnitId);
    }

    /**
     * @OA\Post(
     *     path="/employee/terminated/page-search",
     *     operationId="postEmployeeTerminatedPageSearch",
     *     summary="Get list of terminated employee with query and page parameter search",
     *     tags={"Employee"},
     *     description="Get list of terminated employee with query and page parameter search",
     *     security={
     *          {
     *              "apiKey": {"*"}
     *          }
     *     },
     *     @OA\RequestBody(
     *          required=true,
     *          @OA\MediaType(
     *              mediaType="application/json",
     *              @OA\Schema(
     *                  allOf={
     *                      @OA\Schema(
     *                          @OA\Property(
     *                              property="query",
     *                              description="Query property (Keyword would be filter nik, full name, nick name, birth place, address, phone, mobile, email, identity number, identity address, drive license a number, drive license b number, drive license c number, npwp number, bpjs tenaga kerja number, bpjs kesehatan number, mate bpjs kesehatan number, dplk number, collective number, account number)",
     *                              type="object",
     *                              @OA\Property(
     *                                  property="value",
     *                                  type="string",
     *                                  example="keyword"
     *                              )
     *                          ),
     *                          @OA\Property(property="company_id", ref="#/components/schemas/EmployeeEloquent/properties/company_id"),
     *                          @OA\Property(property="office_id", ref="#/components/schemas/EmployeeEloquent/properties/office_id"),
     *                          @OA\Property(
     *                              property="start_termination_date",
     *                              description="Start termination date parameter",
     *                              type="string",
     *                              format="date-time",
     *                              example="2020-01-01 00:00:00"
     *                          ),
     *                          @OA\Property(
     *                              property="end_termination_date",
     *                              description="End termination date parameter",
     *                              type="string",
     *                              format="date-time",
     *                              example="2020-01-01 00:00:00"
     *                          ),
     *                      ),
     *                      @OA\Schema(ref="#/components/schemas/PagedSearchParameter")
     *                  }
     *              )
     *          )
     *     ),
     *     @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *          @OA\JsonContent()
     *     ),
     *     @OA\Response(
     *          response=400,
     *          description="Bad request",
     *          @OA\JsonContent()
     *     ),
     *     @OA\Response(
     *          response=401,
     *          description="Unauthenticated",
     *          @OA\JsonContent()
     *     )
     * )
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function postEmployeeTerminatedPageSearch(Request $request)
    {
        $companyId = $request->get('company_id');
        $officeId = $request->get('office_id');
        $rangeTerminationDate = new DateTimeRange($request->input('start_termination_date'), $request->input('end_termination_date'));

        return $this->getPageSearchJsonEmployeeTerminated($request, $companyId, $officeId, $rangeTerminationDate,
            [$this->_employeeServiceInterface, 'employeeTerminatedPageSearch'],
            function (Collection $entities) {
                $rowJsonData = new Collection();

                foreach ($entities as $entity) {
                    $rowJsonData->push([
                        'id' => $entity->id,
                        'company' => Common::isDataExist($entity->company) ? $this->getCompanyObject($entity->company) : null,
                        'nip' => $entity->nip,
                        'full_name' => $entity->full_name,
                        'nick_name' => $entity->nick_name,
                        'gender' => Common::isDataExist($entity->gender) ? $this->getGenderObject($entity->gender) : null,
                        'religion'=> Common::isDataExist($entity->religion) ? $this->getReligionObject($entity->religion) : null,
                        'birth_place' => $entity->birth_place,
                        'birth_date' => $entity->birth_date,
                        'address' => $entity->address,
                        'phone' => $entity->phone,
                        'email' => $entity->email,
                        'mobile' => $entity->mobile,
                        'identity_number' => $entity->identity_number,
                        'identity_date_expired' => $entity->identity_date_expired,
                        'identity_address' => $entity->identity_address,
                        'has_drive_license_a' => $entity->has_drive_license_a,
                        'drive_license_a_number' => $entity->drive_license_a_number,
                        'drive_license_a_date' => $entity->drive_license_a_date,
                        'has_drive_license_b' => $entity->has_drive_license_b,
                        'drive_license_b_number' => $entity->drive_license_b_number,
                        'drive_license_b_date' => $entity->drive_license_b_date,
                        'has_drive_license_c' => $entity->has_drive_license_c,
                        'drive_license_c_number' => $entity->drive_license_c_number,
                        'drive_license_c_date' => $entity->drive_license_c_date,
                        'marital_status'=> Common::isDataExist($entity->maritalStatus) ? $this->getMaritalStatusObject($entity->maritalStatus) : null,
                        'mate_as' => $entity->mate_as,
                        'mate_first_name' => $entity->mate_first_name,
                        'mate_last_name' => $entity->mate_last_name,
                        'mate_birth_place' => $entity->mate_birth_place,
                        'mate_birth_date' => $entity->mate_birth_date,
                        'mate_occupation' => $entity->mate_occupation,
                        'office'=> Common::isDataExist($entity->office) ? $this->getOfficeObject($entity->office) : null,
                        'work_area'=> Common::isDataExist($entity->workArea) ? $this->getWorkAreaObject($entity->workArea) : null,
                        'has_npwp' => $entity->has_npwp,
                        'npwp_number' => $entity->npwp_number,
                        'npwp_date' => $entity->npwp_date,
                        'npwp_status' => $entity->npwp_status,
                        'has_bpjs_tenaga_kerja' => $entity->has_bpjs_tenaga_kerja,
                        'bpjs_tenaga_kerja_number' => $entity->bpjs_tenaga_kerja_number,
                        'bpjs_tenaga_kerja_date' => $entity->bpjs_tenaga_kerja_date,
                        'bpjs_tenaga_kerja_class' => $entity->bpjs_tenaga_kerja_class,
                        'has_bpjs_kesehatan' => $entity->has_bpjs_kesehatan,
                        'bpjs_kesehatan_number' => $entity->bpjs_kesehatan_number,
                        'bpjs_kesehatan_date' => $entity->bpjs_kesehatan_date,
                        'bpjs_kesehatan_class' => $entity->bpjs_kesehatan_class,
                        'dplk_number' => $entity->dplk_number,
                        'collective_number' => $entity->collective_number,
                        'english_ability' => $entity->english_ability,
                        'computer_ability' => $entity->computer_ability,
                        'other_ability' => $entity->other_ability,
                        'bank'=> Common::isDataExist($entity->bank) ? $this->getBankObject($entity->bank) : null,
                        'account_number' => $entity->account_number,
                        'join_date' => $entity->join_date,
                        'work_status' => $entity->work_status,
                        'work_type' => $entity->work_type,
                        'created_by' => $entity->created_by,
                        'modified_by' => $entity->modified_by,
                        'media_libraries' => $entity->mediaLibraries
                    ]);
                }

                return $rowJsonData;
            });
    }

    /**
     * @OA\Post(
     *     path="/employee/birth-day/page-search",
     *     operationId="postEmployeeBirthDayPageSearch",
     *     summary="Get list of birth day employee with query and page parameter search",
     *     tags={"Employee"},
     *     description="Get list of birth day employee with query and page parameter search",
     *     security={
     *          {
     *              "apiKey": {"*"}
     *          }
     *     },
     *     @OA\RequestBody(
     *          required=true,
     *          @OA\MediaType(
     *              mediaType="application/json",
     *              @OA\Schema(
     *                  allOf={
     *                      @OA\Schema(
     *                          @OA\Property(
     *                              property="query",
     *                              description="Query property (Keyword would be filter nik, full name, nick name, birth place, address, phone, mobile, email, identity number, identity address, drive license a number, drive license b number, drive license c number, npwp number, bpjs tenaga kerja number, bpjs kesehatan number, mate bpjs kesehatan number, dplk number, collective number, account number)",
     *                              type="object",
     *                              @OA\Property(
     *                                  property="value",
     *                                  type="string",
     *                                  example="keyword"
     *                              )
     *                          ),
     *                          @OA\Property(property="company_id", ref="#/components/schemas/EmployeeEloquent/properties/company_id"),
     *                          @OA\Property(property="office_id", ref="#/components/schemas/EmployeeEloquent/properties/office_id"),
     *                          @OA\Property(
     *                              property="month",
     *                              description="Filter month of employee by month parameter",
     *                              type="integer",
     *                              format="int32"
     *                          ),
     *                      ),
     *                      @OA\Schema(ref="#/components/schemas/PagedSearchParameter")
     *                  }
     *              )
     *          )
     *     ),
     *     @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *          @OA\JsonContent()
     *     ),
     *     @OA\Response(
     *          response=400,
     *          description="Bad request",
     *          @OA\JsonContent()
     *     ),
     *     @OA\Response(
     *          response=401,
     *          description="Unauthenticated",
     *          @OA\JsonContent()
     *     )
     * )
     * 
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function postEmployeeBirthDayPageSearch(Request $request)
    {
        $companyId = $request->get('company_id');
        $officeId = $request->get('office_id');
        $month = $request->get('month');

        return $this->getPageSearchJsonEmployeeBithday($request, $companyId, $officeId, $month,
            [$this->_employeeServiceInterface, 'employeeHasTerminationPageSearch'],
            function (Collection $entities) {
                $rowJsonData = new Collection();

                foreach ($entities as $entity) {
                    $rowJsonData->push([
                        'id' => $entity->id,
                        'company' => Common::isDataExist($entity->company) ? $this->getCompanyObject($entity->company) : null,
                        'nip' => $entity->nip,
                        'full_name' => $entity->full_name,
                        'nick_name' => $entity->nick_name,
                        'gender' => Common::isDataExist($entity->gender) ? $this->getGenderObject($entity->gender) : null,
                        'religion'=> Common::isDataExist($entity->religion) ? $this->getReligionObject($entity->religion) : null,
                        'birth_place' => $entity->birth_place,
                        'birth_date' => $entity->birth_date,
                        'address' => $entity->address,
                        'phone' => $entity->phone,
                        'email' => $entity->email,
                        'mobile' => $entity->mobile,
                        'identity_number' => $entity->identity_number,
                        'identity_expired_date' => $entity->identity_expired_date,
                        'identity_address' => $entity->identity_address,
                        'has_drive_license_a' => $entity->has_drive_license_a,
                        'drive_license_a_number' => $entity->drive_license_a_number,
                        'drive_license_a_date' => $entity->drive_license_a_date,
                        'has_drive_license_b' => $entity->has_drive_license_b,
                        'drive_license_b_number' => $entity->drive_license_b_number,
                        'drive_license_b_date' => $entity->drive_license_b_date,
                        'has_drive_license_c' => $entity->has_drive_license_c,
                        'drive_license_c_number' => $entity->drive_license_c_number,
                        'drive_license_c_date' => $entity->drive_license_c_date,
                        'marital_status'=> Common::isDataExist($entity->maritalStatus) ? $this->getMaritalStatusObject($entity->maritalStatus) : null,
                        'mate_as' => $entity->mate_as,
                        'mate_first_name' => $entity->mate_first_name,
                        'mate_last_name' => $entity->mate_last_name,
                        'mate_birth_place' => $entity->mate_birth_place,
                        'mate_birth_date' => $entity->mate_birth_date,
                        'mate_occupation' => $entity->mate_occupation,
                        'office'=> Common::isDataExist($entity->office) ? $this->getOfficeObject($entity->office) : null,
                        'work_area'=> Common::isDataExist($entity->workArea) ? $this->getWorkAreaObject($entity->workArea) : null,
                        'has_npwp' => $entity->has_npwp,
                        'npwp_number' => $entity->npwp_number,
                        'npwp_date' => $entity->npwp_date,
                        'npwp_status' => $entity->npwp_status,
                        'has_bpjs_tenaga_kerja' => $entity->has_bpjs_tenaga_kerja,
                        'bpjs_tenaga_kerja_number' => $entity->bpjs_tenaga_kerja_number,
                        'bpjs_tenaga_kerja_date' => $entity->bpjs_tenaga_kerja_date,
                        'bpjs_tenaga_kerja_class' => $entity->bpjs_tenaga_kerja_class,
                        'has_bpjs_kesehatan' => $entity->has_bpjs_kesehatan,
                        'bpjs_kesehatan_number' => $entity->bpjs_kesehatan_number,
                        'bpjs_kesehatan_date' => $entity->bpjs_kesehatan_date,
                        'bpjs_kesehatan_class' => $entity->bpjs_kesehatan_class,
                        'dplk_number' => $entity->dplk_number,
                        'collective_number' => $entity->collective_number,
                        'english_ability' => $entity->english_ability,
                        'computer_ability' => $entity->computer_ability,
                        'other_ability' => $entity->other_ability,
                        'bank'=> Common::isDataExist($entity->bank) ? $this->getBankObject($entity->bank) : null,
                        'account_number' => $entity->account_number,
                        'join_date' => $entity->join_date,
                        'work_status' => $entity->work_status,
                        'work_type' => $entity->work_type,
                        'created_by' => $entity->created_by,
                        'modified_by' => $entity->modified_by,
                        'media_libraries' => $entity->mediaLibraries
                    ]);
                }

                return $rowJsonData;
            });
    }

    /**
     * @OA\Post(
     *     path="/employee/office/list-search",
     *     operationId="postEmployeeGroupByOffice",
     *     summary="Get list of employee by office",
     *     tags={"Employee"},
     *     description="Get list of employee by office",
     *     security={
     *          {
     *              "apiKey": {"*"}
     *          }
     *     },
     *     @OA\RequestBody(
     *          required=true,
     *          @OA\MediaType(
     *              mediaType="application/json",
     *              @OA\Schema(
     *                  allOf={
     *                      @OA\Schema(
     *                          @OA\Property(property="company_id", ref="#/components/schemas/EmployeeEloquent/properties/company_id"),
     *                      ),
     *                  }
     *              )
     *          )
     *     ),
     *     @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *          @OA\JsonContent()
     *     ),
     *     @OA\Response(
     *          response=400,
     *          description="Bad request",
     *          @OA\JsonContent()
     *     ),
     *     @OA\Response(
     *          response=401,
     *          description="Unauthenticated",
     *          @OA\JsonContent()
     *     )
     * )
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function postEmployeeGroupByOffice(Request $request)
    {
          $companyId = $request->get('company_id');

          return $this->getEmployeeListGroupByOffice($request, $companyId,
               [$this->_employeeServiceInterface, 'employeeGroupByOfficeListSearch'],
               function (Collection $entities) {
                    $rowJsonData = collect([]);

                    foreach ($entities as $i => $data) {
                         $result = collect([]);
                         foreach ($data as $j => $entity) {
                              $result->put($j, [
                                   'id' => $entity->id,
                                   'company' => Common::isDataExist($entity->company) ? $this->getCompanyObject($entity->company) : null,
                                   'nip' => $entity->nip,
                                   'full_name' => $entity->full_name,
                                   'nick_name' => $entity->nick_name,
                                   'gender' => Common::isDataExist($entity->gender) ? $this->getGenderObject($entity->gender) : null,
                                   'religion'=> Common::isDataExist($entity->religion) ? $this->getReligionObject($entity->religion) : null,
                                   'birth_place' => $entity->birth_place,
                                   'birth_date' => $entity->birth_date,
                                   'address' => $entity->address,
                                   'phone' => $entity->phone,
                                   'email' => $entity->email,
                                   'mobile' => $entity->mobile,
                                   'identity_number' => $entity->identity_number,
                                   'identity_expired_date' => $entity->identity_expired_date,
                                   'identity_address' => $entity->identity_address,
                                   'has_drive_license_a' => $entity->has_drive_license_a,
                                   'drive_license_a_number' => $entity->drive_license_a_number,
                                   'drive_license_a_date' => $entity->drive_license_a_date,
                                   'has_drive_license_b' => $entity->has_drive_license_b,
                                   'drive_license_b_number' => $entity->drive_license_b_number,
                                   'drive_license_b_date' => $entity->drive_license_b_date,
                                   'has_drive_license_c' => $entity->has_drive_license_c,
                                   'drive_license_c_number' => $entity->drive_license_c_number,
                                   'drive_license_c_date' => $entity->drive_license_c_date,
                                   'marital_status'=> Common::isDataExist($entity->maritalStatus) ? $this->getMaritalStatusObject($entity->maritalStatus) : null,
                                   'mate_as' => $entity->mate_as,
                                   'mate_first_name' => $entity->mate_first_name,
                                   'mate_last_name' => $entity->mate_last_name,
                                   'mate_birth_place' => $entity->mate_birth_place,
                                   'mate_birth_date' => $entity->mate_birth_date,
                                   'mate_occupation' => $entity->mate_occupation,
                                   'office'=> Common::isDataExist($entity->office) ? $this->getOfficeObject($entity->office) : null,
                                   'work_area'=> Common::isDataExist($entity->workArea) ? $this->getWorkAreaObject($entity->workArea) : null,
                                   'has_npwp' => $entity->has_npwp,
                                   'npwp_number' => $entity->npwp_number,
                                   'npwp_date' => $entity->npwp_date,
                                   'npwp_status' => $entity->npwp_status,
                                   'has_bpjs_tenaga_kerja' => $entity->has_bpjs_tenaga_kerja,
                                   'bpjs_tenaga_kerja_number' => $entity->bpjs_tenaga_kerja_number,
                                   'bpjs_tenaga_kerja_date' => $entity->bpjs_tenaga_kerja_date,
                                   'bpjs_tenaga_kerja_class' => $entity->bpjs_tenaga_kerja_class,
                                   'has_bpjs_kesehatan' => $entity->has_bpjs_kesehatan,
                                   'bpjs_kesehatan_number' => $entity->bpjs_kesehatan_number,
                                   'bpjs_kesehatan_date' => $entity->bpjs_kesehatan_date,
                                   'bpjs_kesehatan_class' => $entity->bpjs_kesehatan_class,

                                   'has_mate_bpjs_kesehatan' => $entity->has_mate_bpjs_kesehatan,
                                   'mate_bpjs_kesehatan_number' => $entity->mate_bpjs_kesehatan_number,
                                   'mate_bpjs_kesehatan_date' => $entity->mate_bpjs_kesehatan_date,
                                   'mate_bpjs_kesehatan_class' => $entity->mate_bpjs_kesehatan_class,

                                   'dplk_number' => $entity->dplk_number,
                                   'collective_number' => $entity->collective_number,
                                   'english_ability' => $entity->english_ability,
                                   'computer_ability' => $entity->computer_ability,
                                   'other_ability' => $entity->other_ability,
                                   'bank'=> Common::isDataExist($entity->bank) ? $this->getBankObject($entity->bank) : null,
                                   'account_number' => $entity->account_number,
                                   'join_date' => $entity->join_date,
                                   'work_status' => $entity->work_status,
                                   'work_type' => $entity->work_type,

                                   'created_by' => $entity->created_by,
                                   'modified_by' => $entity->modified_by,

                                   'work_unit_mutations' => $entity->workUnitMutations,
                                   'media_libraries' => $entity->mediaLibraries
                              ]);
                              $rowJsonData->put($i, $result);
                         }
                    }
                    return $rowJsonData;
               });
     }

     /**
     * @OA\Post(
     *     path="/employee/workArea/list-search",
     *     operationId="postEmployeeGroupByWorkArea",
     *     summary="Get list of employee by work area",
     *     tags={"Employee"},
     *     description="Get list of employee by work area",
     *     security={
     *          {
     *              "apiKey": {"*"}
     *          }
     *     },
     *     @OA\RequestBody(
     *          required=true,
     *          @OA\MediaType(
     *              mediaType="application/json",
     *              @OA\Schema(
     *                  allOf={
     *                      @OA\Schema(
     *                          @OA\Property(property="company_id", ref="#/components/schemas/EmployeeEloquent/properties/company_id"),
     *                      ),
     *                  }
     *              )
     *          )
     *     ),
     *     @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *          @OA\JsonContent()
     *     ),
     *     @OA\Response(
     *          response=400,
     *          description="Bad request",
     *          @OA\JsonContent()
     *     ),
     *     @OA\Response(
     *          response=401,
     *          description="Unauthenticated",
     *          @OA\JsonContent()
     *     )
     * )
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function postEmployeeGroupByWorkArea(Request $request)
    {
          $companyId = $request->get('company_id');

          return $this->getEmployeeListGroupByOffice($request, $companyId,
               [$this->_employeeServiceInterface, 'employeeGroupByWorkAreaListSearch'],
               function (Collection $entities) {
                    $rowJsonData = collect([]);

                    foreach ($entities as $i => $data) {
                         $result = collect([]);
                         foreach ($data as $j => $entity) {
                              $result->put($j, [
                                   'id' => $entity->id,
                                   'company' => Common::isDataExist($entity->company) ? $this->getCompanyObject($entity->company) : null,
                                   'nip' => $entity->nip,
                                   'full_name' => $entity->full_name,
                                   'nick_name' => $entity->nick_name,
                                   'gender' => Common::isDataExist($entity->gender) ? $this->getGenderObject($entity->gender) : null,
                                   'religion'=> Common::isDataExist($entity->religion) ? $this->getReligionObject($entity->religion) : null,
                                   'birth_place' => $entity->birth_place,
                                   'birth_date' => $entity->birth_date,
                                   'address' => $entity->address,
                                   'phone' => $entity->phone,
                                   'email' => $entity->email,
                                   'mobile' => $entity->mobile,
                                   'identity_number' => $entity->identity_number,
                                   'identity_expired_date' => $entity->identity_expired_date,
                                   'identity_address' => $entity->identity_address,
                                   'has_drive_license_a' => $entity->has_drive_license_a,
                                   'drive_license_a_number' => $entity->drive_license_a_number,
                                   'drive_license_a_date' => $entity->drive_license_a_date,
                                   'has_drive_license_b' => $entity->has_drive_license_b,
                                   'drive_license_b_number' => $entity->drive_license_b_number,
                                   'drive_license_b_date' => $entity->drive_license_b_date,
                                   'has_drive_license_c' => $entity->has_drive_license_c,
                                   'drive_license_c_number' => $entity->drive_license_c_number,
                                   'drive_license_c_date' => $entity->drive_license_c_date,
                                   'marital_status'=> Common::isDataExist($entity->maritalStatus) ? $this->getMaritalStatusObject($entity->maritalStatus) : null,
                                   'mate_as' => $entity->mate_as,
                                   'mate_first_name' => $entity->mate_first_name,
                                   'mate_last_name' => $entity->mate_last_name,
                                   'mate_birth_place' => $entity->mate_birth_place,
                                   'mate_birth_date' => $entity->mate_birth_date,
                                   'mate_occupation' => $entity->mate_occupation,
                                   'office'=> Common::isDataExist($entity->office) ? $this->getOfficeObject($entity->office) : null,
                                   'work_area'=> Common::isDataExist($entity->workArea) ? $this->getWorkAreaObject($entity->workArea) : null,
                                   'has_npwp' => $entity->has_npwp,
                                   'npwp_number' => $entity->npwp_number,
                                   'npwp_date' => $entity->npwp_date,
                                   'npwp_status' => $entity->npwp_status,
                                   'has_bpjs_tenaga_kerja' => $entity->has_bpjs_tenaga_kerja,
                                   'bpjs_tenaga_kerja_number' => $entity->bpjs_tenaga_kerja_number,
                                   'bpjs_tenaga_kerja_date' => $entity->bpjs_tenaga_kerja_date,
                                   'bpjs_tenaga_kerja_class' => $entity->bpjs_tenaga_kerja_class,
                                   'has_bpjs_kesehatan' => $entity->has_bpjs_kesehatan,
                                   'bpjs_kesehatan_number' => $entity->bpjs_kesehatan_number,
                                   'bpjs_kesehatan_date' => $entity->bpjs_kesehatan_date,
                                   'bpjs_kesehatan_class' => $entity->bpjs_kesehatan_class,

                                   'has_mate_bpjs_kesehatan' => $entity->has_mate_bpjs_kesehatan,
                                   'mate_bpjs_kesehatan_number' => $entity->mate_bpjs_kesehatan_number,
                                   'mate_bpjs_kesehatan_date' => $entity->mate_bpjs_kesehatan_date,
                                   'mate_bpjs_kesehatan_class' => $entity->mate_bpjs_kesehatan_class,

                                   'dplk_number' => $entity->dplk_number,
                                   'collective_number' => $entity->collective_number,
                                   'english_ability' => $entity->english_ability,
                                   'computer_ability' => $entity->computer_ability,
                                   'other_ability' => $entity->other_ability,
                                   'bank'=> Common::isDataExist($entity->bank) ? $this->getBankObject($entity->bank) : null,
                                   'account_number' => $entity->account_number,
                                   'join_date' => $entity->join_date,
                                   'work_status' => $entity->work_status,
                                   'work_type' => $entity->work_type,

                                   'created_by' => $entity->created_by,
                                   'modified_by' => $entity->modified_by,

                                   'work_unit_mutations' => $entity->workUnitMutations,
                                   'media_libraries' => $entity->mediaLibraries
                              ]);
                              $rowJsonData->put($i, $result);
                         }
                    }
                    return $rowJsonData;
               });
     }

     /**
     * @OA\Post(
     *     path="/employee/position/list-search",
     *     operationId="postEmployeeGroupByPosition",
     *     summary="Get list of employee by position",
     *     tags={"Employee"},
     *     description="Get list of employee by position",
     *     security={
     *          {
     *              "apiKey": {"*"}
     *          }
     *     },
     *     @OA\RequestBody(
     *          required=true,
     *          @OA\MediaType(
     *              mediaType="application/json",
     *              @OA\Schema(
     *                  allOf={
     *                      @OA\Schema(
     *                          @OA\Property(property="company_id", ref="#/components/schemas/EmployeeEloquent/properties/company_id"),
     *                      ),
     *                  }
     *              )
     *          )
     *     ),
     *     @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *          @OA\JsonContent()
     *     ),
     *     @OA\Response(
     *          response=400,
     *          description="Bad request",
     *          @OA\JsonContent()
     *     ),
     *     @OA\Response(
     *          response=401,
     *          description="Unauthenticated",
     *          @OA\JsonContent()
     *     )
     * )
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function postEmployeeGroupByPosition(Request $request)
    {
          $companyId = $request->get('company_id');

          return $this->getEmployeeListGroupByPosition($request, $companyId,
               [$this->_employeeServiceInterface, 'employeeGroupByPositionListSearch'],
               function (Collection $entities) {
                    $rowJsonData = collect([]);

                    foreach ($entities as $i => $data) {
                         $result = collect([]);
                         foreach ($data as $j => $entity) {
                              $result->put($j, [
                                   'id' => $entity->id,
                                   'company' => Common::isDataExist($entity->company) ? $this->getCompanyObject($entity->company) : null,
                                   'nip' => $entity->nip,
                                   'full_name' => $entity->full_name,
                                   'nick_name' => $entity->nick_name,
                                   'gender' => Common::isDataExist($entity->gender) ? $this->getGenderObject($entity->gender) : null,
                                   'religion'=> Common::isDataExist($entity->religion) ? $this->getReligionObject($entity->religion) : null,
                                   'birth_place' => $entity->birth_place,
                                   'birth_date' => $entity->birth_date,
                                   'address' => $entity->address,
                                   'phone' => $entity->phone,
                                   'email' => $entity->email,
                                   'mobile' => $entity->mobile,
                                   'identity_number' => $entity->identity_number,
                                   'identity_expired_date' => $entity->identity_expired_date,
                                   'identity_address' => $entity->identity_address,
                                   'has_drive_license_a' => $entity->has_drive_license_a,
                                   'drive_license_a_number' => $entity->drive_license_a_number,
                                   'drive_license_a_date' => $entity->drive_license_a_date,
                                   'has_drive_license_b' => $entity->has_drive_license_b,
                                   'drive_license_b_number' => $entity->drive_license_b_number,
                                   'drive_license_b_date' => $entity->drive_license_b_date,
                                   'has_drive_license_c' => $entity->has_drive_license_c,
                                   'drive_license_c_number' => $entity->drive_license_c_number,
                                   'drive_license_c_date' => $entity->drive_license_c_date,
                                   'marital_status'=> Common::isDataExist($entity->maritalStatus) ? $this->getMaritalStatusObject($entity->maritalStatus) : null,
                                   'mate_as' => $entity->mate_as,
                                   'mate_first_name' => $entity->mate_first_name,
                                   'mate_last_name' => $entity->mate_last_name,
                                   'mate_birth_place' => $entity->mate_birth_place,
                                   'mate_birth_date' => $entity->mate_birth_date,
                                   'mate_occupation' => $entity->mate_occupation,
                                   'office'=> Common::isDataExist($entity->office) ? $this->getOfficeObject($entity->office) : null,
                                   'work_area'=> Common::isDataExist($entity->workArea) ? $this->getWorkAreaObject($entity->workArea) : null,
                                   'has_npwp' => $entity->has_npwp,
                                   'npwp_number' => $entity->npwp_number,
                                   'npwp_date' => $entity->npwp_date,
                                   'npwp_status' => $entity->npwp_status,
                                   'has_bpjs_tenaga_kerja' => $entity->has_bpjs_tenaga_kerja,
                                   'bpjs_tenaga_kerja_number' => $entity->bpjs_tenaga_kerja_number,
                                   'bpjs_tenaga_kerja_date' => $entity->bpjs_tenaga_kerja_date,
                                   'bpjs_tenaga_kerja_class' => $entity->bpjs_tenaga_kerja_class,
                                   'has_bpjs_kesehatan' => $entity->has_bpjs_kesehatan,
                                   'bpjs_kesehatan_number' => $entity->bpjs_kesehatan_number,
                                   'bpjs_kesehatan_date' => $entity->bpjs_kesehatan_date,
                                   'bpjs_kesehatan_class' => $entity->bpjs_kesehatan_class,

                                   'has_mate_bpjs_kesehatan' => $entity->has_mate_bpjs_kesehatan,
                                   'mate_bpjs_kesehatan_number' => $entity->mate_bpjs_kesehatan_number,
                                   'mate_bpjs_kesehatan_date' => $entity->mate_bpjs_kesehatan_date,
                                   'mate_bpjs_kesehatan_class' => $entity->mate_bpjs_kesehatan_class,

                                   'dplk_number' => $entity->dplk_number,
                                   'collective_number' => $entity->collective_number,
                                   'english_ability' => $entity->english_ability,
                                   'computer_ability' => $entity->computer_ability,
                                   'other_ability' => $entity->other_ability,
                                   'bank'=> Common::isDataExist($entity->bank) ? $this->getBankObject($entity->bank) : null,
                                   'account_number' => $entity->account_number,
                                   'join_date' => $entity->join_date,
                                   'work_status' => $entity->work_status,
                                   'work_type' => $entity->work_type,

                                   'created_by' => $entity->created_by,
                                   'modified_by' => $entity->modified_by,

                                   'work_unit_mutations' => $entity->workUnitMutations,
                                   'media_libraries' => $entity->mediaLibraries
                              ]);
                              $rowJsonData->put($i, $result);
                         }
                    }
                    return $rowJsonData;
               });
     }

     /**
     * @OA\Post(
     *     path="/employee/workUnit/list-search",
     *     operationId="postEmployeeGroupByWorkUnit",
     *     summary="Get list of employee by work unit",
     *     tags={"Employee"},
     *     description="Get list of employee by work unit",
     *     security={
     *          {
     *              "apiKey": {"*"}
     *          }
     *     },
     *     @OA\RequestBody(
     *          required=true,
     *          @OA\MediaType(
     *              mediaType="application/json",
     *              @OA\Schema(
     *                  allOf={
     *                      @OA\Schema(
     *                          @OA\Property(property="company_id", ref="#/components/schemas/EmployeeEloquent/properties/company_id"),
     *                      ),
     *                  }
     *              )
     *          )
     *     ),
     *     @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *          @OA\JsonContent()
     *     ),
     *     @OA\Response(
     *          response=400,
     *          description="Bad request",
     *          @OA\JsonContent()
     *     ),
     *     @OA\Response(
     *          response=401,
     *          description="Unauthenticated",
     *          @OA\JsonContent()
     *     )
     * )
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function postEmployeeGroupByWorkUnit(Request $request)
    {
          $companyId = $request->get('company_id');

          return $this->getEmployeeListGroupByWorkUnit($request, $companyId,
               [$this->_employeeServiceInterface, 'employeeGroupByWorkUnitListSearch'],
               function (Collection $entities) {
                    $rowJsonData = collect([]);

                    foreach ($entities as $i => $data) {
                         $result = collect([]);
                         foreach ($data as $j => $entity) {
                              $result->put($j, [
                                   'id' => $entity->id,
                                   'company' => Common::isDataExist($entity->company) ? $this->getCompanyObject($entity->company) : null,
                                   'nip' => $entity->nip,
                                   'full_name' => $entity->full_name,
                                   'nick_name' => $entity->nick_name,
                                   'gender' => Common::isDataExist($entity->gender) ? $this->getGenderObject($entity->gender) : null,
                                   'religion'=> Common::isDataExist($entity->religion) ? $this->getReligionObject($entity->religion) : null,
                                   'birth_place' => $entity->birth_place,
                                   'birth_date' => $entity->birth_date,
                                   'address' => $entity->address,
                                   'phone' => $entity->phone,
                                   'email' => $entity->email,
                                   'mobile' => $entity->mobile,
                                   'identity_number' => $entity->identity_number,
                                   'identity_expired_date' => $entity->identity_expired_date,
                                   'identity_address' => $entity->identity_address,
                                   'has_drive_license_a' => $entity->has_drive_license_a,
                                   'drive_license_a_number' => $entity->drive_license_a_number,
                                   'drive_license_a_date' => $entity->drive_license_a_date,
                                   'has_drive_license_b' => $entity->has_drive_license_b,
                                   'drive_license_b_number' => $entity->drive_license_b_number,
                                   'drive_license_b_date' => $entity->drive_license_b_date,
                                   'has_drive_license_c' => $entity->has_drive_license_c,
                                   'drive_license_c_number' => $entity->drive_license_c_number,
                                   'drive_license_c_date' => $entity->drive_license_c_date,
                                   'marital_status'=> Common::isDataExist($entity->maritalStatus) ? $this->getMaritalStatusObject($entity->maritalStatus) : null,
                                   'mate_as' => $entity->mate_as,
                                   'mate_first_name' => $entity->mate_first_name,
                                   'mate_last_name' => $entity->mate_last_name,
                                   'mate_birth_place' => $entity->mate_birth_place,
                                   'mate_birth_date' => $entity->mate_birth_date,
                                   'mate_occupation' => $entity->mate_occupation,
                                   'office'=> Common::isDataExist($entity->office) ? $this->getOfficeObject($entity->office) : null,
                                   'work_area'=> Common::isDataExist($entity->workArea) ? $this->getWorkAreaObject($entity->workArea) : null,
                                   'has_npwp' => $entity->has_npwp,
                                   'npwp_number' => $entity->npwp_number,
                                   'npwp_date' => $entity->npwp_date,
                                   'npwp_status' => $entity->npwp_status,
                                   'has_bpjs_tenaga_kerja' => $entity->has_bpjs_tenaga_kerja,
                                   'bpjs_tenaga_kerja_number' => $entity->bpjs_tenaga_kerja_number,
                                   'bpjs_tenaga_kerja_date' => $entity->bpjs_tenaga_kerja_date,
                                   'bpjs_tenaga_kerja_class' => $entity->bpjs_tenaga_kerja_class,
                                   'has_bpjs_kesehatan' => $entity->has_bpjs_kesehatan,
                                   'bpjs_kesehatan_number' => $entity->bpjs_kesehatan_number,
                                   'bpjs_kesehatan_date' => $entity->bpjs_kesehatan_date,
                                   'bpjs_kesehatan_class' => $entity->bpjs_kesehatan_class,

                                   'has_mate_bpjs_kesehatan' => $entity->has_mate_bpjs_kesehatan,
                                   'mate_bpjs_kesehatan_number' => $entity->mate_bpjs_kesehatan_number,
                                   'mate_bpjs_kesehatan_date' => $entity->mate_bpjs_kesehatan_date,
                                   'mate_bpjs_kesehatan_class' => $entity->mate_bpjs_kesehatan_class,

                                   'dplk_number' => $entity->dplk_number,
                                   'collective_number' => $entity->collective_number,
                                   'english_ability' => $entity->english_ability,
                                   'computer_ability' => $entity->computer_ability,
                                   'other_ability' => $entity->other_ability,
                                   'bank'=> Common::isDataExist($entity->bank) ? $this->getBankObject($entity->bank) : null,
                                   'account_number' => $entity->account_number,
                                   'join_date' => $entity->join_date,
                                   'work_status' => $entity->work_status,
                                   'work_type' => $entity->work_type,

                                   'created_by' => $entity->created_by,
                                   'modified_by' => $entity->modified_by,

                                   'work_unit_mutations' => $entity->workUnitMutations,
                                   'media_libraries' => $entity->mediaLibraries
                              ]);
                              $rowJsonData->put($i, $result);
                         }
                    }
                    return $rowJsonData;
               });
     }



    /**
     * @OA\Get(
     *     path="/employee/detail/{id}",
     *     operationId="getEmployeeDetail",
     *     summary="Get detail employee",
     *     tags={"Employee"},
     *     description="Get detail employee",
     *     security={
     *          {
     *              "apiKey": {"*"}
     *          }
     *     },
     *     @OA\Parameter(
     *          name="id",
     *          in="path",
     *          description="Id parameter",
     *          required=true,
     *          @OA\Schema(
     *              type="integer",
     *              format="int64",
     *              example=1
     *          )
     *     ),
     *     @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *          @OA\JsonContent()
     *     ),
     *     @OA\Response(
     *          response=400,
     *          description="Bad request",
     *          @OA\JsonContent()
     *     ),
     *     @OA\Response(
     *          response=401,
     *          description="Unauthenticated",
     *          @OA\JsonContent()
     *     )
     * )
     * 
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function getEmployeeDetail(int $id)
    {
        return $this->getDetailObjectJson($id,
            [$this->_employeeServiceInterface, 'find'],
            function ($entity) {
                $rowJsonData = new Collection();

                if ($entity) {
                    $rowJsonData->push([
                        'id' => $entity->id,
                        'company' => Common::isDataExist($entity->gender) ? $this->getGenderObject($entity->gender) : null,
                        'nip' => $entity->nip,
                        'full_name' => $entity->full_name,
                        'nick_name' => $entity->nick_name,
                        'gender' => Common::isDataExist($entity->gender) ? $this->getGenderObject($entity->gender) : null,
                        'religion'=> Common::isDataExist($entity->religion) ? $this->getReligionObject($entity->religion) : null,
                        'birth_place' => $entity->birth_place,
                        'birth_date' => $entity->birth_date,
                        'address' => $entity->address,
                        'phone' => $entity->phone,
                        'email' => $entity->email,
                        'mobile' => $entity->mobile,
                        'identity_number' => $entity->identity_number,
                        'identity_expired_date' => $entity->identity_expired_date,
                        'identity_address' => $entity->identity_address,
                        'has_drive_license_a' => $entity->has_drive_license_a,
                        'drive_license_a_number' => $entity->drive_license_a_number,
                        'drive_license_a_date' => $entity->drive_license_a_date,
                        'has_drive_license_b' => $entity->has_drive_license_b,
                        'drive_license_b_number' => $entity->drive_license_b_number,
                        'drive_license_b_date' => $entity->drive_license_b_date,
                        'has_drive_license_c' => $entity->has_drive_license_c,
                        'drive_license_c_number' => $entity->drive_license_c_number,
                        'drive_license_c_date' => $entity->drive_license_c_date,
                        'marital_status'=> Common::isDataExist($entity->maritalStatus) ? $this->getMaritalStatusObject($entity->maritalStatus) : null,
                        'mate_as' => $entity->mate_as,
                        'mate_first_name' => $entity->mate_first_name,
                        'mate_last_name' => $entity->mate_last_name,
                        'mate_birth_place' => $entity->mate_birth_place,
                        'mate_birth_date' => $entity->mate_birth_date,
                        'mate_occupation' => $entity->mate_occupation,
                        'office'=> Common::isDataExist($entity->office) ? $this->getOfficeObject($entity->office) : null,
                        'work_area'=> Common::isDataExist($entity->workArea) ? $this->getWorkAreaObject($entity->workArea) : null,
                        'has_npwp' => $entity->has_npwp,
                        'npwp_number' => $entity->npwp_number,
                        'npwp_date' => $entity->npwp_date,
                        'npwp_status' => $entity->npwp_status,
                        'has_bpjs_tenaga_kerja' => $entity->has_bpjs_tenaga_kerja,
                        'bpjs_tenaga_kerja_number' => $entity->bpjs_tenaga_kerja_number,
                        'bpjs_tenaga_kerja_date' => $entity->bpjs_tenaga_kerja_date,
                        'bpjs_tenaga_kerja_class' => $entity->bpjs_tenaga_kerja_class,
                        'has_bpjs_kesehatan' => $entity->has_bpjs_kesehatan,
                        'bpjs_kesehatan_number' => $entity->bpjs_kesehatan_number,
                        'bpjs_kesehatan_date' => $entity->bpjs_kesehatan_date,
                        'bpjs_kesehatan_class' => $entity->bpjs_kesehatan_class,
                        'dplk_number' => $entity->dplk_number,
                        'collective_number' => $entity->collective_number,
                        'english_ability' => $entity->english_ability,
                        'computer_ability' => $entity->computer_ability,
                        'other_ability' => $entity->other_ability,
                        'bank'=> Common::isDataExist($entity->bank) ? $this->getBankObject($entity->bank) : null,
                        'account_number' => $entity->account_number,
                        'join_date' => $entity->join_date,
                        'work_status' => $entity->work_status,
                        'work_type' => $entity->work_type,
                        'created_by' => $entity->created_by,
                        'modified_by' => $entity->modified_by,

                        'media_libraries' => $entity->mediaLibraries
                    ]);
                }

                return $rowJsonData->first();
            });
    }

    /**
     * @OA\Post(
     *     path="/employee/create",
     *     operationId="postEmployeeCreate",
     *     summary="Create employee",
     *     tags={"Employee"},
     *     description="Create employee",
     *     security={
     *          {
     *              "apiKey": {"*"}
     *          }
     *     },
     *     @OA\RequestBody(
     *          @OA\MediaType(
     *              mediaType="application/json",
     *              @OA\Schema(
     *                  allOf={
     *                      @OA\Schema(ref="#/components/schemas/CreateEmployeeEloquent"),
     *                      @OA\Schema(
     *                          @OA\Property(
     *                              property="media_libraries",
     *                              description="Media library property",
     *                              type="array",
     *                              @OA\Items(
     *                                  @OA\Property(
     *                                      property="media_library_id",
     *                                      description="Media library id property",
     *                                      type="string",
     *                                      example="152cc099-56a2-46b6-b2a8-ebc080477e3a"
     *                                  ),
     *                                  @OA\Property(
     *                                      property="pivot",
     *                                      description="Pivot property",
     *                                      @OA\Property(
     *                                          property="attribute",
     *                                          type="string",
     *                                          example="photo"
     *                                      )
     *                                  )
     *                              )
     *                          )
     *                      ),
     *                      @OA\Schema(
     *                          @OA\Property(
     *                              property="childs",
     *                              description="Childs of employee",
     *                              type="array",
     *                              @OA\Items(ref="#/components/schemas/CreateChildEloquent")
     *                          )
     *                      ),
     *                      @OA\Schema(
     *                          @OA\Property(
     *                              property="formal_education_histories",
     *                              description="Formal education histories of employee",
     *                              type="array",
     *                              @OA\Items(ref="#/components/schemas/CreateFormalEducationHistoryEloquent")
     *                          )
     *                      ),
     *                      @OA\Schema(
     *                          @OA\Property(
     *                              property="non_formal_education_histories",
     *                              description="Non formal education histories of employee",
     *                              type="array",
     *                              @OA\Items(ref="#/components/schemas/CreateNonFormalEducationHistoryEloquent")
     *                          )
     *                      ),
     *                      @OA\Schema(
     *                          @OA\Property(
     *                              property="organization_histories",
     *                              description="Organization histories of employee",
     *                              type="array",
     *                              @OA\Items(ref="#/components/schemas/CreateOrganizationHistoryEloquent")
     *                          )
     *                      ),
     *                      @OA\Schema(
     *                          @OA\Property(
     *                              property="work_competences",
     *                              description="Work competences of employee",
     *                              type="array",
     *                              @OA\Items(ref="#/components/schemas/CreateWorkCompetenceEloquent")
     *                          )
     *                      ),
     *                      @OA\Schema(
     *                          @OA\Property(
     *                              property="work_experiences",
     *                              description="Work experiences of employee",
     *                              type="array",
     *                              @OA\Items(ref="#/components/schemas/CreateWorkExperienceEloquent")
     *                          )
     *                      ),
     *                      @OA\Schema(
     *                          @OA\Property(
     *                              property="other_equipments",
     *                              description="Other equipments of employee",
     *                              type="array",
     *                              @OA\Items(ref="#/components/schemas/CreateOtherEquipmentEloquent")
     *                          )
     *                      )
     *                  }
     *              )
     *          )
     *     ),
     *     @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *          @OA\JsonContent()
     *     ),
     *     @OA\Response(
     *          response=400,
     *          description="Bad request",
     *          @OA\JsonContent()
     *     ),
     *     @OA\Response(
     *          response=401,
     *          description="Unauthenticated",
     *          @OA\JsonContent()
     *     )
     * )
     *
     * @param Request $request
     * @return mixed
     * @throws Exception
     */
    public function postEmployeeCreate(Request $request)
    {
        $createEmployeeRequest = new CreateEmployeeRequest();

        $createEmployeeRequest->company_id = $request->input('company_id');
        $createEmployeeRequest->nip = $request->input('nip');
        $createEmployeeRequest->full_name = $request->input('full_name');
        $createEmployeeRequest->nick_name = $request->input('nick_name');
        $createEmployeeRequest->gender_id = $request->input('gender_id');
        $createEmployeeRequest->religion_id = $request->input('religion_id');
        $createEmployeeRequest->birth_place = $request->input('birth_place');
        $createEmployeeRequest->birth_date = ($request->input('birth_date')) ? new DateTime($request->input('birth_date')) : null;
        $createEmployeeRequest->address = $request->input('address');
        $createEmployeeRequest->phone = $request->input('phone');
        $createEmployeeRequest->mobile = $request->input('mobile');
        $createEmployeeRequest->email = $request->input('email');
        $createEmployeeRequest->identity_number = $request->input('identity_number');
        $createEmployeeRequest->identity_expired_date = ($request->input('identity_expired_date')) ? new DateTime($request->input('identity_expired_date')) : null;
        $createEmployeeRequest->identity_address = $request->input('identity_address');
        $createEmployeeRequest->has_drive_license_a = $request->input('has_drive_license_a');
        $createEmployeeRequest->drive_license_a_number = $request->input('drive_license_a_number');
        $createEmployeeRequest->drive_license_a_date = ($request->input('drive_license_a_date')) ? new DateTime($request->input('drive_license_a_date')) : null;
        $createEmployeeRequest->has_drive_license_b = $request->input('has_drive_license_b');
        $createEmployeeRequest->drive_license_b_number = $request->input('drive_license_b_number');
        $createEmployeeRequest->drive_license_b_date = ($request->input('drive_license_b_date')) ? new DateTime($request->input('drive_license_b_date')) : null;
        $createEmployeeRequest->has_drive_license_c = $request->input('has_drive_license_c');
        $createEmployeeRequest->drive_license_c_number = $request->input('drive_license_c_number');
        $createEmployeeRequest->drive_license_c_date = ($request->input('drive_license_c_date')) ? new DateTime($request->input('drive_license_c_date')) : null;
        $createEmployeeRequest->marital_status_id = $request->input('marital_status_id');
        $createEmployeeRequest->mate_as = $request->input('mate_as');
        $createEmployeeRequest->mate_full_name = $request->input('mate_full_name');
        $createEmployeeRequest->mate_nick_name = $request->input('mate_nick_name');
        $createEmployeeRequest->mate_birth_place = $request->input('mate_birth_place');
        $createEmployeeRequest->mate_birth_date = ($request->input('mate_birth_date')) ? new DateTime($request->input('mate_birth_date')) : null;
        $createEmployeeRequest->mate_occupation = $request->input('mate_occupation');
        $createEmployeeRequest->office_id = $request->input('office_id');
        $createEmployeeRequest->work_area_id = $request->input('work_area_id');
        $createEmployeeRequest->has_npwp = $request->input('has_npwp');
        $createEmployeeRequest->npwp_number = $request->input('npwp_number');
        $createEmployeeRequest->npwp_date = ($request->input('npwp_date')) ? new DateTime($request->input('npwp_date')) : null;
        $createEmployeeRequest->npwp_status = $request->input('npwp_status');
        $createEmployeeRequest->has_bpjs_tenaga_kerja = $request->input('has_bpjs_tenaga_kerja');
        $createEmployeeRequest->bpjs_tenaga_kerja_number = $request->input('bpjs_tenaga_kerja_number');
        $createEmployeeRequest->bpjs_tenaga_kerja_date = ($request->input('bpjs_tenaga_kerja_date')) ? new DateTime($request->input('bpjs_tenaga_kerja_date')) : null;
        $createEmployeeRequest->bpjs_tenaga_kerja_class = $request->input('bpjs_tenaga_kerja_class');
        $createEmployeeRequest->has_bpjs_kesehatan = $request->input('has_bpjs_kesehatan');
        $createEmployeeRequest->bpjs_kesehatan_number = $request->input('bpjs_kesehatan_number');
        $createEmployeeRequest->bpjs_kesehatan_date = ($request->input('bpjs_kesehatan_date')) ? new DateTime($request->input('bpjs_kesehatan_date')) : null;
        $createEmployeeRequest->bpjs_kesehatan_class = $request->input('bpjs_kesehatan_class');
        $createEmployeeRequest->has_mate_bpjs_kesehatan = $request->input('has_mate_bpjs_kesehatan');
        $createEmployeeRequest->mate_bpjs_kesehatan_number = $request->input('mate_bpjs_kesehatan_number');
        $createEmployeeRequest->mate_bpjs_kesehatan_date = ($request->input('mate_bpjs_kesehatan_date')) ? new DateTime($request->input('mate_bpjs_kesehatan_date')) : null;
        $createEmployeeRequest->mate_bpjs_kesehatan_class = $request->input('mate_bpjs_kesehatan_class');
        $createEmployeeRequest->dplk_number = $request->input('dplk_number');
        $createEmployeeRequest->collective_number = $request->input('collective_number');
        $createEmployeeRequest->english_ability = $request->input('english_ability');
        $createEmployeeRequest->computer_ability = $request->input('computer_ability');
        $createEmployeeRequest->other_ability = $request->input('other_ability');
        $createEmployeeRequest->bank_id = $request->input('bank_id');
        $createEmployeeRequest->account_number = $request->input('account_number');
        $createEmployeeRequest->join_date = ($request->input('join_date')) ? new DateTime($request->input('join_date')) : null;
        $createEmployeeRequest->work_status = $request->input('work_status');
        $createEmployeeRequest->work_type = $request->input('work_type');

        //Many to many
        $createEmployeeRequest->media_libraries = $request->input('media_libraries');

        //Has many
        $createEmployeeRequest->childs = $request->input('childs');
        $createEmployeeRequest->formal_educations = $request->input('formal_educations');
        $createEmployeeRequest->non_formal_educations = $request->input('non_formal_educations');
        $createEmployeeRequest->organizations = $request->input('organizations');
        $createEmployeeRequest->other_equipments = $request->input('other_equipments');
        $createEmployeeRequest->work_competences = $request->input('work_competences');
        $createEmployeeRequest->work_experiences = $request->input('work_experiences');

        $this->setRequestAuthor($createEmployeeRequest);

        $response = $this->_employeeServiceInterface->create($createEmployeeRequest);
        $employeeCreated = $response->getObject();

        if (!$response->isSuccess()) {
            return $this->getBasicErrorJson($response);
        }

        return $this->getBasicSuccessJson($response, $employeeCreated);
    }

    /**
     * @OA\Put(
     *     path="/employee/update",
     *     operationId="putEmployeeUpdate",
     *     summary="Update employee",
     *     tags={"Employee"},
     *     description="Update employee",
     *     security={
     *          {
     *              "apiKey": {"*"}
     *          }
     *     },
     *     @OA\RequestBody(
     *          required=true,
     *          @OA\MediaType(
     *              mediaType="application/json",
     *              @OA\Schema(
     *                  allOf={
     *                      @OA\Schema(ref="#/components/schemas/UpdateEmployeeEloquent"),
     *                      @OA\Schema(
     *                          @OA\Property(
     *                              property="media_libraries",
     *                              description="Media library property",
     *                              type="array",
     *                              @OA\Items(
     *                                  @OA\Property(
     *                                      property="media_library_id",
     *                                      description="Media library id property",
     *                                      type="string",
     *                                      example="152cc099-56a2-46b6-b2a8-ebc080477e3a"
     *                                  ),
     *                                  @OA\Property(
     *                                      property="pivot",
     *                                      description="Pivot property",
     *                                      @OA\Property(
     *                                          property="attribute",
     *                                          type="string",
     *                                          example="photo"
     *                                      )
     *                                  )
     *                              )
     *                          )
     *                      ),
     *                      @OA\Schema(
     *                          @OA\Property(
     *                              property="childs",
     *                              description="Childs of employee",
     *                              type="array",
     *                              @OA\Items(ref="#/components/schemas/UpdateChildEloquent")
     *                          )
     *                      ),
     *                      @OA\Schema(
     *                          @OA\Property(
     *                              property="formal_education_histories",
     *                              description="Formal education histories of employee",
     *                              type="array",
     *                              @OA\Items(ref="#/components/schemas/UpdateFormalEducationHistoryEloquent")
     *                          )
     *                      ),
     *                      @OA\Schema(
     *                          @OA\Property(
     *                              property="non_formal_education_histories",
     *                              description="Non formal education histories of employee",
     *                              type="array",
     *                              @OA\Items(ref="#/components/schemas/UpdateNonFormalEducationHistoryEloquent")
     *                          )
     *                      ),
     *                      @OA\Schema(
     *                          @OA\Property(
     *                              property="organization_histories",
     *                              description="Organization histories of employee",
     *                              type="array",
     *                              @OA\Items(ref="#/components/schemas/UpdateOrganizationHistoryEloquent")
     *                          )
     *                      ),
     *                      @OA\Schema(
     *                          @OA\Property(
     *                              property="work_competences",
     *                              description="Work competences of employee",
     *                              type="array",
     *                              @OA\Items(ref="#/components/schemas/UpdateWorkCompetenceEloquent")
     *                          )
     *                      ),
     *                      @OA\Schema(
     *                          @OA\Property(
     *                              property="work_experiences",
     *                              description="Work experiences of employee",
     *                              type="array",
     *                              @OA\Items(ref="#/components/schemas/UpdateWorkExperienceEloquent")
     *                          )
     *                      ),
     *                      @OA\Schema(
     *                          @OA\Property(
     *                              property="other_equipments",
     *                              description="Other equipments of employee",
     *                              type="array",
     *                              @OA\Items(ref="#/components/schemas/UpdateOtherEquipmentEloquent")
     *                          )
     *                      )
     *                  }
     *              )
     *          )
     *     ),
     *     @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *          @OA\JsonContent()
     *     ),
     *     @OA\Response(
     *          response=400,
     *          description="Bad request",
     *          @OA\JsonContent()
     *     ),
     *     @OA\Response(
     *          response=401,
     *          description="Unauthenticated",
     *          @OA\JsonContent()
     *     )
     * )
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws Exception
     */
    public function putEmployeeUpdate(Request $request)
    {
        $editEmployeeRequest = new EditEmployeeRequest();

        $editEmployeeRequest->id = $request->input('id');
        $editEmployeeRequest->company_id = $request->input('company_id');
        $editEmployeeRequest->nip = $request->input('nip');
        $editEmployeeRequest->full_name = $request->input('full_name');
        $editEmployeeRequest->nick_name = $request->input('nick_name');
        $editEmployeeRequest->gender_id = $request->input('gender_id');
        $editEmployeeRequest->religion_id = $request->input('religion_id');
        $editEmployeeRequest->birth_place = $request->input('birth_place');
        $editEmployeeRequest->birth_date = ($request->input('birth_date')) ? new DateTime($request->input('birth_date')) : null;
        $editEmployeeRequest->address = $request->input('address');
        $editEmployeeRequest->phone = $request->input('phone');
        $editEmployeeRequest->mobile = $request->input('mobile');
        $editEmployeeRequest->email = $request->input('email');
        $editEmployeeRequest->identity_number = $request->input('identity_number');
        $editEmployeeRequest->identity_expired_date = ($request->input('identity_expired_date')) ? new DateTime($request->input('identity_expired_date')) : null;
        $editEmployeeRequest->identity_address = $request->input('identity_address');
        $editEmployeeRequest->has_drive_license_a = $request->input('has_drive_license_a');
        $editEmployeeRequest->drive_license_a_number = $request->input('drive_license_a_number');
        $editEmployeeRequest->drive_license_a_date = ($request->input('drive_license_a_date')) ? new DateTime($request->input('drive_license_a_date')) : null;
        $editEmployeeRequest->has_drive_license_b = $request->input('has_drive_license_b');
        $editEmployeeRequest->drive_license_b_number = $request->input('drive_license_b_number');
        $editEmployeeRequest->drive_license_b_date = ($request->input('drive_license_b_date')) ? new DateTime($request->input('drive_license_b_date')) : null;
        $editEmployeeRequest->has_drive_license_c = $request->input('has_drive_license_c');
        $editEmployeeRequest->drive_license_c_number = $request->input('drive_license_c_number');
        $editEmployeeRequest->drive_license_c_date = ($request->input('drive_license_c_date')) ? new DateTime($request->input('drive_license_c_date')) : null;
        $editEmployeeRequest->marital_status_id = $request->input('marital_status_id');
        $editEmployeeRequest->mate_as = $request->input('mate_as');
        $editEmployeeRequest->mate_full_name = $request->input('mate_full_name');
        $editEmployeeRequest->mate_nick_name = $request->input('mate_nick_name');
        $editEmployeeRequest->mate_birth_place = $request->input('mate_birth_place');
        $editEmployeeRequest->mate_birth_date = ($request->input('mate_birth_date')) ? new DateTime($request->input('mate_birth_date')) : null;
        $editEmployeeRequest->mate_occupation = $request->input('mate_occupation');
        $editEmployeeRequest->office_id = $request->input('office_id');
        $editEmployeeRequest->work_area_id = $request->input('work_area_id');
        $editEmployeeRequest->has_npwp = $request->input('has_npwp');
        $editEmployeeRequest->npwp_number = $request->input('npwp_number');
        $editEmployeeRequest->npwp_date = ($request->input('npwp_date')) ? new DateTime($request->input('npwp_date')) : null;
        $editEmployeeRequest->npwp_status = $request->input('npwp_status');
        $editEmployeeRequest->has_bpjs_tenaga_kerja = $request->input('has_bpjs_tenaga_kerja');
        $editEmployeeRequest->bpjs_tenaga_kerja_number = $request->input('bpjs_tenaga_kerja_number');
        $editEmployeeRequest->bpjs_tenaga_kerja_date = ($request->input('bpjs_tenaga_kerja_date')) ? new DateTime($request->input('bpjs_tenaga_kerja_date')) : null;
        $editEmployeeRequest->bpjs_tenaga_kerja_class = $request->input('bpjs_tenaga_kerja_class');
        $editEmployeeRequest->has_bpjs_kesehatan = $request->input('has_bpjs_kesehatan');
        $editEmployeeRequest->bpjs_kesehatan_number = $request->input('bpjs_kesehatan_number');
        $editEmployeeRequest->bpjs_kesehatan_date = ($request->input('bpjs_kesehatan_date')) ? new DateTime($request->input('bpjs_kesehatan_date')) : null;
        $editEmployeeRequest->bpjs_kesehatan_class = $request->input('bpjs_kesehatan_class');
        $editEmployeeRequest->has_mate_bpjs_kesehatan = $request->input('has_mate_bpjs_kesehatan');
        $editEmployeeRequest->mate_bpjs_kesehatan_number = $request->input('mate_bpjs_kesehatan_number');
        $editEmployeeRequest->mate_bpjs_kesehatan_date = ($request->input('mate_bpjs_kesehatan_date')) ? new DateTime($request->input('mate_bpjs_kesehatan_date')) : null;
        $editEmployeeRequest->mate_bpjs_kesehatan_class = $request->input('mate_bpjs_kesehatan_class');
        $editEmployeeRequest->dplk_number = $request->input('dplk_number');
        $editEmployeeRequest->collective_number = $request->input('collective_number');
        $editEmployeeRequest->english_ability = $request->input('english_ability');
        $editEmployeeRequest->computer_ability = $request->input('computer_ability');
        $editEmployeeRequest->other_ability = $request->input('other_ability');
        $editEmployeeRequest->bank_id = $request->input('bank_id');
        $editEmployeeRequest->account_number = $request->input('account_number');
        $editEmployeeRequest->join_date = ($request->input('join_date')) ? new DateTime($request->input('join_date')) : null;
        $editEmployeeRequest->work_status = $request->input('work_status');
        $editEmployeeRequest->work_type = $request->input('work_type');

        //Many to many
        $editEmployeeRequest->media_libraries = $request->input('media_libraries');

        //Has many
        $editEmployeeRequest->childs = $request->input('childs');
        $editEmployeeRequest->formal_educations = $request->input('formal_educations');
        $editEmployeeRequest->non_formal_educations = $request->input('non_formal_educations');
        $editEmployeeRequest->organizations = $request->input('organizations');
        $editEmployeeRequest->other_equipments = $request->input('other_equipments');
        $editEmployeeRequest->work_competences = $request->input('work_competences');
        $editEmployeeRequest->work_experiences = $request->input('work_experiences');

        $this->setRequestAuthor($editEmployeeRequest);

        $response = $this->_employeeServiceInterface->update($editEmployeeRequest);

        if (!$response->isSuccess()) {
            return $this->getBasicErrorJson($response);
        }

        return $this->getBasicSuccessJson($response);
    }

    /**
     * @OA\Delete(
     *     path="/employee/delete/{id}",
     *     operationId="deleteEmployee",
     *     summary="Delete employee",
     *     tags={"Employee"},
     *     description="Delete employee",
     *     security={
     *          {
     *              "apiKey": {"*"}
     *          }
     *     },
     *     @OA\Parameter(
     *          name="id",
     *          in="path",
     *          description="Is parameter",
     *          required=true,
     *          @OA\Schema(
     *              type="integer",
     *              format="int32",
     *              example=1
     *          )
     *     ),
     *     @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *          @OA\JsonContent()
     *     ),
     *     @OA\Response(
     *          response=400,
     *          description="Bad request",
     *          @OA\JsonContent()
     *     ),
     *     @OA\Response(
     *          response=401,
     *          description="Unauthenticated",
     *          @OA\JsonContent()
     *     )
     * )
     *
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function deleteEmployee(int $id)
    {
        $response = $this->_employeeServiceInterface->delete($id);

        if (!$response->isSuccess()) {
            return $this->getBasicErrorJson($response);
        }

        return $this->getBasicSuccessJson($response);
    }

    /**
     * @OA\Delete(
     *     path="/employee/deletes",
     *     operationId="deleteBulkEmployee",
     *     summary="Delete bulk employee",
     *     tags={"Employee"},
     *     description="Delete bulk employee",
     *     security={
     *          {
     *              "apiKey": {"*"}
     *          }
     *     },
     *     @OA\RequestBody(
     *          required=true,
     *          @OA\MediaType(
     *              mediaType="application/json",
     *              @OA\Schema(
     *                  @OA\Property(
     *                      property="ids",
     *                      description="Ids property",
     *                      type="array",
     *                      @OA\Items(
     *                          type="integer",
     *                          format="int64",
     *                          example=1
     *                      )
     *                  )
     *              )
     *          )
     *     ),
     *     @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *          @OA\JsonContent()
     *     ),
     *     @OA\Response(
     *          response=400,
     *          description="Bad request",
     *          @OA\JsonContent()
     *     ),
     *     @OA\Response(
     *          response=401,
     *          description="Unauthenticated",
     *          @OA\JsonContent()
     *     )
     * )
     *
     * @param Request $request
     * @return ObjectResponse|\Illuminate\Http\JsonResponse|mixed
     */
    public function deleteBulkEmployee(Request $request)
    {
        $ids = $request->input('ids');

        $response = $this->_employeeServiceInterface->deleteBulk($ids);

        if (!$response->isSuccess()) {
            return $this->getBasicErrorJson($response);
        }

        return $this->getBasicSuccessJson($response);
    }

    /**
     * @OA\Post(
     *     path="/employee/list-search/export",
     *     operationId="postEmployeeListSearchExport",
     *     summary="Export list of employee",
     *     tags={"Employee"},
     *     description="Export list of employee",
     *     security={
     *          {
     *              "apiKey": {"*"}
     *          }
     *     },
     *     @OA\RequestBody(
     *          @OA\MediaType(
     *              mediaType="application/json",
     *              @OA\Schema(
     *                  @OA\Property(
     *                      property="export",
     *                      description="Export property",
     *                      type="string",
     *                      enum={"excel", "pdf"},
     *                      default="",
     *                      example="excel"
     *                  ),
     *                  @OA\Property(property="company_id", ref="#/components/schemas/EmployeeEloquent/properties/company_id"),
     *                  @OA\Property(property="gender_id", ref="#/components/schemas/EmployeeEloquent/properties/gender_id"),
     *                  @OA\Property(property="religion_id", ref="#/components/schemas/EmployeeEloquent/properties/religion_id"),
     *                  @OA\Property(
     *                      property="start_birth_date",
     *                      description="Start birth date property",
     *                      type="string",
     *                      format="date-time",
     *                      example="2020-01-01 00:00:00"
     *                  ),
     *                  @OA\Property(
     *                      property="end_birth_date",
     *                      description="End birth date property",
     *                      type="string",
     *                      format="date-time",
     *                      example="2020-01-01 00:00:00"
     *                  ),
     *                  @OA\Property(
     *                      property="start_identity_expired_date",
     *                      description="Start identity expired date property",
     *                      type="string",
     *                      format="date-time",
     *                      example="2020-01-01 00:00:00"
     *                  ),
     *                  @OA\Property(
     *                      property="end_identity_expired_date",
     *                      description="End identity expired date property",
     *                      type="string",
     *                      format="date-time",
     *                      example="2020-01-01 00:00:00"
     *                  ),
     *                  @OA\Property(
     *                      property="start_drive_license_a_date",
     *                      description="Start drive license a date property",
     *                      type="string",
     *                      format="date-time",
     *                      example="2020-01-01 00:00:00"
     *                  ),
     *                  @OA\Property(
     *                      property="end_drive_license_a_date",
     *                      description="End drive license a date property",
     *                      type="string",
     *                      format="date-time",
     *                      example="2020-01-01 00:00:00"
     *                  ),
     *                  @OA\Property(
     *                      property="start_drive_license_b_date",
     *                      description="Start drive license b date property",
     *                      type="string",
     *                      format="date-time",
     *                      example="2020-01-01 00:00:00"
     *                  ),
     *                  @OA\Property(
     *                      property="end_drive_license_b_date",
     *                      description="End drive license b date property",
     *                      type="string",
     *                      format="date-time",
     *                      example="2020-01-01 00:00:00"
     *                  ),
     *                  @OA\Property(
     *                      property="start_drive_license_c_date",
     *                      description="Start drive license c date property",
     *                      type="string",
     *                      format="date-time",
     *                      example="2020-01-01 00:00:00"
     *                  ),
     *                  @OA\Property(
     *                      property="end_drive_license_c_date",
     *                      description="End drive license c date property",
     *                      type="string",
     *                      format="date-time",
     *                      example="2020-01-01 00:00:00"
     *                  ),
     *                  @OA\Property(property="marital_status_id", ref="#/components/schemas/EmployeeEloquent/properties/marital_status_id"),
     *                  @OA\Property(property="mate_as", ref="#/components/schemas/EmployeeEloquent/properties/mate_as"),
     *                  @OA\Property(
     *                      property="start_mate_birth_date",
     *                      description="Start mate birth date property",
     *                      type="string",
     *                      format="date-time",
     *                      example="2020-01-01 00:00:00"
     *                  ),
     *                  @OA\Property(
     *                      property="end_mate_birth_date",
     *                      description="End mate birth date property",
     *                      type="string",
     *                      format="date-time",
     *                      example="2020-01-01 00:00:00"
     *                  ),
     *                  @OA\Property(property="office_id", ref="#/components/schemas/EmployeeEloquent/properties/office_id"),
     *                  @OA\Property(property="work_area_id", ref="#/components/schemas/EmployeeEloquent/properties/work_area_id"),
     *                  @OA\Property(
     *                      property="start_npwp_date",
     *                      description="Start npwp date property",
     *                      type="string",
     *                      format="date-time",
     *                      example="2020-01-01 00:00:00"
     *                  ),
     *                  @OA\Property(
     *                      property="end_npwp_date",
     *                      description="End npwp date property",
     *                      type="string",
     *                      format="date-time",
     *                      example="2020-01-01 00:00:00"
     *                  ),
     *                  @OA\Property(property="npwp_status", ref="#/components/schemas/EmployeeEloquent/properties/npwp_status"),
     *                  @OA\Property(
     *                      property="start_bpjs_tenaga_kerja_date",
     *                      description="Start bpjs tenaga kerja date property",
     *                      type="string",
     *                      format="date-time",
     *                      example="2020-01-01 00:00:00"
     *                  ),
     *                  @OA\Property(
     *                      property="end_bpjs_tenaga_kerja_date",
     *                      description="End bpjs tenaga kerja date property",
     *                      type="string",
     *                      format="date-time",
     *                      example="2020-01-01 00:00:00"
     *                  ),
     *                  @OA\Property(property="bpjs_tenaga_kerja_class", ref="#/components/schemas/EmployeeEloquent/properties/bpjs_tenaga_kerja_class"),
     *                  @OA\Property(
     *                      property="start_bpjs_kesehatan_date",
     *                      description="Start bpjs kesehatan date property",
     *                      type="string",
     *                      format="date-time",
     *                      example="2020-01-01 00:00:00"
     *                  ),
     *                  @OA\Property(
     *                      property="end_bpjs_kesehatan_date",
     *                      description="End bpjs kesehatan date property",
     *                      type="string",
     *                      format="date-time",
     *                      example="2020-01-01 00:00:00"
     *                  ),
     *                  @OA\Property(property="bpjs_kesehatan_class", ref="#/components/schemas/EmployeeEloquent/properties/bpjs_kesehatan_class"),
     *                  @OA\Property(
     *                      property="start_mate_bpjs_kesehatan_date",
     *                      description="Start mate bpjs kesehatan date property",
     *                      type="string",
     *                      format="date-time",
     *                      example="2020-01-01 00:00:00"
     *                  ),
     *                  @OA\Property(
     *                      property="end_mate_bpjs_kesehatan_date",
     *                      description="End mate bpjs kesehatan date property",
     *                      type="string",
     *                      format="date-time",
     *                      example="2020-01-01 00:00:00"
     *                  ),
     *                  @OA\Property(property="mate_bpjs_kesehatan_class", ref="#/components/schemas/EmployeeEloquent/properties/mate_bpjs_kesehatan_class"),
     *                  @OA\Property(property="bank_id", ref="#/components/schemas/EmployeeEloquent/properties/bank_id"),
     *                  @OA\Property(
     *                      property="start_join_date",
     *                      description="Start join date property",
     *                      type="string",
     *                      format="date-time",
     *                      example="2020-01-01 00:00:00"
     *                  ),
     *                  @OA\Property(
     *                      property="end_join_date",
     *                      description="End join date property",
     *                      type="string",
     *                      format="date-time",
     *                      example="2020-01-01 00:00:00"
     *                  ),
     *                  @OA\Property(property="work_status", ref="#/components/schemas/EmployeeEloquent/properties/work_status"),
     *                  @OA\Property(property="work_type", ref="#/components/schemas/EmployeeEloquent/properties/work_type"),
     *                  @OA\Property(property="degree_id", ref="#/components/schemas/FormalEducationHistoryEloquent/properties/degree_id"),
     *                  @OA\Property(property="major_id", ref="#/components/schemas/FormalEducationHistoryEloquent/properties/major_id"),
     *                  @OA\Property(property="competence_id", ref="#/components/schemas/WorkCompetenceEloquent/properties/competence_id"),
     *                  @OA\Property(property="position_id", ref="#/components/schemas/PositionMutationEloquent/properties/position_id"),
     *                  @OA\Property(property="project_id", ref="#/components/schemas/ProjectMutationEloquent/properties/project_id"),
     *                  @OA\Property(property="work_unit_id", ref="#/components/schemas/WorkUnitMutationEloquent/properties/work_unit_id"),
     *              )
     *          )
     *     ),
     *     @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *          @OA\JsonContent()
     *     ),
     *     @OA\Response(
     *          response=400,
     *          description="Bad request",
     *          @OA\JsonContent()
     *     ),
     *     @OA\Response(
     *          response=401,
     *          description="Unauthenticated",
     *          @OA\JsonContent()
     *     )
     * )
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function postEmployeeListSearchExport(Request $request)
    {
        $export = $request->input('export');
        $companyId = $request->input('company_id');
        $genderId = $request->input('gender_id');
        $religionId = $request->input('religion_id');

        $rangeBirthDate = new DateTimeRange($request->input('start_birth_date'), $request->input('end_birth_date'));
        $rangeIdentityExpiredDate = new DateTimeRange($request->input('start_identity_expired_date'), $request->input('end_identity_expired_date'));
        $rangeDriveLicenseADate = new DateTimeRange($request->input('start_drive_license_a_date'), $request->input('end_drive_license_a_date'));
        $rangeDriveLicenseBDate = new DateTimeRange($request->input('start_drive_license_b_date'), $request->input('end_drive_license_b_date'));
        $rangeDriveLicenseCDate = new DateTimeRange($request->input('start_drive_license_c_date'), $request->input('end_drive_license_c_date'));

        $maritalStatusId = $request->input('marital_status_id');

        $mateAs = $request->input('mate_as');
        $rangeMateBirthDate = new DateTimeRange($request->input('start_mate_birth_date'), $request->input('end_mate_birth_date'));

        $officeId = $request->input('office_id');
        $workAreaId = $request->input('work_area_id');

        $rangeNPWPDate = new DateTimeRange($request->input('start_npwp_date'), $request->input('end_npwp_date'));
        $npwpStatus = $request->input('npwp_status');
        $rangeBPJSTenagaKerjaDate = new DateTimeRange($request->input('start_bpjs_tenaga_kerja_date'), $request->input('end_bpjs_tenaga_kerja_date'));
        $bpjsTenagaKerjaClass = $request->input('bpjs_tenaga_kerja_class');
        $rangeBPJSKesehatanDate = new DateTimeRange($request->input('start_bpjs_kesehatan_date'), $request->input('end_bpjs_kesehatan_date'));
        $bpjsKesehatanClass = $request->input('bpjs_kesehatan_class');
        $rangeMateBPJSKesehatanDate = new DateTimeRange($request->input('start_mate_bpjs_kesehatan_date'), $request->input('end_mate_bpjs_kesehatan_date'));
        $mateBPJSKesehatanClass = $request->input('bpjs_mate_kesehatan_class');

        $bankId = $request->input('bank_id');

        $rangeJoinDate = new DateTimeRange($request->input('start_join_date'), $request->input('end_join_date'));
        $workStatus = $request->input('work_status');
        $workType = $request->input('work_type');

        $degreeId = $request->input('degree_id');
        $majorId = $request->input('major_id');
        $competenceId = $request->input('competence_id');
        $positionId = $request->input('position_id');
        $projectId = $request->input('project_id');
        $workUnitId = $request->input('work_unit_id');

        return $this->getListSearchExportJson($request,
            [$this->_employeeServiceInterface, 'employeeListSearch'],
            function (Collection $entities, string $export) {
                switch ($export) {
                    case 'excel':
                        $ext = '.xlsx';

                        return self::generateExcel($entities, $ext);

                        break;

                    case 'pdf':
                        $ext = '.pdf';

                        return self::generatePDF($entities, $ext);

                        break;

                    default:
                        //Do nothing
                        break;
                }
            },
            $export, $companyId, $genderId, $religionId, $rangeBirthDate, $rangeIdentityExpiredDate,
            $rangeDriveLicenseADate, $rangeDriveLicenseBDate, $rangeDriveLicenseCDate, $maritalStatusId, $mateAs,
            $rangeMateBirthDate, $officeId, $workAreaId, $rangeNPWPDate, $npwpStatus,
            $rangeBPJSTenagaKerjaDate, $bpjsTenagaKerjaClass, $rangeBPJSKesehatanDate, $bpjsKesehatanClass, $rangeMateBPJSKesehatanDate,
            $mateBPJSKesehatanClass, $bankId, $rangeJoinDate, $workStatus, $workType, $degreeId, $majorId,
            $competenceId, $positionId, $projectId, $workUnitId);

    }

    //</editor-fold>


    //<editor-fold desc="#private (method)">

    /**
     * @param Collection $entities
     * @param string|null $ext
     * @return mixed
     */
    private function generateExcel(Collection $entities, string $ext = null) {
        $response = new BooleanResponse();

        $path = 'public/';
        $file = uniqid() . $ext;

        if (Excel::store(new EmployeeExport($entities), $path . $file)) {
            $response->setResult(true);
            $response->addSuccessMessageResponse($response->getMessageCollection(), 'Success file generate', 200);
        } else {
            $response->setResult(false);
            $response->addErrorMessageResponse($response->getMessageCollection(), 'Invalid file generate', 400);
        }

        if (!$response->isSuccess()) {
            return $this->getBasicErrorJson($response);
        }

        return $this->getBasicSuccessJson($response, [
            'result' => $response->getBoolean(),
            'file' => $file
        ])->getData();
    }

    /**
     * @param Collection $entities
     * @param string|null $ext
     * @return mixed
     */
    private function generatePDF(Collection $entities, string $ext = null) {
        $response = new BooleanResponse();

        $path = 'storage/';
        $file = uniqid() . $ext;

        if (PDF::loadView('exports.human-resources.personal.employee', ['employees' => $entities])
            ->setPaper('a4', 'landscape')
            ->save($path . $file)) {
            $response->setResult(true);
            $response->addSuccessMessageResponse($response->getMessageCollection(), 'Success file generate', 200);
        } else {
            $response->setResult(false);
            $response->addErrorMessageResponse($response->getMessageCollection(), 'Invalid file generate', 400);
        }

        if (!$response->isSuccess()) {
            return $this->getBasicErrorJson($response);
        }

        return $this->getBasicSuccessJson($response, [
            'result' => $response->getBoolean(),
            'file' =>  $file
        ])->getData();
    }

    /**
     * @param int $id
     * @param callable $searchMethod
     * @param callable $dtoObjectToJsonMethod
     * @return \Illuminate\Http\JsonResponse
     */
    private function getDetailObjectJson(int $id,
                                         callable $searchMethod,
                                         callable $dtoObjectToJsonMethod)
    {
        $response = $searchMethod($id);
        $itemJsonData = $dtoObjectToJsonMethod($response->getObject());

        if ($response->isSuccess()) {
            return response()->json($itemJsonData);
        }

        return $this->getBasicErrorJson($response);
    }


    /**
     * @param callable $searchMethod
     * @param callable $dtoCollectionToRowJsonMethod
     * @param int|null $companyId
     * @param int|null $genderId
     * @param int|null $religionId
     * @param object|null $rangeBirthDate
     * @param object|null $rangeIdentityExpiredDate
     * @param object|null $rangeDriveLicenseADate
     * @param object|null $rangeDriveLicenseBDate
     * @param object|null $rangeDriveLicenseCDate
     * @param int|null $maritalStatusId
     * @param string|null $mateAs
     * @param object|null $rangeMateBirthDate
     * @param int|null $officeId
     * @param int|null $workAreaId
     * @param object|null $rangeNPWPDate
     * @param string|null $npwpStatus
     * @param object|null $rangeBPJSTenagaKerjaDate
     * @param string|null $bpjsTenagaKerjaClass
     * @param object|null $rangeBPJSKesehatanDate
     * @param string|null $bpjsKesehatanClass
     * @param object|null $rangeMateBPJSKesehatanDate
     * @param string|null $mateBPJSKesehatanClass
     * @param int|null $bankId
     * @param object|null $rangeJoinDate
     * @param string|null $workStatus
     * @param string|null $workType
     * @param int|null $degreeId
     * @param int|null $majorId
     * @param int|null $competenceId
     * @param int|null $positionId
     * @param int|null $projectId
     * @param int|null $workUnitId
     * @return \Illuminate\Http\JsonResponse
     */
    private function getListJson(callable $searchMethod,
                                 callable $dtoCollectionToRowJsonMethod,
                                 int $companyId = null, int $genderId = null, int $religionId = null, object $rangeBirthDate = null, object $rangeIdentityExpiredDate = null,
                                 object $rangeDriveLicenseADate = null, object $rangeDriveLicenseBDate = null, object $rangeDriveLicenseCDate = null, int $maritalStatusId = null, string $mateAs = null,
                                 object $rangeMateBirthDate = null, int $officeId = null, int $workAreaId = null, object $rangeNPWPDate = null, string $npwpStatus = null,
                                 object $rangeBPJSTenagaKerjaDate = null, string $bpjsTenagaKerjaClass = null, object $rangeBPJSKesehatanDate = null, string $bpjsKesehatanClass = null, object $rangeMateBPJSKesehatanDate = null,
                                 string $mateBPJSKesehatanClass = null, int $bankId = null, object $rangeJoinDate = null, string $workStatus = null, string $workType = null, int $degreeId = null, int $majorId = null,
                                 int $competenceId = null, int $positionId = null, int $projectId = null, int $workUnitId = null)
    {
        $response = $searchMethod($companyId, $genderId, $religionId, $rangeBirthDate, $rangeIdentityExpiredDate,
            $rangeDriveLicenseADate, $rangeDriveLicenseBDate, $rangeDriveLicenseCDate, $maritalStatusId, $mateAs,
            $rangeMateBirthDate, $officeId, $workAreaId, $rangeNPWPDate, $npwpStatus,
            $rangeBPJSTenagaKerjaDate, $bpjsTenagaKerjaClass, $rangeBPJSKesehatanDate, $bpjsKesehatanClass, $rangeMateBPJSKesehatanDate,
            $mateBPJSKesehatanClass, $bankId, $rangeJoinDate, $workStatus, $workType, $degreeId, $majorId,
            $competenceId, $positionId, $projectId, $workUnitId);
        $rowJsonData = $dtoCollectionToRowJsonMethod($response->getDtoCollection());

        if ($response->isSuccess()) {
            return response()->json([
                'rows' => $rowJsonData
            ]);
        }

        return $this->getBasicErrorJson($response);
    }

    /**
     * @param int|null $companyId
     * @param int|null $officeId
     * @param object|null $rangeTerminationDate
     * @param callable $searchMethod
     * @param callable $dtoCollectionToRowJsonMethod
     * @return \Illuminate\Http\JsonResponse
     */
    private function getListJsonEmployeeTerminated(int $companyId = null, int $officeId = null, object $rangeTerminationDate = null,
                                                   callable $searchMethod,
                                                   callable $dtoCollectionToRowJsonMethod)
    {
        $response = $searchMethod($companyId, $officeId, $rangeTerminationDate);
        $rowJsonData = $dtoCollectionToRowJsonMethod($response->getDtoCollection());

        if ($response->isSuccess()) {
            return response()->json([
                'rows' => $rowJsonData
            ]);
        }

        return $this->getBasicErrorJson($response);
    }


    /**
     * @param int|null $companyId
     * @param int|null $officeId
     * @param int|null $month
     * @param callable $searchMethod
     * @param callable $dtoCollectionToRowJsonMethod
     * @return \Illuminate\Http\JsonResponse
     */
    private function getListJsonEmployeeBithday(int $companyId = null, int $officeId = null, int $month = null,
                                                callable $searchMethod,
                                                callable $dtoCollectionToRowJsonMethod)
    {
        $response = $searchMethod($companyId, $officeId, $month);
        $rowJsonData = $dtoCollectionToRowJsonMethod($response->getDtoCollection());

        if ($response->isSuccess()) {
            return response()->json([
                'rows' => $rowJsonData
            ]);
        }

        return $this->getBasicErrorJson($response);
    }

    /**
     * @param Request $request
     * @param callable $searchMethod
     * @param callable $dtoCollectionToRowJsonMethod
     * @param int|null $companyId
     * @param int|null $genderId
     * @param int|null $religionId
     * @param object|null $rangeBirthDate
     * @param object|null $rangeIdentityExpiredDate
     * @param object|null $rangeDriveLicenseADate
     * @param object|null $rangeDriveLicenseBDate
     * @param object|null $rangeDriveLicenseCDate
     * @param int|null $maritalStatusId
     * @param string|null $mateAs
     * @param object|null $rangeMateBirthDate
     * @param int|null $officeId
     * @param int|null $workAreaId
     * @param object|null $rangeNPWPDate
     * @param string|null $npwpStatus
     * @param object|null $rangeBPJSTenagaKerjaDate
     * @param string|null $bpjsTenagaKerjaClass
     * @param object|null $rangeBPJSKesehatanDate
     * @param string|null $bpjsKesehatanClass
     * @param object|null $rangeMateBPJSKesehatanDate
     * @param string|null $mateBPJSKesehatanClass
     * @param int|null $bankId
     * @param object|null $rangeJoinDate
     * @param string|null $workStatus
     * @param string|null $workType
     * @param int|null $degreeId
     * @param int|null $majorId
     * @param int|null $competenceId
     * @param int|null $positionId
     * @param int|null $projectId
     * @param int|null $workUnitId
     * @return \Illuminate\Http\JsonResponse
     */
    private function getListSearchJson(Request $request,
                                 callable $searchMethod,
                                 callable $dtoCollectionToRowJsonMethod,
                                 int $companyId = null, int $genderId = null, int $religionId = null, object $rangeBirthDate = null, object $rangeIdentityExpiredDate = null,
                                 object $rangeDriveLicenseADate = null, object $rangeDriveLicenseBDate = null, object $rangeDriveLicenseCDate = null, int $maritalStatusId = null, string $mateAs = null,
                                 object $rangeMateBirthDate = null, int $officeId = null, int $workAreaId = null, object $rangeNPWPDate = null, string $npwpStatus = null,
                                 object $rangeBPJSTenagaKerjaDate = null, string $bpjsTenagaKerjaClass = null, object $rangeBPJSKesehatanDate = null, string $bpjsKesehatanClass = null, object $rangeMateBPJSKesehatanDate = null,
                                 string $mateBPJSKesehatanClass = null, int $bankId = null, object $rangeJoinDate = null, string $workStatus = null, string $workType = null, int $degreeId = null, int $majorId = null,
                                 int $competenceId = null, int $positionId = null, int $projectId = null, int $workUnitId = null)
    {
        $parameter = $this->generateListSearchParameter($request);
        $response = $searchMethod($parameter, $companyId, $genderId, $religionId, $rangeBirthDate, $rangeIdentityExpiredDate,
            $rangeDriveLicenseADate, $rangeDriveLicenseBDate, $rangeDriveLicenseCDate, $maritalStatusId, $mateAs,
            $rangeMateBirthDate, $officeId, $workAreaId, $rangeNPWPDate, $npwpStatus,
            $rangeBPJSTenagaKerjaDate, $bpjsTenagaKerjaClass, $rangeBPJSKesehatanDate, $bpjsKesehatanClass, $rangeMateBPJSKesehatanDate,
            $mateBPJSKesehatanClass, $bankId, $rangeJoinDate, $workStatus, $workType, $degreeId, $majorId,
            $competenceId, $positionId, $projectId, $workUnitId);
        $rowJsonData = $dtoCollectionToRowJsonMethod($response->getDtoCollection());

        if ($response->isSuccess()) {
            return response()->json([
                'rows' => $rowJsonData,
                'rowCountTotal' => $response->getTotalCount()
            ]);
        }

        return $this->getBasicErrorJson($response);
    }

    /**
     * @param Request $request
     * @param string|null $export
     * @param int|null $companyId
     * @param int|null $genderId
     * @param int|null $religionId
     * @param object|null $rangeBirthDate
     * @param object|null $rangeIdentityExpiredDate
     * @param object|null $rangeDriveLicenseADate
     * @param object|null $rangeDriveLicenseBDate
     * @param object|null $rangeDriveLicenseCDate
     * @param int|null $maritalStatusId
     * @param string|null $mateAs
     * @param object|null $rangeMateBirthDate
     * @param int|null $officeId
     * @param int|null $workAreaId
     * @param object|null $rangeNPWPDate
     * @param string|null $npwpStatus
     * @param string|null $workType
     * @param object|null $rangeBPJSTenagaKerjaDate
     * @param string|null $bpjsTenagaKerjaClass
     * @param object|null $rangeBPJSKesehatanDate
     * @param string|null $bpjsKesehatanClass
     * @param object|null $rangeMateBPJSKesehatanDate
     * @param string|null $mateBPJSKesehatanClass
     * @param int|null $bankId
     * @param object|null $rangeJoinDate
     * @param string|null $workStatus
     * @param string|null $workType
     * @param int|null $degreeId
     * @param int|null $majorId
     * @param int|null $competenceId
     * @param int|null $positionId
     * @param int|null $projectId
     * @param int|null $workUnitId
     * @param callable $searchMethod
     * @param callable $dtoObjectToJsonMethod
     * @return \Illuminate\Http\JsonResponse
     */
    private function getListSearchExportJson(Request $request,
                                             callable $searchMethod,
                                             callable $dtoObjectToJsonMethod,
                                             string $export = null, int $companyId = null, int $genderId = null, int $religionId = null, object $rangeBirthDate = null, object $rangeIdentityExpiredDate = null,
                                             object $rangeDriveLicenseADate = null, object $rangeDriveLicenseBDate = null, object $rangeDriveLicenseCDate = null, int $maritalStatusId = null, string $mateAs = null,
                                             object $rangeMateBirthDate = null, int $officeId = null, int $workAreaId = null, object $rangeNPWPDate = null, string $npwpStatus = null,
                                             object $rangeBPJSTenagaKerjaDate = null, string $bpjsTenagaKerjaClass = null, object $rangeBPJSKesehatanDate = null, string $bpjsKesehatanClass = null, object $rangeMateBPJSKesehatanDate = null,
                                             string $mateBPJSKesehatanClass = null, int $bankId = null, object $rangeJoinDate = null, string $workStatus = null, string $workType = null, int $degreeId = null, int $majorId = null,
                                             int $competenceId = null, int $positionId = null, int $projectId = null, int $workUnitId = null)
    {
        $parameter = $this->generateListSearchParameter($request);
        $response = $searchMethod($parameter, $companyId, $genderId, $religionId, $rangeBirthDate, $rangeIdentityExpiredDate,
            $rangeDriveLicenseADate, $rangeDriveLicenseBDate, $rangeDriveLicenseCDate, $maritalStatusId, $mateAs,
            $rangeMateBirthDate, $officeId, $workAreaId, $rangeNPWPDate, $npwpStatus, $workType,
            $rangeBPJSTenagaKerjaDate, $bpjsTenagaKerjaClass, $rangeBPJSKesehatanDate, $bpjsKesehatanClass, $rangeMateBPJSKesehatanDate,
            $mateBPJSKesehatanClass, $bankId, $rangeJoinDate, $workStatus, $workType, $degreeId, $majorId,
            $competenceId, $positionId, $projectId, $workUnitId);
        $rowJsonData = $dtoObjectToJsonMethod($response->getDtoCollection(), $export);

        if ($response->isSuccess()) {
            return response()->json([
                'rows' => $rowJsonData,
                'rowCountTotal' => $response->getTotalCount()
            ]);
        }

        return $this->getBasicErrorJson($response);
    }

    /**
     * @param Request $request
     * @param int|null $companyId
     * @param int|null $officeId
     * @param object|null $rangeTerminationDate
     * @param callable $searchMethod
     * @param callable $dtoCollectionToRowJsonMethod
     * @return \Illuminate\Http\JsonResponse
     */
    private function getListSearchJsonEmployeeTerminated(Request $request, int $companyId = null, int $officeId = null, object $rangeTerminationDate = null,
                                           callable $searchMethod,
                                           callable $dtoCollectionToRowJsonMethod)
    {
        $parameter = $this->generateListSearchParameter($request);
        $response = $searchMethod($parameter, $companyId, $officeId, $rangeTerminationDate);
        $rowJsonData = $dtoCollectionToRowJsonMethod($response->getDtoCollection());

        if ($response->isSuccess()) {
            return response()->json([
                'rows' => $rowJsonData,
                'rowCountTotal' => $response->getTotalCount()
            ]);
        }

        return $this->getBasicErrorJson($response);
    }

    /**
     * @param Request $request
     * @param int|null $companyId
     * @param int|null $officeId
     * @param int|null $month
     * @param callable $searchMethod
     * @param callable $dtoCollectionToRowJsonMethod
     * @return \Illuminate\Http\JsonResponse
     */
    private function getListSearchJsonEmployeeBithday(Request $request, int $companyId = null, int $officeId = null, int $month = null,
                                                      callable $searchMethod,
                                                      callable $dtoCollectionToRowJsonMethod)
    {
        $parameter = $this->generateListSearchParameter($request);
        $response = $searchMethod($parameter, $companyId, $officeId, $month);
        $rowJsonData = $dtoCollectionToRowJsonMethod($response->getDtoCollection());

        if ($response->isSuccess()) {
            return response()->json([
                'rows' => $rowJsonData,
                'rowCountTotal' => $response->getTotalCount()
            ]);
        }

        return $this->getBasicErrorJson($response);
    }

    /**
     * @param Request $request
     * @param int|null $companyId
     * @param callable $searchMethod
     * @param callable $dtoCollectionToRowJsonMethod
     * @return \Illuminate\Http\JsonResponse
     */
    private function getEmployeeListGroupByOffice(Request $request, int $companyId = null, callable $searchMethod, callable $dtoCollectionToRowJsonMethod)
    {
        $parameter = $this->generateListSearchParameter($request);
        $response = $searchMethod($parameter, $companyId);
        $rowJsonData = $dtoCollectionToRowJsonMethod($response->getDtoCollection());

        if ($response->isSuccess()) {
            return response()->json([
                'rows' => $rowJsonData,
                'rowCountTotal' => $response->getTotalCount()
            ]);
        }

        return $this->getBasicErrorJson($response);
    }

    /**
     * @param Request $request
     * @param int|null $companyId
     * @param callable $searchMethod
     * @param callable $dtoCollectionToRowJsonMethod
     * @return \Illuminate\Http\JsonResponse
     */
    private function getEmployeeListGroupByWorkArea(Request $request, int $companyId = null, callable $searchMethod, callable $dtoCollectionToRowJsonMethod)
    {
        $parameter = $this->generateListSearchParameter($request);
        $response = $searchMethod($parameter, $companyId);
        $rowJsonData = $dtoCollectionToRowJsonMethod($response->getDtoCollection());

        if ($response->isSuccess()) {
            return response()->json([
                'rows' => $rowJsonData,
                'rowCountTotal' => $response->getTotalCount()
            ]);
        }

        return $this->getBasicErrorJson($response);
    }

    /**
     * @param Request $request
     * @param int|null $companyId
     * @param callable $searchMethod
     * @param callable $dtoCollectionToRowJsonMethod
     * @return \Illuminate\Http\JsonResponse
     */
    private function getEmployeeListGroupByPosition(Request $request, int $companyId = null, callable $searchMethod, callable $dtoCollectionToRowJsonMethod)
    {
        $parameter = $this->generateListSearchParameter($request);
        $response = $searchMethod($parameter, $companyId);
        $rowJsonData = $dtoCollectionToRowJsonMethod($response->getDtoCollection());

        if ($response->isSuccess()) {
            return response()->json([
                'rows' => $rowJsonData,
                'rowCountTotal' => $response->getTotalCount()
            ]);
        }

        return $this->getBasicErrorJson($response);
    }

    /**
     * @param Request $request
     * @param int|null $companyId
     * @param callable $searchMethod
     * @param callable $dtoCollectionToRowJsonMethod
     * @return \Illuminate\Http\JsonResponse
     */
    private function getEmployeeListGroupByWorkUnit(Request $request, int $companyId = null, callable $searchMethod, callable $dtoCollectionToRowJsonMethod)
    {
        $parameter = $this->generateListSearchParameter($request);
        $response = $searchMethod($parameter, $companyId);
        $rowJsonData = $dtoCollectionToRowJsonMethod($response->getDtoCollection());

        if ($response->isSuccess()) {
            return response()->json([
                'rows' => $rowJsonData,
                'rowCountTotal' => $response->getTotalCount()
            ]);
        }

        return $this->getBasicErrorJson($response);
    }


    /**
     * @param Request $request
     * @param callable $searchMethod
     * @param callable $dtoCollectionToRowJsonMethod
     * @param int $companyId
     * @param int $genderId
     * @param int $religionId
     * @param object|null $rangeBirthDate
     * @param object|null $rangeIdentityExpiredDate
     * @param object|null $rangeDriveLicenseADate
     * @param object|null $rangeDriveLicenseBDate
     * @param object|null $rangeDriveLicenseCDate
     * @param int $maritalStatusId
     * @param string|null $mateAs
     * @param object|null $rangeMateBirthDate
     * @param int|null $officeId
     * @param int $workAreaId
     * @param object|null $rangeNPWPDate
     * @param string|null $npwpStatus
     * @param object|null $rangeBPJSTenagaKerjaDate
     * @param string|null $bpjsTenagaKerjaClass
     * @param object|null $rangeBPJSKesehatanDate
     * @param string|null $bpjsKesehatanClass
     * @param object|null $rangeMateBPJSKesehatanDate
     * @param string|null $mateBPJSKesehatanClass
     * @param int $bankId
     * @param object|null $rangeJoinDate
     * @param string|null $workStatus
     * @param string|null $workType
     * @param int $degreeId
     * @param int $majorId
     * @param int|null $competenceId
     * @param int|null $positionId
     * @param int|null $projectId
     * @param int|null $workUnitId
     * @return \Illuminate\Http\JsonResponse
     */
    private function getPagedSearchJson(Request $request,
                                        callable $searchMethod,
                                        callable $dtoCollectionToRowJsonMethod,
                                        int $companyId = null, int $genderId = null, int $religionId = null, object $rangeBirthDate = null, object $rangeIdentityExpiredDate = null,
                                        object $rangeDriveLicenseADate = null, object $rangeDriveLicenseBDate = null, object $rangeDriveLicenseCDate = null, int $maritalStatusId = null, string $mateAs = null,
                                        object $rangeMateBirthDate = null, int $officeId = null, int $workAreaId = null, object $rangeNPWPDate = null, string $npwpStatus = null,
                                        object $rangeBPJSTenagaKerjaDate = null, string $bpjsTenagaKerjaClass = null, object $rangeBPJSKesehatanDate = null, string $bpjsKesehatanClass = null, object $rangeMateBPJSKesehatanDate = null,
                                        string $mateBPJSKesehatanClass = null, int $bankId = null, object $rangeJoinDate = null, string $workStatus = null, string $workType = null, int $degreeId = null, int $majorId = null,
                                        int $competenceId = null, int $positionId = null, int $projectId = null, int $workUnitId = null)
    {
        $parameter = $this->generatePageSearchParameter($request);
        $response = $searchMethod($parameter, $companyId, $genderId, $religionId, $rangeBirthDate, $rangeIdentityExpiredDate,
            $rangeDriveLicenseADate, $rangeDriveLicenseBDate, $rangeDriveLicenseCDate, $maritalStatusId, $mateAs,
            $rangeMateBirthDate, $officeId, $workAreaId, $rangeNPWPDate, $npwpStatus,
            $rangeBPJSTenagaKerjaDate, $bpjsTenagaKerjaClass, $rangeBPJSKesehatanDate, $bpjsKesehatanClass, $rangeMateBPJSKesehatanDate,
            $mateBPJSKesehatanClass, $bankId, $rangeJoinDate, $workStatus, $workType, $degreeId, $majorId,
            $competenceId, $positionId, $projectId, $workUnitId);
        $rowJsonData = $dtoCollectionToRowJsonMethod($response->getDtoCollection());

        if ($response->isSuccess()) {
            if ($parameter->draw) {
                return response()->json([
                    'rows' => $rowJsonData,
                    'rowCountPage' => $response->getTotalPage(),
                    'rowCountTotal' => $response->getTotalCount()
                ]);
            } else {
                return response()->json([
                    'meta' => [
                        'page' => (integer)$parameter->pagination['page'],
                        'pages' => $response->getTotalPage(),
                        'perpage' => (integer)$parameter->pagination['perpage'],
                        'total' => $response->getTotalCount(),
                        'sort' => $parameter->sort['sort'],
                        'field' => $parameter->sort['field']
                    ],
                    'rows' => $rowJsonData
                ]);
            }
        }

        return $this->getBasicErrorJson($response);
    }

    /**
     * @param Request $request
     * @param int|null $companyId
     * @param int|null $officeId
     * @param object|null $rangeTerminationDate
     * @param callable $searchMethod
     * @param callable $dtoCollectionToRowJsonMethod
     * @return \Illuminate\Http\JsonResponse
     */
    private function getPageSearchJsonEmployeeTerminated(Request $request, int $companyId = null, int $officeId = null, object $rangeTerminationDate = null,
                                                         callable $searchMethod,
                                                         callable $dtoCollectionToRowJsonMethod)
    {
        $parameter = $this->generateListSearchParameter($request);
        $response = $searchMethod($parameter, $companyId, $officeId, $rangeTerminationDate);
        $rowJsonData = $dtoCollectionToRowJsonMethod($response->getDtoCollection());

        if ($response->isSuccess()) {
            if ($parameter->draw) {
                return response()->json([
                    'rows' => $rowJsonData,
                    'rowCountPage' => $response->getTotalPage(),
                    'rowCountTotal' => $response->getTotalCount()
                ]);
            } else {
                return response()->json([
                    'meta' => [
                        'page' => (integer)$parameter->pagination['page'],
                        'pages' => $response->getTotalPage(),
                        'perpage' => (integer)$parameter->pagination['perpage'],
                        'total' => $response->getTotalCount(),
                        'sort' => $parameter->sort['sort'],
                        'field' => $parameter->sort['field']
                    ],
                    'rows' => $rowJsonData
                ]);
            }
        }

        return $this->getBasicErrorJson($response);
    }

    /**
     * @param Request $request
     * @param int|null $companyId
     * @param int|null $officeId
     * @param int|null $month
     * @param callable $searchMethod
     * @param callable $dtoCollectionToRowJsonMethod
     * @return \Illuminate\Http\JsonResponse
     */
    private function getPageSearchJsonEmployeeBithday(Request $request, int $companyId = null, int $officeId = null, int $month = null,
                                                      callable $searchMethod,
                                                      callable $dtoCollectionToRowJsonMethod)
    {
        $parameter = $this->generateListSearchParameter($request);
        $response = $searchMethod($parameter, $companyId, $officeId, $month);
        $rowJsonData = $dtoCollectionToRowJsonMethod($response->getDtoCollection());

        if ($response->isSuccess()) {
            if ($parameter->draw) {
                return response()->json([
                    'rows' => $rowJsonData,
                    'rowCountPage' => $response->getTotalPage(),
                    'rowCountTotal' => $response->getTotalCount()
                ]);
            } else {
                return response()->json([
                    'meta' => [
                        'page' => (integer)$parameter->pagination['page'],
                        'pages' => $response->getTotalPage(),
                        'perpage' => (integer)$parameter->pagination['perpage'],
                        'total' => $response->getTotalCount(),
                        'sort' => $parameter->sort['sort'],
                        'field' => $parameter->sort['field']
                    ],
                    'rows' => $rowJsonData
                ]);
            }
        }

        return $this->getBasicErrorJson($response);
    }


    /**
     * @param CompanyInterface $entity
     * @return Collection
     */
    private function getCompanyObject(CompanyInterface $entity)
    {
        $rowJsonData = new Collection();

        $rowJsonData->push([
            'id' => $entity->id,
            'name' => $entity->name
        ]);

        return $rowJsonData;
    }

    /**
     * @param GenderInterface $entity
     * @return Collection
     */
    private function getGenderObject(GenderInterface $entity)
    {
        $rowJsonData = new Collection();

        $rowJsonData->push([
            'id' => $entity->id,
            'name' => $entity->name
        ]);

        return $rowJsonData;
    }

    /**
     * @param ReligionInterface $entity
     * @return Collection
     */
    private function getReligionObject(ReligionInterface $entity)
    {
        $rowJsonData = new Collection();

        $rowJsonData->push([
            'id' => $entity->id,
            'name' => $entity->name
        ]);

        return $rowJsonData;
    }

    /**
     * @param MaritalStatusInterface $entity
     * @return Collection
     */
    private function getMaritalStatusObject(MaritalStatusInterface $entity)
    {
        $rowJsonData = new Collection();

        $rowJsonData->push([
            'id' => $entity->id,
            'name' => $entity->name
        ]);

        return $rowJsonData;
    }

    /**
     * @param OfficeInterface $entity
     * @return Collection
     */
    private function getOfficeObject(OfficeInterface $entity)
    {
        $rowJsonData = new Collection();

        $rowJsonData->push([
            'id' => $entity->id,
            'name' => $entity->name
        ]);

        return $rowJsonData;
    }

    /**
     * @param WorkAreaInterface $entity
     * @return Collection
     */
    private function getWorkAreaObject(WorkAreaInterface $entity)
    {
        $rowJsonData = new Collection();

        $rowJsonData->push([
            'id' => $entity->id,
            'title' => $entity->title
        ]);

        return $rowJsonData;
    }

    /**
     * @param BankInterface $entity
     * @return Collection
     */
    private function getBankObject(BankInterface $entity)
    {
        $rowJsonData = new Collection();

        $rowJsonData->push([
            'id' => $entity->id,
            'name' => $entity->name
        ]);

        return $rowJsonData;
    }

    //</editor-fold>
}

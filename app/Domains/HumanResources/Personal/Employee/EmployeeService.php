<?php

namespace App\Domains\HumanResources\Personal\Employee;

use App\Core\Domains\Contracts\Pagination\ListedSearchParameter;
use App\Core\Domains\Contracts\Pagination\PagedSearchParameter;
use App\Core\Services\Request\ListSearchRequest;
use App\Core\Services\Request\PageSearchRequest;
use App\Core\Services\Response\BasicResponse;
use App\Core\Services\Response\GenericCollectionResponse;
use App\Core\Services\Response\GenericListSearchResponse;
use App\Core\Services\Response\GenericPageSearchResponse;
use App\Core\Services\Response\ObjectResponse;
use App\Domains\Commons\MaritalStatus\Contracts\MaritalStatusRepositoryInterface;
use App\Domains\HumanResources\Personal\Employee\Contracts\Request\CreateEmployeeRequest;
use App\Domains\HumanResources\Personal\Employee\Contracts\Request\EditEmployeeRequest;
use App\Domains\ServiceAbstract;
use App\Domains\HumanResources\Personal\Employee\Contracts\EmployeeRepositoryInterface;
use App\Domains\HumanResources\Personal\Employee\Contracts\EmployeeServiceInterface;
use App\Domains\HumanResources\Personal\Employee\Contracts\EmployeeInterface;
use ErrorException;
use Exception;
use Illuminate\Support\Facades\Validator;

/**
 * EmployeeService Class
 * It has all useful methods for business logic.
 */
class EmployeeService extends ServiceAbstract implements EmployeeServiceInterface
{
    //<editor-fold desc="#field">

    protected $repository;

    protected $maritalStatusRepository;

    //</editor-fold>


    //<editor-fold desc="#constructor">

    /**
     * Loads our $repo with the actual Repo associated with our EmployeeInterface
     * EmployeeService constructor.
     *
     * @param EmployeeRepositoryInterface $repository
     * @param MaritalStatusRepositoryInterface $maritalStatusRepository
     */
    public function __construct(EmployeeRepositoryInterface $repository,
                                MaritalStatusRepositoryInterface $maritalStatusRepository)
    {
        $this->repository = $repository;

        $this->maritalStatusRepository = $maritalStatusRepository;
    }

    //</editor-fold>


    //<editor-fold desc="#public (method)">

    /**
     * {@inheritdoc}
     */
    public function create(CreateEmployeeRequest $request)
    {
        $response = new ObjectResponse();

        $maritalStatus = $this->maritalStatusRepository->findWhere([
            ['slug', '=', 'sudah-menikah']
        ])->first();

        $rule = [
            'company_id' => 'required',
            'nip' => 'required',
            'full_name' => 'required',
            'nick_name' => 'required',
            'gender_id' => 'required',
            'religion_id' => 'required',
            'birth_place' => 'required',
            'birth_date' => 'required',
            'address' => 'required',
            'mobile' => 'required',
            'identity_number' => 'required',
            'identity_expired_date' => 'required',
            'identity_address' => 'required',

            'drive_license_a_number' => 'required_if:has_drive_license_a,1',
            'drive_license_a_date' => 'required_if:has_drive_license_a,1',
            'drive_license_b_number' => 'required_if:has_drive_license_b,1',
            'drive_license_b_date' => 'required_if:has_drive_license_b,1',
            'drive_license_c_number' => 'required_if:has_drive_license_c,1',
            'drive_license_c_date' => 'required_if:has_drive_license_c,1',

            'marital_status_id' => 'required',

            'npwp_number' => 'required_if:has_npwp,1',

            'office_id' => 'required',
            'work_area_id' => 'required',
            'npwp_date' => 'required_if:has_npwp,1',
            'npwp_status' => 'required_if:has_npwp,1',
            'bpjs_tenaga_kerja_number' => 'required_if:has_bpjs_tenaga_kerja,1',
            'bpjs_tenaga_kerja_date' => 'required_if:has_bpjs_tenaga_kerja,1',
            'bpjs_tenaga_kerja_class' => 'required_if:has_bpjs_tenaga_kerja,1',
            'bpjs_kesehatan_number' => 'required_if:has_bpjs_kesehatan,1',
            'bpjs_kesehatan_date' => 'required_if:has_bpjs_kesehatan,1',
            'bpjs_kesehatan_class' => 'required_if:has_bpjs_tenaga_kerja,1',
            'mate_bpjs_kesehatan_number' => 'required_if:mate_has_bpjs_kesehatan,1',
            'mate_bpjs_kesehatan_date' => 'required_if:mate_has_bpjs_kesehatan,1',
            'mate_bpjs_kesehatan_class' => 'required_if:mate_has_bpjs_tenaga_kerja,1',

            'bank_id' => 'required_with:account_number',

            'join_date' => 'required',
            'work_status' => 'required',
            'work_type' => 'required'
        ];

        if ($maritalStatus) {
            $rule['mate_as'] = 'required_if:marital_status_id,' . $maritalStatus->id;
            $rule['mate_full_name'] = 'required_if:marital_status_id,' . $maritalStatus->id;
            $rule['mate_nick_name'] = 'required_if:marital_status_id,' . $maritalStatus->id;
            $rule['mate_birth_place'] = 'required_if:marital_status_id,' . $maritalStatus->id;
            $rule['mate_birth_date'] = 'required_if:marital_status_id,' . $maritalStatus->id;
        }

        $validator = Validator::make((array) $request, $rule);

        if ($validator->fails()) {
            $response->addErrorMessageResponse($response->getMessageCollection(), $validator->errors(), 400);

            return $response;
        }

        try {
            $employee = $this->newInstance([
                'company_id' => $request->company_id,
                'nip' => $request->nip,
                'full_name' => $request->full_name,
                'nick_name' => $request->nick_name,
                'gender_id' => $request->gender_id,
                'religion_id' => $request->religion_id,
                'birth_place' => $request->birth_place,
                'birth_date' => $request->birth_date,
                'address' => $request->address,
                'phone' => $request->phone,
                'mobile' => $request->mobile,
                'email' => $request->email,
                'identity_number' => $request->identity_number,
                'identity_expired_date' => $request->identity_expired_date,
                'identity_date' => $request->identity_date,
                'identity_address' => $request->identity_address,
                'has_drive_license_a' => $request->has_drive_license_a,
                'drive_license_a_number' => $request->drive_license_a_number,
                'drive_license_a_date' => $request->drive_license_a_date,
                'has_drive_license_b' => $request->has_drive_license_b,
                'drive_license_b_number' => $request->drive_license_b_number,
                'drive_license_b_date' => $request->drive_license_b_date,
                'has_drive_license_c' => $request->has_drive_license_c,
                'drive_license_c_number' => $request->drive_license_c_number,
                'drive_license_c_date' => $request->drive_license_c_date,
                'marital_status_id' => $request->marital_status_id,
                'mate_as' => $request->mate_as,
                'mate_full_name' => $request->mate_full_name,
                'mate_birth_place' => $request->mate_birth_place,
                'mate_birth_date' => $request->mate_birth_date,
                'mate_occupation' => $request->mate_occupation,
                'office_id' => $request->office_id,
                'work_area_id' => $request->work_area_id,
                'has_npwp' => $request->has_npwp,
                'npwp_number' => $request->npwp_number,
                'npwp_date' => $request->npwp_date,
                'npwp_status' => $request->npwp_status,
                'has_bpjs_tenaga_kerja' => $request->has_bpjs_tenaga_kerja,
                'bpjs_tenaga_kerja_number' => $request->bpjs_tenaga_kerja_number,
                'bpjs_tenaga_kerja_date' => $request->bpjs_tenaga_kerja_date,
                'bpjs_tenaga_kerja_class' => $request->bpjs_tenaga_kerja_class,
                'has_bpjs_kesehatan' => $request->has_bpjs_kesehatan,
                'bpjs_kesehatan_number' => $request->bpjs_kesehatan_number,
                'bpjs_kesehatan_date' => $request->bpjs_kesehatan_date,
                'bpjs_kesehatan_class' => $request->bpjs_kesehatan_class,
                'has_mate_bpjs_kesehatan' => $request->has_mate_bpjs_kesehatan,
                'mate_bpjs_kesehatan_number' => $request->mate_bpjs_kesehatan_number,
                'mate_bpjs_kesehatan_date' => $request->mate_bpjs_kesehatan_date,
                'mate_bpjs_kesehatan_class' => $request->mate_bpjs_kesehatan_class,
                'dplk_number' => $request->dplk_number,
                'collective_number' => $request->collective_number,
                'english_ability' => $request->english_ability,
                'computer_ability' => $request->computer_ability,
                'other_ability' => $request->other_ability,
                'bank_id' => $request->bank_id,
                'account_number' => $request->account_number,
                'join_date' => $request->join_date,
                'work_status' => $request->work_status,
                'work_type' => $request->work_type,
            ]);

            $this->setAuditableInformationFromRequest($employee, $request);

            $mediaLibraries = [];

            if ($request->media_libraries) {
                foreach ($request->media_libraries as $item) {
                    $mediaLibraries[$item['media_library_id']] = [
                        'attribute' => $item['pivot']['attribute']
                    ];
                }
            }

            $relation = [
                'morphMediaLibraries' => [
                    'data' => $mediaLibraries,
                    'method' => 'attach'
                ],
                'childs' => [
                    'data' => $request->childs,
                    'method' => 'createMany'
                ],
                'formalEducations' => [
                    'data' => $request->formal_educations,
                    'method' => 'createMany'
                ],
                'nonFormalEducations' => [
                    'data' => $request->non_formal_educations,
                    'method' => 'createMany'
                ],
                'organizations' => [
                    'data' => $request->organizations,
                    'method' => 'createMany'
                ],
                'otherEquipments' => [
                    'data' => $request->other_equipments,
                    'method' => 'createMany'
                ],
                'workCompetences' => [
                    'data' => $request->work_competences,
                    'method' => 'createMany'
                ],
                'workExperiences' => [
                    'data' => $request->work_experiences,
                    'method' => 'createMany'
                ]
            ];

            $employeeResult = $this->repository->create($employee, $relation);

            $response->setResult($employeeResult);
            $response->addSuccessMessageResponse($response->getMessageCollection(), 'Employee was created', 200);
        } catch (Exception $ex) {
            if (method_exists($ex,'getResponse')) {
                $exception = new ErrorException((string) $ex->getResponse()->getBody());
                $response->addErrorMessageResponse($response->getMessageCollection(), json_decode($exception->getMessage(), true)['message'], $ex->getCode());
            }

            $response->addErrorMessageResponse($response->getMessageCollection(), (string) $ex->getMessage(), 500);
        }

        return $response;
    }

    /**
     * {@inheritdoc}
     */
    public function update(EditEmployeeRequest $request)
    {
        $response = new ObjectResponse();

        $maritalStatus = $this->maritalStatusRepository->findWhere([
            ['slug', '=', 'sudah-menikah']
        ])->first();

        $validator = Validator::make((array) $request, [
            'company_id' => 'required',
            'nip' => 'required',
            'full_name' => 'required',
            'nick_name' => 'required',
            'gender_id' => 'required',
            'religion_id' => 'required',
            'birth_place' => 'required',
            'birth_date' => 'required',
            'address' => 'required',
            'mobile' => 'required',
            'identity_number' => 'required',
            'identity_expired_date' => 'required',
            'identity_address' => 'required',

            'drive_license_a_number' => 'required_if:has_drive_license_a,1',
            'drive_license_a_date' => 'required_if:has_drive_license_a,1',
            'drive_license_b_number' => 'required_if:has_drive_license_b,1',
            'drive_license_b_date' => 'required_if:has_drive_license_b,1',
            'drive_license_c_number' => 'required_if:has_drive_license_c,1',
            'drive_license_c_date' => 'required_if:has_drive_license_c,1',

            'marital_status_id' => 'required',

            'npwp_number' => 'required_if:has_npwp,1',

            'office_id' => 'required',
            'work_area_id' => 'required',
            'npwp_date' => 'required_if:has_npwp,1',
            'npwp_status' => 'required_if:has_npwp,1',
            'bpjs_tenaga_kerja_number' => 'required_if:has_bpjs_tenaga_kerja,1',
            'bpjs_tenaga_kerja_date' => 'required_if:has_bpjs_tenaga_kerja,1',
            'bpjs_tenaga_kerja_class' => 'required_if:has_bpjs_tenaga_kerja,1',
            'bpjs_kesehatan_number' => 'required_if:has_bpjs_kesehatan,1',
            'bpjs_kesehatan_date' => 'required_if:has_bpjs_kesehatan,1',
            'bpjs_kesehatan_class' => 'required_if:has_bpjs_tenaga_kerja,1',
            'mate_bpjs_kesehatan_number' => 'required_if:mate_has_bpjs_kesehatan,1',
            'mate_bpjs_kesehatan_date' => 'required_if:mate_has_bpjs_kesehatan,1',
            'mate_bpjs_kesehatan_class' => 'required_if:mate_has_bpjs_tenaga_kerja,1',

            'bank_id' => 'required_with:account_number',

            'join_date' => 'required',
            'work_status' => 'required',
            'work_type' => 'required'
        ]);

        if ($maritalStatus) {
            $rule['mate_as'] = 'required_if:marital_status_id,' . $maritalStatus->id;
            $rule['mate_full_name'] = 'required_if:marital_status_id,' . $maritalStatus->id;
            $rule['mate_nick_name'] = 'required_if:marital_status_id,' . $maritalStatus->id;
            $rule['mate_birth_place'] = 'required_if:marital_status_id,' . $maritalStatus->id;
            $rule['mate_birth_date'] = 'required_if:marital_status_id,' . $maritalStatus->id;
        }

        if ($validator->fails()) {
            $response->addErrorMessageResponse($response->getMessageCollection(), $validator->errors(), 400);

            return $response;
        }

        try {
            $employee = $this->repository->find($request->id);

            $employee->fill([
                'company_id' => $request->company_id,
                'nip' => $request->nip,
                'full_name' => $request->full_name,
                'nick_name' => $request->nick_name,
                'gender_id' => $request->gender_id,
                'religion_id' => $request->religion_id,
                'birth_place' => $request->birth_place,
                'birth_date' => $request->birth_date,
                'address' => $request->address,
                'phone' => $request->phone,
                'mobile' => $request->mobile,
                'email' => $request->email,
                'identity_number' => $request->identity_number,
                'identity_expired_date' => $request->identity_expired_date,
                'identity_address' => $request->identity_address,
                'has_drive_license_a' => $request->has_drive_license_a,
                'drive_license_a_number' => $request->drive_license_a_number,
                'drive_license_a_date' => $request->drive_license_a_date,
                'has_drive_license_b' => $request->has_drive_license_b,
                'drive_license_b_number' => $request->drive_license_b_number,
                'drive_license_b_date' => $request->drive_license_b_date,
                'has_drive_license_c' => $request->has_drive_license_c,
                'drive_license_c_number' => $request->drive_license_c_number,
                'drive_license_c_date' => $request->drive_license_c_date,
                'marital_status_id' => $request->marital_status_id,
                'mate_as' => $request->mate_as,
                'mate_full_name' => $request->mate_full_name,
                'mate_birth_place' => $request->mate_birth_place,
                'mate_birth_date' => $request->mate_birth_date,
                'mate_occupation' => $request->mate_occupation,
                'office_id' => $request->office_id,
                'work_area_id' => $request->work_area_id,
                'has_npwp' => $request->has_npwp,
                'npwp_number' => $request->npwp_number,
                'npwp_date' => $request->npwp_date,
                'npwp_status' => $request->npwp_status,
                'has_bpjs_tenaga_kerja' => $request->has_bpjs_tenaga_kerja,
                'bpjs_tenaga_kerja_number' => $request->bpjs_tenaga_kerja_number,
                'bpjs_tenaga_kerja_date' => $request->bpjs_tenaga_kerja_date,
                'bpjs_tenaga_kerja_class' => $request->bpjs_tenaga_kerja_class,
                'has_bpjs_kesehatan' => $request->has_bpjs_kesehatan,
                'bpjs_kesehatan_number' => $request->bpjs_kesehatan_number,
                'bpjs_kesehatan_date' => $request->bpjs_kesehatan_date,
                'bpjs_kesehatan_class' => $request->bpjs_kesehatan_class,
                'has_mate_bpjs_kesehatan' => $request->has_mate_bpjs_kesehatan,
                'mate_bpjs_kesehatan_number' => $request->mate_bpjs_kesehatan_number,
                'mate_bpjs_kesehatan_date' => $request->mate_bpjs_kesehatan_date,
                'mate_bpjs_kesehatan_class' => $request->mate_bpjs_kesehatan_class,
                'dplk_number' => $request->dplk_number,
                'collective_number' => $request->collective_number,
                'english_ability' => $request->english_ability,
                'computer_ability' => $request->computer_ability,
                'other_ability' => $request->other_ability,
                'bank_id' => $request->bank_id,
                'account_number' => $request->account_number,
                'join_date' => $request->join_date,
                'work_status' => $request->work_status,
                'work_type' => $request->work_type
            ]);

            $this->setAuditableInformationFromRequest($employee);

            $mediaLibraries = [];

            if ($request->media_libraries) {
                foreach ($request->media_libraries as $item) {
                    $mediaLibraries[$item['media_library_id']] = [
                        'attribute' => $item['pivot']['attribute']
                    ];
                }
            }

            $relation = [
                'morphMediaLibraries' => [
                    'data' => $mediaLibraries,
                    'method' => 'sync'
                ],
                'childs' => [
                    'data' => (array) $request->childs,
                    'method' => 'sync',
                    'isDetach' => false
                ],
                'formalEducations' => [
                    'data' => (array) $request->formal_educations,
                    'method' => 'sync',
                    'isDetach' => false
                ],
                'nonFormalEducations' => [
                    'data' => (array) $request->non_formal_educations,
                    'method' => 'sync',
                    'isDetach' => false
                ],
                'organizations' => [
                    'data' => (array) $request->organizations,
                    'method' => 'sync',
                    'isDetach' => false
                ],
                'otherEquipments' => [
                    'data' => (array) $request->other_equipments,
                    'method' => 'sync',
                    'isDetach' => false
                ],
                'workCompetences' => [
                    'data' => (array) $request->work_competences,
                    'method' => 'sync',
                    'isDetach' => false
                ],
                'workExperiences' => [
                    'data' => (array) $request->work_experiences,
                    'method' => 'sync',
                    'isDetach' => false
                ]
            ];

            $employeeResult = $this->repository->update($employee, $relation);

            $response->setResult($employeeResult);
            $response->addSuccessMessageResponse($response->getMessageCollection(), 'Employee was updated', 200);
        } catch (Exception $ex) {
            if (method_exists($ex,'getResponse')) {
                $exception = new ErrorException((string) $ex->getResponse()->getBody());
                $response->addErrorMessageResponse($response->getMessageCollection(), json_decode($exception->getMessage(), true)['message'], $ex->getCode());
            }

            $response->addErrorMessageResponse($response->getMessageCollection(), (string) $ex->getMessage(), 500);
        }

        return $response;
    }

    /**
     * {@inheritdoc}
     */
    public function delete(int $id): BasicResponse
    {
        $response = new BasicResponse();

        try {
            $relation = [
                'morphMediaLibraries' => [
                    'method' => 'detach'
                ],
                'childs' => [
                    'method' => 'detach'
                ],
                'formalEducations' => [
                    'method' => 'detach'
                ],
                'nonFormalEducations' => [
                    'method' => 'detach'
                ],
                'organizations' => [
                    'method' => 'detach'
                ],
                'otherEquipments' => [
                    'method' => 'detach'
                ],
                'workCompetences' => [
                    'method' => 'detach'
                ],
                'workExperiences' => [
                    'method' => 'detach'
                ]
            ];

            $employee = $this->repository->find($id);

            $this->repository->delete($employee, false, $relation);

            $response->addSuccessMessageResponse($response->getMessageCollection(), 'Employee was deleted', 200);
        } catch (Exception $ex) {
            if (method_exists($ex,'getResponse')) {
                $exception = new ErrorException((string) $ex->getResponse()->getBody());
                $response->addErrorMessageResponse($response->getMessageCollection(), json_decode($exception->getMessage(), true)['message'], $ex->getCode());
            }

            $response->addErrorMessageResponse($response->getMessageCollection(), (string) $ex->getMessage(), 500);
        }

        return $response;
    }

    /**
     * @param array $ids
     * @return BasicResponse|mixed
     */
    public function deleteBulk(array $ids)
    {
        $response = new BasicResponse();

        try {
            $relation = [
                'morphMediaLibraries' => [
                    'method' => 'detach'
                ],
                'childs' => [
                    'method' => 'detach'
                ],
                'formalEducations' => [
                    'method' => 'detach'
                ],
                'nonFormalEducations' => [
                    'method' => 'detach'
                ],
                'organizations' => [
                    'method' => 'detach'
                ],
                'otherEquipments' => [
                    'method' => 'detach'
                ],
                'workCompetences' => [
                    'method' => 'detach'
                ],
                'workExperiences' => [
                    'method' => 'detach'
                ]
            ];

            $this->repository->deleteBulk($ids, false, $relation);

            $response->addSuccessMessageResponse($response->getMessageCollection(), 'Employees was deleted', 200);
        } catch (Exception $ex) {
            if (method_exists($ex,'getResponse')) {
                $exception = new ErrorException((string) $ex->getResponse()->getBody());
                $response->addErrorMessageResponse($response->getMessageCollection(), json_decode($exception->getMessage(), true)['message'], $ex->getCode());
            }

            $response->addErrorMessageResponse($response->getMessageCollection(), (string) $ex->getMessage(), 500);
        }

        return $response;
    }


    /**
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
     * @param int $officeId
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
     * @param int|null $degreeId
     * @param int|null $majorId
     * @param int|null $competenceId
     * @param int|null $positionId
     * @param int|null $projectId
     * @param int|null $workUnitId
     * @return GenericCollectionResponse
     */
    public function employeeList(int $companyId = null, int $genderId = null, int $religionId = null, object $rangeBirthDate = null, object $rangeIdentityExpiredDate = null,
                                 object $rangeDriveLicenseADate = null, object $rangeDriveLicenseBDate = null, object $rangeDriveLicenseCDate = null, int $maritalStatusId = null, string $mateAs = null,
                                 object $rangeMateBirthDate = null, int $officeId = null, int $workAreaId = null, object $rangeNPWPDate = null, string $npwpStatus = null,
                                 object $rangeBPJSTenagaKerjaDate = null, string $bpjsTenagaKerjaClass = null, object $rangeBPJSKesehatanDate = null, string $bpjsKesehatanClass = null, object $rangeMateBPJSKesehatanDate = null,
                                 string $mateBPJSKesehatanClass = null, int $bankId = null, object $rangeJoinDate = null, string $workStatus = null, string $workType = null, int $degreeId = null, int $majorId = null,
                                 int $competenceId = null, int $positionId = null, int $projectId = null, int $workUnitId = null): GenericCollectionResponse
    {
        $response = new GenericCollectionResponse();

        try {
            $results = $this->repository->employeeList($companyId, $genderId, $religionId, $rangeBirthDate, $rangeIdentityExpiredDate,
                $rangeDriveLicenseADate, $rangeDriveLicenseBDate, $rangeDriveLicenseCDate, $maritalStatusId, $mateAs,
                $rangeMateBirthDate, $officeId, $workAreaId, $rangeNPWPDate, $npwpStatus,
                $rangeBPJSTenagaKerjaDate, $bpjsTenagaKerjaClass, $rangeBPJSKesehatanDate, $bpjsKesehatanClass, $rangeMateBPJSKesehatanDate,
                $mateBPJSKesehatanClass, $bankId, $rangeJoinDate, $workStatus, $workType, $degreeId, $majorId,
                $competenceId, $positionId, $projectId, $workUnitId);

            $response->setDtoList($results);
            $response->addSuccessMessageResponse($response->getMessageCollection(), 'Ok', 200);
        } catch (Exception $ex) {
            if (method_exists($ex,'getResponse')) {
                $exception = new ErrorException((string) $ex->getResponse()->getBody());
                $response->addErrorMessageResponse($response->getMessageCollection(), json_decode($exception->getMessage(), true)['message'], $ex->getCode());
            }

            $response->addErrorMessageResponse($response->getMessageCollection(), (string) $ex->getMessage(), 500);
        }

        return $response;
    }

    /**
     * @param int|null $companyId
     * @param int|null $officeId
     * @param object|null $rangerTerminationDate
     * @return GenericCollectionResponse
     */
    public function employeeTerminatedList(int $companyId = null, int $officeId = null, object $rangerTerminationDate = null): GenericCollectionResponse
    {
        $response = new GenericCollectionResponse();

        try {
            $results = $this->repository->employeeTerminatedList($companyId, $officeId, $rangerTerminationDate);

            $response->setDtoList($results);

            $response->addSuccessMessageResponse($response->getMessageCollection(), 'Ok', 200);
        } catch (Exception $ex) {
            if (method_exists($ex,'getResponse')) {
                $exception = new ErrorException((string) $ex->getResponse()->getBody());
                $response->addErrorMessageResponse($response->getMessageCollection(), json_decode($exception->getMessage(), true)['message'], $ex->getCode());
            }

            $response->addErrorMessageResponse($response->getMessageCollection(), (string) $ex->getMessage(), 500);
        }

        return $response;
    }

    /**
     * @param int $companyId
     * @param int $officeId
     * @param int $month
     * @return GenericCollectionResponse
     */
    public function employeeBirthDayList(int $companyId = null, int $officeId = null, int $month = null): GenericCollectionResponse
    {
        $response = new GenericCollectionResponse();

        try {
            $results = $this->repository->employeeBirthDayList($companyId, $officeId, $month);

            $response->setDtoList($results);

            $response->addSuccessMessageResponse($response->getMessageCollection(), 'Ok', 200);
        } catch (Exception $ex) {
            if (method_exists($ex,'getResponse')) {
                $exception = new ErrorException((string) $ex->getResponse()->getBody());
                $response->addErrorMessageResponse($response->getMessageCollection(), json_decode($exception->getMessage(), true)['message'], $ex->getCode());
            }

            $response->addErrorMessageResponse($response->getMessageCollection(), (string) $ex->getMessage(), 500);
        }

        return $response;
    }


    /**
     * @param ListSearchRequest $listSearchRequest
     * @param int $companyId
     * @param int $genderId
     * @param int $religionId
     * @param object|null $rangeBirthDate
     * @param object|null $rangeIdentityDate
     * @param object|null $rangeDriveLicenseADate
     * @param object|null $rangeDriveLicenseBDate
     * @param object|null $rangeDriveLicenseCDate
     * @param int $maritalStatusId
     * @param string|null $mateAs
     * @param object|null $rangeMateBirthDate
     * @param int $officeId
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
     * @param int|null $degreeId
     * @param int|null $majorId
     * @param int|null $competenceId
     * @param int|null $positionId
     * @param int|null $projectId
     * @param int|null $workUnitId
     * @return GenericListSearchResponse
     */
    public function employeeListSearch(ListSearchRequest $listSearchRequest,
                                       int $companyId = null, int $genderId = null, int $religionId = null, object $rangeBirthDate = null, object $rangeIdentityExpiredDate = null,
                                       object $rangeDriveLicenseADate = null, object $rangeDriveLicenseBDate = null, object $rangeDriveLicenseCDate = null, int $maritalStatusId = null, string $mateAs = null,
                                       object $rangeMateBirthDate = null, int $officeId = null, int $workAreaId = null, object $rangeNPWPDate = null, string $npwpStatus = null,
                                       object $rangeBPJSTenagaKerjaDate = null, string $bpjsTenagaKerjaClass = null, object $rangeBPJSKesehatanDate = null, string $bpjsKesehatanClass = null, object $rangeMateBPJSKesehatanDate = null,
                                       string $mateBPJSKesehatanClass = null, int $bankId = null, object $rangeJoinDate = null, string $workStatus = null, string $workType = null, int $degreeId = null, int $majorId = null,
                                       int $competenceId = null, int $positionId = null, int $projectId = null, int $workUnitId = null): GenericListSearchResponse
    {
        $response = new GenericListSearchResponse();

        $parameter = new ListedSearchParameter();

        try {
            $parameter->query = $listSearchRequest->query;

            $results = $this->repository->employeeListSearch($parameter,
                $companyId, $genderId, $religionId, $rangeBirthDate, $rangeIdentityExpiredDate,
                $rangeDriveLicenseADate, $rangeDriveLicenseBDate, $rangeDriveLicenseCDate, $maritalStatusId, $mateAs,
                $rangeMateBirthDate, $officeId, $workAreaId, $rangeNPWPDate, $npwpStatus,
                $rangeBPJSTenagaKerjaDate, $bpjsTenagaKerjaClass, $rangeBPJSKesehatanDate, $bpjsKesehatanClass, $rangeMateBPJSKesehatanDate,
                $mateBPJSKesehatanClass, $bankId, $rangeJoinDate, $workStatus, $workType, $degreeId, $majorId,
                $competenceId, $positionId, $projectId, $workUnitId);

            $totalCount = $this->repository->employeeListSearch($parameter,
                $companyId, $genderId, $religionId, $rangeBirthDate, $rangeIdentityExpiredDate,
                $rangeDriveLicenseADate, $rangeDriveLicenseBDate, $rangeDriveLicenseCDate, $maritalStatusId, $mateAs,
                $rangeMateBirthDate, $officeId, $workAreaId, $rangeNPWPDate, $npwpStatus,
                $rangeBPJSTenagaKerjaDate, $bpjsTenagaKerjaClass, $rangeBPJSKesehatanDate, $bpjsKesehatanClass, $rangeMateBPJSKesehatanDate,
                $mateBPJSKesehatanClass, $bankId, $rangeJoinDate, $workStatus, $workType, $degreeId, $majorId,
                $competenceId, $positionId, $projectId, $workUnitId, true);

            $response->setDtoList($results);
            $response->setTotalCount($totalCount);

            $response->addSuccessMessageResponse($response->getMessageCollection(), 'Ok', 200);
        } catch (Exception $ex) {
            if (method_exists($ex,'getResponse')) {
                $exception = new ErrorException((string) $ex->getResponse()->getBody());
                $response->addErrorMessageResponse($response->getMessageCollection(), json_decode($exception->getMessage(), true)['message'], $ex->getCode());
            }

            $response->addErrorMessageResponse($response->getMessageCollection(), (string) $ex->getMessage(), 500);
        }

        return $response;
    }

    /**
     * @param ListSearchRequest $listSearchRequest
     * @param int|null $companyId
     * @param int|null $officeId
     * @param object|null $rangerTerminationDate
     * @return GenericListSearchResponse
     */
    public function employeeTerminatedListSearch(ListSearchRequest $listSearchRequest,
                                                 int $companyId = null, int $officeId = null, object $rangerTerminationDate = null): GenericListSearchResponse
    {
        $response = new GenericListSearchResponse();

        $parameter = new ListedSearchParameter();

        try {
            $parameter->query = $listSearchRequest->query;

            $results = $this->repository->employeeTerminatedListSearch($parameter,
                $companyId, $officeId, $rangerTerminationDate);
            $totalCount = $this->repository->employeeTerminatedListSearch($parameter,
                $companyId, $officeId, $rangerTerminationDate);

            $response->setDtoList($results);
            $response->setTotalCount($totalCount);

            $response->addSuccessMessageResponse($response->getMessageCollection(), 'Ok', 200);
        } catch (Exception $ex) {
            if (method_exists($ex,'getResponse')) {
                $exception = new ErrorException((string) $ex->getResponse()->getBody());
                $response->addErrorMessageResponse($response->getMessageCollection(), json_decode($exception->getMessage(), true)['message'], $ex->getCode());
            }

            $response->addErrorMessageResponse($response->getMessageCollection(), (string) $ex->getMessage(), 500);
        }

        return $response;
    }

    /**
     * @param ListSearchRequest $listSearchRequest
     * @param int $companyId
     * @param int $officeId
     * @param int $month
     * @return GenericListSearchResponse
     */
    public function employeeBirthDayListSearch(ListSearchRequest $listSearchRequest,
                                               int $companyId = null, int $officeId = null, int $month = null): GenericListSearchResponse
    {
        $response = new GenericListSearchResponse();

        $parameter = new ListedSearchParameter();

        try {
            $parameter->query = $listSearchRequest->query;

            $results = $this->repository->employeeBirthDayListSearch($parameter,
                $companyId, $officeId, $month);
            $totalCount = $this->repository->employeeBirthDayListSearch($parameter,
                $companyId, $officeId, $month);

            $response->setDtoList($results);
            $response->setTotalCount($totalCount);

            $response->addSuccessMessageResponse($response->getMessageCollection(), 'Ok', 200);
        } catch (Exception $ex) {
            if (method_exists($ex,'getResponse')) {
                $exception = new ErrorException((string) $ex->getResponse()->getBody());
                $response->addErrorMessageResponse($response->getMessageCollection(), json_decode($exception->getMessage(), true)['message'], $ex->getCode());
            }

            $response->addErrorMessageResponse($response->getMessageCollection(), (string) $ex->getMessage(), 500);
        }

        return $response;
    }


    /**
     * @param PageSearchRequest $pageSearchRequest
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
     * @param int $officeId
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
     * @param int|null $degreeId
     * @param int|null $majorId
     * @param int|null $competenceId
     * @param int|null $positionId
     * @param int|null $projectId
     * @param int|null $workUnitId
     * @return GenericPageSearchResponse
     */
    public function employeePageSearch(PageSearchRequest $pageSearchRequest,
                                       int $companyId = null, int $genderId = null, int $religionId = null, object $rangeBirthDate = null, object $rangeIdentityExpiredDate = null,
                                       object $rangeDriveLicenseADate = null, object $rangeDriveLicenseBDate = null, object $rangeDriveLicenseCDate = null, int $maritalStatusId = null, string $mateAs = null,
                                       object $rangeMateBirthDate = null, int $officeId = null, int $workAreaId = null, object $rangeNPWPDate = null, string $npwpStatus = null,
                                       object $rangeBPJSTenagaKerjaDate = null, string $bpjsTenagaKerjaClass = null, object $rangeBPJSKesehatanDate = null, string $bpjsKesehatanClass = null, object $rangeMateBPJSKesehatanDate = null,
                                       string $mateBPJSKesehatanClass = null, int $bankId = null, object $rangeJoinDate = null, string $workStatus = null, string $workType = null, int $degreeId = null, int $majorId = null,
                                       int $competenceId = null, int $positionId = null, int $projectId = null, int $workUnitId = null): GenericPageSearchResponse
    {
        $response = new GenericPageSearchResponse();

        $parameter = new PagedSearchParameter();

        try {
            if ($pageSearchRequest->draw) {
                $parameter->draw = $pageSearchRequest->draw;
                $parameter->columns = $pageSearchRequest->columns;
                $parameter->order = $pageSearchRequest->order;
                $parameter->start = $pageSearchRequest->start;
                $parameter->length = $pageSearchRequest->length;
                $parameter->search = $pageSearchRequest->search;
            } else {
                $parameter->pagination = $pageSearchRequest->pagination;
                $parameter->query = $pageSearchRequest->query;
                $parameter->sort = $pageSearchRequest->sort;
            }

            $results = $this->repository->employeePageSearch($parameter, $companyId, $genderId, $religionId, $rangeBirthDate, $rangeIdentityExpiredDate,
                $rangeDriveLicenseADate, $rangeDriveLicenseBDate, $rangeDriveLicenseCDate, $maritalStatusId, $mateAs,
                $rangeMateBirthDate, $officeId, $workAreaId, $rangeNPWPDate, $npwpStatus,
                $rangeBPJSTenagaKerjaDate, $bpjsTenagaKerjaClass, $rangeBPJSKesehatanDate, $bpjsKesehatanClass, $rangeMateBPJSKesehatanDate,
                $mateBPJSKesehatanClass, $bankId, $rangeJoinDate, $workStatus, $workType, $degreeId, $majorId,
                $competenceId, $positionId, $projectId, $workUnitId);

            $totalCount = $this->repository->employeePageSearch($parameter, $companyId, $genderId, $religionId, $rangeBirthDate, $rangeIdentityExpiredDate,
                $rangeDriveLicenseADate, $rangeDriveLicenseBDate, $rangeDriveLicenseCDate, $maritalStatusId, $mateAs,
                $rangeMateBirthDate, $officeId, $workAreaId, $rangeNPWPDate, $npwpStatus,
                $rangeBPJSTenagaKerjaDate, $bpjsTenagaKerjaClass, $rangeBPJSKesehatanDate, $bpjsKesehatanClass, $rangeMateBPJSKesehatanDate,
                $mateBPJSKesehatanClass, $bankId, $rangeJoinDate, $workStatus, $workType, $degreeId, $majorId,
                $competenceId, $positionId, $projectId, $workUnitId, true);

            if ($pageSearchRequest->draw) {
                $totalPage = ceil($totalCount / $parameter->length);
            } else {
                $totalPage = ceil($totalCount / $parameter->pagination['perpage']);
            }

            $response->setDtoList($results);
            $response->setTotalCount($totalCount);
            $response->setTotalPage($totalPage);

            $response->addSuccessMessageResponse($response->getMessageCollection(), 'Ok', 200);
        } catch (Exception $ex) {
            if (method_exists($ex,'getResponse')) {
                $exception = new ErrorException((string) $ex->getResponse()->getBody());
                $response->addErrorMessageResponse($response->getMessageCollection(), json_decode($exception->getMessage(), true)['message'], $ex->getCode());
            }

            $response->addErrorMessageResponse($response->getMessageCollection(), (string) $ex->getMessage(), 500);
        }

        return $response;
    }

    /**
     * @param PageSearchRequest $pageSearchRequest
     * @param int|null $companyId
     * @param int|null $officeId
     * @param object|null $rangerTerminationDate
     * @return GenericPageSearchResponse
     */
    public function employeeTerminatedPageSearch(PageSearchRequest $pageSearchRequest,
                                                 int $companyId = null, int $officeId = null, object $rangerTerminationDate = null): GenericPageSearchResponse
    {
        $response = new GenericPageSearchResponse();

        $parameter = new PagedSearchParameter();

        try {
            if ($pageSearchRequest->draw) {
                $parameter->draw = $pageSearchRequest->draw;
                $parameter->columns = $pageSearchRequest->columns;
                $parameter->order = $pageSearchRequest->order;
                $parameter->start = $pageSearchRequest->start;
                $parameter->length = $pageSearchRequest->length;
                $parameter->search = $pageSearchRequest->search;
            } else {
                $parameter->pagination = $pageSearchRequest->pagination;
                $parameter->query = $pageSearchRequest->query;
                $parameter->sort = $pageSearchRequest->sort;
            }

            $results = $this->repository->employeeTerminatedPageSearch($parameter,
                $companyId, $officeId, $rangerTerminationDate);
            $totalCount = $this->repository->employeeTerminatedPageSearch($parameter,
                $companyId, $officeId, $rangerTerminationDate, true);

            if ($pageSearchRequest->draw) {
                $totalPage = ceil($totalCount / $parameter->length);
            } else {
                $totalPage = ceil($totalCount / $parameter->pagination['perpage']);
            }

            $response->setDtoList($results);
            $response->setTotalCount($totalCount);
            $response->setTotalPage($totalPage);

            $response->addSuccessMessageResponse($response->getMessageCollection(), 'Ok', 200);
        } catch (Exception $ex) {
            if (method_exists($ex,'getResponse')) {
                $exception = new ErrorException((string) $ex->getResponse()->getBody());
                $response->addErrorMessageResponse($response->getMessageCollection(), json_decode($exception->getMessage(), true)['message'], $ex->getCode());
            }

            $response->addErrorMessageResponse($response->getMessageCollection(), (string) $ex->getMessage(), 500);
        }

        return $response;
    }

    /**
     * @param PageSearchRequest $pageSearchRequest
     * @param int $companyId
     * @param int $officeId
     * @param int $month
     * @return GenericPageSearchResponse
     */
    public function employeeBirthDayPageSearch(PageSearchRequest $pageSearchRequest,
                                               int $companyId = null, int $officeId = null, int $month = null): GenericPageSearchResponse
    {
        $response = new GenericPageSearchResponse();

        $parameter = new PagedSearchParameter();

        try {
            if ($pageSearchRequest->draw) {
                $parameter->draw = $pageSearchRequest->draw;
                $parameter->columns = $pageSearchRequest->columns;
                $parameter->order = $pageSearchRequest->order;
                $parameter->start = $pageSearchRequest->start;
                $parameter->length = $pageSearchRequest->length;
                $parameter->search = $pageSearchRequest->search;
            } else {
                $parameter->pagination = $pageSearchRequest->pagination;
                $parameter->query = $pageSearchRequest->query;
                $parameter->sort = $pageSearchRequest->sort;
            }

            $results = $this->repository->employeeBirthDayPageSearch($parameter,
                $companyId, $officeId, $month);
            $totalCount = $this->repository->employeeBirthDayPageSearch($parameter,
                $companyId, $officeId, $month, true);

            if ($pageSearchRequest->draw) {
                $totalPage = ceil($totalCount / $parameter->length);
            } else {
                $totalPage = ceil($totalCount / $parameter->pagination['perpage']);
            }

            $response->setDtoList($results);
            $response->setTotalCount($totalCount);
            $response->setTotalPage($totalPage);

            $response->addSuccessMessageResponse($response->getMessageCollection(), 'Ok', 200);
        } catch (Exception $ex) {
            if (method_exists($ex,'getResponse')) {
                $exception = new ErrorException((string) $ex->getResponse()->getBody());
                $response->addErrorMessageResponse($response->getMessageCollection(), json_decode($exception->getMessage(), true)['message'], $ex->getCode());
            }

            $response->addErrorMessageResponse($response->getMessageCollection(), (string) $ex->getMessage(), 500);
        }

        return $response;
    }

    /**
     * @param ListSearchRequest $listSearchRequest
     * @param int $companyId
     * @return GenericListSearchResponse
     */
    public function employeeGroupByOfficeListSearch(ListSearchRequest $listSearchRequest, int $companyId = null): GenericListSearchResponse
    {
        $response = new GenericListSearchResponse();

        $parameter = new ListedSearchParameter();

        try {
            $results = $this->repository->employeeGroupByOfficeListSearch($parameter, $companyId);

            $totalCount = $this->repository->employeeGroupByOfficeListSearch($parameter, $companyId, true);

            $response->setDtoList($results);
            $response->setTotalCount($totalCount);

            $response->addSuccessMessageResponse($response->getMessageCollection(), 'Ok', 200);
        } catch (Exception $ex) {
            if (method_exists($ex, 'getResponse')) {
                $exception = new ErrorException((string) $ex->getResponse()->getBody());
                $response->addErrorMessageResponse($response->getMessageCollection(), json_decode($exception->getMessage(), true)['message'], $ex->getCode());
            }

            $response->addErrorMessageResponse($response->getMessageCollection(), (string) $ex->getMessage(), 500);
        }

        return $response;
    }

    /**
     * @param ListSearchRequest $listSearchRequest
     * @param int $companyId
     * @return GenericListSearchResponse
     */
    public function employeeGroupByWorkAreaListSearch(ListSearchRequest $listSearchRequest, int $companyId = null): GenericListSearchResponse
    {
        $response = new GenericListSearchResponse();

        $parameter = new ListedSearchParameter();

        try {
            $results = $this->repository->employeeGroupByWorkAreaListSearch($parameter, $companyId);

            $totalCount = $this->repository->employeeGroupByWorkAreaListSearch($parameter, $companyId, true);

            $response->setDtoList($results);
            $response->setTotalCount($totalCount);

            $response->addSuccessMessageResponse($response->getMessageCollection(), 'Ok', 200);
        } catch (Exception $ex) {
            if (method_exists($ex, 'getResponse')) {
                $exception = new ErrorException((string) $ex->getResponse()->getBody());
                $response->addErrorMessageResponse($response->getMessageCollection(), json_decode($exception->getMessage(), true)['message'], $ex->getCode());
            }

            $response->addErrorMessageResponse($response->getMessageCollection(), (string) $ex->getMessage(), 500);
        }

        return $response;
    }

    /**
     * @param ListSearchRequest $listSearchRequest
     * @param int $companyId
     * @return GenericListSearchResponse
     */
    public function employeeGroupByPositionListSearch(ListSearchRequest $listSearchRequest, int $companyId = null): GenericListSearchResponse
    {
        $response = new GenericListSearchResponse();

        $parameter = new ListedSearchParameter();

        try {
            $results = $this->repository->employeeGroupByPositionListSearch($parameter, $companyId);

            $totalCount = $this->repository->employeeGroupByPositionListSearch($parameter, $companyId, true);

            $response->setDtoList($results);
            $response->setTotalCount($totalCount);

            $response->addSuccessMessageResponse($response->getMessageCollection(), 'Ok', 200);
        } catch (Exception $ex) {
            if (method_exists($ex, 'getResponse')) {
                $exception = new ErrorException((string) $ex->getResponse()->getBody());
                $response->addErrorMessageResponse($response->getMessageCollection(), json_decode($exception->getMessage(), true)['message'], $ex->getCode());
            }

            $response->addErrorMessageResponse($response->getMessageCollection(), (string) $ex->getMessage(), 500);
        }

        return $response;
    }

    /**
     * @param ListSearchRequest $listSearchRequest
     * @param int $companyId
     * @return GenericListSearchResponse
     */
    public function employeeGroupByWorkUnitListSearch(ListSearchRequest $listSearchRequest, int $companyId = null): GenericListSearchResponse
    {
        $response = new GenericListSearchResponse();

        $parameter = new ListedSearchParameter();

        try {
            $results = $this->repository->employeeGroupByWorkUnitListSearch($parameter, $companyId);

            $totalCount = $this->repository->employeeGroupByWorkUnitListSearch($parameter, $companyId, true);

            $response->setDtoList($results);
            $response->setTotalCount($totalCount);

            $response->addSuccessMessageResponse($response->getMessageCollection(), 'Ok', 200);
        } catch (Exception $ex) {
            if (method_exists($ex, 'getResponse')) {
                $exception = new ErrorException((string) $ex->getResponse()->getBody());
                $response->addErrorMessageResponse($response->getMessageCollection(), json_decode($exception->getMessage(), true)['message'], $ex->getCode());
            }

            $response->addErrorMessageResponse($response->getMessageCollection(), (string) $ex->getMessage(), 500);
        }

        return $response;
    }



    /**
     * @param string $path
     * @param string $input
     * @param string|null $file
     * @return ObjectResponse
     */
    /*public function uploadPhoto(string $path, string $input = 'slim', string $file = null): ObjectResponse
    {
        $response = new ObjectResponse();

        try {
            $images = Slim::getImages($input);
        } catch (Exception $ex) {
            $response->addErrorMessageResponse($response->getMessageCollection(), $ex->getMessage(), SlimStatus::UNKNOWN);

            return $response;
        }

        if ($images === false) {
            $response->addErrorMessageResponse($response->getMessageCollection(), 'No data posted', SlimStatus::NO_DATA_POSTED);

            return $response;
        }

        $image = array_shift($images);

        if (!isset($image)) {
            $response->addErrorMessageResponse($response->getMessageCollection(), 'No images found', SlimStatus::NO_IMAGE_FOUND);

            return $response;
        }

        if (!isset($image['output']['data']) && !isset($image['input']['data'])) {
            $response->addErrorMessageResponse($response->getMessageCollection(), 'No image data', SlimStatus::NO_IMAGE_DATA);

            return $response;
        }

        if ((!isset($image) || (!isset($image['output']['data']) && !isset($image['input']['data']))) &&
            isset($file)) {
            if (file_exists($file)) {
                unlink($file);
            }

            $response->addErrorMessageResponse($response->getMessageCollection(), 'Image updated to null', SlimStatus::IMAGE_UPDATED_TO_NULL);

            return $response;
        }

        if ((isset($image) || (isset($image['output']['data']) && isset($image['input']['data']))) &&
            isset($file)) {
            if (pathinfo($image['name'], PATHINFO_EXTENSION) != pathinfo($file, PATHINFO_EXTENSION)) {
                if (file_exists($file)) {
                    unlink($file);
                }
            }
        }

        if (isset($image['output']['data'])) {
            $name = isset($file) ? pathinfo($file, PATHINFO_FILENAME) . '.' . pathinfo($file, PATHINFO_EXTENSION) : $image['output']['name'];
            $data = $image['output']['data'];

            if (isset($file)) {
                $output = Slim::saveFile($data, $name, $path);
            } else {
                $output = Slim::saveFile($data, $name, $path, false, true);
            }
        }

        if (isset($image['input']['data'])) {
            $name = isset($file) ? pathinfo($file, PATHINFO_FILENAME) . '.' . pathinfo($file, PATHINFO_EXTENSION) : $image['input']['name'];
            $data = $image['input']['data'];

            if (isset($file)) {
                $input = Slim::saveFile($data, $name, $path);
            } else {
                $input = Slim::saveFile($data, $name, $path, false, true);
            }
        }

        if (isset($output) && isset($input)) {
            $objectResponse = [
                'output' => [
                    'file' => $output['name'],
                    'path' => $output['path']
                ],
                'input' => [
                    'file' => $input['name'],
                    'path' => $input['path']
                ]
            ];

        } else {
            $objectResponse = [
                'file' => isset($output) ? $output['name'] : $input['name'],
                'path' => isset($output) ? $output['path'] : $input['path']
            ];
        }

        $response->addSuccessMessageResponse($response->getMessageCollection(), 'Success', SlimStatus::SUCCESS);
        $response->setResult(response()->json($objectResponse));

        return $response;
    }*/

    //</editor-fold>
}

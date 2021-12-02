<?php

namespace App\Domains\HumanResources\Personal\Employee;

use App\Core\Domains\Contracts\Pagination\ListedSearchParameter;
use App\Core\Domains\Contracts\Pagination\PagedSearchParameter;
use App\Domains\HumanResources\MasterData\Position\PositionEloquent;
use App\Domains\HumanResources\MasterData\WorkUnit\WorkUnitEloquent;
use App\Domains\HumanResources\Mutation\PositionMutation\PositionMutationEloquent;
use App\Domains\HumanResources\Mutation\WorkUnitMutation\WorkUnitMutationEloquent;
use App\Domains\HumanResources\Personal\Employee\Contracts\EmployeeInterface;
use App\Domains\HumanResources\Personal\Employee\Contracts\EmployeeRepositoryInterface;
use App\Domains\RepositoryAbstract;
use App\Infrastructures\HumanResources\Personal\Employee\Contracts\EloquentEmployeeRepositoryInterface;
use Closure;
use DB;
use Illuminate\Support\Facades\Config;

/**
 * Class EmployeeRepository.
 */
class EmployeeRepository extends RepositoryAbstract implements EmployeeRepositoryInterface
{
    //<editor-fold desc="#constructor">

    /**
     * EmployeeRepository constructor.
     *
     * @param EloquentEmployeeRepositoryInterface $eloquent
     */
    public function __construct(EloquentEmployeeRepositoryInterface $eloquent)
    {
        parent::__construct($eloquent);
    }

    //</editor-fold>


    //<editor-fold desc="#public (method)">

    /**
     * Setup payload.
     *
     * @return array
     */
    public function setupPayload(EmployeeInterface $Employee)
    {
        $data = [
            'company_id' => $Employee->getCompanyId(),
            'nip' => $Employee->getNip(),
            'full_name' => $Employee->getFullName(),
            'nick_name' => $Employee->getNickName(),
            'gender_id' => $Employee->getGenderId(),
            'religion_id' => $Employee->getReligionId(),
            'birth_place' => $Employee->getBirthPlace(),
            'birth_date' => (!is_null($Employee->getBirthDate())) ? $Employee->getBirthDate()->format(Config::get('datetime.format.default')) : null,
            'address' => $Employee->getAddress(),
            'phone' => $Employee->getPhone(),
            'mobile' => $Employee->getMobile(),
            'email' => $Employee->getEmail(),
            'identity_number' => $Employee->getIdentityNumber(),
            'identity_expired_date' => (!is_null($Employee->getIdentityExpiredDate())) ? $Employee->getIdentityExpiredDate()->format(Config::get('datetime.format.default')) : null,
            'identity_address' => $Employee->getIdentityAddress(),
            'has_drive_license_a' => $Employee->getHasDriveLicenseA(),
            'drive_license_a_number' => $Employee->getDriveLicenseANumber(),
            'drive_license_a_date' => (!is_null($Employee->getDriveLicenseADate())) ? $Employee->getDriveLicenseADate()->format(Config::get('datetime.format.default')) : null,
            'has_drive_license_b' => $Employee->getHasDriveLicenseB(),
            'drive_license_b_number' => $Employee->getDriveLicenseBNumber(),
            'drive_license_b_date' => (!is_null($Employee->getDriveLicenseBDate())) ? $Employee->getDriveLicenseBDate()->format(Config::get('datetime.format.default')) : null,
            'has_drive_license_c' => $Employee->getHasDriveLicenseC(),
            'drive_license_c_number' => $Employee->getDriveLicenseCNumber(),
            'drive_license_c_date' => (!is_null($Employee->getDriveLicenseCDate())) ? $Employee->getDriveLicenseCDate()->format(Config::get('datetime.format.default')) : null,
            'marital_status_id' => $Employee->getMaritalStatusId(),
            'mate_as' => $Employee->getMateAs(),
            'mate_full_name' => $Employee->getMateFullName(),
            'mate_nick_name' => $Employee->getMateNickName(),
            'mate_birth_place' => $Employee->getMateBirthPlace(),
            'mate_birth_date' => (!is_null($Employee->getMateBirthDate())) ? $Employee->getMateBirthDate()->format(Config::get('datetime.format.default')) : null,
            'mate_occupation' => $Employee->getMateOccupation(),
            'office_id' => $Employee->getOfficeId(),
            'work_area_id' => $Employee->getWorkAreaId(),
            'has_npwp' => $Employee->getHasNpwp(),
            'npwp_number' => $Employee->getNpwpNumber(),
            'npwp_date' => (!is_null($Employee->getNpwpDate())) ? $Employee->getNpwpDate()->format(Config::get('datetime.format.default')) : null,
            'npwp_status' => $Employee->getNpwpStatus(),
            'has_bpjs_tenaga_kerja' => $Employee->getHasBpjsTenagaKerja(),
            'bpjs_tenaga_kerja_number' => $Employee->getBpjsTenagaKerjaNumber(),
            'bpjs_tenaga_kerja_date' => (!is_null($Employee->getBpjsTenagaKerjaDate())) ? $Employee->getBpjsTenagaKerjaDate()->format(Config::get('datetime.format.default')) : null,
            'bpjs_tenaga_kerja_class' => $Employee->getBpjsTenagaKerjaClass(),
            'has_bpjs_kesehatan' => $Employee->getHasBpjsKesehatan(),
            'bpjs_kesehatan_number' => $Employee->getBpjsKesehatanNumber(),
            'bpjs_kesehatan_date' => (!is_null($Employee->getBpjsKesehatanDate())) ? $Employee->getBpjsKesehatanDate()->format(Config::get('datetime.format.default')) : null,
            'bpjs_kesehatan_class' => $Employee->getBpjsKesehatanClass(),
            'has_mate_bpjs_kesehatan' => $Employee->getHasMateBpjsKesehatan(),
            'mate_bpjs_kesehatan_number' => $Employee->getMateBpjsKesehatanNumber(),
            'mate_bpjs_kesehatan_date' => (!is_null($Employee->getMateBpjsKesehatanDate())) ? $Employee->getMateBpjsKesehatanDate()->format(Config::get('datetime.format.default')) : null,
            'mate_bpjs_kesehatan_class' => $Employee->getMateBpjsKesehatanClass(),
            'dplk_number' => $Employee->getDplkNumber(),
            'collective_number' => $Employee->getCollectiveNumber(),
            'english_ability' => $Employee->getEnglishAbility(),
            'computer_ability' => $Employee->getComputerAbility(),
            'other_ability' => $Employee->getOtherAbility(),
            'bank_id' => $Employee->getBankId(),
            'account_number' => $Employee->getAccountNumber(),
            'join_date' => (!is_null($Employee->getJoinDate())) ? $Employee->getJoinDate()->format(Config::get('datetime.format.default')) : null,
            'work_status' => $Employee->getWorkStatus(),
            'work_type' => $Employee->getWorkType(),
            'created_by' => $Employee->getCreatedBy(),
            'modified_by' => $Employee->getModifiedBy()
        ];

        return $data;
    }

    /**
     * {@inheritdoc}
     */
    public function create(EmployeeInterface $Employee, array $relations = null)
    {
        $data = $this->setupPayload($Employee);

        return $this->eloquent()->create($data, $relations);
    }

    /**
     * {@inheritdoc}
     */
    public function update(EmployeeInterface $Employee, array $relations = null)
    {
        $data = $this->setupPayload($Employee);
       
        return $this->eloquent()->update($data, $Employee->getKey(), $relations);
    }

    /**
     * {@inheritdoc}
     */
    public function delete(EmployeeInterface $Employee, bool $isPermanentDelete = false, array $relations = null)
    {
        return $this->eloquent()->delete($Employee->getKey(), $isPermanentDelete, $relations);
    }

    /**
     * @param array $ids
     * @param array|null $relations
     * @param bool $isPermanentDelete
     * @return mixed
     */
    public function deleteBulk(array $ids, bool $isPermanentDelete = false, array $relations = null)
    {
        return $this->eloquent()->delete($ids, $isPermanentDelete, $relations);
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
     * @return mixed
     */
    public function employeeList(int $companyId = null, int $genderId = null, int $religionId = null, object $rangeBirthDate = null, object $rangeIdentityExpiredDate = null,
                                 object $rangeDriveLicenseADate = null, object $rangeDriveLicenseBDate = null, object $rangeDriveLicenseCDate = null, int $maritalStatusId = null, string $mateAs = null,
                                 object $rangeMateBirthDate = null, int $officeId = null, int $workAreaId = null, object $rangeNPWPDate = null, string $npwpStatus = null,
                                 object $rangeBPJSTenagaKerjaDate = null, string $bpjsTenagaKerjaClass = null, object $rangeBPJSKesehatanDate = null, string $bpjsKesehatanClass = null, object $rangeMateBPJSKesehatanDate = null,
                                 string $mateBPJSKesehatanClass = null, int $bankId = null, object $rangeJoinDate = null, string $workStatus = null, string $workType = null, int $degreeId = null, int $majorId = null,
                                 int $competenceId = null, int $positionId = null, int $projectId = null, int $workUnitId = null)
    {
        if (!is_null($companyId)) {
            $this->eloquent->findWhereByCompanyId($companyId);
        }

        if (!is_null($genderId)) {
            $this->eloquent->findWhereByGenderId($genderId);
        }

        if (!is_null($religionId)) {
            $this->eloquent->findWhereByReligionId($religionId);
        }

        if (!is_null($rangeBirthDate->start) &&
            !is_null($rangeBirthDate->end)) {
            $this->eloquent->findWhereBetweenByRangeBirthDate($rangeBirthDate->start, $rangeBirthDate->end);
        }

        if (!is_null($rangeIdentityExpiredDate->start) &&
            !is_null($rangeIdentityExpiredDate->end)) {
            $this->eloquent->findWhereBetweenByRangeIdentityExpiredDate($rangeIdentityExpiredDate->start, $rangeIdentityExpiredDate->end);
        }

        if (!is_null($rangeDriveLicenseADate->start) &&
            !is_null($rangeDriveLicenseADate->end)) {
            $this->eloquent->findWhereBetweenByRangeDriveLicenseADate($rangeDriveLicenseADate->start, $rangeDriveLicenseADate->end);
        }

        if (!is_null($rangeDriveLicenseBDate->start) &&
            !is_null($rangeDriveLicenseBDate->end)) {
            $this->eloquent->findWhereBetweenByRangeDriveLicenseBDate($rangeDriveLicenseBDate->start, $rangeDriveLicenseBDate->end);
        }

        if (!is_null($rangeDriveLicenseCDate->start) &&
            !is_null($rangeDriveLicenseCDate->end)) {
            $this->eloquent->findWhereBetweenByRangeDriveLicenseCDate($rangeDriveLicenseCDate->start, $rangeDriveLicenseCDate->end);
        }

        if (!is_null($maritalStatusId)) {
            $this->eloquent->findWhereByMaritalStatusId($maritalStatusId);
        }

        if (!is_null($mateAs)) {
            $this->eloquent->findWhereByMateAs($mateAs);
        }

        if (!is_null($rangeMateBirthDate->start) &&
            !is_null($rangeMateBirthDate->end)) {
            $this->eloquent->findWhereBetweenByRangeMateBirthDate($rangeMateBirthDate->start, $rangeMateBirthDate->end);
        }

        if (!is_null($officeId)) {
            $this->eloquent->findWhereByOfficeId($officeId);
        }

        if (!is_null($workAreaId)) {
            $this->eloquent->findWhereByWorkAreaId($workAreaId);
        }

        if (!is_null($rangeNPWPDate->start) &&
            !is_null($rangeNPWPDate->end)) {
            $this->eloquent->findWhereBetweenByRangeNPWPDate($rangeNPWPDate->start, $rangeNPWPDate->end);
        }

        if (!is_null($npwpStatus)) {
            $this->eloquent->findWhereByNPWPStatus($npwpStatus);
        }

        if (!is_null($rangeBPJSTenagaKerjaDate->start) &&
            !is_null($rangeBPJSTenagaKerjaDate->end)) {
            $this->eloquent->findWhereBetweenByRangeBPJSTenagaKerjaDate($rangeBPJSTenagaKerjaDate->start, $rangeBPJSTenagaKerjaDate->end);
        }

        if (!is_null($bpjsTenagaKerjaClass)) {
            $this->eloquent->findWhereByBPJSTenagaKerjaClass($bpjsTenagaKerjaClass);
        }

        if (!is_null($rangeBPJSKesehatanDate->start) &&
            !is_null($rangeBPJSKesehatanDate->end)) {
            $this->eloquent->findWhereBetweenByRangeBPJSKesehatanDate($rangeBPJSKesehatanDate->start, $rangeBPJSKesehatanDate->end);
        }

        if (!is_null($bpjsKesehatanClass)) {
            $this->eloquent->findWhereByBPJSKesehatanClass($bpjsKesehatanClass);
        }

        if (!is_null($rangeMateBPJSKesehatanDate->start) &&
            !is_null($rangeMateBPJSKesehatanDate->end)) {
            $this->eloquent->findWhereBetweenByRangeMateBPJSKesehatanDate($rangeMateBPJSKesehatanDate->start, $rangeMateBPJSKesehatanDate->end);
        }

        if (!is_null($mateBPJSKesehatanClass)) {
            $this->eloquent->findWhereByMateBPJSKesehatanClass($mateBPJSKesehatanClass);
        }

        if (!is_null($bankId)) {
            $this->eloquent->findWhereByBankId($bankId);
        }

        if (!is_null($rangeJoinDate->start) &&
            !is_null($rangeJoinDate->end)) {
            $this->eloquent->findWhereBetweenByRangeJoinDate($rangeJoinDate->start, $rangeJoinDate->end);
        }

        if (!is_null($workStatus)) {
            $this->eloquent->findWhereByWorkStatus($workStatus);
        }

        if (!is_null($workType)) {
            $this->eloquent->findWhereByWorkType($workType);
        }

        if (!is_null($degreeId)) {
            $this->eloquent->findHasFormalEducationHistoryByDegreeId($degreeId);
        }

        if (!is_null($majorId)) {
            $this->eloquent->findHasFormalEducationHistoryByMajorId($majorId);
        }

        if (!is_null($competenceId)) {
            $this->eloquent->findHasWorkCompetenceByCompetenceId($competenceId);
        }

        if (!is_null($positionId)) {
            $this->eloquent->findHasPositionMutationByPositionId($positionId);
        }

        if (!is_null($projectId)) {
            $this->eloquent->findHasProjectMutationByProjectId($projectId);
        }

        if (!is_null($workUnitId)) {
            $this->eloquent->findHasWorkUnitMutationByWorkUnitId($workUnitId);
        }

        $this->eloquent->doesnthave('terminations');

        return $this->eloquent->all();
    }

    /**
     * @param int|null $companyId
     * @param int|null $officeId
     * @param object|null $rangeTerminationDate
     * @return mixed
     */
    public function employeeTerminatedList(int $companyId = null, int $officeId = null, object $rangeTerminationDate = null)
    {
        if (!is_null($companyId)) {
            $this->eloquent->findWhereByCompanyId($companyId);
        }

        if (!is_null($officeId)) {
            $this->eloquent->findWhereByOfficeId($officeId);
        }

        if (!is_null($rangeTerminationDate->start) &&
            !is_null($rangeTerminationDate->end)) {
            $this->eloquent->findWhereBetweenByRangeTerminationDate($rangeTerminationDate->start, $rangeTerminationDate->end);
        }

        $this->eloquent->has('terminations');

        return $this->eloquent->all();
    }

    /**
     * @param int $companyId
     * @param int $officeId
     * @param int $month
     * @return mixed
     */
    public function employeeBirthDayList(int $companyId = null, int $officeId = null, int $month = null)
    {
        if (!is_null($companyId)) {
            $this->eloquent->findWhereByCompanyId($companyId);
        }

        if (!is_null($officeId)) {
            $this->eloquent->findWhereByOfficeId($officeId);
        }

        if (!is_null($month)) {
            $this->eloquent->findWhereBirthDateByMonth($month);
        }

        $this->eloquent->doesnthave('terminations');

        return $this->eloquent->all();
    }


    /**
     * @param ListedSearchParameter $parameter
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
     * @param bool $count
     * @return mixed
     */
    public function employeeListSearch(ListedSearchParameter $parameter,
                                       int $companyId = null, int $genderId = null, int $religionId = null, object $rangeBirthDate = null, object $rangeIdentityExpiredDate = null,
                                       object $rangeDriveLicenseADate = null, object $rangeDriveLicenseBDate = null, object $rangeDriveLicenseCDate = null, int $maritalStatusId = null, string $mateAs = null,
                                       object $rangeMateBirthDate = null, int $officeId = null, int $workAreaId = null, object $rangeNPWPDate = null, string $npwpStatus = null,
                                       object $rangeBPJSTenagaKerjaDate = null, string $bpjsTenagaKerjaClass = null, object $rangeBPJSKesehatanDate = null, string $bpjsKesehatanClass = null, object $rangeMateBPJSKesehatanDate = null,
                                       string $mateBPJSKesehatanClass = null, int $bankId = null, object $rangeJoinDate = null, string $workStatus = null, string $workType = null, int $degreeId = null, int $majorId = null,
                                       int $competenceId = null, int $positionId = null, int $projectId = null, int $workUnitId = null,
                                       $count = false)
    {
        $searchQuery = $parameter->query;

        if ($searchQuery) {
            $this->eloquent->findWhereBySearchQuery($searchQuery);
        }

        if (!is_null($companyId)) {
            $this->eloquent->findWhereByCompanyId($companyId);
        }

        if (!is_null($genderId)) {
            $this->eloquent->findWhereByGenderId($genderId);
        }

        if (!is_null($religionId)) {
            $this->eloquent->findWhereByReligionId($religionId);
        }

        if (!is_null($rangeBirthDate->start) &&
            !is_null($rangeBirthDate->end)) {
            $this->eloquent->findWhereBetweenByRangeBirthDate($rangeBirthDate->start, $rangeBirthDate->end);
        }

        if (!is_null($rangeIdentityExpiredDate->start) &&
            !is_null($rangeIdentityExpiredDate->end)) {
            $this->eloquent->findWhereBetweenByRangeIdentityExpiredDate($rangeIdentityExpiredDate->start, $rangeIdentityExpiredDate->end);
        }

        if (!is_null($rangeDriveLicenseADate->start) &&
            !is_null($rangeDriveLicenseADate->end)) {
            $this->eloquent->findWhereBetweenByRangeDriveLicenseADate($rangeDriveLicenseADate->start, $rangeDriveLicenseADate->end);
        }

        if (!is_null($rangeDriveLicenseBDate->start) &&
            !is_null($rangeDriveLicenseBDate->end)) {
            $this->eloquent->findWhereBetweenByRangeDriveLicenseBDate($rangeDriveLicenseBDate->start, $rangeDriveLicenseBDate->end);
        }

        if (!is_null($rangeDriveLicenseCDate->start) &&
            !is_null($rangeDriveLicenseCDate->end)) {
            $this->eloquent->findWhereBetweenByRangeDriveLicenseCDate($rangeDriveLicenseCDate->start, $rangeDriveLicenseCDate->end);
        }

        if (!is_null($maritalStatusId)) {
            $this->eloquent->findWhereByMaritalStatusId($maritalStatusId);
        }

        if (!is_null($mateAs)) {
            $this->eloquent->findWhereByMateAs($mateAs);
        }

        if (!is_null($rangeMateBirthDate->start) &&
            !is_null($rangeMateBirthDate->end)) {
            $this->eloquent->findWhereBetweenByRangeMateBirthDate($rangeMateBirthDate->start, $rangeMateBirthDate->end);
        }

        if (!is_null($officeId)) {
            $this->eloquent->findWhereByOfficeId($officeId);
        }

        if (!is_null($workAreaId)) {
            $this->eloquent->findWhereByWorkAreaId($workAreaId);
        }

        if (!is_null($rangeNPWPDate->start) &&
            !is_null($rangeNPWPDate->end)) {
            $this->eloquent->findWhereBetweenByRangeNPWPDate($rangeNPWPDate->start, $rangeNPWPDate->end);
        }

        if (!is_null($npwpStatus)) {
            $this->eloquent->findWhereByNPWPStatus($npwpStatus);
        }

        if (!is_null($rangeBPJSTenagaKerjaDate->start) &&
            !is_null($rangeBPJSTenagaKerjaDate->end)) {
            $this->eloquent->findWhereBetweenByRangeBPJSTenagaKerjaDate($rangeBPJSTenagaKerjaDate->start, $rangeBPJSTenagaKerjaDate->end);
        }

        if (!is_null($bpjsTenagaKerjaClass)) {
            $this->eloquent->findWhereByBPJSTenagaKerjaClass($bpjsTenagaKerjaClass);
        }

        if (!is_null($rangeBPJSKesehatanDate->start) &&
            !is_null($rangeBPJSKesehatanDate->end)) {
            $this->eloquent->findWhereBetweenByRangeBPJSKesehatanDate($rangeBPJSKesehatanDate->start, $rangeBPJSKesehatanDate->end);
        }

        if (!is_null($bpjsKesehatanClass)) {
            $this->eloquent->findWhereByBPJSKesehatanClass($bpjsKesehatanClass);
        }

        if (!is_null($rangeMateBPJSKesehatanDate->start) &&
            !is_null($rangeMateBPJSKesehatanDate->end)) {
            $this->eloquent->findWhereBetweenByRangeMateBPJSKesehatanDate($rangeMateBPJSKesehatanDate->start, $rangeMateBPJSKesehatanDate->end);
        }

        if (!is_null($mateBPJSKesehatanClass)) {
            $this->eloquent->findWhereByMateBPJSKesehatanClass($mateBPJSKesehatanClass);
        }

        if (!is_null($bankId)) {
            $this->eloquent->findWhereByBankId($bankId);
        }

        if (!is_null($rangeJoinDate->start) &&
            !is_null($rangeJoinDate->end)) {
            $this->eloquent->findWhereBetweenByRangeJoinDate($rangeJoinDate->start, $rangeJoinDate->end);
        }

        if (!is_null($workStatus)) {
            $this->eloquent->findWhereByWorkStatus($workStatus);
        }

        if (!is_null($workType)) {
            $this->eloquent->findWhereByWorkType($workType);
        }

        if (!is_null($degreeId)) {
            $this->eloquent->findHasFormalEducationHistoryByDegreeId($degreeId);
        }

        if (!is_null($majorId)) {
            $this->eloquent->findHasFormalEducationHistoryByMajorId($majorId);
        }

        if (!is_null($competenceId)) {
            $this->eloquent->findHasWorkCompetenceByCompetenceId($competenceId);
        }

        if (!is_null($positionId)) {
            $this->eloquent->findHasPositionMutationByPositionId($positionId);
        }

        if (!is_null($projectId)) {
            $this->eloquent->findHasProjectMutationByProjectId($projectId);
        }

        if (!is_null($workUnitId)) {
            $this->eloquent->findHasWorkUnitMutationByWorkUnitId($workUnitId);
        }

        $this->eloquent->doesnthave('terminations');

        if (!$count) {
            return $this->eloquent->with(['company', 'gender', 'religion', 'maritalStatus', 'workArea', 'office', 'bank',
                'projectMutations' => function ($query) {
                    return $query->latest('id');
                },
                'workUnitMutations' => function ($query) {
                    return $query->latest('id');
                },
                'positionMutations' => function ($query) {
                    return $query->latest('id');
                },
                'workCompetences', 'formalEducationHistories', 'nonFormalEducationHistories', 'organizationHistories', 'workExperiences', 'workAgreementLetters', 'registrationLetters', 'terminations', 'otherEquipments', 'childs',
                'morphMediaLibraries'])
                ->all();
        } else {
            return $this->eloquent->all()->count();
        }
    }

    /**
     * @param ListedSearchParameter $parameter
     * @param int|null $companyId
     * @param int|null $officeId
     * @param object|null $rangeTerminationDate
     * @param bool $count
     * @return mixed
     */
    public function employeeTerminatedListSearch(ListedSearchParameter $parameter,
                                                 int $companyId = null, int $officeId = null, object $rangeTerminationDate = null,
                                                 $count = false)
    {
        $searchQuery = $parameter->query;

        if ($searchQuery) {
            $this->eloquent->findWhereBySearchQuery($searchQuery);
        }

        if (!is_null($companyId)) {
            $this->eloquent->findWhereByCompanyId($companyId);
        }

        if (!is_null($officeId)) {
            $this->eloquent->findWhereByOfficeId($officeId);
        }

        if (!is_null($rangeTerminationDate->start) &&
            !is_null($rangeTerminationDate->end)) {
            $this->eloquent->findWhereBetweenByRangeTerminationDate($rangeTerminationDate->start, $rangeTerminationDate->end);
        }

        $this->eloquent->has('terminations');

        if (!$count) {
            return $this->eloquent->with(['company', 'gender', 'religion', 'maritalStatus', 'workArea', 'office', 'bank',
                'projectMutations', 'workUnitMutations', 'positionMutations', 'workCompetences', 'formalEducationHistories', 'nonFormalEducationHistories', 'organizationHistories', 'workExperiences', 'workAgreementLetters', 'registrationLetters', 'terminations', 'otherEquipments', 'childs',
                'morphMediaLibraries'])
                ->all();
        } else {
            return $this->eloquent->all()->count();
        }
    }

    /**
     * @param ListedSearchParameter $parameter
     * @param null $companyId
     * @param null $officeId
     * @param null $month
     * @param bool $termination
     * @param bool $count
     * @return mixed
     */
    public function employeeBirthDayListSearch(ListedSearchParameter $parameter,
                                               $companyId = null, $officeId = null, $month = null,
                                               $termination = false,
                                               $count = false)
    {
        $searchQuery = $parameter->query;

        if ($searchQuery) {
            $this->eloquent->findWhereBySearchQuery($searchQuery);
        }

        if (!is_null($companyId)) {
            $this->eloquent->findWhereByCompanyId($companyId);
        }

        if (!is_null($officeId)) {
            $this->eloquent->findWhereByOfficeId($officeId);
        }

        if (!is_null($month)) {
            $this->eloquent->findWhereBirthDateByMonth($month);
        }

        $this->eloquent->doesnthave('terminations');

        if (!$count) {
            return $this->eloquent->with(['company', 'gender', 'religion', 'maritalStatus', 'workArea', 'office', 'bank',
                'projectMutations' => function ($query) {
                    return $query->latest('id');
                },
                'workUnitMutations' => function ($query) {
                    return $query->latest('id');
                },
                'positionMutations' => function ($query) {
                    return $query->latest('id');
                },
                'workCompetences', 'formalEducationHistories', 'nonFormalEducationHistories', 'organizationHistories', 'workExperiences', 'workAgreementLetters', 'registrationLetters', 'terminations', 'otherEquipments', 'childs',
                'morphMediaLibraries'])
                ->all();
        } else {
            return $this->eloquent->all()->count();
        }
    }


    /**
     * @param PagedSearchParameter $parameter
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
     * @param bool $count
     * @return mixed
     */
    public function employeePageSearch(PagedSearchParameter $parameter,
                                       int $companyId = null, int $genderId = null, int $religionId = null, object $rangeBirthDate = null, object $rangeIdentityExpiredDate = null,
                                       object $rangeDriveLicenseADate = null, object $rangeDriveLicenseBDate = null, object $rangeDriveLicenseCDate = null, int $maritalStatusId = null, string $mateAs = null,
                                       object $rangeMateBirthDate = null, int $officeId = null, int $workAreaId = null, object $rangeNPWPDate = null, string $npwpStatus = null,
                                       object $rangeBPJSTenagaKerjaDate = null, string $bpjsTenagaKerjaClass = null, object $rangeBPJSKesehatanDate = null, string $bpjsKesehatanClass = null, object $rangeMateBPJSKesehatanDate = null,
                                       string $mateBPJSKesehatanClass = null, int $bankId = null, object $rangeJoinDate = null, string $workStatus = null, string $workType = null, int $degreeId = null, int $majorId = null,
                                       int $competenceId = null, int $positionId = null, int $projectId = null, int $workUnitId = null,
                                       $count = false)
    {
        $this->eloquent->select('employees.*, genders.name as gender, religions.name as religion, marital_status.name as marital_status, offices.name as office');
        $this->eloquent->join('companies', 'employees.company_id', '=', 'companies.id');
        $this->eloquent->join('genders', 'employees.gender_id', '=', 'genders.id');
        $this->eloquent->join('religions', 'employees.religion_id', '=', 'religions.id');
        $this->eloquent->join('marital_status', 'employees.marital_status_id', '=', 'marital_status.id');
        $this->eloquent->join('offices', 'employees.office_id', '=', 'offices.id');
        $this->eloquent->join('work_areas', 'employees.work_area_id', '=', 'work_areas.id');
        $this->eloquent->join('banks', 'employees.bank_id', '=', 'banks.id');

        $searchQuery = !is_null($parameter->search) ? $parameter->search['value'] : $parameter->query['value'] ?? null;

        if ($searchQuery) {
            $this->eloquent->findWhereBySearchQuery($searchQuery);
        }

        if (!is_null($companyId)) {
            $this->eloquent->findWhereByCompanyId($companyId);
        }

        if (!is_null($genderId)) {
            $this->eloquent->findWhereByGenderId($genderId);
        }

        if (!is_null($religionId)) {
            $this->eloquent->findWhereByReligionId($religionId);
        }

        if (!is_null($rangeBirthDate->start) &&
            !is_null($rangeBirthDate->end)) {
            $this->eloquent->findWhereBetweenByRangeBirthDate($rangeBirthDate->start, $rangeBirthDate->end);
        }

        if (!is_null($rangeIdentityExpiredDate->start) &&
            !is_null($rangeIdentityExpiredDate->end)) {
            $this->eloquent->findWhereBetweenByRangeIdentityExpiredDate($rangeIdentityExpiredDate->start, $rangeIdentityExpiredDate->end);
        }

        if (!is_null($rangeDriveLicenseADate->start) &&
            !is_null($rangeDriveLicenseADate->end)) {
            $this->eloquent->findWhereBetweenByRangeDriveLicenseADate($rangeDriveLicenseADate->start, $rangeDriveLicenseADate->end);
        }

        if (!is_null($rangeDriveLicenseBDate->start) &&
            !is_null($rangeDriveLicenseBDate->end)) {
            $this->eloquent->findWhereBetweenByRangeDriveLicenseBDate($rangeDriveLicenseBDate->start, $rangeDriveLicenseBDate->end);
        }

        if (!is_null($rangeDriveLicenseCDate->start) &&
            !is_null($rangeDriveLicenseCDate->end)) {
            $this->eloquent->findWhereBetweenByRangeDriveLicenseCDate($rangeDriveLicenseCDate->start, $rangeDriveLicenseCDate->end);
        }

        if (!is_null($maritalStatusId)) {
            $this->eloquent->findWhereByMaritalStatusId($maritalStatusId);
        }

        if (!is_null($mateAs)) {
            $this->eloquent->findWhereByMateAs($mateAs);
        }

        if (!is_null($rangeMateBirthDate->start) &&
            !is_null($rangeMateBirthDate->end)) {
            $this->eloquent->findWhereBetweenByRangeMateBirthDate($rangeMateBirthDate->start, $rangeMateBirthDate->end);
        }

        if (!is_null($officeId)) {
            $this->eloquent->findWhereByOfficeId($officeId);
        }

        if (!is_null($workAreaId)) {
            $this->eloquent->findWhereByWorkAreaId($workAreaId);
        }

        if (!is_null($rangeNPWPDate->start) &&
            !is_null($rangeNPWPDate->end)) {
            $this->eloquent->findWhereBetweenByRangeNPWPDate($rangeNPWPDate->start, $rangeNPWPDate->end);
        }

        if (!is_null($npwpStatus)) {
            $this->eloquent->findWhereByNPWPStatus($npwpStatus);
        }

        if (!is_null($rangeBPJSTenagaKerjaDate->start) &&
            !is_null($rangeBPJSTenagaKerjaDate->end)) {
            $this->eloquent->findWhereBetweenByRangeBPJSTenagaKerjaDate($rangeBPJSTenagaKerjaDate->start, $rangeBPJSTenagaKerjaDate->end);
        }

        if (!is_null($bpjsTenagaKerjaClass)) {
            $this->eloquent->findWhereByBPJSTenagaKerjaClass($bpjsTenagaKerjaClass);
        }

        if (!is_null($rangeBPJSKesehatanDate->start) &&
            !is_null($rangeBPJSKesehatanDate->end)) {
            $this->eloquent->findWhereBetweenByRangeBPJSKesehatanDate($rangeBPJSKesehatanDate->start, $rangeBPJSKesehatanDate->end);
        }

        if (!is_null($bpjsKesehatanClass)) {
            $this->eloquent->findWhereByBPJSKesehatanClass($bpjsKesehatanClass);
        }

        if (!is_null($rangeMateBPJSKesehatanDate->start) &&
            !is_null($rangeMateBPJSKesehatanDate->end)) {
            $this->eloquent->findWhereBetweenByRangeMateBPJSKesehatanDate($rangeMateBPJSKesehatanDate->start, $rangeMateBPJSKesehatanDate->end);
        }

        if (!is_null($mateBPJSKesehatanClass)) {
            $this->eloquent->findWhereByMateBPJSKesehatanClass($mateBPJSKesehatanClass);
        }

        if (!is_null($bankId)) {
            $this->eloquent->findWhereByBankId($bankId);
        }

        if (!is_null($rangeJoinDate->start) &&
            !is_null($rangeJoinDate->end)) {
            $this->eloquent->findWhereBetweenByRangeJoinDate($rangeJoinDate->start, $rangeJoinDate->end);
        }

        if (!is_null($workStatus)) {
            $this->eloquent->findWhereByWorkStatus($workStatus);
        }

        if (!is_null($workType)) {
            $this->eloquent->findWhereByWorkType($workType);
        }

        if (!is_null($degreeId)) {
            $this->eloquent->findHasFormalEducationHistoryByDegreeId($degreeId);
        }

        if (!is_null($majorId)) {
            $this->eloquent->findHasFormalEducationHistoryByMajorId($majorId);
        }

        if (!is_null($competenceId)) {
            $this->eloquent->findHasWorkCompetenceByCompetenceId($competenceId);
        }

        if (!is_null($positionId)) {
            $this->eloquent->findHasPositionMutationByPositionId($positionId);
        }

        if (!is_null($projectId)) {
            $this->eloquent->findHasProjectMutationByProjectId($projectId);
        }

        if (!is_null($workUnitId)) {
            $this->eloquent->findHasWorkUnitMutationByWorkUnitId($workUnitId);
        }

        $this->eloquent->doesntHave('terminations');

        if (!$count) {
            if ($parameter->draw) {
                return $this->eloquent->with(['company', 'gender', 'religion', 'maritalStatus', 'workArea', 'office', 'bank',
                    'projectMutations' => function ($query) {
                        return $query->latest('id');
                    },
                    'workUnitMutations' => function ($query) {
                        return $query->latest('id');
                    },
                    'positionMutations' => function ($query) {
                        return $query->latest('id');
                    },
                    'workCompetences', 'formalEducationHistories', 'nonFormalEducationHistories', 'organizationHistories', 'workExperiences', 'workAgreementLetters', 'registrationLetters', 'terminations', 'otherEquipments', 'childs',
                    'morphMediaLibraries'])
                    ->orderBy($parameter->columns[$parameter->order[0]['column']]['data'], $parameter->order[0]['dir'])
                    ->paginate($parameter->length, $parameter->start);
            } else {
                return $this->eloquent->with(['company', 'gender', 'religion', 'maritalStatus', 'workArea', 'office', 'bank',
                    'projectMutations' => function ($query) {
                        return $query->latest('id');
                    },
                    'workUnitMutations' => function ($query) {
                        return $query->latest('id');
                    },
                    'positionMutations' => function ($query) {
                        return $query->latest('id');
                    },
                    'workCompetences', 'formalEducationHistories', 'nonFormalEducationHistories', 'organizationHistories', 'workExperiences', 'workAgreementLetters', 'registrationLetters', 'terminations', 'otherEquipments', 'childs',
                    'morphMediaLibraries'])
                    ->orderBy($parameter->sort['field'], $parameter->sort['sort'])
                    ->paginate($parameter->pagination['perpage'], ($parameter->pagination['perpage'] * ($parameter->pagination['page'] - 1)));
            }
        } else {
            return $this->eloquent->all()->count();
        }
    }

    /**
     * @param PagedSearchParameter $parameter
     * @param int|null $companyId
     * @param int|null $officeId
     * @param object|null $rangeTerminationDate
     * @param bool $count
     * @return mixed
     */
    public function employeeTerminatedPageSearch(PagedSearchParameter $parameter,
                                                 int $companyId = null, int $officeId = null, object $rangeTerminationDate = null,
                                                 $count = false)
    {
        $this->eloquent->select('employees.*, genders.name as gender, religions.name as religion, marital_status.name as marital_status, offices.name as office');
        $this->eloquent->join('companies', 'employees.company_id', '=', 'companies.id');
        $this->eloquent->join('genders', 'employees.gender_id', '=', 'genders.id');
        $this->eloquent->join('religions', 'employees.religion_id', '=', 'religions.id');
        $this->eloquent->join('marital_status', 'employees.marital_status_id', '=', 'marital_status.id');
        $this->eloquent->join('offices', 'employees.office_id', '=', 'offices.id');
        $this->eloquent->join('work_areas', 'employees.work_area_id', '=', 'work_areas.id');
        $this->eloquent->join('banks', 'employees.bank_id', '=', 'banks.id');

        $searchQuery = !is_null($parameter->search) ? $parameter->search['value'] : $parameter->query['value'] ?? null;

        if ($searchQuery) {
            $this->eloquent->findWhereBySearchQuery($searchQuery);
        }

        if (!is_null($companyId)) {
            $this->eloquent->findWhereByCompanyId($companyId);
        }

        if (!is_null($officeId)) {
            $this->eloquent->findWhereByOfficeId($officeId);
        }

        if (!is_null($rangeTerminationDate->start) &&
            !is_null($rangeTerminationDate->end)) {
            $this->eloquent->findWhereBetweenByRangeTerminationDate($rangeTerminationDate->start, $rangeTerminationDate->end);
        }

        $this->eloquent->has('terminations');

        if (!$count) {
            if ($parameter->draw) {
                return $this->eloquent->with(['company', 'gender', 'religion', 'maritalStatus', 'workArea', 'office', 'bank',
                    'projectMutations' => function ($query) {
                        return $query->latest('id');
                    },
                    'workUnitMutations' => function ($query) {
                        return $query->latest('id');
                    },
                    'positionMutations' => function ($query) {
                        return $query->latest('id');
                    },
                    'workCompetences', 'formalEducationHistories', 'nonFormalEducationHistories', 'organizationHistories', 'workExperiences', 'workAgreementLetters', 'registrationLetters', 'terminations', 'otherEquipments', 'childs',
                    'morphMediaLibraries'])
                    ->orderBy($parameter->columns[$parameter->order[0]['column']]['data'], $parameter->order[0]['dir'])
                    ->paginate($parameter->length, $parameter->start);
            } else {
                return $this->eloquent->with(['company', 'gender', 'religion', 'maritalStatus', 'workArea', 'office', 'bank',
                    'projectMutations' => function ($query) {
                        return $query->latest('id');
                    },
                    'workUnitMutations' => function ($query) {
                        return $query->latest('id');
                    },
                    'positionMutations' => function ($query) {
                        return $query->latest('id');
                    },
                    'workCompetences', 'formalEducationHistories', 'nonFormalEducationHistories', 'organizationHistories', 'workExperiences', 'workAgreementLetters', 'registrationLetters', 'terminations', 'otherEquipments', 'childs',
                    'morphMediaLibraries'])
                    ->orderBy($parameter->sort['field'], $parameter->sort['sort'])
                    ->paginate($parameter->pagination['perpage'], ($parameter->pagination['perpage'] * ($parameter->pagination['page'] - 1)));
            }
        } else {
            return $this->eloquent->all()->count();
        }
    }

    /**
     * @param PagedSearchParameter $parameter
     * @param null $companyId
     * @param null $officeId
     * @param null $month
     * @param bool $termination
     * @param null $count
     * @return mixed
     */
    public function employeeBirthDayPageSearch(PagedSearchParameter $parameter,
                                               $companyId = null, $officeId = null, $month = null,
                                               $termination = false,
                                               $count = null)
    {
        $this->eloquent->select('employees.*, genders.name as gender, religions.name as religion, marital_status.name as marital_status, offices.name as office');
        $this->eloquent->join('companies', 'employees.company_id', '=', 'companies.id');
        $this->eloquent->join('genders', 'employees.gender_id', '=', 'genders.id');
        $this->eloquent->join('religions', 'employees.religion_id', '=', 'religions.id');
        $this->eloquent->join('marital_status', 'employees.marital_status_id', '=', 'marital_status.id');
        $this->eloquent->join('offices', 'employees.office_id', '=', 'offices.id');
        $this->eloquent->join('work_areas', 'employees.work_area_id', '=', 'work_areas.id');
        $this->eloquent->join('banks', 'employees.bank_id', '=', 'banks.id');

        $searchQuery = !is_null($parameter->search) ? $parameter->search['value'] : $parameter->query['value'] ?? null;

        if ($searchQuery) {
            $this->eloquent->findWhereBySearchQuery($searchQuery);
        }

        if ($companyId != null) {
            $this->eloquent->findWhereByCompanyId($companyId);
        }

        if ($officeId != null) {
            $this->eloquent->findWhereByOfficeId($officeId);
        }

        if ($month != null) {
            $this->eloquent->findWhereBirthDateByMonth($month);
        }

        $this->eloquent->doesnthave('terminations');

        if (!$count) {
            if ($parameter->draw) {
                return $this->eloquent->with(['company', 'gender', 'religion', 'maritalStatus', 'workArea', 'office', 'bank',
                    'projectMutations' => function ($query) {
                        return $query->latest('id');
                    },
                    'workUnitMutations' => function ($query) {
                        return $query->latest('id');
                    },
                    'positionMutations' => function ($query) {
                        return $query->latest('id');
                    },
                    'workCompetences', 'formalEducationHistories', 'nonFormalEducationHistories', 'organizationHistories', 'workExperiences', 'workAgreementLetters', 'registrationLetters', 'terminations', 'otherEquipments', 'childs',
                    'morphMediaLibraries'])
                    ->orderBy($parameter->columns[$parameter->order[0]['column']]['data'], $parameter->order[0]['dir'])
                    ->paginate($parameter->length, $parameter->start);
            } else {
                return $this->eloquent->with(['company', 'gender', 'religion', 'maritalStatus', 'workArea', 'office', 'bank',
                    'projectMutations' => function ($query) {
                        return $query->latest('id');
                    },
                    'workUnitMutations' => function ($query) {
                        return $query->latest('id');
                    },
                    'positionMutations' => function ($query) {
                        return $query->latest('id');
                    },
                    'workCompetences', 'formalEducationHistories', 'nonFormalEducationHistories', 'organizationHistories', 'workExperiences', 'workAgreementLetters', 'registrationLetters', 'terminations', 'otherEquipments', 'childs',
                    'morphMediaLibraries'])
                    ->orderBy($parameter->sort['field'], $parameter->sort['sort'])
                    ->paginate($parameter->pagination['perpage'], ($parameter->pagination['perpage'] * ($parameter->pagination['page'] - 1)));
            }
        } else {
            return $this->eloquent->all()->count();
        }
    }

    /**
     * @param ListedSearchParameter $parameter
     * @param null $companyId
     * @param bool $count
     * @return mixed
     */
    public function employeeGroupByOfficeListSearch(ListedSearchParameter $parameter, $companyId = null, $count = false)
    {
        if ($companyId != null) {
            $this->eloquent->findWhereByCompanyId($companyId);
        }

        $this->eloquent->doesnthave('terminations');

        if (!$count) {
            return $this->eloquent->with(['company', 'gender', 'religion', 'maritalStatus', 'workArea', 'bank', 'office',
                'projectMutations' => function ($query) {
                    return $query->latest('id');
                },
                'workUnitMutations' => function ($query) {
                    return $query->latest('id');
                },
                'positionMutations' => function ($query) {
                    return $query->latest('id');
                },
                'workCompetences', 'formalEducationHistories', 'nonFormalEducationHistories', 'organizationHistories', 'workExperiences', 'workAgreementLetters', 'registrationLetters', 'terminations', 'otherEquipments', 'childs',
                'morphMediaLibraries'])
                ->get()
                ->groupBy('office.name');
        } else {
            return $this->eloquent->all()->count();
        }
    }

    /**
     * @param ListedSearchParameter $parameter
     * @param null $companyId
     * @param bool $count
     * @return mixed
     */
    public function employeeGroupByWorkAreaListSearch(ListedSearchParameter $parameter, $companyId = null, $count = false)
    {
        if ($companyId != null) {
            $this->eloquent->findWhereByCompanyId($companyId);
        }

        $this->eloquent->doesnthave('terminations');

        if (!$count) {
            return $this->eloquent->with(['company', 'gender', 'religion', 'maritalStatus', 'workArea', 'bank', 'office',
                'projectMutations' => function ($query) {
                    return $query->latest('id');
                },
                'workUnitMutations' => function ($query) {
                    return $query->latest('id');
                },
                'positionMutations' => function ($query) {
                    return $query->latest('id');
                },
                'workCompetences', 'formalEducationHistories', 'nonFormalEducationHistories', 'organizationHistories', 'workExperiences', 'workAgreementLetters', 'registrationLetters', 'terminations', 'otherEquipments', 'childs',
                'morphMediaLibraries'])
                ->get()
                ->groupBy('workArea.title');
        } else {
            return $this->eloquent->all()->count();
        }
    }

    /**
     * @param ListedSearchParameter $parameter
     * @param null $companyId
     * @param bool $count
     * @return mixed
     */
    public function employeeGroupByPositionListSearch(ListedSearchParameter $parameter, $companyId = null, $count = false)
    {
        $data = collect([]);
        $position_mutations = PositionMutationEloquent::get()
            ->groupBy('position_id');

        foreach ($position_mutations as $position_id => $position_mutation) {
            $position = PositionEloquent::query();

            if ($companyId != null) {
                $position = $position->whereCompanyId($companyId);
            }

            $position = $position->first();

            $data_employee = collect([]);
            foreach ($position_mutation as $key => $row) {
                $employee = $row->employee;
                $data_employee->put($key, $employee);
            }
            $data->put($position->name, $data_employee);
        }

        if (!$count) {
            return $data;
        } else {
            return $data->count();
        }
    }

    /**
     * @param ListedSearchParameter $parameter
     * @param null $companyId
     * @param bool $count
     * @return mixed
     */
    public function employeeGroupByWorkUnitListSearch(ListedSearchParameter $parameter, $companyId = null, $count = false)
    {
        $data = collect([]);
        $position_mutations = WorkUnitMutationEloquent::get()
            ->groupBy('work_unit_id');

        foreach ($position_mutations as $work_unit_id => $work_unit_mutation) {
            $work_unit = WorkUnitEloquent::query();

            if ($companyId != null) {
                $work_unit = $work_unit->whereCompanyId($companyId);
            }

            $work_unit = $work_unit->first();

            $data_employee = collect([]);
            foreach ($work_unit_mutation as $key => $row) {
                $employee = $row->employee;
                $data_employee->put($key, $employee);
            }
            $data->put($work_unit->name, $data_employee);
        }

        if (!$count) {
            return $data;
        } else {
            return $data->count();
        }
    }
}

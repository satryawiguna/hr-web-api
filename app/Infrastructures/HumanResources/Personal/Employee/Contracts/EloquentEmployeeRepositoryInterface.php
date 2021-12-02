<?php

namespace App\Infrastructures\HumanResources\Personal\Employee\Contracts;

use App\Infrastructures\Contracts\EloquentRepositoryInterface;
use DateTime;

interface EloquentEmployeeRepositoryInterface extends EloquentRepositoryInterface
{
    /**
     * @param int $companyId
     * @return mixed
     */
    public function findWhereByCompanyId(int $companyId);

    /**
     * @param int $genderId
     * @return mixed
     */
    public function findWhereByGenderId(int $genderId);

    /**
     * @param int $religionId
     * @return mixed
     */
    public function findWhereByReligionId(int $religionId);

    /**
     * @param DateTime $startBirthDate
     * @param DateTime $endBirthDate
     * @return mixed
     */
    public function findWhereBetweenByRangeBirthDate(DateTime $startBirthDate, Datetime $endBirthDate);

    /**
     * @param DateTime $startIdentityExpiredDate
     * @param DateTime $endIdentityExpiredDate
     * @return mixed
     */
    public function findWhereBetweenByRangeIdentityExpiredDate(DateTime $startIdentityExpiredDate, Datetime $endIdentityExpiredDate);

    /**
     * @param DateTime $startDriveLicenseADate
     * @param DateTime $endDriveLicenseADate
     * @return mixed
     */
    public function findWhereBetweenByRangeDriveLicenseADate(DateTime $startDriveLicenseADate, Datetime $endDriveLicenseADate);

    /**
     * @param DateTime $startDriveLicenseBDate
     * @param DateTime $endDriveLicenseBDate
     * @return mixed
     */
    public function findWhereBetweenByRangeDriveLicenseBDate(DateTime $startDriveLicenseBDate, Datetime $endDriveLicenseBDate);

    /**
     * @param DateTime $startDriveLicenseCDate
     * @param DateTime $endDriveLicenseCDate
     * @return mixed
     */
    public function findWhereBetweenByRangeDriveLicenseCDate(DateTime $startDriveLicenseCDate, Datetime $endDriveLicenseCDate);

    /**
     * @param int $maritalStatusId
     * @return mixed
     */
    public function findWhereByMaritalStatusId(int $maritalStatusId);

    /**
     * @param string $mateAs
     * @return mixed
     */
    public function findWhereByMateAs(string $mateAs);

    /**
     * @param DateTime $startMateBirthDate
     * @param DateTime $endMateBirthDate
     * @return mixed
     */
    public function findWhereBetweenByRangeMateBirthDate(DateTime $startMateBirthDate, Datetime $endMateBirthDate);

    /**
     * @param DateTime $startMateBPJSKesehatanDate
     * @param DateTime $endMateBPJSKesehatanDate
     * @return mixed
     */
    public function findWhereBetweenByRangeMateBPJSKesehatanDate(DateTime $startMateBPJSKesehatanDate, Datetime $endMateBPJSKesehatanDate);

    /**
     * @param string $mateBPJSKesehatanClass
     * @return mixed
     */
    public function findWhereByMateBPJSKesehatanClass(string $mateBPJSKesehatanClass);

    /**
     * @param int $officeId
     * @return mixed
     */
    public function findWhereByOfficeId(int $officeId);

    /**
     * @param int $workAreaId
     * @return mixed
     */
    public function findWhereByWorkAreaId(int $workAreaId);

    /**
     * @param DateTime $startNPWPDate
     * @param DateTime $endNPWPDate
     * @return mixed
     */
    public function findWhereBetweenByRangeNPWPDate(DateTime $startNPWPDate, Datetime $endNPWPDate);

    /**
     * @param string $npwpStatus
     * @return mixed
     */
    public function findWhereByNPWPStatus(string $npwpStatus);

    /**
     * @param DateTime $startBPJSTenagaKerjaDate
     * @param DateTime $endBPJSTenagaKerjaDate
     * @return mixed
     */
    public function findWhereBetweenByRangeBPJSTenagaKerjaDate(DateTime $startBPJSTenagaKerjaDate, Datetime $endBPJSTenagaKerjaDate);

    /**
     * @param string $bpjsTenagaKerjaClass
     * @return mixed
     */
    public function findWhereByBPJSTenagaKerjaClass(string $bpjsTenagaKerjaClass);

    /**
     * @param DateTime $startBPJSKesehatanDate
     * @param DateTime $endBPJSKesehatanDate
     * @return mixed
     */
    public function findWhereBetweenByRangeBPJSKesehatanDate(DateTime $startBPJSKesehatanDate, Datetime $endBPJSKesehatanDate);

    /**
     * @param string $bpjsKesehatanClass
     * @return mixed
     */
    public function findWhereByBPJSKesehatanClass(string $bpjsKesehatanClass);

    /**
     * @param int $bankId
     * @return mixed
     */
    public function findWhereByBankId(int $bankId);

    /**
     * @param DateTime $startJoinDate
     * @param DateTime $endJoinDate
     * @return mixed
     */
    public function findWhereBetweenByRangeJoinDate(DateTime $startJoinDate, DateTime $endJoinDate);

    /**
     * @param string $workStatus
     * @return mixed
     */
    public function findWhereByWorkStatus(string $workStatus);

    /**
     * @param string $workType
     * @return mixed
     */
    public function findWhereByWorkType(string $workType);

    /**
     * @param int $degreeId
     * @return mixed
     */
    public function findHasFormalEducationHistoryByDegreeId(int $degreeId);

    /**
     * @param int $majorId
     * @return mixed
     */
    public function findHasFormalEducationHistoryByMajorId(int $majorId);

    /**
     * @param int $competenceId
     * @return mixed
     */
    public function findHasWorkCompetenceByCompetenceId(int $competenceId);

    /**
     * @param int $positionId
     * @return mixed
     */
    public function findHasPositionMutationByPositionId(int $positionId);

    /**
     * @param int $projectId
     * @return mixed
     */
    public function findHasProjectMutationByProjectId(int $projectId);

    /**
     * @param int $workUnitId
     * @return mixed
     */
    public function findHasWorkUnitMutationByWorkUnitId(int $workUnitId);

    /**
     * @param DateTime $startTerminationDate
     * @param DateTime $endTerminationDate
     * @return mixed
     */
    public function findHasTerminationByRangeTerminationDate(DateTime $startTerminationDate, DateTime $endTerminationDate);

    /**
     * @param int $month
     * @return mixed
     */
    public function findWhereBirthDateByMonth(int $month);

    /**
     * @param string $searchQuery
     * @return mixed
     */
    public function findWhereBySearchQuery(string $searchQuery);
}

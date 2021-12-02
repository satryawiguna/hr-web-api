<?php

namespace App\Domains\HumanResources\Personal\Employee\Contracts;

use App\Core\Domains\Contracts\Pagination\ListedSearchParameter;
use App\Core\Domains\Contracts\Pagination\PagedSearchParameter;
use App\Domains\Contracts\HasEloquentStorageRepositoryInterface;
use App\Infrastructures\HumanResources\Personal\Employee\Contracts\EloquentEmployeeRepositoryInterface;
use App\Domains\Contracts\BaseEntityInterface;
use Closure;

/**
 * Interface EmployeeRepositoryInterface.
 */
interface EmployeeRepositoryInterface
{
    //<editor-fold desc="#constructor">

    /**
     * EmployeeRepositoryInterface constructor.
     *
     * @param EloquentEmployeeRepositoryInterface $eloquent
     */
    public function __construct(EloquentEmployeeRepositoryInterface $eloquent);

    //</editor-fold>


    //<editor-fold desc="#public (method)">

    /**
     * Create Employee.
     *
     * @param EmployeeInterface $Employee
     *
     * @param array|null $relations
     * @return mixed
     */
    public function create(EmployeeInterface $Employee, array $relations = null);

    /**
     * Update Employee.
     *
     * @param EmployeeInterface $Employee
     *
     * @param array|null $relations
     * @return mixed
     */
    public function update(EmployeeInterface $Employee, array $relations = null);

    /**
     * Delete Employee.
     *
     * @param EmployeeInterface $Employee
     *
     * @param array|null $relations
     * @param bool $isPermanentDelete
     * @return mixed
     */
    public function delete(EmployeeInterface $Employee, bool $isPermanentDelete = false, array $relations = null);

    /**
     * @param array $ids
     * @param array|null $relations
     * @param bool $isPermanentDelete
     * @return mixed
     */
    public function deleteBulk(array $ids, bool $isPermanentDelete = false, array $relations = null);

    /**
     * Get CompanySize.
     *
     * @param $id
     *
     * @return mixed
     */
    public function find(int $id);


    /**
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
     * @return mixed
     */
    public function employeeList(int $companyId = null, int $genderId = null, int $religionId = null, object $rangeBirthDate = null, object $rangeIdentityExpiredDate = null,
                                 object $rangeDriveLicenseADate = null, object $rangeDriveLicenseBDate = null, object $rangeDriveLicenseCDate = null, int $maritalStatusId = null, string $mateAs = null,
                                 object $rangeMateBirthDate = null, int $officeId = null, int $workAreaId = null, object $rangeNPWPDate = null, string $npwpStatus = null,
                                 object $rangeBPJSTenagaKerjaDate = null, string $bpjsTenagaKerjaClass = null, object $rangeBPJSKesehatanDate = null, string $bpjsKesehatanClass = null, object $rangeMateBPJSKesehatanDate = null,
                                 string $mateBPJSKesehatanClass = null, int $bankId = null, object $rangeJoinDate = null, string $workStatus = null, string $workType = null, int $degreeId = null, int $majorId = null,
                                 int $competenceId = null, int $positionId = null, int $projectId = null, int $workUnitId = null);

    /**
     * @param int|null $companyId
     * @param int|null $officeId
     * @param object|null $rangerTerminationDate
     * @return mixed
     */
    public function employeeTerminatedList(int $companyId = null, int $officeId = null, object $rangerTerminationDate = null);

    /**
     * @param int $companyId
     * @param int $officeId
     * @param int $month
     * @return mixed
     */
    public function employeeBirthDayList(int $companyId = null, int $officeId = null, int $month = null);


    /**
     * @param ListedSearchParameter $parameter
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
                                       $count = false);

    /**
     * @param ListedSearchParameter $parameter
     * @param int|null $companyId
     * @param int|null $officeId
     * @param object|null $rangerTerminationDate
     * @param bool $count
     * @return mixed
     */
    public function employeeTerminatedListSearch(ListedSearchParameter $parameter,
                                                 int $companyId = null, int $officeId = null, object $rangerTerminationDate = null,
                                                 $count = false);

    /**
     * @param ListedSearchParameter $parameter
     * @param null $companyId
     * @param null $officeId
     * @param null $month
     * @param bool $count
     * @return mixed
     */
    public function employeeBirthDayListSearch(ListedSearchParameter $parameter,
                                               $companyId = null, $officeId = null, $month = null,
                                               $count = false);


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
                                       $count = false);

    /**
     * @param PagedSearchParameter $parameter
     * @param int|null $companyId
     * @param int|null $officeId
     * @param object|null $rangerTerminationDate
     * @param bool $count
     * @return mixed
     */
    public function employeeTerminatedPageSearch(PagedSearchParameter $parameter,
                                                 int $companyId = null, int $officeId = null, object $rangerTerminationDate = null,
                                                 $count = false);

    /**
     * @param PagedSearchParameter $parameter
     * @param null $companyId
     * @param null $officeId
     * @param null $month
     * @param bool $count
     * @return mixed
     */
    public function employeeBirthDayPageSearch(PagedSearchParameter $parameter,
                                               $companyId = null, $officeId = null, $month = null,
                                               $count = false);

    //</editor-fold>
}

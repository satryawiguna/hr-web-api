<?php

namespace App\Domains\HumanResources\Personal\Employee\Contracts;

use App\Core\Services\Request\ListSearchRequest;
use App\Core\Services\Request\PageSearchRequest;
use App\Core\Services\Response\BasicResponse;
use App\Core\Services\Response\GenericCollectionResponse;
use App\Core\Services\Response\GenericListSearchResponse;
use App\Core\Services\Response\ObjectResponse;
use App\Core\Services\Response\GenericPageSearchResponse;
use App\Domains\Commons\MaritalStatus\Contracts\MaritalStatusRepositoryInterface;
use App\Domains\HumanResources\Personal\Employee\Child\Contracts\ChildRepositoryInterface;
use App\Domains\HumanResources\Personal\Employee\Contracts\Request\CreateEmployeeRequest;
use App\Domains\HumanResources\Personal\Employee\Contracts\Request\EditEmployeeRequest;

/**
 * Interface EmployeeServiceInterface.
 */
interface EmployeeServiceInterface
{
    //<editor-fold desc="#constructor">

    /**
     * EmployeeServiceInterface constructor.
     *
     * @param EmployeeRepositoryInterface $repository
     * @param MaritalStatusRepositoryInterface $maritalStatusRepository
     */
    public function __construct(EmployeeRepositoryInterface $repository,
                                MaritalStatusRepositoryInterface $maritalStatusRepository);

    //</editor-fold>


    //<editor-fold desc="#public (method)">

    /**
     * Create Employee.
     *
     * @param CreateEmployeeRequest $request
     * @return mixed
     */
    public function create(CreateEmployeeRequest $request);

    /**
     * Update Employee.
     *
     * @param EditEmployeeRequest $request
     * @return mixed
     */
    public function update(EditEmployeeRequest $request);

    /**
     * Delete Employee.
     *
     * @param int $id
     * @return mixed
     */
    public function delete(int $id): BasicResponse;

    /**
     * @param array $ids
     * @return mixed
     */
    public function deleteBulk(array $ids);

    /**
     * @param int $id
     * @return ObjectResponse
     */
    public function find(int $id): ObjectResponse;


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
                                 string $mateBPJSKesehatanClass = null, int $bankId = null, object $rangeJoinDate = null, string $workStatus = null, string $workType = null,  int $degreeId = null, int $majorId = null,
                                 int $competenceId = null, int $positionId = null, int $projectId = null, int $workUnitId = null): GenericCollectionResponse;

    /**
     * @param int|null $companyId
     * @param int|null $officeId
     * @param object|null $rangerTerminationDate
     * @return mixed
     */
    public function employeeTerminatedList(int $companyId = null, int $officeId = null, object $rangerTerminationDate = null): GenericCollectionResponse;

    /**
     * @param int $companyId
     * @param int $officeId
     * @param int $month
     * @return GenericCollectionResponse
     */
    public function employeeBirthDayList(int $companyId = null, int $officeId = null, int $month = null): GenericCollectionResponse;


    /**
     * @param ListSearchRequest $request
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
     * @return GenericListSearchResponse
     */
    public function employeeListSearch(ListSearchRequest $request,
                                       int $companyId = null, int $genderId = null, int $religionId = null, object $rangeBirthDate = null, object $rangeIdentityExpiredDate = null,
                                       object $rangeDriveLicenseADate = null, object $rangeDriveLicenseBDate = null, object $rangeDriveLicenseCDate = null, int $maritalStatusId = null, string $mateAs = null,
                                       object $rangeMateBirthDate = null, int $officeId = null, int $workAreaId = null, object $rangeNPWPDate = null, string $npwpStatus = null,
                                       object $rangeBPJSTenagaKerjaDate = null, string $bpjsTenagaKerjaClass = null, object $rangeBPJSKesehatanDate = null, string $bpjsKesehatanClass = null, object $rangeMateBPJSKesehatanDate = null,
                                       string $mateBPJSKesehatanClass = null, int $bankId = null, object $rangeJoinDate = null, string $workStatus = null, string $workType = null, int $degreeId = null, int $majorId = null,
                                       int $competenceId = null, int $positionId = null, int $projectId = null, int $workUnitId = null): GenericListSearchResponse;

    /**
     * @param ListSearchRequest $request
     * @param int|null $companyId
     * @param int|null $officeId
     * @param object|null $rangerTerminationDate
     * @return mixed
     */
    public function employeeTerminatedListSearch(ListSearchRequest $request,
                                                 int $companyId = null, int $officeId = null, object $rangerTerminationDate = null): GenericListSearchResponse;

    /**
     * @param ListSearchRequest $request
     * @param int $companyId
     * @param int $officeId
     * @param int $month
     * @return GenericListSearchResponse
     */
    public function employeeBirthDayListSearch(ListSearchRequest $request,
                                               int $companyId = null, int $officeId = null, int $month = null): GenericListSearchResponse;


    /**
     * @param PageSearchRequest $request
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
     * @param string $workType
     * @param int|null $degreeId
     * @param int|null $majorId
     * @param int|null $competenceId
     * @param int|null $positionId
     * @param int|null $projectId
     * @param int|null $workUnitId
     * @return GenericPageSearchResponse
     */
    public function employeePageSearch(PageSearchRequest $request,
                                       int $companyId = null, int $genderId = null, int $religionId = null, object $rangeBirthDate = null, object $rangeIdentityExpiredDate = null,
                                       object $rangeDriveLicenseADate = null, object $rangeDriveLicenseBDate = null, object $rangeDriveLicenseCDate = null, int $maritalStatusId = null, string $mateAs = null,
                                       object $rangeMateBirthDate = null, int $officeId = null, int $workAreaId = null, object $rangeNPWPDate = null, string $npwpStatus = null,
                                       object $rangeBPJSTenagaKerjaDate = null, string $bpjsTenagaKerjaClass = null, object $rangeBPJSKesehatanDate = null, string $bpjsKesehatanClass = null, object $rangeMateBPJSKesehatanDate = null,
                                       string $mateBPJSKesehatanClass = null, int $bankId = null, object $rangeJoinDate = null, string $workStatus = null, string $workType = null, int $degreeId = null, int $majorId = null,
                                       int $competenceId = null, int $positionId = null, int $projectId = null, int $workUnitId = null): GenericPageSearchResponse;

    /**
     * @param PageSearchRequest $request
     * @param int|null $companyId
     * @param int|null $officeId
     * @param object|null $rangerTerminationDate
     * @return mixed
     */
    public function employeeTerminatedPageSearch(PageSearchRequest $request,
                                                 int $companyId = null, int $officeId = null, object $rangerTerminationDate = null): GenericPageSearchResponse;

    /**
     * @param PageSearchRequest $request
     * @param int $companyId
     * @param int $officeId
     * @param int $month
     * @return GenericPageSearchResponse
     */
    public function employeeBirthDayPageSearch(PageSearchRequest $request,
                                               int $companyId = null, int $officeId = null, int $month = null): GenericPageSearchResponse;



    /**
     * @param string $path
     * @param string $input
     * @param string|null $file
     * @return ObjectResponse
     */
    /*public function uploadPhoto(string $path, string $input = 'slim', string $file = null): ObjectResponse;*/


    //</editor-fold>
}

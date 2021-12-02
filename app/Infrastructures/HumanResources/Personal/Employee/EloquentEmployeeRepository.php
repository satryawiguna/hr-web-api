<?php
namespace App\Infrastructures\HumanResources\Personal\Employee;

use App\Infrastructures\HumanResources\Personal\Employee\Contracts\EloquentEmployeeRepositoryInterface;
use App\Infrastructures\EloquentRepositoryAbstract;
use DateTime;
use Illuminate\Support\Facades\Config;

/**
 * EloquentEmployeeRepository Class.
 */
class EloquentEmployeeRepository extends EloquentRepositoryAbstract implements EloquentEmployeeRepositoryInterface
{
    /**
     * @param int $companyId
     * @return $this|mixed
     */
    public function findWhereByCompanyId(int $companyId)
    {
        $this->model = $this->model->where('company_id', $companyId);

        return $this;
    }

    /**
     * @param int $genderId
     * @return $this|mixed
     */
    public function findWhereByGenderId(int $genderId)
    {
        $this->model = $this->model->where('gender_id', $genderId);

        return $this;
    }

    /**
     * @param int $religionId
     * @return $this|mixed
     */
    public function findWhereByReligionId(int $religionId)
    {
        $this->model = $this->model->where('religion_id', $religionId);

        return $this;
    }

    /**
     * @param DateTime $startBirthDate
     * @param DateTime $endBirthDate
     * @return $this|mixed
     */
    public function findWhereBetweenByRangeBirthDate(DateTime $startBirthDate, DateTime $endBirthDate)
    {
        $this->model = $this->model->whereBetween('birth_date', [
            $startBirthDate->format(Config::get('datetime.format.default')),
            $endBirthDate->format(Config::get('datetime.format.default'))
        ]);

        return $this;
    }

    /**
     * @param DateTime $startIdentityExpiredDate
     * @param DateTime $endIdentityExpiredDate
     * @return $this|mixed
     */
    public function findWhereBetweenByRangeIdentityExpiredDate(DateTime $startIdentityExpiredDate, Datetime $endIdentityExpiredDate)
    {
        $this->model = $this->model->whereBetween('identity_expired_date', [
            $startIdentityExpiredDate->format(Config::get('datetime.format.default')),
            $endIdentityExpiredDate->format(Config::get('datetime.format.default'))
        ]);

        return $this;
    }

    /**
     * @param DateTime $startDriveLicenseADate
     * @param DateTime $endDriveLicenseADate
     * @return $this|mixed
     */
    public function findWhereBetweenByRangeDriveLicenseADate(DateTime $startDriveLicenseADate, Datetime $endDriveLicenseADate)
    {
        $this->model = $this->model->whereBetween('drive_license_a_date', [
            $startDriveLicenseADate->format(Config::get('datetime.format.default')),
            $endDriveLicenseADate->format(Config::get('datetime.format.default'))
        ]);

        return $this;
    }

    /**
     * @param DateTime $startDriveLicenseBDate
     * @param DateTime $endDriveLicenseBDate
     * @return $this|mixed
     */
    public function findWhereBetweenByRangeDriveLicenseBDate(DateTime $startDriveLicenseBDate, Datetime $endDriveLicenseBDate)
    {
        $this->model = $this->model->whereBetween('drive_license_b_date', [
            $startDriveLicenseBDate->format(Config::get('datetime.format.default')),
            $endDriveLicenseBDate->format(Config::get('datetime.format.default'))
        ]);

        return $this;
    }

    /**
     * @param DateTime $startDriveLicenseCDate
     * @param DateTime $endDriveLicenseCDate
     * @return $this|mixed
     */
    public function findWhereBetweenByRangeDriveLicenseCDate(DateTime $startDriveLicenseCDate, Datetime $endDriveLicenseCDate)
    {
        $this->model = $this->model->whereBetween('drive_license_b_date', [
            $startDriveLicenseCDate->format(Config::get('datetime.format.default')),
            $endDriveLicenseCDate->format(Config::get('datetime.format.default'))
        ]);

        return $this;
    }

    /**
     * @param int $maritalStatusId
     * @return $this|mixed
     */
    public function findWhereByMaritalStatusId(int $maritalStatusId)
    {
        $this->model = $this->model->where('marital_status_id', $maritalStatusId);

        return $this;
    }

    /**
     * @param string $mateAs
     * @return $this|mixed
     */
    public function findWhereByMateAs(string $mateAs)
    {
        $this->model = $this->model->where('mate_as', $mateAs);

        return $this;
    }

    /**
     * @param DateTime $startMateBirthDate
     * @param DateTime $endMateBirthDate
     * @return $this|mixed
     */
    public function findWhereBetweenByRangeMateBirthDate(DateTime $startMateBirthDate, Datetime $endMateBirthDate)
    {
        $this->model = $this->model->whereBetween('mate_birth_date', [
            $startMateBirthDate->format(Config::get('datetime.format.default')),
            $endMateBirthDate->format(Config::get('datetime.format.default'))
        ]);

        return $this;
    }

    /**
     * @param DateTime $startMateBPJSKesehatanDate
     * @param DateTime $endMateBPJSKesehatanDate
     * @return $this|mixed
     */
    public function findWhereBetweenByRangeMateBPJSKesehatanDate(DateTime $startMateBPJSKesehatanDate, DateTime $endMateBPJSKesehatanDate)
    {
        $this->model = $this->model->whereBetween('mate_bpjs_kesehatan_date', [
            $startMateBPJSKesehatanDate->format(Config::get('datetime.format.default')),
            $endMateBPJSKesehatanDate->format(Config::get('datetime.format.default'))
        ]);

        return $this;
    }

    /**
     * @param string $mateBPJSKesehatanClass
     * @return $this|mixed
     */
    public function findWhereByMateBPJSKesehatanClass(string $mateBPJSKesehatanClass)
    {
        $this->model = $this->model->where('mate_bpjs_kesehatan_class', $mateBPJSKesehatanClass);

        return $this;
    }

    /**
     * @param int $officeId
     * @return $this|mixed
     */
    public function findWhereByOfficeId(int $officeId)
    {
        $this->model = $this->model->where('office_id', $officeId);

        return $this;
    }

    /**
     * @param int $workAreaId
     * @return $this|mixed
     */
    public function findWhereByWorkAreaId(int $workAreaId)
    {
        $this->model = $this->model->where('work_area_id', $workAreaId);

        return $this;
    }

    /**
     * @param DateTime $startNPWPDate
     * @param DateTime $endNPWPDate
     * @return $this|mixed
     */
    public function findWhereBetweenByRangeNPWPDate(DateTime $startNPWPDate, Datetime $endNPWPDate)
    {
        $this->model = $this->model->whereBetween('npwp_date', [
            $startNPWPDate->format(Config::get('datetime.format.default')),
            $endNPWPDate->format(Config::get('datetime.format.default'))
        ]);

        return $this;
    }

    /**
     * @param string $npwpStatus
     * @return $this|mixed
     */
    public function findWhereByNPWPStatus(string $npwpStatus)
    {
        $this->model = $this->model->where('npwp_status', $npwpStatus);

        return $this;
    }

    /**
     * @param DateTime $startBPJSTenagaKerjaDate
     * @param DateTime $endBPJSTenagaKerjaDate
     * @return $this|mixed
     */
    public function findWhereBetweenByRangeBPJSTenagaKerjaDate(DateTime $startBPJSTenagaKerjaDate, Datetime $endBPJSTenagaKerjaDate)
    {
        $this->model = $this->model->whereBetween('bpjs_tenaga_kerja_date', [
            $startBPJSTenagaKerjaDate->format(Config::get('datetime.format.default')),
            $endBPJSTenagaKerjaDate->format(Config::get('datetime.format.default'))
        ]);

        return $this;
    }

    /**
     * @param string $bpjsTenagaKerjaClass
     * @return $this|mixed
     */
    public function findWhereByBPJSTenagaKerjaClass(string $bpjsTenagaKerjaClass)
    {
        $this->model = $this->model->where('bpjs_tenaga_kerja_class', $bpjsTenagaKerjaClass);

        return $this;
    }

    /**
     * @param DateTime $startBPJSKesehatanDate
     * @param DateTime $endBPJSKesehatanDate
     * @return $this|mixed
     */
    public function findWhereBetweenByRangeBPJSKesehatanDate(DateTime $startBPJSKesehatanDate, Datetime $endBPJSKesehatanDate)
    {
        $this->model = $this->model->whereBetween('bpjs_kesehatan_date', [
            $startBPJSKesehatanDate->format(Config::get('datetime.format.default')),
            $endBPJSKesehatanDate->format(Config::get('datetime.format.default'))
        ]);

        return $this;
    }

    /**
     * @param string $bpjsKesehatanClass
     * @return $this|mixed
     */
    public function findWhereByBPJSKesehatanClass(string $bpjsKesehatanClass)
    {
        $this->model = $this->model->where('bpjs_kesehatan_class', $bpjsKesehatanClass);

        return $this;
    }

    /**
     * @param int $bankId
     * @return $this|mixed
     */
    public function findWhereByBankId(int $bankId)
    {
        $this->model = $this->model->where('bank_id', $bankId);

        return $this;
    }

    /**
     * @param DateTime $startJoinDate
     * @param DateTime $endJoinDate
     * @return $this|mixed
     */
    public function findWhereBetweenByRangeJoinDate(DateTime $startJoinDate, DateTime $endJoinDate)
    {
        $this->model = $this->model->whereBetween('join_date', [
            $startJoinDate->format(Config::get('datetime.format.default')),
            $endJoinDate->format(Config::get('datetime.format.default'))
        ]);

        return $this;
    }

    /**
     * @param string $workStatus
     * @return $this|mixed
     */
    public function findWhereByWorkStatus(string $workStatus)
    {
        $this->model = $this->model->where('work_status', '=', $workStatus);

        return $this;
    }

    /**
     * @param string $workType
     * @return $this|mixed
     */
    public function findWhereByWorkType(string $workType)
    {
        $this->model = $this->model->where('work_type', '=', $workType);

        return $this;
    }

    /**
     * @param int $degreeId
     * @return $this
     */
    public function findHasFormalEducationHistoryByDegreeId(int $degreeId)
    {
        $this->model = $this->model->whereHas('formalEducationHistories', function($q) use($degreeId) {
            return $q->where('degree_id', '=', $degreeId);
        });

        return $this;
    }

    /**
     * @param int $majorId
     * @return $this
     */
    public function findHasFormalEducationHistoryByMajorId(int $majorId)
    {
        $this->model = $this->model->whereHas('formalEducationHistories', function($q) use($majorId) {
            return $q->where('major_id', '=', $majorId);
        });

        return $this;
    }

    /**
     * @param int $competenceId
     * @return mixed|void
     */
    public function findHasWorkCompetenceByCompetenceId(int $competenceId)
    {
        $this->model = $this->model->whereHas('workCompetences', function($q) use($competenceId) {
           return $q->where('competence_id', '=', $competenceId);
        });

        return $this;
    }

    /**
     * @param int $positionId
     * @return mixed|void
     */
    public function findHasPositionMutationByPositionId(int $positionId)
    {
        $this->model = $this->model->whereHas('positionMutations', function($q) use($positionId) {
            return $q->where('position_id', '=', $positionId);
        });

        return $this;
    }

    /**
     * @param int $projectId
     * @return mixed|void
     */
    public function findHasProjectMutationByProjectId(int $projectId)
    {
        $this->model = $this->model->whereHas('projectMutations', function($q) use($projectId) {
            return $q->where('project_id', '=', $projectId);
        });

        return $this;
    }

    /**
     * @param int $workUnitId
     * @return mixed|void
     */
    public function findHasWorkUnitMutationByWorkUnitId(int $workUnitId)
    {
        $this->model = $this->model->whereHas('workUnitMutations', function($q) use($workUnitId) {
           return $q->where('work_unit_id', '=', $workUnitId);
        });

        return $this;
    }

    /**
     * @param DateTime $startTerminationDate
     * @param DateTime $endTerminationDate
     * @return mixed|void
     */
    public function findHasTerminationByRangeTerminationDate(DateTime $startTerminationDate, DateTime $endTerminationDate)
    {
        $this->model = $this->model->whereHas('termination', function($q) use($startTerminationDate, $endTerminationDate) {
            return $q->whereBetween('termination_date', [
                $startTerminationDate->format(Config::get('datetime.format.default')),
                $endTerminationDate->format(Config::get('datetime.format.default'))
            ]);
        });

        return $this;
    }

    /**
     * @param int $month
     * @return $this|mixed
     */
    public function findWhereBirthDateByMonth(int $month)
    {
        $this->model = $this->model->whereMonth('birth_date', $month);

        return $this;
    }

    /**
     * @param string $searchQuery
     * @return $this|mixed
     */
    public function findWhereBySearchQuery(string $searchQuery)
    {
        $searchParameter = [
            'nip' => '%' . $searchQuery . '%',
            'full_name' => '%' . $searchQuery . '%',
            'nick_name' => '%' . $searchQuery . '%',
            'birth_place' => '%' . $searchQuery . '%',
            'address' => '%' . $searchQuery . '%',
            'phone' => '%' . $searchQuery . '%',
            'mobile' => '%' . $searchQuery . '%',
            'email' => '%' . $searchQuery . '%',
            'identity_number' => '%' . $searchQuery . '%',
            'identity_address' => '%' . $searchQuery . '%',
            'drive_license_a_number' => '%' . $searchQuery . '%',
            'drive_license_b_number' => '%' . $searchQuery . '%',
            'drive_license_c_number' => '%' . $searchQuery . '%',
            'npwp_number' => '%' . $searchQuery . '%',
            'bpjs_tenaga_kerja_number' => '%' . $searchQuery . '%',
            'bpjs_kesehatan_number' => '%' . $searchQuery . '%',
            'mate_bpjs_kesehatan_number' => '%' . $searchQuery . '%',
            'mate_dplk_number' => '%' . $searchQuery . '%',
            'mate_collective_number' => '%' . $searchQuery . '%',
            'mate_account_number' => '%' . $searchQuery . '%'
        ];

        $this->model = $this->model->whereRaw('(nip LIKE ?
            OR full_name LIKE ?
            OR nick_name LIKE ?
            OR birth_place LIKE ?
            OR address LIKE ?
            OR phone LIKE ?
            OR mobile LIKE ?
            OR email LIKE ?
            OR identity_number LIKE ?
            OR identity_address LIKE ?
            OR drive_license_a_number LIKE ?
            OR drive_license_b_number LIKE ?
            OR drive_license_c_number LIKE ?
            OR npwp_number LIKE ?
            OR bpjs_tenaga_kerja_number LIKE ?
            OR bpjs_kesehatan_number LIKE ?
            OR mate_bpjs_kesehatan_number LIKE ?
            OR dplk_number LIKE ?
            OR collective_number LIKE ?
            OR account_number LIKE ?)', $searchParameter);

        return $this;
    }
}

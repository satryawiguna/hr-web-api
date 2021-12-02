<?php
namespace App\Infrastructures\Vacancy;

use App\Infrastructures\Vacancy\Contracts\EloquentVacancyRepositoryInterface;
use App\Infrastructures\EloquentRepositoryAbstract;
use DateTime;
use Illuminate\Support\Facades\Config;

/**
 * EloquentVacancyRepository Class.
 */
class EloquentVacancyRepository extends EloquentRepositoryAbstract implements EloquentVacancyRepositoryInterface
{
    //<editor-fold desc="#public (method)">

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
     * @param int $positionId
     * @return $this|mixed
     */
    public function findWhereByPositionId(int $positionId)
    {
        $this->model = $this->model->where('position_id', $positionId);

        return $this;
    }

    /**
     * @param int $degreeId
     * @return $this|mixed
     */
    public function findWhereByDegreeId(int $degreeId)
    {
        $this->model = $this->model->where('degree_id', $degreeId);

        return $this;
    }

    /**
     * @param int $status
     * @return $this|mixed
     */
    public function findWhereByStatus(int $status)
    {
        $this->model = $this->model->where('status', $status);

        return $this;
    }

    /**
     * @param DateTime $startPublishDate
     * @param DateTime $endPublishDate
     * @return $this|mixed
     */
    public function findWhereBetweenByRangePublishDate(DateTime $startPublishDate, DateTime $endPublishDate)
    {
        $this->model = $this->model->whereBetween('publish_date', [
            $startPublishDate->format(Config::get('datetime.format.default')),
            $endPublishDate->format(Config::get('datetime.format.default'))
        ]);

        return $this;
    }

    /**
     * @param DateTime $startExpiredDate
     * @param DateTime $endExpiredDate
     * @return $this|mixed
     */
    public function findWhereBetweenByRangeExpiredDate(DateTime $startExpiredDate, DateTime $endExpiredDate)
    {
        $this->model = $this->model->whereBetween('expired_date', [
            $startExpiredDate->format(Config::get('datetime.format.default')),
            $endExpiredDate->format(Config::get('datetime.format.default'))
        ]);

        return $this;
    }

    /**
     * @param int $startSalary
     * @param int $endSalary
     * @return $this|mixed
     */
    public function findWhereBetweenByRangeSalary(int $startSalary, int $endSalary)
    {
        $this->model = $this->model->where('start_salary', ">=", $startSalary)->where('end_salary', "<=", $endSalary);

        return $this;
    }

    /**
     * @param string $workStatus
     * @return $this|mixed
     */
    public function findWhereByWorkStatus(string $workStatus)
    {
        $this->model = $this->model->where('work_status', $workStatus);

        return $this;
    }

    /**
     * @param string $searchQuery
     * @return $this|mixed
     */
    public function findWhereBySearchQuery(string $searchQuery)
    {
        $this->model = $this->model->where('title', 'LIKE', '%' . $searchQuery . '%')
            ->orwhere('intro', 'LIKE', '%' . $searchQuery . '%')
            ->orWhere('description', 'LIKE', '%' . $searchQuery . '%')
            ->orWhere('responsibility', 'LIKE', '%' . $searchQuery . '%')
            ->orWhere('requirement', 'LIKE', '%' . $searchQuery . '%')
            ->orWhere('career', 'LIKE', '%' . $searchQuery . '%')
            ->orWhere('facility_and_allowance', 'LIKE', '%' . $searchQuery . '%')
            ->orWhere('expertise', 'LIKE', '%' . $searchQuery . '%')
            ->orWhere('placement', 'LIKE', '%' . $searchQuery . '%')
            ->orWhere('language', 'LIKE', '%' . $searchQuery . '%')
            ->orWhere('apperance', 'LIKE', '%' . $searchQuery . '%');

        return $this;
    }

    //</editor-fold>
}

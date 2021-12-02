<?php
namespace App\Infrastructures\HumanResources\Vacancy;

use App\Infrastructures\HumanResources\Vacancy\Contracts\EloquentVacancyRepositoryInterface;
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
     * @param int $vacancyLocationId
     * @return $this|mixed
     */
    public function findWhereByVacancyLocationId(int $vacancyLocationId)
    {
        $this->model = $this->model->where('vacancy_location_id', $vacancyLocationId);

        return $this;
    }

    /**
     * @param int $vacancyCategoryId
     * @return $this|mixed
     */
    public function findWhereByVacancyCategoryId(int $vacancyCategoryId)
    {
        $this->model = $this->model->where('vacancy_category_id', $vacancyCategoryId);

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
     * @param string $workStatus
     * @return $this|mixed
     */
    public function findWhereByWorkStatus(string $workStatus)
    {
        $this->model = $this->model->where('work_status', $workStatus);

        return $this;
    }

    /**
     * @param string $workType
     * @return $this|mixed
     */
    public function findWhereByWorkType(string $workType)
    {
        $this->model = $this->model->where('work_type', $workType);

        return $this;
    }

    /**
     * @param string $status
     * @return $this|mixed
     */
    public function findWhereByStatus(string $status)
    {
        $this->model = $this->model->where('status', $status);

        return $this;
    }

    /**
     * @param string $searchQuery
     * @return $this|mixed
     */
    public function findWhereBySearchQuery(string $searchQuery)
    {
        $this->model = $this->model->where('title', 'LIKE', '%' . $searchQuery . '%')
            ->orwhere('reference_code', 'LIKE', '%' . $searchQuery . '%')
            ->orwhere('intro', 'LIKE', '%' . $searchQuery . '%')
            ->orWhere('description', 'LIKE', '%' . $searchQuery . '%')
            ->orWhere('requirement', 'LIKE', '%' . $searchQuery . '%');

        return $this;
    }

    //</editor-fold>
}

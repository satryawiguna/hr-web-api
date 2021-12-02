<?php
namespace App\Infrastructures\HumanResources\Recruitment\RecruitmentSchedule;

use App\Infrastructures\HumanResources\Recruitment\RecruitmentSchedule\Contracts\EloquentRecruitmentScheduleRepositoryInterface;
use App\Infrastructures\EloquentRepositoryAbstract;
use DateTime;
use Illuminate\Support\Facades\Config;

/**
 * EloquentRecruitmentScheduleRepository Class.
 */
class EloquentRecruitmentScheduleRepository extends EloquentRepositoryAbstract implements EloquentRecruitmentScheduleRepositoryInterface
{
    //<editor-fold desc="#public (method)">

    /**
     * @param int $vacancyApplicationId
     * @return $this|mixed
     */
    public function findWhereByVacancyApplicationId(int $vacancyApplicationId)
    {
        $this->model = $this->model->where('vacancy_application_id', $vacancyApplicationId);

        return $this;
    }

    /**
     * @param DateTime $startScheduleDate
     * @param DateTime $endScheduleDate
     * @return $this|mixed
     */
    public function findWhereBetweenByRangeScheduleDate(DateTime $startScheduleDate, DateTime $endScheduleDate)
    {
        $this->model = $this->model->whereBetween('schedule_date', [
            $startScheduleDate->format(Config::get('datetime.format.default')),
            $endScheduleDate->format(Config::get('datetime.format.default'))
        ]);

        return $this;
    }

    /**
     * @param string $searchQuery
     * @return $this|mixed
     */
    public function findWhereBySearchQuery(string $searchQuery)
    {
        return $this;
    }

    //</editor-fold>
}

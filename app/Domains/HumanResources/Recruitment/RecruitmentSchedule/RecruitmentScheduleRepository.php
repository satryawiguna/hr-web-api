<?php

namespace App\Domains\HumanResources\Recruitment\RecruitmentSchedule;

use App\Core\Domains\Contracts\Pagination\ListedSearchParameter;
use App\Core\Domains\Contracts\Pagination\PagedSearchParameter;
use App\Domains\HumanResources\Recruitment\RecruitmentSchedule\Contracts\RecruitmentScheduleRepositoryInterface;
use App\Infrastructures\HumanResources\Recruitment\RecruitmentSchedule\Contracts\EloquentRecruitmentScheduleRepositoryInterface;
use App\Domains\HumanResources\Recruitment\RecruitmentSchedule\Contracts\RecruitmentScheduleInterface;
use App\Domains\RepositoryAbstract;
use App\Domains\Contracts\BaseEntityInterface;
use Closure;

/**
 * Class RecruitmentScheduleRepository.
 */
class RecruitmentScheduleRepository extends RepositoryAbstract implements RecruitmentScheduleRepositoryInterface
{
    //<editor-fold desc="#constructor">

    /**
     * RecruitmentScheduleRepository constructor.
     *
     * @param EloquentRecruitmentScheduleRepositoryInterface $eloquent
     */
    public function __construct(EloquentRecruitmentScheduleRepositoryInterface $eloquent)
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
    public function setupPayload(RecruitmentScheduleInterface $RecruitmentSchedule)
    {
        return [
            'vacancy_application_id' => $RecruitmentSchedule->getVacancyApplicationId(),
            'schedule_date' => $RecruitmentSchedule->getScheduleDate()
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function create(RecruitmentScheduleInterface $RecruitmentSchedule)
    {
        $data = $this->setupPayload($RecruitmentSchedule);

        return $this->eloquent()->create($data);
    }

    /**
     * {@inheritdoc}
     */
    public function update(RecruitmentScheduleInterface $RecruitmentSchedule)
    {
        $data = $this->setupPayload($RecruitmentSchedule);

        return $this->eloquent()->update($data, $RecruitmentSchedule->getKey());
    }

    /**
     * {@inheritdoc}
     */
    public function delete(RecruitmentScheduleInterface $RecruitmentSchedule)
    {
        return $this->eloquent()->delete($RecruitmentSchedule->getKey());
    }

    /**
     * @param int|null $vacancyApplicationId
     * @param object|null $rangeScheduleDate
     * @return mixed
     */
    public function recruitmentScheduleList(int $vacancyApplicationId = null, object $rangeScheduleDate = null)
    {
        if (!is_null($vacancyApplicationId)) {
            $this->eloquent->findWhereByVacancyApplicationId($vacancyApplicationId);
        }

        if ($rangeScheduleDate != null &&
            property_exists($rangeScheduleDate, 'start') &&
            property_exists($rangeScheduleDate, 'end')) {
            if(!is_null($rangeScheduleDate->start) && !is_null($rangeScheduleDate->end)){
                $this->eloquent->findWhereBetweenByRangeScheduleDate($rangeScheduleDate->start, $rangeScheduleDate->end);
            }
        }

        return $this->eloquent->all();
    }

    /**
     * @param ListedSearchParameter $parameter
     * @param int|null $vacancyApplicationId
     * @param object|null $rangeScheduleDate
     * @param bool $count
     * @return mixed
     */
    public function recruitmentScheduleListSearch(ListedSearchParameter $parameter, int $vacancyApplicationId = null, object $rangeScheduleDate = null, bool $count = false)
    {
        $searchQuery = $parameter->query;

        if ($searchQuery) {
            $this->eloquent->findWhereBySearchQuery($searchQuery);
        }

        if (!is_null($vacancyApplicationId)) {
            $this->eloquent->findWhereByVacancyApplicationId($vacancyApplicationId);
        }

        if ($rangeScheduleDate != null &&
            property_exists($rangeScheduleDate, 'start') &&
            property_exists($rangeScheduleDate, 'end')) {
            if(!is_null($rangeScheduleDate->start) && !is_null($rangeScheduleDate->end)){
                $this->eloquent->findWhereBetweenByRangeScheduleDate($rangeScheduleDate->start, $rangeScheduleDate->end);
            }
        }

        if (!$count) {
            return $this->eloquent->with(['vacancyApplication'])
                ->all();
        } else {
            return $this->eloquent->all()->count();
        }
    }

    /**
     * @param PagedSearchParameter $parameter
     * @param int|null $vacancyApplicationId
     * @param object|null $rangeScheduleDate
     * @param bool $count
     * @return mixed
     */
    public function recruitmentSchedulePageSearch(PagedSearchParameter $parameter, int $vacancyApplicationId = null, object $rangeScheduleDate = null, bool $count = false)
    {
        if (!is_null($vacancyApplicationId)) {
            $this->eloquent->findWhereByVacancyApplicationId($vacancyApplicationId);
        }

        if ($rangeScheduleDate != null &&
            property_exists($rangeScheduleDate, 'start') &&
            property_exists($rangeScheduleDate, 'end')) {
            if(!is_null($rangeScheduleDate->start) && !is_null($rangeScheduleDate->end)){
                $this->eloquent->findWhereBetweenByRangeScheduleDate($rangeScheduleDate->start, $rangeScheduleDate->end);
            }
        }

        $searchQuery = !is_null($parameter->search) ? $parameter->search['value'] : $parameter->query['value'] ?? null;

        if ($searchQuery) {
            $this->eloquent->findWhereBySearchQuery($searchQuery);
        }

        if (!$count) {
            if ($parameter->draw) {
                return $this->eloquent->with(['vacancyApplication'])
                    ->orderBy($parameter->columns[$parameter->order[0]['column']]['data'], $parameter->order[0]['dir'])
                    ->paginate($parameter->length, $parameter->start);
            } else {
                return $this->eloquent->with(['vacancyApplication'])
                    ->orderBy($parameter->sort['field'], $parameter->sort['sort'])
                    ->paginate($parameter->pagination['perpage'], ($parameter->pagination['perpage'] * ($parameter->pagination['page'] - 1)));
            }
        } else {
            return $this->eloquent->all()->count();
        }

    }

    //</editor-fold>
}

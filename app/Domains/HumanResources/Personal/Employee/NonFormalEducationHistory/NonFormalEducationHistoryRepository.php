<?php

namespace App\Domains\HumanResources\Personal\Employee\NonFormalEducationHistory;

use App\Core\Domains\Contracts\Pagination\ListedSearchParameter;
use App\Core\Domains\Contracts\Pagination\PagedSearchParameter;
use App\Domains\HumanResources\Personal\Employee\NonFormalEducationHistory\Contracts\NonFormalEducationHistoryRepositoryInterface;
use App\Infrastructures\NonFormalEducationHistory\Contracts\EloquentNonFormalEducationHistoryRepositoryInterface;
use App\Domains\HumanResources\Personal\Employee\NonFormalEducationHistory\Contracts\NonFormalEducationHistoryInterface;
use App\Domains\RepositoryAbstract;
use App\Domains\Contracts\BaseEntityInterface;
use Closure;
use DateTime;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Config;

/**
 * Class NonFormalEducationHistoryRepository.
 */
class NonFormalEducationHistoryRepository extends RepositoryAbstract implements NonFormalEducationHistoryRepositoryInterface
{
    //<editor-fold desc="#constructor">

    /**
     * NonFormalEducationHistoryRepository constructor.
     *
     * @param EloquentNonFormalEducationHistoryRepositoryInterface $eloquent
     */
    public function __construct(EloquentNonFormalEducationHistoryRepositoryInterface $eloquent)
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
    public function setupPayload(NonFormalEducationHistoryInterface $NonFormalEducationHistory)
    {
        return [
            'employee_id' => $NonFormalEducationHistory->getEmployeeId(),
            'type' => $NonFormalEducationHistory->getType(),
            'name' => $NonFormalEducationHistory->getName(),
            'start_date' => (!is_null($NonFormalEducationHistory->getStartDate())) ? $NonFormalEducationHistory->getStartDate()->format(Config::get('datetime.format.default')) : null,
            'end_date' => (!is_null($NonFormalEducationHistory->getEndDate())) ? $NonFormalEducationHistory->getEndDate()->format(Config::get('datetime.format.default')) : null,
            'institution' => $NonFormalEducationHistory->getInstitution(),
            'created_by' => $NonFormalEducationHistory->getCreatedBy(),
            'modified_by' => $NonFormalEducationHistory->getModifiedBy(),
            
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function create(NonFormalEducationHistoryInterface $NonFormalEducationHistory)
    {
        $data = $this->setupPayload($NonFormalEducationHistory);

        return $this->eloquent()->create($data);
    }

    /**
     * @param Collection $NonFormalEducationHistories
     * @return mixed
     */
    public function insert(Collection $NonFormalEducationHistories)
    {
        return $this->eloquent()->insert($NonFormalEducationHistories->toArray());
    }

    /**
     * {@inheritdoc}
     */
    public function update(NonFormalEducationHistoryInterface $NonFormalEducationHistory)
    {
        $data = $this->setupPayload($NonFormalEducationHistory);
       
        return $this->eloquent()->update($data, $NonFormalEducationHistory->getKey());
    }

    /**
     * @param NonFormalEducationHistoryInterface $NonFormalEducationHistory
     * @param array $params
     * @return mixed
     */
    public function updateOrCreate(NonFormalEducationHistoryInterface $NonFormalEducationHistory, array $params)
    {
        $data = $this->setupPayload($NonFormalEducationHistory);

        return $this->eloquent()->updateOrCreate($data, $params);
    }

    /**
     * {@inheritdoc}
     */
    public function delete(NonFormalEducationHistoryInterface $NonFormalEducationHistory)
    {
        return $this->eloquent()->delete($NonFormalEducationHistory->getKey());
    }

    /**
     * @param array $ids
     * @return mixed
     */
    public function deleteBulk(array $ids)
    {
        return $this->eloquent()->delete($ids);
    }

    /**
     * @param int|null $companyId
     * @param int|null $employeeId
     * @param DateTime|null $date
     * @return mixed
     */
    public function nonFormalEducationHistoryList(int $companyId = null, int $employeeId = null, DateTime $date = null)
    {
        if ($companyId != null) {
            $this->eloquent->findWhereByCompanyId($companyId);
        }

        if ($employeeId != null) {
            $this->eloquent->findWhereByEmployeeId($employeeId);
        }

        // start and end date
        if ($date != null) {
            $this->eloquent->findWhereDateByDate($date);
        }

        return $this->eloquent->with(['employee' => function($query) {
            return $query->with(['company']);
        }])
            ->all();
    }

    /**
     * @param ListedSearchParameter $parameter
     * @param int|null $companyId
     * @param int $employeeId
     * @param DateTime $date
     * @param bool $count
     * @return mixed
     */
    public function nonFormalEducationHistoryListSearch(ListedSearchParameter $parameter, int $companyId = null, int $employeeId = null, DateTime $date = null, bool $count = false)
    {
        $searchQuery = $parameter->query;

        if ($searchQuery) {
            $this->eloquent->findWhereBySearchQuery($searchQuery);
        }

        if ($companyId != null) {
            $this->eloquent->findWhereByCompanyId($companyId);
        }

        if ($employeeId != null) {
            $this->eloquent->findWhereByEmployeeId($employeeId);
        }

        // start and end date
        if ($date != null) {
            $this->eloquent->findWhereDateByDate($date);
        }

        if (!$count) {
            return $this->eloquent->with(['employee' => function($query) {
                return $query->with(['company']);
            }])
                ->all();
        } else {
            return $this->eloquent->all()->count();
        }
    }

    /**
     * @param PagedSearchParameter $parameter
     * @param int|null $companyId
     * @param int $employeeId
     * @param DateTime $date
     * @param bool $count
     * @return mixed
     */
    public function nonFormalEducationHistoryPageSearch(PagedSearchParameter $parameter, int $companyId = null, int $employeeId = null, DateTime $date = null, bool $count = false)
    {
        if ($companyId != null) {
            $this->eloquent->findWhereByCompanyId($companyId);
        }

        if ($employeeId != null) {
            $this->eloquent->findWhereByEmployeeId($employeeId);
        }

        // start and end date
        if ($date != null) {
            $this->eloquent->findWhereDateByDate($date);
        }

        $searchQuery = !is_null($parameter->search) ? $parameter->search['value'] : $parameter->query['value'] ?? null;

        if ($searchQuery) {
            $this->eloquent->findWhereBySearchQuery($searchQuery);
        }

        if (!$count) {
            if ($parameter->draw) {
                return $this->eloquent->with(['employee' => function($query) {
                    return $query->with(['company']);
                }])
                    ->orderBy($parameter->columns[$parameter->order[0]['column']]['data'], $parameter->order[0]['dir'])
                    ->paginate($parameter->length, $parameter->start);
            } else {
                return $this->eloquent->with(['employee' => function($query) {
                    return $query->with(['company']);
                }])
                    ->orderBy($parameter->sort['field'], $parameter->sort['sort'])
                    ->paginate($parameter->pagination['perpage'], ($parameter->pagination['perpage'] * ($parameter->pagination['page'] - 1)));
            }
        } else {
            return $this->eloquent->all()->count();
        }

    }

    //</editor-fold>
}

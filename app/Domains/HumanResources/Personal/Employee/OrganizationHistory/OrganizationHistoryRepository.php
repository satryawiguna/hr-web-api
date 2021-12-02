<?php

namespace App\Domains\HumanResources\Personal\Employee\OrganizationHistory;

use App\Core\Domains\Contracts\Pagination\ListedSearchParameter;
use App\Core\Domains\Contracts\Pagination\PagedSearchParameter;
use App\Domains\HumanResources\Personal\Employee\OrganizationHistory\Contracts\OrganizationHistoryRepositoryInterface;
use App\Infrastructures\HumanResources\Personal\Employee\OrganizationHistory\Contracts\EloquentOrganizationHistoryRepositoryInterface;
use App\Domains\HumanResources\Personal\Employee\OrganizationHistory\Contracts\OrganizationHistoryInterface;
use App\Domains\RepositoryAbstract;
use App\Domains\Contracts\BaseEntityInterface;
use Closure;
use DateTime;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Config;

/**
 * Class OrganizationHistoryRepository.
 */
class OrganizationHistoryRepository extends RepositoryAbstract implements OrganizationHistoryRepositoryInterface
{
    //<editor-fold desc="#constructor">

    /**
     * OrganizationHistoryRepository constructor.
     *
     * @param EloquentOrganizationHistoryRepositoryInterface $eloquent
     */
    public function __construct(EloquentOrganizationHistoryRepositoryInterface $eloquent)
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
    public function setupPayload(OrganizationHistoryInterface $OrganizationHistory)
    {
        return [
            'employee_id' => $OrganizationHistory->getEmployeeId(),
            'name' => $OrganizationHistory->getName(),
            'start_date' => (!is_null($OrganizationHistory->getStartDate())) ? $OrganizationHistory->getStartDate()->format(Config::get('datetime.format.default')) : null,
            'end_date' => (!is_null($OrganizationHistory->getEndDate())) ? $OrganizationHistory->getEndDate()->format(Config::get('datetime.format.default')) : null,
            'activity' => $OrganizationHistory->getActivity(),
            'created_by' => $OrganizationHistory->getCreatedBy(),
            'modified_by' => $OrganizationHistory->getModifiedBy(),
            
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function create(OrganizationHistoryInterface $OrganizationHistory)
    {
        $data = $this->setupPayload($OrganizationHistory);

        return $this->eloquent()->create($data);
    }

    /**
     * @param Collection $OrganizationHistories
     * @return mixed
     */
    public function insert(Collection $OrganizationHistories)
    {
        return $this->eloquent()->insert($OrganizationHistories->toArray());
    }

    /**
     * {@inheritdoc}
     */
    public function update(OrganizationHistoryInterface $OrganizationHistory)
    {
        $data = $this->setupPayload($OrganizationHistory);
       
        return $this->eloquent()->update($data, $OrganizationHistory->getKey());
    }

    /**
     * @param OrganizationHistoryInterface $OrganizationHistory
     * @param array $params
     * @return mixed
     */
    public function updateOrCreate(OrganizationHistoryInterface $OrganizationHistory, array $params)
    {
        $data = $this->setupPayload($OrganizationHistory);

        return $this->eloquent()->updateOrCreate($data, $params);
    }

    /**
     * {@inheritdoc}
     */
    public function delete(OrganizationHistoryInterface $OrganizationHistory)
    {
        return $this->eloquent()->delete($OrganizationHistory->getKey());
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
    public function organizationHistoryList(int $companyId = null, int $employeeId = null, DateTime $date = null)
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
     * @param int|null $employeeId
     * @param DateTime|null $date
     * @param bool $count
     * @return mixed
     */
    public function organizationHistoryListSearch(ListedSearchParameter $parameter, int $companyId = null, int $employeeId = null, DateTime $date = null, bool $count = false)
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
     * @param int|null $employeeId
     * @param DateTime|null $date
     * @param bool $count
     * @return mixed
     */
    public function organizationHistoryPageSearch(PagedSearchParameter $parameter, int $companyId = null, int $employeeId = null, DateTime $date = null, bool $count = false)
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

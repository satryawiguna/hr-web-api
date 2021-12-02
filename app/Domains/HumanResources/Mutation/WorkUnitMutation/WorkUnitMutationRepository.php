<?php

namespace App\Domains\HumanResources\Mutation\WorkUnitMutation;

use App\Core\Domains\Contracts\Pagination\ListedSearchParameter;
use App\Core\Domains\Contracts\Pagination\PagedSearchParameter;
use App\Domains\HumanResources\Mutation\WorkUnitMutation\Contracts\WorkUnitMutationRepositoryInterface;
use App\Infrastructures\HumanResources\Mutation\WorkUnitMutation\Contracts\EloquentWorkUnitMutationRepositoryInterface;
use App\Domains\HumanResources\Mutation\WorkUnitMutation\Contracts\WorkUnitMutationInterface;
use App\Domains\RepositoryAbstract;
use App\Domains\Contracts\BaseEntityInterface;
use Closure;
use Illuminate\Support\Facades\Config;

/**
 * Class WorkUnitMutationRepository.
 */
class WorkUnitMutationRepository extends RepositoryAbstract implements WorkUnitMutationRepositoryInterface
{
    //<editor-fold desc="#constructor">

    /**
     * WorkUnitMutationRepository constructor.
     *
     * @param EloquentWorkUnitMutationRepositoryInterface $eloquent
     */
    public function __construct(EloquentWorkUnitMutationRepositoryInterface $eloquent)
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
    public function setupPayload(WorkUnitMutationInterface $WorkUnitMutation)
    {
        return [
            'employee_id' => $WorkUnitMutation->getEmployeeId(),
            'work_unit_id' => $WorkUnitMutation->getWorkUnitId(),
            'mutation_date' => (!is_null($WorkUnitMutation->getMutationDate())) ? $WorkUnitMutation->getMutationDate()->format(Config::get('datetime.format.default')) : null,
            'note' => $WorkUnitMutation->getNote(),
            'created_by' => $WorkUnitMutation->getCreatedBy(),
            'modified_by' => $WorkUnitMutation->getModifiedBy(),
            
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function create(WorkUnitMutationInterface $WorkUnitMutation)
    {
        $data = $this->setupPayload($WorkUnitMutation);

        return $this->eloquent()->create($data);
    }

    /**
     * {@inheritdoc}
     */
    public function update(WorkUnitMutationInterface $WorkUnitMutation)
    {
        $data = $this->setupPayload($WorkUnitMutation);
       
        return $this->eloquent()->update($data, $WorkUnitMutation->getKey());
    }

    /**
     * @param int|null $employeeId
     * @param int|null $workUnitId
     * @param object|null $rangeMutationDate
     * @return mixed
     */
    public function workUnitMutationList(int $employeeId = null, int $workUnitId = null, object $rangeMutationDate = null)
    {
        if (!is_null($employeeId)) {
            $this->eloquent->findWhereByEmployeeId($employeeId);
        }

        if (!is_null($workUnitId)) {
            $this->eloquent->findWhereByWorkUnitId($workUnitId);
        }

        if (!is_null($rangeMutationDate->start) &&
            !is_null($rangeMutationDate->end)) {
            $this->eloquent->findWhereBetweenByRangeMutationDate($rangeMutationDate->start, $rangeMutationDate->end);
        }

        return $this->eloquent->with(['employee', 'workUnit'])->all();
    }

    /**
     * @param ListedSearchParameter $parameter
     * @param int|null $employeeId
     * @param int|null $workUnitId
     * @param object|null $rangeMutationDate
     * @param bool $count
     * @return mixed
     */
    public function workUnitMutationListSearch(ListedSearchParameter $parameter, int $employeeId = null, int $workUnitId = null, object $rangeMutationDate = null, bool $count = false)
    {
        $searchQuery = $parameter->query;

        if ($searchQuery) {
            $this->eloquent->findWhereBySearchQuery($searchQuery);
        }

        if (!is_null($employeeId)) {
            $this->eloquent->findWhereByEmployeeId($employeeId);
        }

        if (!is_null($workUnitId)) {
            $this->eloquent->findWhereByWorkUnitId($workUnitId);
        }

        if (!is_null($rangeMutationDate->start) &&
            !is_null($rangeMutationDate->end)) {
            $this->eloquent->findWhereBetweenByRangeMutationDate($rangeMutationDate->start, $rangeMutationDate->end);
        }

        if (!$count) {
            return $this->eloquent->with(['employee', 'workUnit'])->all();
        } else {
            return $this->eloquent->all()->count();
        }
    }

    /**
     * @param PagedSearchParameter $parameter
     * @param int|null $employeeId
     * @param int|null $workUnitId
     * @param object|null $rangeMutationDate
     * @param bool $count
     * @return mixed
     */
    public function workUnitMutationPageSearch(PagedSearchParameter $parameter,int $employeeId = null, int $workUnitId = null, object $rangeMutationDate = null, bool $count = false)
    {
        if (!is_null($employeeId)) {
            $this->eloquent->findWhereByEmployeeId($employeeId);
        }

        if (!is_null($workUnitId)) {
            $this->eloquent->findWhereByWorkUnitId($workUnitId);
        }

        if (!is_null($rangeMutationDate->start) &&
            !is_null($rangeMutationDate->end)) {
            $this->eloquent->findWhereBetweenByRangeMutationDate($rangeMutationDate->start, $rangeMutationDate->end);
        }

        if (!$count) {
            if ($parameter->draw) {
                return $this->eloquent->with(['employee', 'workUnit'])
                    ->orderBy($parameter->columns[$parameter->order[0]['column']]['data'], $parameter->order[0]['dir'])
                    ->paginate($parameter->length, $parameter->start);
            } else {
                return $this->eloquent->with(['employee', 'workUnit'])
                    ->orderBy($parameter->sort['field'], $parameter->sort['sort'])
                    ->paginate($parameter->pagination['perpage'], ($parameter->pagination['perpage'] * ($parameter->pagination['page'] - 1)));
            }
        } else {
            return $this->eloquent->all()->count();
        }

    }

    //</editor-fold>
}

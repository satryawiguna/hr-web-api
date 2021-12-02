<?php

namespace App\Domains\HumanResources\Mutation\PositionMutation;

use App\Core\Domains\Contracts\Pagination\ListedSearchParameter;
use App\Core\Domains\Contracts\Pagination\PagedSearchParameter;
use App\Domains\HumanResources\Mutation\PositionMutation\Contracts\PositionMutationRepositoryInterface;
use App\Infrastructures\HumanResources\Mutation\PositionMutation\Contracts\EloquentPositionMutationRepositoryInterface;
use App\Domains\HumanResources\Mutation\PositionMutation\Contracts\PositionMutationInterface;
use App\Domains\RepositoryAbstract;
use Closure;
use Illuminate\Support\Facades\Config;

/**
 * Class PositionMutationRepository.
 */
class PositionMutationRepository extends RepositoryAbstract implements PositionMutationRepositoryInterface
{
    //<editor-fold desc="#constructor">

    /**
     * PositionMutationRepository constructor.
     *
     * @param EloquentPositionMutationRepositoryInterface $eloquent
     */
    public function __construct(EloquentPositionMutationRepositoryInterface $eloquent)
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
    public function setupPayload(PositionMutationInterface $PositionMutation)
    {
        return [
            'employee_id' => $PositionMutation->getEmployeeId(),
            'position_id' => $PositionMutation->getPositionId(),
            'grade_id' => $PositionMutation->getGradeId(),
            'mutation_date' => (!is_null($PositionMutation->getMutationDate())) ? $PositionMutation->getMutationDate()->format(Config::get('datetime.format.default')) : null,
            'note' => $PositionMutation->getNote(),
            'created_by' => $PositionMutation->getCreatedBy(),
            'modified_by' => $PositionMutation->getModifiedBy(),
            
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function create(PositionMutationInterface $PositionMutation)
    {
        $data = $this->setupPayload($PositionMutation);

        return $this->eloquent()->create($data);
    }

    /**
     * {@inheritdoc}
     */
    public function update(PositionMutationInterface $PositionMutation)
    {
        $data = $this->setupPayload($PositionMutation);
       
        return $this->eloquent()->update($data, $PositionMutation->getKey());
    }

    /**
     * @param int|null $employeeId
     * @param int|null $positionId
     * @param int|null $gradeId
     * @param object|null $rangeMutationDate
     * @return mixed
     */
    public function positionMutationList(int $employeeId = null, int $positionId = null, int $gradeId = null, object $rangeMutationDate = null)
    {
        if (!is_null($employeeId)) {
            $this->eloquent->findWhereByEmployeeId($employeeId);
        }

        if (!is_null($positionId)) {
            $this->eloquent->findWhereByPositionId($positionId);
        }

        if (!is_null($gradeId)) {
            $this->eloquent->findWhereByGradeId($gradeId);
        }

        if (!is_null($rangeMutationDate->start) &&
            !is_null($rangeMutationDate->end)) {
            $this->eloquent->findWhereBetweenByRangeMutationDate($rangeMutationDate->start, $rangeMutationDate->end);
        }

        return $this->eloquent->with(['employee' => function($query) {
            return $query->with(['company']);
        }])
            ->all();
    }

    /**
     * @param ListedSearchParameter $parameter
     * @param int|null $employeeId
     * @param int|null $positionId
     * @param int|null $gradeId
     * @param object|null $rangeMutationDate
     * @param bool $count
     * @return mixed
     */
    public function positionMutationListSearch(ListedSearchParameter $parameter, int $employeeId = null, int $positionId = null, int $gradeId = null, object $rangeMutationDate = null, bool $count = false)
    {
        $searchQuery = $parameter->query;

        if ($searchQuery) {
            $this->eloquent->findWhereBySearchQuery($searchQuery);
        }

        if (!is_null($employeeId)) {
            $this->eloquent->findWhereByEmployeeId($employeeId);
        }

        if (!is_null($positionId)) {
            $this->eloquent->findWhereByPositionId($positionId);
        }

        if (!is_null($gradeId)) {
            $this->eloquent->findWhereByGradeId($gradeId);
        }

        if (!is_null($rangeMutationDate->start) &&
            !is_null($rangeMutationDate->end)) {
            $this->eloquent->findWhereBetweenByRangeMutationDate($rangeMutationDate->start, $rangeMutationDate->end);
        }

        if (!$count) {
            return $this->eloquent->with(['employee', 'position', 'grade'])
                ->all();
        } else {
            return $this->eloquent->all()->count();
        }
    }

    /**
     * @param PagedSearchParameter $parameter
     * @param int|null $employeeId
     * @param int|null $positionId
     * @param int|null $gradeId
     * @param object|null $rangeMutationDate
     * @param bool $count
     * @return mixed
     */
    public function positionMutationPageSearch(PagedSearchParameter $parameter, int $employeeId = null, int $positionId = null, int $gradeId = null, object $rangeMutationDate = null, bool $count = false)
    {
        if (!is_null($employeeId)) {
            $this->eloquent->findWhereByEmployeeId($employeeId);
        }

        if (!is_null($positionId)) {
            $this->eloquent->findWhereByPositionId($positionId);
        }

        if (!is_null($gradeId)) {
            $this->eloquent->findWhereByGradeId($gradeId);
        }

        if (!is_null($rangeMutationDate->start) &&
            !is_null($rangeMutationDate->end)) {
            $this->eloquent->findWhereBetweenByRangeMutationDate($rangeMutationDate->start, $rangeMutationDate->end);
        }

        if (!$count) {
            if ($parameter->draw) {
                return $this->eloquent->with(['employee', 'position', 'grade'])
                    ->orderBy($parameter->columns[$parameter->order[0]['column']]['data'], $parameter->order[0]['dir'])
                    ->paginate($parameter->length, $parameter->start);
            } else {
                return $this->eloquent->with(['employee', 'position', 'grade'])
                    ->orderBy($parameter->sort['field'], $parameter->sort['sort'])
                    ->paginate($parameter->pagination['perpage'], ($parameter->pagination['perpage'] * ($parameter->pagination['page'] - 1)));
            }
        } else {
            return $this->eloquent->all()->count();
        }

    }

    /**
     * @param PagedSearchParameter $parameter
     * @param int|null $companyId
     * @param int|null $positionId
     * @param object|null $rangeMutationDate
     * @param bool $count
     * @return mixed
     */
    public function positionMutationPageSearchCompany(PagedSearchParameter $parameter, int $companyId = null, int $positionId = null, object $rangeMutationDate = null, bool $count = false)
    {
        $searchQuery = !is_null($parameter->search) ? $parameter->search['value'] : $parameter->query['value'] ?? null;

        if ($searchQuery) {
            $this->eloquent->findWhereBySearchQueryEmployee($searchQuery);
        }

        if (!is_null($companyId)) {
            $this->eloquent->findWhereByCompanyId($companyId);
        }

        if (!is_null($positionId)) {
            $this->eloquent->findWhereByPositionId($positionId);
        }

        if (!is_null($rangeMutationDate->start) &&
            !is_null($rangeMutationDate->end)) {
            $this->eloquent->findWhereBetweenByRangeMutationDate($rangeMutationDate->start, $rangeMutationDate->end);
        }

        if (!$count) {
            if ($parameter->draw) {
                return $this->eloquent->with(['employee', 'position', 'grade'])
                    ->orderBy($parameter->columns[$parameter->order[0]['column']]['data'], $parameter->order[0]['dir'])
                    ->paginate($parameter->length, $parameter->start);
            } else {
                return $this->eloquent->with(['employee', 'position', 'grade'])
                    ->orderBy($parameter->sort['field'], $parameter->sort['sort'])
                    ->paginate($parameter->pagination['perpage'], ($parameter->pagination['perpage'] * ($parameter->pagination['page'] - 1)));
            }
        } else {
            return $this->eloquent->all()->count();
        }

    }

    //</editor-fold>
}

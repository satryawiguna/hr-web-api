<?php

namespace App\Domains\HumanResources\Mutation\ProjectMutation;

use App\Core\Domains\Contracts\Pagination\ListedSearchParameter;
use App\Core\Domains\Contracts\Pagination\PagedSearchParameter;
use App\Domains\HumanResources\Mutation\ProjectMutation\Contracts\ProjectMutationRepositoryInterface;
use App\Infrastructures\HumanResources\Mutation\ProjectMutation\Contracts\EloquentProjectMutationRepositoryInterface;
use App\Domains\HumanResources\Mutation\ProjectMutation\Contracts\ProjectMutationInterface;
use App\Domains\RepositoryAbstract;
use App\Domains\Contracts\BaseEntityInterface;
use Closure;
use Illuminate\Support\Facades\Config;

/**
 * Class ProjectMutationRepository.
 */
class ProjectMutationRepository extends RepositoryAbstract implements ProjectMutationRepositoryInterface
{
    /**
     * ProjectMutationRepository constructor.
     *
     * @param EloquentProjectMutationRepositoryInterface $eloquent
     */
    public function __construct(EloquentProjectMutationRepositoryInterface $eloquent)
    {
        parent::__construct($eloquent);
    }

    /**
     * Setup payload.
     *
     * @return array
     */
    public function setupPayload(ProjectMutationInterface $ProjectMutation)
    {
        return [
            'employee_id' => $ProjectMutation->getEmployeeId(),
            'project_id' => $ProjectMutation->getProjectId(),
            'mutation_date' => (!is_null($ProjectMutation->getMutationDate())) ? $ProjectMutation->getMutationDate()->format(Config::get('datetime.format.default')) : null,
            'created_by' => $ProjectMutation->getCreatedBy(),
            'modified_by' => $ProjectMutation->getModifiedBy(),  
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function create(ProjectMutationInterface $ProjectMutation)
    {
        $data = $this->setupPayload($ProjectMutation);

        return $this->eloquent()->create($data);
    }

    /**
     * {@inheritdoc}
     */
    public function update(ProjectMutationInterface $ProjectMutation)
    {
        $data = $this->setupPayload($ProjectMutation);
       
        return $this->eloquent()->update($data, $ProjectMutation->getKey());
    }

    /**
     * @param int|null $employeeId
     * @param int|null $projectId
     * @param object|null $rangeMutationDate
     * @return mixed
     */
    public function projectMutationList(int $employeeId = null, int $projectId = null, object $rangeMutationDate = null)
    {
        if (!is_null($employeeId)) {
            $this->eloquent->findWhereByEmployeeId($employeeId);
        }

        if (!is_null($projectId)) {
            $this->eloquent->findWhereByProjectId($projectId);
        }

        if (!is_null($rangeMutationDate->start) &&
            !is_null($rangeMutationDate->end)) {
            $this->eloquent->findWhereBetweenByRangeMutationDate($rangeMutationDate->start, $rangeMutationDate->end);
        }

        return $this->eloquent->with(['employee'])->all();
    }

    /**
     * @param ListedSearchParameter $parameter
     * @param int|null $employeeId
     * @param int|null $projectId
     * @param object|null $rangeMutationDate
     * @param bool $count
     * @return mixed
     */
    public function projectMutationListSearch(ListedSearchParameter $parameter, int $employeeId = null, int $projectId = null, object $rangeMutationDate = null, bool $count = false)
    {
        $searchQuery = $parameter->query;

        if ($searchQuery) {
            $this->eloquent->findWhereBySearchQuery($searchQuery);
        }

        if (!is_null($employeeId)) {
            $this->eloquent->findWhereByEmployeeId($employeeId);
        }

        if (!is_null($projectId)) {
            $this->eloquent->findWhereByProjectId($projectId);
        }

        if (!is_null($rangeMutationDate->start) &&
            !is_null($rangeMutationDate->end)) {
            $this->eloquent->findWhereBetweenByRangeMutationDate($rangeMutationDate->start, $rangeMutationDate->end);
        }

        if (!$count) {
            return $this->eloquent->with(['employee', 'project'])->all();
        } else {
            return $this->eloquent->all()->count();
        }
    }

    /**
     * @param PagedSearchParameter $parameter
     * @param int|null $employeeId
     * @param int|null $projectId
     * @param object|null $rangeMutationDate
     * @param bool $count
     * @return mixed
     */
    public function projectMutationPageSearch(PagedSearchParameter $parameter, int $employeeId = null, int $projectId = null, object $rangeMutationDate = null, bool $count = false)
    {
        if (!is_null($employeeId)) {
            $this->eloquent->findWhereByEmployeeId($employeeId);
        }

        if (!is_null($projectId)) {
            $this->eloquent->findWhereByProjectId($projectId);
        }

        if (!is_null($rangeMutationDate->start) &&
            !is_null($rangeMutationDate->end)) {
            $this->eloquent->findWhereBetweenByRangeMutationDate($rangeMutationDate->start, $rangeMutationDate->end);
        }

        if (!$count) {
            if ($parameter->draw) {
                return $this->eloquent->with(['employee', 'project'])
                    ->orderBy($parameter->columns[$parameter->order[0]['column']]['data'], $parameter->order[0]['dir'])
                    ->paginate($parameter->length, $parameter->start);
            } else {
                return $this->eloquent->with(['employee', 'project'])
                    ->orderBy($parameter->sort['field'], $parameter->sort['sort'])
                    ->paginate($parameter->pagination['perpage'], ($parameter->pagination['perpage'] * ($parameter->pagination['page'] - 1)));
            }
        } else {
            return $this->eloquent->all()->count();
        }

    }
}

<?php

namespace App\Domains\HumanResources\Personal\Employee\WorkCompetence;

use App\Core\Domains\Contracts\Pagination\ListedSearchParameter;
use App\Core\Domains\Contracts\Pagination\PagedSearchParameter;
use App\Domains\HumanResources\Personal\Employee\WorkCompetence\Contracts\WorkCompetenceRepositoryInterface;
use App\Infrastructures\HumanResources\Personal\Employee\WorkCompetence\Contracts\EloquentWorkCompetenceRepositoryInterface;
use App\Domains\HumanResources\Personal\Employee\WorkCompetence\Contracts\WorkCompetenceInterface;
use App\Domains\RepositoryAbstract;
use App\Domains\Contracts\BaseEntityInterface;
use Closure;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Config;

/**
 * Class WorkCompetenceRepository.
 */
class WorkCompetenceRepository extends RepositoryAbstract implements WorkCompetenceRepositoryInterface
{
    //<editor-fold desc="#constructor">

    /**
     * WorkCompetenceRepository constructor.
     *
     * @param EloquentWorkCompetenceRepositoryInterface $eloquent
     */
    public function __construct(EloquentWorkCompetenceRepositoryInterface $eloquent)
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
    public function setupPayload(WorkCompetenceInterface $WorkCompetence)
    {
        return [
            'employee_id' => $WorkCompetence->getEmployeeId(),
            'competence_id' => $WorkCompetence->getCompetenceId(),
            'reference_number' => $WorkCompetence->getReferenceNumber(),
            'issue_date' => (!is_null($WorkCompetence->getIssueDate())) ? $WorkCompetence->getIssueDate()->format(Config::get('datetime.format.default')) : null,
            'validity' => $WorkCompetence->getValidity(),
            'created_by' => $WorkCompetence->getCreatedBy(),
            'modified_by' => $WorkCompetence->getModifiedBy(),
            
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function create(WorkCompetenceInterface $WorkCompetence)
    {
        $data = $this->setupPayload($WorkCompetence);

        return $this->eloquent()->create($data);
    }

    /**
     * @param Collection $WorkCompetences
     * @return mixed
     */
    public function insert(Collection $WorkCompetences)
    {
        return $this->eloquent()->insert($WorkCompetences->toArray());
    }

    /**
     * {@inheritdoc}
     */
    public function update(WorkCompetenceInterface $WorkCompetence)
    {
        $data = $this->setupPayload($WorkCompetence);
       
        return $this->eloquent()->update($data, $WorkCompetence->getKey());
    }

    /**
     * @param WorkCompetenceInterface $WorkCompetence
     * @param array $params
     * @return mixed
     */
    public function updateOrCreate(WorkCompetenceInterface $WorkCompetence, array $params)
    {
        $data = $this->setupPayload($WorkCompetence);

        return $this->eloquent()->updateOrCreate($data, $params);
    }

    /**
     * {@inheritdoc}
     */
    public function delete(WorkCompetenceInterface $WorkCompetence)
    {
        return $this->eloquent()->delete($WorkCompetence->getKey());
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
     * @param int|null $competenceId
     * @param object|null $rangeIssueDate
     * @return mixed
     */
    public function workCompetenceList(int $companyId = null, int $employeeId = null, int $competenceId = null, object $rangeIssueDate = null)
    {
        if (!is_null($companyId)) {
            $this->eloquent->findWhereByCompanyId($companyId);
        }

        if (!is_null($employeeId)) {
            $this->eloquent->findWhereByEmployeeId($employeeId);
        }

        if (!is_null($competenceId)) {
            $this->eloquent->findWhereByCompetenceId($competenceId);
        }

        if (!is_null($rangeIssueDate->start) &&
            !is_null($rangeIssueDate->end)) {
            $this->eloquent->findWhereBetweenByRangeIssueDate($rangeIssueDate->start, $rangeIssueDate->end);
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
     * @param int|null $competenceId
     * @param object|null $rangeIssueDate
     * @param bool $count
     * @return mixed
     */
    public function workCompetenceListSearch(ListedSearchParameter $parameter, int $companyId = null, int $employeeId = null, int $competenceId = null, object $rangeIssueDate = null, bool $count = false)
    {
        $searchQuery = $parameter->query;

        if ($searchQuery) {
            $this->eloquent->findWhereBySearchQuery($searchQuery);
        }

        if (!is_null($companyId)) {
            $this->eloquent->findWhereByCompanyId($companyId);
        }

        if (!is_null($employeeId)) {
            $this->eloquent->findWhereByEmployeeId($employeeId);
        }

        if (!is_null($competenceId)) {
            $this->eloquent->findWhereByCompetenceId($competenceId);
        }

        if (!is_null($rangeIssueDate->start) &&
            !is_null($rangeIssueDate->end)) {
            $this->eloquent->findWhereBetweenByRangeIssueDate($rangeIssueDate->start, $rangeIssueDate->end);
        }

        if (!$count) {
            return $this->eloquent->with(['employee' => function($query) {
                return $query->with(['company']);
            }, 'competence'])
                ->all();
        } else {
            return $this->eloquent->all()->count();
        }
    }

    /**
     * @param PagedSearchParameter $parameter
     * @param int|null $companyId
     * @param int|null $employeeId
     * @param int|null $competenceId
     * @param object|null $rangeIssueDate
     * @param bool $count
     * @return mixed
     */
    public function workCompetencePageSearch(PagedSearchParameter $parameter, int $companyId = null, int $employeeId = null, int $competenceId = null, object $rangeIssueDate = null, bool $count = false)
    {
        if (!is_null($companyId)) {
            $this->eloquent->findWhereByCompanyId($companyId);
        }

        if (!is_null($employeeId)) {
            $this->eloquent->findWhereByEmployeeId($employeeId);
        }

        if (!is_null($competenceId)) {
            $this->eloquent->findWhereByCompetenceId($competenceId);
        }

        if (!is_null($rangeIssueDate->start) &&
            !is_null($rangeIssueDate->end)) {
            $this->eloquent->findWhereBetweenByRangeIssueDate($rangeIssueDate->start, $rangeIssueDate->end);
        }

        $searchQuery = !is_null($parameter->search) ? $parameter->search['value'] : $parameter->query['value'] ?? null;

        if ($searchQuery) {
            $this->eloquent->findWhereBySearchQuery($searchQuery);
        }

        if (!$count) {
            if ($parameter->draw) {
                return $this->eloquent->with(['employee' => function($query) {
                    return $query->with(['company']);
                }, 'competence'])
                    ->orderBy($parameter->columns[$parameter->order[0]['column']]['data'], $parameter->order[0]['dir'])
                    ->paginate($parameter->length, $parameter->start);
            } else {
                return $this->eloquent->with(['employee' => function($query) {
                    return $query->with(['company']);
                }, 'competence'])
                    ->orderBy($parameter->sort['field'], $parameter->sort['sort'])
                    ->paginate($parameter->pagination['perpage'], ($parameter->pagination['perpage'] * ($parameter->pagination['page'] - 1)));
            }
        } else {
            return $this->eloquent->all()->count();
        }

    }

    //</editor-fold>
}

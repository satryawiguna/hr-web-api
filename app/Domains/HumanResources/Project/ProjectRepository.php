<?php

namespace App\Domains\HumanResources\Project;

use App\Core\Domains\Contracts\Pagination\ListedSearchParameter;
use App\Core\Domains\Contracts\Pagination\PagedSearchParameter;
use App\Domains\HumanResources\Project\Contracts\ProjectRepositoryInterface;
use App\Infrastructures\HumanResources\Project\Contracts\EloquentProjectRepositoryInterface;
use App\Domains\HumanResources\Project\Contracts\ProjectInterface;
use App\Domains\RepositoryAbstract;
use App\Domains\Contracts\BaseEntityInterface;
use Closure;
use DateTime;
use Illuminate\Support\Facades\Config;

/**
 * Class ProjectRepository.
 */
class ProjectRepository extends RepositoryAbstract implements ProjectRepositoryInterface
{
    //<editor-fold desc="#constructor">

    /**
     * ProjectRepository constructor.
     *
     * @param EloquentProjectRepositoryInterface $eloquent
     */
    public function __construct(EloquentProjectRepositoryInterface $eloquent)
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
    public function setupPayload(ProjectInterface $Project)
    {
        $data = [
            'parent_id' => $Project->getParentId(),
            'company_id' => $Project->getCompanyId(),
            'contract_type_id' => $Project->getContractTypeId(),
            'reference_number' => $Project->getReferenceNumber(),
            'name' => $Project->getName(),
            'first_party_number' => $Project->getFirstPartyNumber(),
            'second_party_number' => $Project->getSecondPartyNumber(),
            'issue_date' => (!is_null($Project->getIssueDate())) ? $Project->getIssueDate()->format(Config::get('datetime.format.default')) : null,
            'start_date' => (!is_null($Project->getStartDate())) ? $Project->getStartDate()->format(Config::get('datetime.format.default')) : null,
            'end_date' => (!is_null($Project->getEndDate())) ? $Project->getEndDate()->format(Config::get('datetime.format.default')) : null,
            'activity' => $Project->getActivity(),
            'description' => $Project->getDescription(),
            'value' => $Project->getValue(),
            'is_contract' => $Project->getIsContract(),
            'created_by' => $Project->getCreatedBy(),
            'modified_by' => $Project->getModifiedBy()
        ];

        return $data;
    }

    /**
     * {@inheritdoc}
     */
    public function create(ProjectInterface $Project, array $relation = null)
    {
        $data = $this->setupPayload($Project);

        return $this->eloquent()->create($data, $relation);
    }

    /**
     * {@inheritdoc}
     */
    public function update(ProjectInterface $Project, array $relation = null)
    {
        $data = $this->setupPayload($Project);

        return $this->eloquent()->update($data, $Project->getKey(), $relation);
    }

    /**
     * {@inheritdoc}
     */
    public function delete(ProjectInterface $Project, bool $isPermanentDelete = false, array $relation = null)
    {
        return $this->eloquent()->delete($Project->getKey(), $isPermanentDelete, $relation);
    }

    /**
     * @param array $ids
     * @param bool $isPermanentDelete
     * @param array|null $relation
     * @return mixed
     */
    public function deleteBulk(array $ids, bool $isPermanentDelete = false, array $relation = null)
    {
        return $this->eloquent()->delete($ids, $isPermanentDelete, $relation);
    }

    /**
     * @param int|null $parentId
     * @param int|null $companyId
     * @param int|null $contractTypeId
     * @param object|null $rangeIssueDate
     * @param DateTime|null $date
     * @param object|null $rangeValue
     * @return mixed
     */
    public function projectList(int $parentId = null, int $companyId = null, int $contractTypeId = null, object $rangeIssueDate = null, DateTime $date = null, object $rangeValue = null)
    {
        if (!is_null($parentId)) {
            $this->eloquent->findWhereByParentId($parentId);
        }

        if (!is_null($companyId)) {
            $this->eloquent->findWhereByCompanyId($companyId);
        }

        if (!is_null($contractTypeId)) {
            $this->eloquent->findWhereByContractTypeId($contractTypeId);
        }

        if (!is_null($date)) {
            $this->eloquent->findWhereDateByDate($date);
        }

        if (!is_null($rangeIssueDate->start) &&
            !is_null($rangeIssueDate->end)) {
            $this->eloquent->findWhereBetweenByRangeIssueDate($rangeIssueDate->start, $rangeIssueDate->end);
        }

        if (!is_null($rangeValue->start) &&
            !is_null($rangeValue->end)) {
            $this->eloquent->findWhereBetweenByRangeValue($rangeValue->start, $rangeValue->end);
        }

        return $this->eloquent->all();
    }

    /**
     * @param int|null $companyId
     * @param int|null $contractTypeId
     * @param object|null $rangeIssueDate
     * @param DateTime|null $date
     * @param object|null $rangeValue
     * @return mixed
     */
    public function projectListHierarchical(int $companyId = null, int $contractTypeId = null, object $rangeIssueDate = null, DateTime $date = null, object $rangeValue = null)
    {
        $this->eloquent->findWhereByParentIdIsNull();

        if (!is_null($companyId)) {
            $this->eloquent->findWhereByCompanyId($companyId);
        }

        if (!is_null($contractTypeId)) {
            $this->eloquent->findWhereByContractTypeId($contractTypeId);
        }

        if (!is_null($date)) {
            $this->eloquent->findWhereDateByDate($date);
        }

        if (!is_null($rangeIssueDate->start) &&
            !is_null($rangeIssueDate->end)) {
            $this->eloquent->findWhereBetweenByRangeIssueDate($rangeIssueDate->start, $rangeIssueDate->end);
        }

        if (!is_null($rangeValue->start) &&
            !is_null($rangeValue->end)) {
            $this->eloquent->findWhereBetweenByRangeValue($rangeValue->start, $rangeValue->end);
        }

        return $this->eloquent->with(['projectChilds' => function($query) use($companyId, $contractTypeId, $date, $rangeIssueDate, $rangeValue) {
            if (!is_null($companyId)) {
                $query->where('company_id', $companyId);
            }

            if (!is_null($contractTypeId)) {
                $query->where('contract_type_id', $contractTypeId);
            }

            if (!is_null($date)) {
                $query->whereDate([
                    ['start_date', '<=', $date->format(Config::get('datetime.format.default'))],
                    ['end_date', '>=', $date->format(Config::get('datetime.format.default'))]
                ]);
            }

            if (!is_null($rangeIssueDate->start) &&
                !is_null($rangeIssueDate->end)) {
                $query->whereBetween('issue_date', [
                    $rangeIssueDate->start->format(Config::get('datetime.format.default')),
                    $rangeIssueDate->end->format(Config::get('datetime.format.default'))
                ]);
            }

            if (!is_null($rangeValue->start) &&
                !is_null($rangeValue->end)) {
                $query->whereBetween('value', [$rangeValue->start, $rangeValue->end]);
            }

            return $query;
        }])
            ->all();
    }

    /**
     * @param ListedSearchParameter $parameter
     * @param int|null $parentId
     * @param int|null $companyId
     * @param int|null $contractTypeId
     * @param object|null $rangeIssueDate
     * @param DateTime|null $date
     * @param object|null $rangeValue
     * @param bool $count
     * @return mixed
     */
    public function projectListSearch(ListedSearchParameter $parameter, int $parentId = null, int $companyId = null, int $contractTypeId = null, object $rangeIssueDate = null, DateTime $date = null, object $rangeValue = null, bool $count = false)
    {
        $searchQuery = $parameter->query;

        if ($searchQuery) {
            $this->eloquent->findWhereBySearchQuery($searchQuery);
        }

        if (!is_null($parentId)) {
            $this->eloquent->findWhereByParentId($parentId);
        }

        if (!is_null($companyId)) {
            $this->eloquent->findWhereByCompanyId($companyId);
        }

        if (!is_null($contractTypeId)) {
            $this->eloquent->findWhereByContractTypeId($contractTypeId);
        }

        if (!is_null($date)) {
            $this->eloquent->findWhereDateByDate($date);
        }

        if (!is_null($rangeIssueDate->start) &&
            !is_null($rangeIssueDate->end)) {
            $this->eloquent->findWhereBetweenByRangeIssueDate($rangeIssueDate->start, $rangeIssueDate->end);
        }

        if (!is_null($rangeValue->start) &&
            !is_null($rangeValue->end)) {
            $this->eloquent->findWhereBetweenByRangeValue($rangeValue->start, $rangeValue->end);
        }

        if (!$count) {
            return $this->eloquent->with(['projectParent', 'company',
                'workUnits',
                'contractType',
                'projectChilds', 'projectTerms', 'projectAddendums',
                'morphMediaLibraries'])
                ->all();
        } else {
            return $this->eloquent->all()->count();
        }
    }

    /**
     * @param PagedSearchParameter $parameter
     * @param int|null $parentId
     * @param int|null $companyId
     * @param int|null $contractTypeId
     * @param object|null $rangeIssueDate
     * @param DateTime|null $date
     * @param object|null $rangeValue
     * @param bool $count
     * @return mixed
     */
    public function projectPageSearch(PagedSearchParameter $parameter, int $parentId = null, int $companyId = null, int $contractTypeId = null, object $rangeIssueDate = null, DateTime $date = null, object $rangeValue = null, bool $count = false)
    {
        if (!is_null($parentId)) {
            $this->eloquent->findWhereByParentId($parentId);
        }

        if (!is_null($companyId)) {
            $this->eloquent->findWhereByCompanyId($companyId);
        }

        if (!is_null($contractTypeId)) {
            $this->eloquent->findWhereByContractTypeId($contractTypeId);
        }

        if (!is_null($date)) {
            $this->eloquent->findWhereDateByDate($date);
        }

        if (!is_null($rangeIssueDate->start) &&
            !is_null($rangeIssueDate->end)) {
            $this->eloquent->findWhereBetweenByRangeIssueDate($rangeIssueDate->start, $rangeIssueDate->end);
        }

        if (!is_null($rangeValue->start) &&
            !is_null($rangeValue->end)) {
            $this->eloquent->findWhereBetweenByRangeValue($rangeValue->start, $rangeValue->end);
        }

        $searchQuery = !is_null($parameter->search) ? $parameter->search['value'] : $parameter->query['value'] ?? null;

        if ($searchQuery) {
            $this->eloquent->findWhereBySearchQuery($searchQuery);
        }

        if (!$count) {
            if ($parameter->draw) {
                return $this->eloquent->with(['projectParent', 'company',
                    'workUnits',
                    'contractType',
                    'projectChilds', 'projectTerms', 'projectAddendums',
                    'morphMediaLibraries'])
                    ->orderBy($parameter->columns[$parameter->order[0]['column']]['data'], $parameter->order[0]['dir'])
                    ->paginate($parameter->length, $parameter->start);
            } else {
                return $this->eloquent->with(['projectParent', 'company',
                    'workUnits',
                    'contractType',
                    'projectChilds', 'projectTerms', 'projectAddendums',
                    'morphMediaLibraries'])
                    ->orderBy($parameter->sort['field'], $parameter->sort['sort'])
                    ->paginate($parameter->pagination['perpage'], ($parameter->pagination['perpage'] * ($parameter->pagination['page'] - 1)));
            }
        } else {
            return $this->eloquent->all()->count();
        }

    }

    //</editor-fold>
}

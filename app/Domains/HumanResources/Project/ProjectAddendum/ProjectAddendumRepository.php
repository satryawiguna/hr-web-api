<?php

namespace App\Domains\HumanResources\Project\ProjectAddendum;

use App\Core\Domains\Contracts\Pagination\ListedSearchParameter;
use App\Core\Domains\Contracts\Pagination\PagedSearchParameter;
use App\Domains\HumanResources\Project\ProjectAddendum\Contracts\ProjectAddendumRepositoryInterface;
use App\Infrastructures\HumanResources\Project\ProjectAddendum\Contracts\EloquentProjectAddendumRepositoryInterface;
use App\Domains\HumanResources\Project\ProjectAddendum\Contracts\ProjectAddendumInterface;
use App\Domains\RepositoryAbstract;
use App\Domains\Contracts\BaseEntityInterface;
use Closure;
use DateTime;
use Illuminate\Support\Facades\Config;

/**
 * Class ProjectAddendumRepository.
 */
class ProjectAddendumRepository extends RepositoryAbstract implements ProjectAddendumRepositoryInterface
{
    //<editor-fold desc="#constructor">

    /**
     * ProjectAddendumRepository constructor.
     *
     * @param EloquentProjectAddendumRepositoryInterface $eloquent
     */
    public function __construct(EloquentProjectAddendumRepositoryInterface $eloquent)
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
    public function setupPayload(ProjectAddendumInterface $ProjectAddendum)
    {
        $data = [
            'project_id' => $ProjectAddendum->getProjectId(),
            'reference_number' => $ProjectAddendum->getReferenceNumber(),
            'name' => $ProjectAddendum->getName(),
            'issue_date' => (!is_null($ProjectAddendum->getIssueDate())) ? $ProjectAddendum->getIssueDate()->format(Config::get('datetime.format.default')) : null,
            'start_date' => (!is_null($ProjectAddendum->getStartDate())) ? $ProjectAddendum->getStartDate()->format(Config::get('datetime.format.default')) : null,
            'end_date' => (!is_null($ProjectAddendum->getEndDate())) ? $ProjectAddendum->getEndDate()->format(Config::get('datetime.format.default')) : null,
            'description' => $ProjectAddendum->getDescription(),
            'value' => $ProjectAddendum->getValue(),
            'created_by' => $ProjectAddendum->getCreatedBy(),
            'modified_by' => $ProjectAddendum->getModifiedBy()
        ];

        return $data;
    }

    /**
     * {@inheritdoc}
     */
    public function create(ProjectAddendumInterface $ProjectAddendum, array $relations = null)
    {
        $data = $this->setupPayload($ProjectAddendum);

        return $this->eloquent()->create($data, $relations);
    }

    /**
     * {@inheritdoc}
     */
    public function update(ProjectAddendumInterface $ProjectAddendum, array $relations = null)
    {
        $data = $this->setupPayload($ProjectAddendum);
       
        return $this->eloquent()->update($data, $ProjectAddendum->getKey(), $relations);
    }

    /**
     * {@inheritdoc}
     */
    public function delete(ProjectAddendumInterface $ProjectAddendum, bool $isPermanentDelete = false, array $relations = null)
    {
        return $this->eloquent()->delete($ProjectAddendum->getKey(), $isPermanentDelete, $relations);
    }

    /**
     * @param array $ids
     * @param bool $isPermanentDelete
     * @param array|null $relations
     * @return mixed
     */
    public function deleteBulk(array $ids, bool $isPermanentDelete = false, array $relations = null)
    {
        return $this->eloquent()->delete($ids, $isPermanentDelete, $relations);
    }

    /**
     * @param int|null $projectId
     * @param DateTime|null $date
     * @param object|null $rangeIssueDate
     * @param object|null $rangeValue
     * @param object|null $rangeValueByContractType
     * @return mixed
     */
    public function projectAddendumList(int $projectId = null, DateTime $date = null, object $rangeIssueDate = null, object $rangeValue = null)
    {
        if (!is_null($projectId)) {
            $this->eloquent->findWhereByProjectId($projectId);
        }

        // issue date
        if (!is_null($rangeIssueDate->start) &&
            !is_null($rangeIssueDate->end)) {
            $this->eloquent->findWhereBetweenByRangeIssueDate($rangeIssueDate->start, $rangeIssueDate->end);
        }

        // start and end date
        if (!is_null($date)) {
            $this->eloquent->findWhereDateByDate($date);
        }

        if (!is_null($rangeValue->start) &&
            !is_null($rangeValue->end)) {
            $this->eloquent->findWhereBetweenByRangeValue($rangeValue->start, $rangeValue->end);
        }

        return $this->eloquent->all();
    }

    /**
     * @param ListedSearchParameter $parameter
     * @param int|null $projectId
     * @param DateTime|null $date
     * @param object|null $rangeIssueDate
     * @param object|null $rangeValue
     * @param object|null $rangeValueByContractType
     * @param bool $count
     * @return mixed
     */
    public function projectAddendumListSearch(ListedSearchParameter $parameter, int $projectId = null, DateTime $date = null, object $rangeIssueDate = null, object $rangeValue = null, bool $count = false)
    {
        $searchQuery = $parameter->query;

        if ($searchQuery) {
            $this->eloquent->findWhereBySearchQuery($searchQuery);
        }

        if (!is_null($projectId)) {
            $this->eloquent->findWhereByProjectId($projectId);
        }

        //issue date
        if (!is_null($rangeIssueDate->start) &&
            !is_null($rangeIssueDate->end)) {
            $this->eloquent->findWhereBetweenByRangeIssueDate($rangeIssueDate->start, $rangeIssueDate->end);
        }

        //start and end date
        if (!is_null($date)) {
            $this->eloquent->findWhereDateByDate($date);
        }

        if (!is_null($rangeValue->start) &&
            !is_null($rangeValue->end)) {
            $this->eloquent->findWhereBetweenByRangeValue($rangeValue->start, $rangeValue->end);
        }

        if (!$count) {
            return $this->eloquent->with(['project',
            'morphMediaLibraries'])
                ->all();
        } else {
            return $this->eloquent->all()->count();
        }
    }

    /**
     * @param PagedSearchParameter $parameter
     * @param int|null $projectId
     * @param DateTime|null $date
     * @param object|null $rangeIssueDate
     * @param object|null $rangeValue
     * @param object|null $rangeValueByContractType
     * @param bool $count
     * @return mixed
     */
    public function projectAddendumPageSearch(PagedSearchParameter $parameter, int $projectId = null, DateTime $date = null, object $rangeIssueDate = null, object $rangeValue = null, bool $count = false)
    {
        if (!is_null($projectId)) {
            $this->eloquent->findWhereByProjectId($projectId);
        }

        //issue date
        if (!is_null($rangeIssueDate->start) &&
            !is_null($rangeIssueDate->end)) {
            $this->eloquent->findWhereBetweenByRangeIssueDate($rangeIssueDate->start, $rangeIssueDate->end);
        }

        //start and end date
        if (!is_null($date)) {
            $this->eloquent->findWhereDateByDate($date->start, $date->end);
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
                return $this->eloquent->with(['project', 'morphMediaLibraries'])
                    ->orderBy($parameter->columns[$parameter->order[0]['column']]['data'], $parameter->order[0]['dir'])
                    ->paginate($parameter->length, $parameter->start);
            } else {
                return $this->eloquent->with(['project', 'morphMediaLibraries'])
                    ->orderBy($parameter->sort['field'], $parameter->sort['sort'])
                    ->paginate($parameter->pagination['perpage'], ($parameter->pagination['perpage'] * ($parameter->pagination['page'] - 1)));
            }
        } else {
            return $this->eloquent->all()->count();
        }

    }

    //</editor-fold>
}

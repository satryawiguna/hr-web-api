<?php

namespace App\Domains\HumanResources\Project\ProjectTerms;

use App\Core\Domains\Contracts\Pagination\ListedSearchParameter;
use App\Core\Domains\Contracts\Pagination\PagedSearchParameter;
use App\Domains\HumanResources\Project\ProjectTerms\Contracts\ProjectTermsRepositoryInterface;
use App\Infrastructures\HumanResources\Project\ProjectTerms\Contracts\EloquentProjectTermsRepositoryInterface;
use App\Domains\HumanResources\Project\ProjectTerms\Contracts\ProjectTermsInterface;
use App\Domains\RepositoryAbstract;
use App\Domains\Contracts\BaseEntityInterface;
use Closure;

/**
 * Class ProjectTermsRepository.
 */
class ProjectTermsRepository extends RepositoryAbstract implements ProjectTermsRepositoryInterface
{
    //<editor-fold desc="#constructor">

    /**
     * ProjectTermsRepository constructor.
     *
     * @param EloquentProjectTermsRepositoryInterface $eloquent
     */
    public function __construct(EloquentProjectTermsRepositoryInterface $eloquent)
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
    public function setupPayload(ProjectTermsInterface $ProjectTerms)
    {
        return [
            'project_id' => $ProjectTerms->getProjectId(),
            'step' => $ProjectTerms->getStep(),
            'name' => $ProjectTerms->getName(),
            'value' => $ProjectTerms->getValue(),
            'description' => $ProjectTerms->getDescription(),
            'created_by' => $ProjectTerms->getCreatedBy(),
            'modified_by' => $ProjectTerms->getModifiedBy()
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function create(ProjectTermsInterface $ProjectTerms)
    {
        $data = $this->setupPayload($ProjectTerms);

        return $this->eloquent()->create($data);
    }

    /**
     * {@inheritdoc}
     */
    public function update(ProjectTermsInterface $ProjectTerms)
    {
        $data = $this->setupPayload($ProjectTerms);
       
        return $this->eloquent()->update($data, $ProjectTerms->getKey());
    }

    /**
     * {@inheritdoc}
     */
    public function delete(ProjectTermsInterface $ProjectTerms)
    {
        return $this->eloquent()->delete($ProjectTerms->getKey());
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
     * @param int|null $projectId
     * @param null $rangeValue
     * @return mixed
     */
    public function projectTermsList(int $projectId = null, $rangeValue = null)
    {
        if ($projectId != null) {
            $this->eloquent->findWhereByProjectId($projectId);
        }

        if ($rangeValue != null &&
            property_exists($rangeValue, 'start') &&
            property_exists($rangeValue, 'end')) {
            if(!is_null($rangeValue->start) && !is_null($rangeValue->end)){
                $this->eloquent->findWhereBetweenByRangeValue($rangeValue->start, $rangeValue->end);
            }
        }

        return $this->eloquent->with(['project'])
            ->all();
    }

    /**
     * @param ListedSearchParameter $parameter
     * @param int|null $projectId
     * @param null $rangeValue
     * @param bool $count
     * @return mixed
     */
    public function projectTermsListSearch(ListedSearchParameter $parameter, int $projectId = null, $rangeValue = null, bool $count = false)
    {
        $searchQuery = $parameter->query;

        if ($searchQuery) {
            $this->eloquent->findWhereBySearchQuery($searchQuery);
        }

        if ($projectId != null) {
            $this->eloquent->findWhereByProjectId($projectId);
        }

        if ($rangeValue != null &&
            property_exists($rangeValue, 'start') &&
            property_exists($rangeValue, 'end')) {
            if(!is_null($rangeValue->start) && !is_null($rangeValue->end)){
                $this->eloquent->findWhereBetweenByRangeValue($rangeValue->start, $rangeValue->end);
            }
        }

        if (!$count) {
            return $this->eloquent->with(['project'])
                ->all();
        } else {
            return $this->eloquent->with(['project'])
                ->count();
        }
    }

    /**
     * @param PagedSearchParameter $parameter
     * @param int|null $projectId
     * @param null $rangeValue
     * @param bool $count
     * @return mixed
     */
    public function projectTermsPageSearch(PagedSearchParameter $parameter, int $projectId = null, $rangeValue = null, bool $count = false)
    {
        if ($projectId != null) {
            $this->eloquent->findWhereByProjectId($projectId);
        }

        if ($rangeValue != null &&
            property_exists($rangeValue, 'start') &&
            property_exists($rangeValue, 'end')) {
            if(!is_null($rangeValue->start) && !is_null($rangeValue->end)){
                $this->eloquent->findWhereBetweenByRangeValue($rangeValue->start, $rangeValue->end);
            }
        }

        $searchQuery = !is_null($parameter->search) ? $parameter->search['value'] : $parameter->query['value'] ?? null;

        if ($searchQuery) {
            $this->eloquent->findWhereBySearchQuery($searchQuery);
        }

        if (!$count) {
            if ($parameter->draw) {
                return $this->eloquent->with(['project'])
                    ->orderBy($parameter->columns[$parameter->order[0]['column']]['data'], $parameter->order[0]['dir'])
                    ->paginate($parameter->length, $parameter->start);
            } else {
                return $this->eloquent->with(['project'])
                    ->orderBy($parameter->sort['field'], $parameter->sort['sort'])
                    ->paginate($parameter->pagination['perpage'], ($parameter->pagination['perpage'] * ($parameter->pagination['page'] - 1)));
            }
        } else {
            return $this->eloquent->all()->count();
        }

    }

    //</editor-fold>
}

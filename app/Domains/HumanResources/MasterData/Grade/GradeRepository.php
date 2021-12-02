<?php

namespace App\Domains\HumanResources\MasterData\Grade;

use App\Core\Domains\Contracts\Pagination\ListedSearchParameter;
use App\Core\Domains\Contracts\Pagination\PagedSearchParameter;
use App\Domains\HumanResources\MasterData\Grade\Contracts\GradeRepositoryInterface;
use App\Infrastructures\HumanResources\MasterData\Grade\Contracts\EloquentGradeRepositoryInterface;
use App\Domains\HumanResources\MasterData\Grade\Contracts\GradeInterface;
use App\Domains\RepositoryAbstract;
use App\Domains\Contracts\BaseEntityInterface;
use Closure;

/**
 * Class GradeRepository.
 */
class GradeRepository extends RepositoryAbstract implements GradeRepositoryInterface
{
    //<editor-fold desc="#constructor">

    /**
     * GradeRepository constructor.
     *
     * @param EloquentGradeRepositoryInterface $eloquent
     */
    public function __construct(EloquentGradeRepositoryInterface $eloquent)
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
    public function setupPayload(GradeInterface $Grade)
    {
        return [
            'company_id' => $Grade->getCompanyId(),
            'name' => $Grade->getName(),
            'slug' => $Grade->getSlug(),
            'description' => $Grade->getDescription(),
            'is_active' => (!is_null($Grade->getIsActive())) ? $Grade->getIsActive() : 0,
            'created_by' => $Grade->getCreatedBy(),
            'modified_by' => $Grade->getModifiedBy(),
            
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function create(GradeInterface $Grade)
    {
        $data = $this->setupPayload($Grade);

        return $this->eloquent()->create($data);
    }

    /**
     * {@inheritdoc}
     */
    public function update(GradeInterface $Grade)
    {
        $data = $this->setupPayload($Grade);
       
        return $this->eloquent()->update($data, $Grade->getKey());
    }

    /**
     * {@inheritdoc}
     */
    public function delete(GradeInterface $Grade)
    {
        return $this->eloquent()->delete($Grade->getKey());
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
     * @param int|null $isActive
     * @return mixed
     */
    public function gradeList(int $companyId = null, int $isActive = null)
    {
        if (!is_null($companyId)) {
            $this->eloquent->findWhereByCompanyId($companyId);
        }

        if (!is_null($isActive)) {
            $this->eloquent->findWhereByIsActive($isActive);
        }

        return $this->eloquent->all();
    }

    /**
     * @param ListedSearchParameter $parameter
     * @param int|null $companyId
     * @param int|null $isActive
     * @param bool $count
     * @return mixed
     */
    public function gradeListSearch(ListedSearchParameter $parameter, int $companyId = null, int $isActive = null, bool $count = false)
    {
        $searchQuery = $parameter->query;

        if ($searchQuery) {
            $this->eloquent->findWhereBySearchQuery($searchQuery);
        }

        if (!is_null($companyId)) {
            $this->eloquent->findWhereByCompanyId($companyId);
        }

        if (!is_null($isActive)) {
            $this->eloquent->findWhereByIsActive($isActive);
        }

        if (!$count) {
            return $this->eloquent->with(['company'])
                ->all();
        } else {
            return $this->eloquent->all()->count();
        }
    }

    /**
     * @param PagedSearchParameter $parameter
     * @param int|null $companyId
     * @param int|null $isActive
     * @param int $count
     * @return mixed
     */
    public function gradePageSearch(PagedSearchParameter $parameter, int $companyId = null, int $isActive = null, bool $count = false)
    {
        $searchQuery = !is_null($parameter->search) ? $parameter->search['value'] : $parameter->query['value'] ?? null;

        if (!is_null($companyId)) {
            $this->eloquent->findWhereByCompanyId($companyId);
        }

        if (!is_null($isActive)) {
            $this->eloquent->findWhereByIsActive($isActive);
        }

        if ($searchQuery) {
            $this->eloquent->findWhereBySearchQuery($searchQuery);
        }

        if (!$count) {
            if ($parameter->draw) {
                return $this->eloquent->with(['company'])
                    ->orderBy($parameter->columns[$parameter->order[0]['column']]['data'], $parameter->order[0]['dir'])
                    ->paginate($parameter->length, $parameter->start);
            } else {
                return $this->eloquent->with(['company'])
                    ->orderBy($parameter->sort['field'], $parameter->sort['sort'])
                    ->paginate($parameter->pagination['perpage'], ($parameter->pagination['perpage'] * ($parameter->pagination['page'] - 1)));
            }
        } else {
            return $this->eloquent->all()->count();
        }

    }

    //</editor-fold>
}

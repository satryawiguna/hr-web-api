<?php

namespace App\Domains\Commons\CompanyCategory;

use App\Core\Domains\Contracts\Pagination\ListedSearchParameter;
use App\Core\Domains\Contracts\Pagination\PagedSearchParameter;
use App\Domains\Commons\CompanyCategory\Contracts\CompanyCategoryRepositoryInterface;
use App\Infrastructures\Commons\CompanyCategory\Contracts\EloquentCompanyCategoryRepositoryInterface;
use App\Domains\Commons\CompanyCategory\Contracts\CompanyCategoryInterface;
use App\Domains\RepositoryAbstract;
use App\Domains\Contracts\BaseEntityInterface;
use Closure;

/**
 * Class CompanyCategoryRepository.
 */
class CompanyCategoryRepository extends RepositoryAbstract implements CompanyCategoryRepositoryInterface
{
    //<editor-fold desc="#constructor">

    /**
     * CompanyCategoryRepository constructor.
     *
     * @param EloquentCompanyCategoryRepositoryInterface $eloquent
     */
    public function __construct(EloquentCompanyCategoryRepositoryInterface $eloquent)
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
    public function setupPayload(CompanyCategoryInterface $CompanyCategory)
    {
        return [
            'name' => $CompanyCategory->getName(),
            'slug' => $CompanyCategory->getSlug(),
            'description' => $CompanyCategory->getDescription(),
            'is_active' => (!is_null($CompanyCategory->getIsActive())) ? $CompanyCategory->getIsActive() : 0,
            'created_by' => $CompanyCategory->getCreatedBy(),
            'modified_by' => $CompanyCategory->getModifiedBy(),
            
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function create(CompanyCategoryInterface $CompanyCategory)
    {
        $data = $this->setupPayload($CompanyCategory);

        return $this->eloquent()->create($data);
    }

    /**
     * {@inheritdoc}
     */
    public function update(CompanyCategoryInterface $CompanyCategory)
    {
        $data = $this->setupPayload($CompanyCategory);
       
        return $this->eloquent()->update($data, $CompanyCategory->getKey());
    }

    /**
     * {@inheritdoc}
     */
    public function delete(CompanyCategoryInterface $CompanyCategory)
    {
        return $this->eloquent()->delete($CompanyCategory->getKey());
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
     * @param int|null $isActive
     * @return mixed
     */
    public function companyCategoryList(int $isActive = null)
    {
        if (!is_null($isActive)) {
            $this->eloquent->findWhereByIsActive($isActive);
        }

        return $this->eloquent->all();
    }

    /**
     * @param ListedSearchParameter $parameter
     * @param int|null $isActive
     * @param bool $count
     * @return mixed
     */
    public function companyCategoryListSearch(ListedSearchParameter $parameter, int $isActive = null, bool $count = false)
    {
        $searchQuery = $parameter->query;

        if ($searchQuery) {
            $this->eloquent->findWhereBySearchQuery($searchQuery);
        }

        if (!is_null($isActive)) {
            $this->eloquent->findWhereByIsActive($isActive);
        }

        if (!$count) {
            return $this->eloquent->all();
        } else {
            return $this->eloquent->all()->count();
        }
    }

    /**
     * @param PagedSearchParameter $parameter
     * @param int|null $isActive
     * @param bool $count
     * @return mixed
     */
    public function companyCategoryPageSearch(PagedSearchParameter $parameter, int $isActive = null, bool $count = false)
    {
        if (!is_null($isActive)) {
            $this->eloquent->findWhereByIsActive($isActive);
        }

        $searchQuery = !is_null($parameter->search) ? $parameter->search['value'] : $parameter->query['value'] ?? null;

        if ($searchQuery) {
            $this->eloquent->findWhereBySearchQuery($searchQuery);
        }

        if (!$count) {
            if ($parameter->draw) {
                return $this->eloquent->orderBy($parameter->columns[$parameter->order[0]['column']]['data'], $parameter->order[0]['dir'])
                    ->paginate($parameter->length, $parameter->start);
            } else {
                return $this->eloquent->orderBy($parameter->sort['field'], $parameter->sort['sort'])
                    ->paginate($parameter->pagination['perpage'], ($parameter->pagination['perpage'] * ($parameter->pagination['page'] - 1)));
            }
        } else {
            return $this->eloquent->all()->count();
        }

    }

    //</editor-fold>
}

<?php

namespace App\Domains\Commons\VacancyCategory;

use App\Core\Domains\Contracts\Pagination\ListedSearchParameter;
use App\Core\Domains\Contracts\Pagination\PagedSearchParameter;
use App\Domains\Commons\VacancyCategory\Contracts\VacancyCategoryRepositoryInterface;
use App\Infrastructures\Commons\VacancyCategory\Contracts\EloquentVacancyCategoryRepositoryInterface;
use App\Domains\Commons\VacancyCategory\Contracts\VacancyCategoryInterface;
use App\Domains\RepositoryAbstract;
use App\Domains\Contracts\BaseEntityInterface;
use Closure;

/**
 * Class VacancyCategoryRepository.
 */
class VacancyCategoryRepository extends RepositoryAbstract implements VacancyCategoryRepositoryInterface
{
    //<editor-fold desc="#constructor">

    /**
     * VacancyCategoryRepository constructor.
     *
     * @param EloquentVacancyCategoryRepositoryInterface $eloquent
     */
    public function __construct(EloquentVacancyCategoryRepositoryInterface $eloquent)
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
    public function setupPayload(VacancyCategoryInterface $VacancyCategory)
    {
        return [
            'name' => $VacancyCategory->getName(),
            'slug' => $VacancyCategory->getSlug()
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function create(VacancyCategoryInterface $VacancyCategory)
    {
        $data = $this->setupPayload($VacancyCategory);

        return $this->eloquent()->create($data);
    }

    /**
     * {@inheritdoc}
     */
    public function update(VacancyCategoryInterface $VacancyCategory)
    {
        $data = $this->setupPayload($VacancyCategory);

        return $this->eloquent()->update($data, $VacancyCategory->getKey());
    }

    /**
     * {@inheritdoc}
     */
    public function delete(VacancyCategoryInterface $VacancyCategory)
    {
        return $this->eloquent()->delete($VacancyCategory->getKey());
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
     * @return mixed
     */
    public function vacancyCategoryList()
    {
        return $this->eloquent->all();
    }

    /**
     * @param ListedSearchParameter $parameter
     * @param bool|null $count
     * @return mixed
     */
    public function vacancyCategoryListSearch(ListedSearchParameter $parameter, bool $count = null)
    {
        $searchQuery = $parameter->query;

        if ($searchQuery) {
            $this->eloquent->findWhereBySearchQuery($searchQuery);
        }

        if (!$count) {
            return $this->eloquent->all();
        } else {
            return $this->eloquent->all()->count();
        }
    }

    /**
     * @param PagedSearchParameter $parameter
     * @param bool $count
     * @return mixed
     */
    public function vacancyCategoryPageSearch(PagedSearchParameter $parameter, bool $count = false)
    {
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

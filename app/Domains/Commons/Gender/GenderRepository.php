<?php

namespace App\Domains\Commons\Gender;

use App\Core\Domains\Contracts\Pagination\ListedSearchParameter;
use App\Core\Domains\Contracts\Pagination\PagedSearchParameter;
use App\Domains\Commons\Gender\Contracts\GenderRepositoryInterface;
use App\Infrastructures\Commons\Gender\Contracts\EloquentGenderRepositoryInterface;
use App\Domains\Commons\Gender\Contracts\GenderInterface;
use App\Domains\RepositoryAbstract;
use App\Domains\Contracts\BaseEntityInterface;
use Closure;

/**
 * Class GenderRepository.
 */
class GenderRepository extends RepositoryAbstract implements GenderRepositoryInterface
{
    //<editor-fold desc="#constructor">

    /**
     * GenderRepository constructor.
     *
     * @param EloquentGenderRepositoryInterface $eloquent
     */
    public function __construct(EloquentGenderRepositoryInterface $eloquent)
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
    public function setupPayload(GenderInterface $Gender)
    {
        return [
            'name' => $Gender->getName(),
            'slug' => $Gender->getSlug(),
            'description' => $Gender->getDescription(),
            'is_active' => (!is_null($Gender->getIsActive())) ? $Gender->getIsActive() : 0,
            'created_by' => $Gender->getCreatedBy(),
            'modified_by' => $Gender->getModifiedBy(),
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function create(GenderInterface $Gender)
    {
        $data = $this->setupPayload($Gender);

        return $this->eloquent()->create($data);
    }

    /**
     * {@inheritdoc}
     */
    public function update(GenderInterface $Gender)
    {
        $data = $this->setupPayload($Gender);

        return $this->eloquent()->update($data, $Gender->getKey());
    }

    /**
     * {@inheritdoc}
     */
    public function delete(GenderInterface $Gender)
    {
        return $this->eloquent()->delete($Gender->getKey());
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
    public function genderList(int $isActive = null)
    {
        if (!is_null($isActive)) {
            $this->eloquent->findWhereByIsActive($isActive);
        }

        return $this->eloquent->all();
    }

    /**
     * @param ListedSearchParameter $parameter
     * @param int|null $isActive
     * @param bool|null $count
     * @return mixed
     */
    public function genderListSearch(ListedSearchParameter $parameter, int $isActive = null, bool $count = null)
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
    public function genderPageSearch(PagedSearchParameter $parameter, int $isActive = null, bool $count = false)
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

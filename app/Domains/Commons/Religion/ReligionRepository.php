<?php

namespace App\Domains\Commons\Religion;

use App\Core\Domains\Contracts\Pagination\ListedSearchParameter;
use App\Core\Domains\Contracts\Pagination\PagedSearchParameter;
use App\Domains\Commons\Religion\Contracts\ReligionRepositoryInterface;
use App\Infrastructures\Commons\Religion\Contracts\EloquentReligionRepositoryInterface;
use App\Domains\Commons\Religion\Contracts\ReligionInterface;
use App\Domains\RepositoryAbstract;
use App\Domains\Contracts\BaseEntityInterface;
use Closure;

/**
 * Class ReligionRepository.
 */
class ReligionRepository extends RepositoryAbstract implements ReligionRepositoryInterface
{
    //<editor-fold desc="#constructor">

    /**
     * ReligionRepository constructor.
     *
     * @param EloquentReligionRepositoryInterface $eloquent
     */
    public function __construct(EloquentReligionRepositoryInterface $eloquent)
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
    public function setupPayload(ReligionInterface $Religion)
    {
        return [
            'name' => $Religion->getName(),
            'slug' => $Religion->getSlug(),
            'description' => $Religion->getDescription(),
            'is_active' => (!is_null($Religion->getIsActive())) ? $Religion->getIsActive() : 0,
            'created_by' => $Religion->getCreatedBy(),
            'modified_by' => $Religion->getModifiedBy()
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function create(ReligionInterface $religion)
    {
        $data = $this->setupPayload($religion);

        return $this->eloquent->create($data);
    }

    /**
     * {@inheritdoc}
     */
    public function update(ReligionInterface $religion)
    {
        $data = $this->setupPayload($religion);

        return $this->eloquent->update($data, $religion->getKey());
    }

    /**
     * {@inheritdoc}
     */
    public function delete(ReligionInterface $religion)
    {
        return $this->eloquent->delete($religion->getKey());
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
    public function religionList(int $isActive = null)
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
    public function religionListSearch(ListedSearchParameter $parameter, int $isActive = null, bool $count = false)
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
    public function religionPageSearch(PagedSearchParameter $parameter, int $isActive = null, bool $count = false)
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

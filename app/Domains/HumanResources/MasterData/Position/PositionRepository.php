<?php

namespace App\Domains\HumanResources\MasterData\Position;

use App\Core\Domains\Contracts\Pagination\ListedSearchParameter;
use App\Core\Domains\Contracts\Pagination\PagedSearchParameter;
use App\Domains\HumanResources\MasterData\Position\Contracts\PositionRepositoryInterface;
use App\Infrastructures\HumanResources\MasterData\Position\Contracts\EloquentPositionRepositoryInterface;
use App\Domains\HumanResources\MasterData\Position\Contracts\PositionInterface;
use App\Domains\RepositoryAbstract;
use App\Domains\Contracts\BaseEntityInterface;
use Closure;

/**
 * Class PositionRepository.
 */
class PositionRepository extends RepositoryAbstract implements PositionRepositoryInterface
{
    //<editor-fold desc="#constructor">

    /**
     * PositionRepository constructor.
     *
     * @param EloquentPositionRepositoryInterface $eloquent
     */
    public function __construct(EloquentPositionRepositoryInterface $eloquent)
    {
        parent::__construct($eloquent);
    }

    //</editor-fold>


    //<editor-fold desc="#public (method)">

    /**
     * Setup payload.
     *
     * @param PositionInterface $Position
     * @return array
     */
    public function setupPayload(PositionInterface $Position)
    {
        return [
            'company_id' => $Position->getCompanyId(),
            'parent_id' => $Position->getParentId(),
            'code' => $Position->getCode(),
            'name' => $Position->getName(),
            'slug' => $Position->getSlug(),
            'description' => $Position->getDescription(),
            'is_active' => (!is_null($Position->getIsActive())) ? $Position->getIsActive() : 0,
            'created_by' => $Position->getCreatedBy(),
            'modified_by' => $Position->getModifiedBy()
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function create(PositionInterface $Position)
    {
        $data = $this->setupPayload($Position);

        return $this->eloquent()->create($data);
    }

    /**
     * {@inheritdoc}
     */
    public function update(PositionInterface $Position)
    {
        $data = $this->setupPayload($Position);

        return $this->eloquent()->update($data, $Position->getKey());
    }

    /**
     * {@inheritdoc}
     */
    public function delete(PositionInterface $Position)
    {
        return $this->eloquent()->delete($Position->getKey());
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
     * @param int|null $parentId
     * @param int|null $companyId
     * @param int|null $isActive
     * @return mixed
     */
    public function positionList(int $parentId = null, int $companyId = null, int $isActive = null)
    {
        if (!is_null($parentId)) {
            $this->eloquent->findWhereByParentId($parentId);
        }

        if (!is_null($companyId)) {
            $this->eloquent->findWhereByCompanyId($companyId);
        }

        if (!is_null($isActive)) {
            $this->eloquent->findWhereByIsActive($isActive);
        }

        return $this->eloquent->all();
    }

    /**
     * @param int|null $companyId
     * @param int|null $isActive
     * @return mixed
     */
    public function positionListHierarchical(int $companyId = null, int $isActive = null)
    {
        $this->eloquent->findWhereByParentIdIsNull();

        if (!is_null($companyId)) {
            $this->eloquent->findWhereByCompanyId($companyId);
        }

        if (!is_null($isActive)) {
            $this->eloquent->findWhereByIsActive($isActive);
        }

        return $this->eloquent->with(['positionChilds' => function($query) use($companyId, $isActive) {
            if (!is_null($companyId)) {
                $query->where('company_id', $companyId);
            }

            if (!is_null($isActive)) {
                $query->where('is_active', $isActive);
            }

            return $query;
        }])
            ->all();
    }

    /**
     * @param ListedSearchParameter $parameter
     * @param int|null $parentId
     * @param int|null $companyId
     * @param int|null $isActive
     * @param bool $count
     * @return mixed
     */
    public function positionListSearch(ListedSearchParameter $parameter, int $parentId = null, int $companyId = null, int $isActive = null, bool $count = false)
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
     * @param int|null $parentId
     * @param int|null $companyId
     * @param int|null $isActive
     * @param bool $count
     * @return mixed
     */
    public function positionPageSearch(PagedSearchParameter $parameter, int $parentId = null, int $companyId = null, int $isActive = null, bool $count = false)
    {
        if (!is_null($parentId)) {
            $this->eloquent->findWhereByParentId($parentId);
        }

        if (!is_null($companyId)) {
            $this->eloquent->findWhereByCompanyId($companyId);
        }

        if (!is_null($isActive)) {
            $this->eloquent->findWhereByIsActive($isActive);
        }

        $searchQuery = !is_null($parameter->search) ? $parameter->search['value'] : $parameter->query['value'] ?? null;

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

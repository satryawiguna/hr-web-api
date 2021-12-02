<?php

namespace App\Infrastructures\HumanResources\MasterData\Position;

use App\Infrastructures\HumanResources\MasterData\Position\Contracts\EloquentPositionRepositoryInterface;
use App\Infrastructures\EloquentRepositoryAbstract;

/**
 * EloquentPositionRepository Class.
 */
class EloquentPositionRepository extends EloquentRepositoryAbstract implements EloquentPositionRepositoryInterface
{
    //<editor-fold desc="#public (method)">

    /**
     * @param int $companyId
     * @return $this|mixed
     */
    public function findWhereByCompanyId(int $companyId)
    {
        $this->model = $this->model->where('company_id', $companyId);

        return $this;
    }

    /**
     * @param int $parentId
     * @return $this
     */
    public function findWhereByParentId(int $parentId)
    {
        if ($parentId <> 0) {
            $this->model = $this->model->where('parent_id', $parentId);
        } else {
            $this->model = $this->model->whereNull('parent_id');
        }

        return $this;
    }

    /**
     * @return $this|mixed
     */
    public function findWhereByParentIdIsNull()
    {
        $this->model = $this->model->where('parent_id', null);

        return $this;
    }

    /**
     * @param int $isActive
     * @return $this|mixed
     */
    public function findWhereByIsActive(int $isActive)
    {
        $this->model = $this->model->where('is_active', $isActive);

        return $this;
    }

    /**
     * @param string $searchQuery
     * @return $this|mixed
     */
    public function findWhereBySearchQuery(string $searchQuery)
    {
        $searchParameter = [
            'code' => '%' . $searchQuery . '%',
            'name' => '%' . $searchQuery . '%',
            'slug' => '%' . $searchQuery . '%',
            'description' => '%' . $searchQuery . '%'
        ];

        $this->model = $this->model->whereRaw('(code LIKE ?
            OR name LIKE ?
            OR slug LIKE ?
            OR description LIKE ?)', $searchParameter);

        return $this;
    }

    /**
     * @param int $id
     * @return $this|mixed
     */
    public function findWhereNotEqualById(int $id)
    {
        $this->model = $this->model->where('id', '<>', $id);

        return $this;
    }

    //</editor-fold>
}

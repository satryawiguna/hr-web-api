<?php

namespace App\Infrastructures\HumanResources\MasterData\Position\Contracts;

use App\Infrastructures\Contracts\EloquentRepositoryInterface;

interface EloquentPositionRepositoryInterface extends EloquentRepositoryInterface
{
    //<editor-fold desc="#public (method)">

    /**
     * @param int $parentId
     * @return mixed
     */
    public function findWhereByParentId(int $parentId);

    /**
     * @return mixed
     */
    public function findWhereByParentIdIsNull();

    /**
     * @param int $companyId
     * @return mixed
     */
    public function findWhereByCompanyId(int $companyId);

    /**
     * @param int $isActive
     * @return mixed
     */
    public function findWhereByIsActive(int $isActive);

    /**
     * @param string $searchQuery
     * @return mixed
     */
    public function findWhereBySearchQuery(string $searchQuery);

    /**
     * @param int $id
     * @return mixed
     */
    public function findWhereNotEqualById(int $id);

    //</editor-fold>
}

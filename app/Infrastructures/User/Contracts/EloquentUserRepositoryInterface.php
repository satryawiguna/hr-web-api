<?php

namespace App\Infrastructures\User\Contracts;

use App\Infrastructures\Contracts\EloquentRepositoryInterface;

interface EloquentUserRepositoryInterface extends EloquentRepositoryInterface
{
    //<editor-fold desc="#public (method)">

    /**
     * @param $companyId
     * @return mixed
     */
    public function findWhereHasCompanyByCompanyId(int $companyId);

    /**
     * @param int $applicationId
     * @return mixed
     */
    public function findWhereHasApplicationByApplicationId(int $applicationId);

    /**
     * @param int $applicationId
     * @return mixed
     */
    public function findWhereHasCompanyByApplicationId(int $applicationId);

    /**
     * @param int $roleId
     * @return mixed
     */
    public function findWhereHasRoleByRoleId(int $roleId);

    /**
     * @param $permissionId
     * @return mixed
     */
    public function findWhereHasPermissionByPermissionId(int $permissionId);

    /**
     * @param $isActive
     * @return mixed
     */
    public function findWhereByIsActive(int $isActive);

    /**
     * @param $isBlock
     * @return mixed
     */
    public function findWhereByIsBlock(int $isBlock);

    /**
     * @param $searchQuery
     * @return mixed
     */
    public function findWhereBySearchQuery(string $searchQuery);

    //</editor-fold>
}

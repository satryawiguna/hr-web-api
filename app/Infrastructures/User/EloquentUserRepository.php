<?php
namespace App\Infrastructures\User;

use App\Infrastructures\User\Contracts\EloquentUserRepositoryInterface;
use App\Infrastructures\EloquentRepositoryAbstract;
use function foo\func;

/**
 * EloquentUserRepository Class.
 */
class EloquentUserRepository extends EloquentRepositoryAbstract implements EloquentUserRepositoryInterface
{
    //<editor-fold desc="#public (method)">

    /**
     * @param int $companyId
     * @return $this
     */
    public function findWhereHasCompanyByCompanyId(int $companyId)
    {
        $this->model = $this->model->whereHas('companies', function($q) use($companyId) {
            return $q->where('id', '=', $companyId);
        });

        return $this;
    }

    public function findWhereHasApplicationByApplicationId(int $applicationId)
    {
        $this->model = $this->model->whereHas('applications', function($q) use($applicationId) {
            return $q->where('id', '=', $applicationId);
        });

        return $this;
    }

    public function findWhereHasCompanyByApplicationId(int $applicationId)
    {
        $this->model = $this->model->whereHas('companies', function($q) use($applicationId) {
            return $q->whereHas('applications', '=', $applicationId);
        });

        return $this;
    }

    /**
     * @param int $roleId
     * @return $this|mixed
     */
    public function findWhereHasRoleByRoleId(int $roleId)
    {
        $this->model = $this->model->whereHas('roles', function($q) use($roleId) {
            return $q->where('id', '=', $roleId);
        });

        return $this;
    }

    /**
     * @param $permissionId
     * @return $this|mixed
     */
    public function findWhereHasPermissionByPermissionId($permissionId)
    {
        $this->model = $this->model->whereHas('permissions', function($q) use($permissionId) {
            return $q->where('id', '=', $permissionId);
        });

        return $this;
    }

    /**
     * @param $isActive
     * @return $this|mixed
     */
    public function findWhereByIsActive($isActive)
    {
        $this->model = $this->model->where('is_active', $isActive);

        return $this;
    }

    /**
     * @param $isBlock
     * @return $this|mixed
     */
    public function findWhereByIsBlock($isBlock)
    {
        $this->model = $this->model->where('is_block', $isBlock);

        return $this;
    }

    /**
     * @param $searchQuery
     * @return $this|mixed
     */
    public function findWhereBySearchQuery($searchQuery)
    {
        $this->model = $this->model->where('username', 'LIKE', '%' . $searchQuery . '%')
            ->orWhere('email', 'LIKE', '%' . $searchQuery . '%');

        return $this;
    }

    //</editor-fold>
}

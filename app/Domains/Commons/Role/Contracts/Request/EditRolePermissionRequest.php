<?php


namespace App\Domains\Commons\Role\Contracts\Request;


use App\Core\Services\Request\AuditableRequest;

class EditRolePermissionRequest extends AuditableRequest
{
    public $id;

    public $permission_ids;

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id): void
    {
        $this->id = $id;
    }

    /**
     * @return mixed
     */
    public function getPermissionIds()
    {
        return $this->permission_ids;
    }

    /**
     * @param mixed $permission_ids
     */
    public function setPermissionIds($permission_ids): void
    {
        $this->permission_ids = $permission_ids;
    }
}
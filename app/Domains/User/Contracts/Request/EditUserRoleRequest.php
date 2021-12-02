<?php


namespace App\Domains\User\Contracts\Request;


use App\Core\Services\Request\AuditableRequest;

class EditUserRoleRequest extends AuditableRequest
{
    public $id;

    public $role_ids;

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
    public function getRoleIds()
    {
        return $this->role_ids;
    }

    /**
     * @param mixed $role_ids
     */
    public function setRoleIds($role_ids): void
    {
        $this->role_ids = $role_ids;
    }
}
<?php


namespace App\Domains\Commons\Permission\Contracts\Request;


use App\Core\Services\Request\AuditableRequest;

class EditPermissionAccessRequest extends AuditableRequest
{
    public $id;

    public $access_ids;

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
    public function getAccessIds()
    {
        return $this->access_ids;
    }

    /**
     * @param mixed $access_ids
     */
    public function setAccessIds($access_ids): void
    {
        $this->access_ids = $access_ids;
    }
}
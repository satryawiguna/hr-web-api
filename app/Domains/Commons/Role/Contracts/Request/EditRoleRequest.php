<?php


namespace App\Domains\Commons\Role\Contracts\Request;


use App\Core\Services\Request\AuditableRequest;

class EditRoleRequest extends AuditableRequest
{    
    public $id;

    public $group_id;

    public $name;

    public $slug;

    public $description;    

    public $is_active;

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
    public function getGroupId()
    {
        return $this->group_id;
    }

    /**
     * @param mixed $group_id
     */
    public function setGroupId($group_id)
    {
        $this->group_id = $group_id;
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param mixed $name
     */
    public function setName($name): void
    {
        $this->name = $name;
    }

    /**
     * @return mixed
     */
    public function getSlug()
    {
        return $this->slug;
    }

    /**
     * @param mixed $slug
     */
    public function setSlug($slug): void
    {
        $this->slug = $slug;
    }

    /**
     * @return mixed
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param mixed $description
     */
    public function setDescription($description): void
    {
        $this->description = $description;
    }

    /**
     * @return mixed
     */
    public function getIsActive()
    {
        return $this->is_active;
    }

    /**
     * @param mixed $is_active
     */
    public function setIsActive($is_active)
    {
        $this->is_active = $is_active;
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

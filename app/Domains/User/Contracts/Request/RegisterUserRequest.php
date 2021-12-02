<?php


namespace App\Domains\User\Contracts\Request;


use App\Core\Services\Request\AuditableRequest;

class RegisterUserRequest extends AuditableRequest
{
    public $group;

    //Profile
    public $full_name;

    public $nick_name;

    //User
    public $application_id;

    public $email;

    public $username;

    public $password;

    public $confirm_password;

    //Company
    public $company_category_id;

    public $employee_number_scale_id;

    public $name;

    public $slug;

    public $application_ids;


    /**
     * @return mixed
     */
    public function getGroup()
    {
        return $this->group;
    }

    /**
     * @param mixed $group
     */
    public function setGroup($group): void
    {
        $this->group = $group;
    }

    /**
     * @return mixed
     */
    public function getFullName()
    {
        return $this->full_name;
    }

    /**
     * @param mixed $full_name
     */
    public function setFullName($full_name): void
    {
        $this->full_name = $full_name;
    }

    /**
     * @return mixed
     */
    public function getNickName()
    {
        return $this->nick_name;
    }

    /**
     * @param mixed $nick_name
     */
    public function setNickName($nick_name): void
    {
        $this->nick_name = $nick_name;
    }

    /**
     * @return mixed
     */
    public function getApplicationId()
    {
        return $this->application_id;
    }

    /**
     * @param mixed $application_id
     */
    public function setApplicationId($application_id): void
    {
        $this->application_id = $application_id;
    }

    /**
     * @return mixed
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param mixed $email
     */
    public function setEmail($email): void
    {
        $this->email = $email;
    }

    /**
     * @return mixed
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * @param mixed $username
     */
    public function setUsername($username): void
    {
        $this->username = $username;
    }

    /**
     * @return mixed
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * @param mixed $password
     */
    public function setPassword($password): void
    {
        $this->password = $password;
    }

    /**
     * @return mixed
     */
    public function getConfirmPassword()
    {
        return $this->confirm_password;
    }

    /**
     * @param mixed $confirm_password
     */
    public function setConfirmPassword($confirm_password): void
    {
        $this->confirm_password = $confirm_password;
    }

    /**
     * @return mixed
     */
    public function getCompanyCategoryId()
    {
        return $this->company_category_id;
    }

    /**
     * @param mixed $company_category_id
     */
    public function setCompanyCategoryId($company_category_id): void
    {
        $this->company_category_id = $company_category_id;
    }

    /**
     * @return mixed
     */
    public function getEmployeeNumberScaleId()
    {
        return $this->employee_number_scale_id;
    }

    /**
     * @param mixed $employee_number_scale_id
     */
    public function setEmployeeNumberScaleId($employee_number_scale_id): void
    {
        $this->employee_number_scale_id = $employee_number_scale_id;
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
    public function getApplicationIds()
    {
        return $this->application_ids;
    }

    /**
     * @param mixed $application_ids
     */
    public function setApplicationIds($application_ids): void
    {
        $this->application_ids = $application_ids;
    }
}
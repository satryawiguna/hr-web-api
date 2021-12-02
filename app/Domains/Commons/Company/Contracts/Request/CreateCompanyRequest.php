<?php


namespace App\Domains\Commons\Company\Contracts\Request;


use App\Core\Services\Request\AuditableRequest;

class CreateCompanyRequest extends AuditableRequest
{
    public $company_category_id;

    public $employee_number_scale_id;

    public $name;

    public $slug;

    public $email;

    public $url;

    public $latitude;

    public $longitude;

    public $description;

    public $is_active;

    public $media_libraries;

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
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * @param mixed $url
     */
    public function setUrl($url): void
    {
        $this->url = $url;
    }

    /**
     * @return mixed
     */
    public function getLatitude()
    {
        return $this->latitude;
    }

    /**
     * @param mixed $latitude
     */
    public function setLatitude($latitude): void
    {
        $this->latitude = $latitude;
    }

    /**
     * @return mixed
     */
    public function getLongitude()
    {
        return $this->longitude;
    }

    /**
     * @param mixed $longitude
     */
    public function setLongitude($longitude): void
    {
        $this->longitude = $longitude;
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
    public function setIsActive($is_active): void
    {
        $this->is_active = $is_active;
    }

    /**
     * @return mixed
     */
    public function getMediaLibraries()
    {
        return $this->media_libraries;
    }

    /**
     * @param mixed $media_libraries
     */
    public function setMediaLibraries($media_libraries): void
    {
        $this->media_libraries = $media_libraries;
    }
}

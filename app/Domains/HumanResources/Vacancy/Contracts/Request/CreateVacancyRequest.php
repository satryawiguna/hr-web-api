<?php
namespace App\Domains\HumanResources\Vacancy\Contracts\Request;

use App\Core\Services\Request\AuditableRequest;

class CreateVacancyRequest extends AuditableRequest
{
    public $company_id;

    public $vacancy_location_id;

    public $vacancy_category_id;

    public $title;

    public $slug;

    public $publish_date;

    public $expired_date;

    public $min_salary;

    public $max_salary;

    public $reference_code;

    public $intro;

    public $description;

    public $requirement;

    public $needs;

    public $work_status;

    public $work_type;

    public $status;

    // Attach
    public $degree;

    public $skill;

    public $additional_question;

    /**
     * @return mixed
     */
    public function getCompanyId()
    {
        return $this->company_id;
    }

    /**
     * @param mixed $company_id
     */
    public function setCompanyId($company_id): void
    {
        $this->company_id = $company_id;
    }

    /**
     * @return mixed
     */
    public function getDegree()
    {
        return $this->degree;
    }

    /**
     * @param mixed $degree
     */
    public function setDegree($degree): void
    {
        $this->degree = $degree;
    }

    /**
     * @return mixed
     */
    public function getSkill()
    {
        return $this->skill;
    }

    /**
     * @param mixed $skill
     */
    public function setSkill($skill): void
    {
        $this->skill = $skill;
    }

    /**
     * @return mixed
     */
    public function getAdditionalQuestion()
    {
        return $this->additional_question;
    }

    /**
     * @param mixed $additional_question
     */
    public function setAdditionalQuestion($additional_question): void
    {
        $this->additional_question = $additional_question;
    }
}

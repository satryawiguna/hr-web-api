<?php
namespace App\Infrastructures\HumanResources\Recruitment\VacancyApplicant;

use App\Infrastructures\HumanResources\Recruitment\VacancyApplicant\Contracts\EloquentVacancyApplicantRepositoryInterface;
use App\Infrastructures\EloquentRepositoryAbstract;

/**
 * EloquentVacancyApplicantRepository Class.
 */
class EloquentVacancyApplicantRepository extends EloquentRepositoryAbstract implements EloquentVacancyApplicantRepositoryInterface
{
    //<editor-fold desc="#public (method)">

    /**
     * @param int $applicantId
     * @return $this|mixed
     */
    public function findWhereByApplicantId(int $applicantId)
    {
        $this->model = $this->model->where('applicant_id', $applicantId);

        return $this;
    }

    /**
     * @param int $vacancyId
     * @return $this|mixed
     */
    public function findWhereByVacancyId(int $vacancyId)
    {
        $this->model = $this->model->where('vacancy_id', $vacancyId);

        return $this;
    }

    /**
     * @param int $recruitmentStageId
     * @return $this|mixed
     */
    public function findWhereByRecruitmentStageId(int $recruitmentStageId)
    {
        $this->model = $this->model->where('recruitment_stage_id', $recruitmentStageId);

        return $this;
    }

    /**
     * @param string $rating
     * @return $this|mixed
     */
    public function findWhereByRating(string $rating)
    {
        $this->model = $this->model->where('rating', $rating);

        return $this;
    }

    /**
     * @param string $searchQuery
     * @return $this|mixed
     */
    public function findWhereBySearchQuery(string $searchQuery)
    {
        $searchParameter = [
            'cover_letter' => '%' . $searchQuery . '%'
        ];

        $this->model = $this->model->whereRaw('(cover_letter LIKE ?)', $searchParameter);

        return $this;
    }

    //</editor-fold>
}

<?php
namespace App\Infrastructures\HumanResources\Recruitment;

use App\Infrastructures\HumanResources\Recruitment\Contracts\EloquentVacancyApplicantRepositoryInterface;
use App\Infrastructures\EloquentRepositoryAbstract;
use DateTime;
use Illuminate\Support\Facades\Config;

/**
 * EloquentVacancyApplicantRepository Class.
 */
class EloquentVacancyApplicantRepository extends EloquentRepositoryAbstract implements EloquentVacancyApplicantRepositoryInterface
{
    //<editor-fold desc="#public (method)">

    /**
     * @param int $vacancyId
     * @return $this|mixed
     */
    public function findWhereByApplicantId(int $vacancyId)
    {
        $this->model = $this->model->where('applicant_id', $vacancyId);

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
     * @param string $searchQuery
     * @return $this|mixed
     */
    public function findWhereBySearchQuery(string $searchQuery)
    {
        $this->model = $this->model->where('cover_letter', 'LIKE', '%' . $searchQuery . '%');

        return $this;
    }

    //</editor-fold>
}

<?php

namespace App\Infrastructures\HumanResources\Recruitment\VacancyApplicant\Contracts;

use App\Infrastructures\Contracts\EloquentRepositoryInterface;

interface EloquentVacancyApplicantRepositoryInterface extends EloquentRepositoryInterface
{
    //<editor-fold desc="#public (method)">

    /**
     * @param int $applicantId
     * @return mixed
     */
    public function findWhereByApplicantId(int $applicantId);

    /**
     * @param int $vacancyId
     * @return mixed
     */
    public function findWhereByVacancyId(int $vacancyId);

    /**
     * @param int $recruitmentStageId
     * @return mixed
     */
    public function findWhereByRecruitmentStageId(int $recruitmentStageId);

    /**
     * @param string $rating
     * @return mixed
     */
    public function findWhereByRating(string $rating);

    /**
     * @param string $searchQuery
     * @return mixed
     */
    public function findWhereBySearchQuery(string $searchQuery);

    //</editor-fold>
}

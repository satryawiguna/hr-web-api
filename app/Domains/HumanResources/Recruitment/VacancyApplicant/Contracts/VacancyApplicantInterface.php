<?php

namespace App\Domains\HumanResources\Recruitment\VacancyApplicant\Contracts;

use App\Domains\Contracts\BaseEntityInterface;

interface VacancyApplicantInterface extends BaseEntityInterface
{
    //<editor-fold desc="#constanta">

    const TABLE_NAME = 'vacancy_applications';
    const MORPH_NAME = 'vacancy_applications';

    //</editor-fold>


    //<editor-fold desc="#property">

    /**
     * Get applicant_id.
     *
     * @return mixed
     */
    public function getApplicantId();
    
    /**
     * Set applicant_id.
     *
     * @param $applicant_id
     *
     * @return mixed
     */
    public function setApplicantId($applicant_id);

    /**
     * Get vacancy_id.
     *
     * @return mixed
     */
    public function getVacancyId();
    
    /**
     * Set vacancy_id.
     *
     * @param $vacancy_id
     *
     * @return mixed
     */
    public function setVacancyId($vacancy_id);

    /**
     * Get recruitment_stage_id.
     *
     * @return mixed
     */
    public function getRecruitmentStageId();
    
    /**
     * Set recruitment_stage_id.
     *
     * @param $recruitment_stage_id
     *
     * @return mixed
     */
    public function setRecruitmentStageId($recruitment_stage_id);

    /**
     * Get cover_letter.
     *
     * @return mixed
     */
    public function getCoverLetter();
    
    /**
     * Set cover_letter.
     *
     * @param $cover_letter
     *
     * @return mixed
     */
    public function setCoverLetter($cover_letter);

    /**
     * Get rating.
     *
     * @return mixed
     */
    public function getRating();
    
    /**
     * Set rating.
     *
     * @param $rating
     *
     * @return mixed
     */
    public function setRating($rating);

    //</editor-fold>


    //<editor-fold desc="#public (method)">


    //<editor-fold desc="#belongs to relation">

    /**
     * @return mixed
     */
    public function applicant();

    /**
     * @return mixed
     */
    public function vacancy();

    /**
     * @return mixed
     */
    public function recruitment_stage();

    //</editor-fold>


    //<editor-fold desc="#has many relation">
    //</editor-fold>


    //</editor-fold>
}

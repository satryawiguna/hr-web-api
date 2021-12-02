<?php

namespace App\Domains\HumanResources\Recruitment\RecruitmentSchedule\Contracts;

use App\Domains\Contracts\BaseEntityInterface;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

interface RecruitmentScheduleInterface extends BaseEntityInterface
{
    //<editor-fold desc="#constanta">

    const TABLE_NAME = 'recruitment_schedule';
    const MORPH_NAME = 'recruitment_schedule';

    //</editor-fold>


    //<editor-fold desc="#property">

    /**
     * Get vacancy_application_id.
     *
     * @return mixed
     */
    public function getVacancyApplicationId();

    /**
     * Set vacancy_application_id.
     *
     * @param $vacancy_application_id
     *
     * @return mixed
     */
    public function setVacancyApplicationId($vacancy_application_id);

    /**
     * Get schedule_date.
     *
     * @return mixed
     */
    public function getScheduleDate();

    /**
     * Set schedule_date.
     *
     * @param $schedule_date
     *
     * @return mixed
     */
    public function setScheduleDate($schedule_date);

    //</editor-fold>


    //<editor-fold desc="#public (method)">


    //<editor-fold desc="#belongs to relation">

    /**
     * @return mixed
     */
    public function vacancyApplication();

    //</editor-fold>
}

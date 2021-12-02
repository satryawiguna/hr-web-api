<?php
namespace App\Domains\HumanResources\Recruitment\VacancyApplicationNote\Contracts;

use App\Domains\Contracts\BaseEntityInterface;

interface VacancyApplicationNoteInterface extends BaseEntityInterface
{
    //<editor-fold desc="#constanta">

    const TABLE_NAME = 'vacancy_application_notes';
    const MORPH_NAME = 'vacancy_application_notes';

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
     * Get note.
     *
     * @return mixed
     */
    public function getNote();
    
    /**
     * Set note.
     *
     * @param $note
     *
     * @return mixed
     */
    public function setNote($note);

    //</editor-fold>


    //<editor-fold desc="#public (method)">


    //<editor-fold desc="#belongs to relation">

    /**
     * @return mixed
     */
    public function vacancy_application();

    //</editor-fold>


    //<editor-fold desc="#has many relation">
    //</editor-fold>


    //</editor-fold>
}

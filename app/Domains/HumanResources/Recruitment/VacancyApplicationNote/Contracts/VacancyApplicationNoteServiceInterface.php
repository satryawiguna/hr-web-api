<?php

namespace App\Domains\HumanResources\Recruitment\VacancyApplicationNote\Contracts;

/**
 * Interface VacancyApplicationNoteServiceInterface.
 */
interface VacancyApplicationNoteServiceInterface
{
    //<editor-fold desc="#constructor">

    /**
     * VacancyApplicationNoteServiceInterface constructor.
     *
     * @param VacancyApplicationNoteRepositoryInterface $repository
     */
    public function __construct(VacancyApplicationNoteRepositoryInterface $repository);

    //</editor-fold>


    //<editor-fold desc="#public (method)">

    /**
     * Create VacancyApplicationNote.
     *
     * @param VacancyApplicationNoteInterface $VacancyApplicationNote
     *
     * @return mixed
     */
    public function create(VacancyApplicationNoteInterface $VacancyApplicationNote);

    /**
     * Update VacancyApplicationNote.
     *
     * @param VacancyApplicationNoteInterface $VacancyApplicationNote
     *
     * @return mixed
     */
    public function update(VacancyApplicationNoteInterface $VacancyApplicationNote);

    /**
     * Delete VacancyApplicationNote.
     *
     * @param VacancyApplicationNoteInterface $VacancyApplicationNote
     *
     * @return mixed
     */
    public function delete(VacancyApplicationNoteInterface $VacancyApplicationNote);

    //</editor-fold>
}

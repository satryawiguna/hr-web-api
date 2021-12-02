<?php

namespace App\Domains\HumanResources\Recruitment\VacancyApplicationNote\Contracts;

use App\Domains\Contracts\HasEloquentStorageRepositoryInterface;
use App\Infrastructures\HumanResources\Recruitment\VacancyApplicationNote\Contracts\EloquentVacancyApplicationNoteRepositoryInterface;
use App\Domains\Contracts\BaseEntityInterface;
use Closure;

/**
 * Interface VacancyApplicationNoteRepositoryInterface.
 */
interface VacancyApplicationNoteRepositoryInterface
{
    //<editor-fold desc="#constructor">
    
    /**
     * VacancyApplicationNoteRepositoryInterface constructor.
     *
     * @param EloquentVacancyApplicationNoteRepositoryInterface $eloquent
     */
    public function __construct(EloquentVacancyApplicationNoteRepositoryInterface $eloquent);

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

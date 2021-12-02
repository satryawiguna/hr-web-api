<?php

namespace App\Domains\HumanResources\Recruitment\VacancyApplicationNote;

use App\Domains\HumanResources\Recruitment\VacancyApplicationNote\Contracts\VacancyApplicationNoteRepositoryInterface;
use App\Infrastructures\HumanResources\Recruitment\VacancyApplicationNote\Contracts\EloquentVacancyApplicationNoteRepositoryInterface;
use App\Domains\HumanResources\Recruitment\VacancyApplicationNote\Contracts\VacancyApplicationNoteInterface;
use App\Domains\RepositoryAbstract;
use App\Domains\Contracts\BaseEntityInterface;
use Closure;

/**
 * Class VacancyApplicationNoteRepository.
 */
class VacancyApplicationNoteRepository extends RepositoryAbstract implements VacancyApplicationNoteRepositoryInterface
{
    //<editor-fold desc="#constructor">

    /**
     * VacancyApplicationNoteRepository constructor.
     *
     * @param EloquentVacancyApplicationNoteRepositoryInterface $eloquent
     */
    public function __construct(EloquentVacancyApplicationNoteRepositoryInterface $eloquent)
    {
        parent::__construct($eloquent);
    }

    //</editor-fold>


    //<editor-fold desc="#public (method)">

    /**
     * Setup payload.
     *
     * @return array
     */
    public function setupPayload(VacancyApplicationNoteInterface $VacancyApplicationNote)
    {
        return [
            'vacancy_application_id' => $VacancyApplicationNote->getVacancyApplicationId(),
            'note' => $VacancyApplicationNote->getNote(),
            
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function create(VacancyApplicationNoteInterface $VacancyApplicationNote)
    {
        $data = $this->setupPayload($VacancyApplicationNote);

        return $this->eloquent()->create($data);
    }

    /**
     * {@inheritdoc}
     */
    public function update(VacancyApplicationNoteInterface $VacancyApplicationNote)
    {
        $data = $this->setupPayload($VacancyApplicationNote);
       
        return $this->eloquent()->update($data, $VacancyApplicationNote->getKey());
    }

    /**
     * {@inheritdoc}
     */
    public function delete(VacancyApplicationNoteInterface $VacancyApplicationNote)
    {
        return $this->eloquent()->delete($VacancyApplicationNote->getKey());
    }

    //</editor-fold>
}

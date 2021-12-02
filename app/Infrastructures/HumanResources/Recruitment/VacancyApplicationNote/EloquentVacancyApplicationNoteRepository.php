<?php
namespace App\Infrastructures\HumanResources\Recruitment\VacancyApplicationNote;

use App\Infrastructures\HumanResources\Recruitment\VacancyApplicationNote\Contracts\EloquentVacancyApplicationNoteRepositoryInterface;
use App\Infrastructures\EloquentRepositoryAbstract;

/**
 * EloquentVacancyApplicationNoteRepository Class.
 */
class EloquentVacancyApplicationNoteRepository extends EloquentRepositoryAbstract implements EloquentVacancyApplicationNoteRepositoryInterface
{
    //<editor-fold desc="#public (method)">

    /**
     * @param int $vacancyApplicationId
     * @return $this|mixed
     */
    public function findWhereByVacancyApplicationId(int $vacancyApplicationId)
    {
        $this->model = $this->model->where('vacancy_application_id', $vacancyApplicationId);

        return $this;
    }

    /**
     * @param string $searchQuery
     * @return $this|mixed
     */
    public function findWhereBySearchQuery(string $searchQuery)
    {
        $searchParameter = [
            'note' => '%' . $searchQuery . '%'
        ];

        $this->model = $this->model->whereRaw('(note LIKE ?)', $searchParameter);

        return $this;
    }

    //</editor-fold>
}

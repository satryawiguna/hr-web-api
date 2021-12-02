<?php
namespace App\Infrastructures\HumanResources\MasterData\AdditionalQuestion;

use App\Infrastructures\HumanResources\MasterData\AdditionalQuestion\Contracts\EloquentAdditionalQuestionRepositoryInterface;
use App\Infrastructures\EloquentRepositoryAbstract;

/**
 * EloquentAdditionalQuestionRepository Class.
 */
class EloquentAdditionalQuestionRepository extends EloquentRepositoryAbstract implements EloquentAdditionalQuestionRepositoryInterface
{
    //<editor-fold desc="#public (method)">

    /**
     * @param int $companyId
     * @return $this|mixed
     */
    public function findWhereByCompanyId(int $companyId)
    {
        $this->model = $this->model->where('company_id', $companyId);

        return $this;
    }

    /**
     * @param int $isRequired
     * @return $this|mixed
     */
    public function findWhereByIsRequired(int $isRequired)
    {
        $this->model = $this->model->where('is_required', $isRequired);

        return $this;
    }

    /**
     * @param string $status
     * @return $this|mixed
     */
    public function findWhereByStatus(string $status)
    {
        $this->model = $this->model->where('status', $status);

        return $this;
    }

    /**
     * @param string $searchQuery
     * @return $this|mixed
     */
    public function findWhereBySearchQuery(string $searchQuery)
    {
        $searchParameter = [
            'question' => '%' . $searchQuery . '%'
        ];

        $this->model = $this->model->whereRaw('(question LIKE ?)', $searchParameter);

        return $this;
    }

    //</editor-fold>
}

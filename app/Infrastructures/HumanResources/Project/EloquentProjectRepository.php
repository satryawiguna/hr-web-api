<?php
namespace App\Infrastructures\HumanResources\Project;

use App\Infrastructures\HumanResources\Project\Contracts\EloquentProjectRepositoryInterface;
use App\Infrastructures\EloquentRepositoryAbstract;
use DateTime;
use Illuminate\Support\Facades\Config;

/**
 * EloquentProjectRepository Class.
 */
class EloquentProjectRepository extends EloquentRepositoryAbstract implements EloquentProjectRepositoryInterface
{
    //<editor-fold desc="#public (method)">

    /**
     * @param int $parentId
     * @return $this
     */
    public function findWhereByParentId(int $parentId)
    {
        $this->model = $this->model->where('parent_id', $parentId);

        return $this;
    }

    /**
     * @return $this|mixed
     */
    public function findWhereByParentIdIsNull()
    {
        $this->model = $this->model->where('parent_id', null);

        return $this;
    }

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
     * @param int $contractTypeId
     * @return $this|mixed
     */
    public function findWhereByContractTypeId(int $contractTypeId)
    {
        $this->model = $this->model->where('contract_type_id', $contractTypeId);

        return $this;
    }

    /**
     * @param DateTime $date
     * @return $this|mixed
     */
    public function findWhereDateByDate(DateTime $date)
    {
        $this->model = $this->model->whereDate('start_date', '<=', $date->format(Config::get('datetime.format.default')))
            ->whereDate('end_date', '>=', $date->format(Config::get('datetime.format.default')));

        return $this;
    }

    /**
     * @param DateTime $startIssueDate
     * @param DateTime $endIssueDate
     * @return $this|mixed
     */
    public function findWhereBetweenByRangeIssueDate(DateTime $startIssueDate, DateTime $endIssueDate)
    {
        $this->model = $this->model->whereBetween('issue_date', [
            $startIssueDate->format(Config::get('datetime.format.default')),
            $endIssueDate->format(Config::get('datetime.format.default'))
        ]);

        return $this;
    }

    /**
     * @param float $startValue
     * @param float $endValue
     * @return $this|mixed
     */
    public function findWhereBetweenByRangeValue(float $startValue, float $endValue)
    {
        $this->model = $this->model->whereBetween('value', [$startValue, $endValue]);

        return $this;
    }

    /**
     * @param string $searchQuery
     * @return $this|mixed
     */
    public function findWhereBySearchQuery(string $searchQuery)
    {
        $searchParameter = [
            'reference_number' => '%' . $searchQuery . '%',
            'name' => '%' . $searchQuery . '%',
            'first_party_number' => '%' . $searchQuery . '%',
            'second_party_number' => '%' . $searchQuery . '%',
            'activity' => '%' . $searchQuery . '%',
            'description' => '%' . $searchQuery . '%'
        ];

        $this->model = $this->model->whereRaw('(reference_number LIKE ?
            OR name LIKE ?
            OR first_party_number LIKE ?
            OR second_party_number LIKE ?
            OR activity LIKE ?
            OR description LIKE ?)', $searchParameter);

        return $this;
    }

    //</editor-fold>
}

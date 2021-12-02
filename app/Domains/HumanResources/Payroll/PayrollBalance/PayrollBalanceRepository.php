<?php

namespace App\Domains\HumanResources\Payroll\PayrollBalance;

use App\Core\Domains\Contracts\Pagination\ListedSearchParameter;
use App\Core\Domains\Contracts\Pagination\PagedSearchParameter;
use App\Domains\HumanResources\Payroll\PayrollBalance\Contracts\PayrollBalanceRepositoryInterface;
use App\Infrastructures\HumanResources\Payroll\PayrollBalance\Contracts\EloquentPayrollBalanceRepositoryInterface;
use App\Domains\HumanResources\Payroll\PayrollBalance\Contracts\PayrollBalanceInterface;
use App\Domains\RepositoryAbstract;
use App\Domains\Contracts\BaseEntityInterface;
use Closure;

/**
 * Class PayrollBalanceRepository.
 */
class PayrollBalanceRepository extends RepositoryAbstract implements PayrollBalanceRepositoryInterface
{
    //<editor-fold desc="#constructor">

    /**
     * PayrollBalanceRepository constructor.
     *
     * @param EloquentPayrollBalanceRepositoryInterface $eloquent
     */
    public function __construct(EloquentPayrollBalanceRepositoryInterface $eloquent)
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
    public function setupPayload(PayrollBalanceInterface $PayrollBalance)
    {
        return [
            'name' => $PayrollBalance->getName(),
            'slug' => $PayrollBalance->getSlug(),
            'description' => $PayrollBalance->getDescription(),
            'created_by' => $PayrollBalance->getCreatedBy(),
            'modified_by' => $PayrollBalance->getModifiedBy(),
            
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function create(PayrollBalanceInterface $PayrollBalance)
    {
        $data = $this->setupPayload($PayrollBalance);

        return $this->eloquent()->create($data);
    }

    /**
     * {@inheritdoc}
     */
    public function update(PayrollBalanceInterface $PayrollBalance)
    {
        $data = $this->setupPayload($PayrollBalance);
       
        return $this->eloquent()->update($data, $PayrollBalance->getKey());
    }

    /**
     * {@inheritdoc}
     */
    public function delete(PayrollBalanceInterface $PayrollBalance)
    {
        return $this->eloquent()->delete($PayrollBalance->getKey());
    }

    /**
     * @return mixed
     */
    public function payrollBalanceList()
    {
        return $this->eloquent->all();
    }

    /**
     * @param ListedSearchParameter $parameter
     * @param bool $count
     * @return mixed
     */
    public function payrollBalanceListSearch(ListedSearchParameter $parameter, bool $count = false)
    {
        $searchQuery = $parameter->query;

        if ($searchQuery) {
            $this->eloquent->findWhereBySearchQuery($searchQuery);
        }

        if (!$count) {
            return $this->eloquent->all();
        } else {
            return $this->eloquent->all()->count();
        }
    }

    /**
     * @param PagedSearchParameter $parameter
     * @param bool $count
     * @return mixed
     */
    public function payrollBalancePageSearch(PagedSearchParameter $parameter, bool $count = false)
    {
        $searchQuery = !is_null($parameter->search) ? $parameter->search['value'] : $parameter->query['value'] ?? null;

        if ($searchQuery) {
            $this->eloquent->findWhereBySearchQuery($searchQuery);
        }

        if (!$count) {
            if ($parameter->draw) {
                return $this->eloquent->orderBy($parameter->columns[$parameter->order[0]['column']]['data'], $parameter->order[0]['dir'])
                    ->paginate($parameter->length, $parameter->start);
            } else {
                return $this->eloquent->orderBy($parameter->sort['field'], $parameter->sort['sort'])
                    ->paginate($parameter->pagination['perpage'], ($parameter->pagination['perpage'] * ($parameter->pagination['page'] - 1)));
            }
        } else {
            return $this->eloquent->all()->count();
        }

    }

    //</editor-fold>
}

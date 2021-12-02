<?php

namespace App\Domains\HumanResources\Payroll\PayrollBalanceFeed;

use App\Core\Domains\Contracts\Pagination\ListedSearchParameter;
use App\Core\Domains\Contracts\Pagination\PagedSearchParameter;
use App\Domains\HumanResources\Payroll\PayrollBalanceFeed\Contracts\PayrollBalanceFeedRepositoryInterface;
use App\Infrastructures\HumanResources\Payroll\PayrollBalanceFeed\Contracts\EloquentPayrollBalanceFeedRepositoryInterface;
use App\Domains\HumanResources\Payroll\PayrollBalanceFeed\Contracts\PayrollBalanceFeedInterface;
use App\Domains\RepositoryAbstract;
use App\Domains\Contracts\BaseEntityInterface;
use Closure;

/**
 * Class PayrollBalanceFeedRepository.
 */
class PayrollBalanceFeedRepository extends RepositoryAbstract implements PayrollBalanceFeedRepositoryInterface
{
    //<editor-fold desc="#constructor">

    /**
     * PayrollBalanceFeedRepository constructor.
     *
     * @param EloquentPayrollBalanceFeedRepositoryInterface $eloquent
     */
    public function __construct(EloquentPayrollBalanceFeedRepositoryInterface $eloquent)
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
    public function setupPayload(PayrollBalanceFeedInterface $PayrollBalanceFeed)
    {
        return [
            'payroll_balance_id' => $PayrollBalanceFeed->getPayrollBalanceId(),
            'element_id' => $PayrollBalanceFeed->getElementId(),
            'element_value_id' => $PayrollBalanceFeed->getElementValueId(),
            'add_or_substract' => $PayrollBalanceFeed->getAddOrSubstract(),
            'created_by' => $PayrollBalanceFeed->getCreatedBy(),
            'modified_by' => $PayrollBalanceFeed->getModifiedBy(),
            
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function create(PayrollBalanceFeedInterface $PayrollBalanceFeed)
    {
        $data = $this->setupPayload($PayrollBalanceFeed);

        return $this->eloquent()->create($data);
    }

    /**
     * {@inheritdoc}
     */
    public function update(PayrollBalanceFeedInterface $PayrollBalanceFeed)
    {
        $data = $this->setupPayload($PayrollBalanceFeed);
       
        return $this->eloquent()->update($data, $PayrollBalanceFeed->getKey());
    }

    /**
     * {@inheritdoc}
     */
    public function delete(PayrollBalanceFeedInterface $PayrollBalanceFeed)
    {
        return $this->eloquent()->delete($PayrollBalanceFeed->getKey());
    }

    /**
     * @param int|null $payrollBalanceId
     * @param int|null $elementId
     * @param int|null $elementValueId
     * @return mixed
     */
    public function payrollBalanceFeedList(int $payrollBalanceId = null, int $elementId = null, int $elementValueId = null)
    {
        if ($payrollBalanceId != null) {
            $this->eloquent->findWherePayrollBalanceId($payrollBalanceId);
        }

        if ($elementId != null) {
            $this->eloquent->findWhereElementId($elementId);
        }

        if ($elementValueId != null) {
            $this->eloquent->findWhereElementValueId($elementValueId);
        }

        return $this->eloquent->all();
    }

    /**
     * @param ListedSearchParameter $parameter
     * @param int|null $payrollBalanceId
     * @param int|null $elementId
     * @param int|null $elementValueId
     * @param bool $count
     * @return mixed
     */
    public function payrollBalanceFeedListSearch(ListedSearchParameter $parameter, int $payrollBalanceId = null, int $elementId = null, int $elementValueId = null, bool $count = false)
    {
        $searchQuery = $parameter->query;

        if ($searchQuery) {
            $this->eloquent->findWhereBySearchQuery($searchQuery);
        }

        if ($payrollBalanceId != null) {
            $this->eloquent->findWherePayrollBalanceId($payrollBalanceId);
        }

        if ($elementId != null) {
            $this->eloquent->findWhereElementId($elementId);
        }

        if ($elementValueId != null) {
            $this->eloquent->findWhereElementValueId($elementValueId);
        }

        if (!$count) {
            return $this->eloquent->all();
        } else {
            return $this->eloquent->all()->count();
        }
    }

    /**
     * @param PagedSearchParameter $parameter
     * @param int|null $payrollBalanceId
     * @param int|null $elementId
     * @param int|null $elementValueId
     * @param bool $count
     * @return mixed
     */
    public function payrollBalanceFeedPageSearch(PagedSearchParameter $parameter, int $payrollBalanceId = null, int $elementId = null, int $elementValueId = null, bool $count = false)
    {
        $searchQuery = !is_null($parameter->search) ? $parameter->search['value'] : $parameter->query['value'] ?? null;

        if ($searchQuery) {
            $this->eloquent->findWhereBySearchQuery($searchQuery);
        }

        if ($payrollBalanceId != null) {
            $this->eloquent->findWherePayrollBalanceId($payrollBalanceId);
        }

        if ($elementId != null) {
            $this->eloquent->findWhereElementId($elementId);
        }

        if ($elementValueId != null) {
            $this->eloquent->findWhereElementValueId($elementValueId);
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

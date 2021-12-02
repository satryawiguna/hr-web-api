<?php

namespace App\Domains\HumanResources\Payroll\PayrollBatch;

use App\Core\Domains\Contracts\Pagination\ListedSearchParameter;
use App\Core\Domains\Contracts\Pagination\PagedSearchParameter;
use App\Domains\HumanResources\Payroll\PayrollBatch\Contracts\PayrollBatchRepositoryInterface;
use App\Infrastructures\HumanResources\Payroll\PayrollBatch\Contracts\EloquentPayrollBatchRepositoryInterface;
use App\Domains\HumanResources\Payroll\PayrollBatch\Contracts\PayrollBatchInterface;
use App\Domains\RepositoryAbstract;
use App\Domains\Contracts\BaseEntityInterface;
use Closure;

/**
 * Class PayrollBatchRepository.
 */
class PayrollBatchRepository extends RepositoryAbstract implements PayrollBatchRepositoryInterface
{
    //<editor-fold desc="#constructor">

    /**
     * PayrollBatchRepository constructor.
     *
     * @param EloquentPayrollBatchRepositoryInterface $eloquent
     */
    public function __construct(EloquentPayrollBatchRepositoryInterface $eloquent)
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
    public function setupPayload(PayrollBatchInterface $PayrollBatch)
    {
        return [
            'name' => $PayrollBatch->getName(),
            'slug' => $PayrollBatch->getSlug(),
            'description' => $PayrollBatch->getDescription(),
            'created_by' => $PayrollBatch->getCreatedBy(),
            'modified_by' => $PayrollBatch->getModifiedBy(),
            
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function create(PayrollBatchInterface $PayrollBatch)
    {
        $data = $this->setupPayload($PayrollBatch);

        return $this->eloquent()->create($data);
    }

    /**
     * {@inheritdoc}
     */
    public function update(PayrollBatchInterface $PayrollBatch)
    {
        $data = $this->setupPayload($PayrollBatch);
       
        return $this->eloquent()->update($data, $PayrollBatch->getKey());
    }

    /**
     * {@inheritdoc}
     */
    public function delete(PayrollBatchInterface $PayrollBatch)
    {
        return $this->eloquent()->delete($PayrollBatch->getKey());
    }

    /**
     * @return mixed
     */
    public function payrollBatchList()
    {
        return $this->eloquent->all();
    }

    /**
     * @param ListedSearchParameter $parameter
     * @param bool $count
     * @return mixed
     */
    public function payrollBatchListSearch(ListedSearchParameter $parameter, bool $count = false)
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
    public function payrollBatchPageSearch(PagedSearchParameter $parameter, bool $count = false)
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

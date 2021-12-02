<?php

namespace App\Domains\HumanResources\Payroll\PayrollProcessType;

use App\Core\Domains\Contracts\Pagination\ListedSearchParameter;
use App\Core\Domains\Contracts\Pagination\PagedSearchParameter;
use App\Domains\HumanResources\Payroll\PayrollProcessType\Contracts\PayrollProcessTypeRepositoryInterface;
use App\Infrastructures\HumanResources\Payroll\PayrollProcessType\Contracts\EloquentPayrollProcessTypeRepositoryInterface;
use App\Domains\HumanResources\Payroll\PayrollProcessType\Contracts\PayrollProcessTypeInterface;
use App\Domains\RepositoryAbstract;
use App\Domains\Contracts\BaseEntityInterface;
use Closure;

/**
 * Class PayrollProcessTypeRepository.
 */
class PayrollProcessTypeRepository extends RepositoryAbstract implements PayrollProcessTypeRepositoryInterface
{
    //<editor-fold desc="#constructor">

    /**
     * PayrollProcessTypeRepository constructor.
     *
     * @param EloquentPayrollProcessTypeRepositoryInterface $eloquent
     */
    public function __construct(EloquentPayrollProcessTypeRepositoryInterface $eloquent)
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
    public function setupPayload(PayrollProcessTypeInterface $PayrollProcessType)
    {
        return [
            'name' => $PayrollProcessType->getName(),
            'slug' => $PayrollProcessType->getSlug(),
            'description' => $PayrollProcessType->getDescription(),
            'created_by' => $PayrollProcessType->getCreatedBy(),
            'modified_by' => $PayrollProcessType->getModifiedBy(),
            
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function create(PayrollProcessTypeInterface $PayrollProcessType)
    {
        $data = $this->setupPayload($PayrollProcessType);

        return $this->eloquent()->create($data);
    }

    /**
     * {@inheritdoc}
     */
    public function update(PayrollProcessTypeInterface $PayrollProcessType)
    {
        $data = $this->setupPayload($PayrollProcessType);
       
        return $this->eloquent()->update($data, $PayrollProcessType->getKey());
    }

    /**
     * {@inheritdoc}
     */
    public function delete(PayrollProcessTypeInterface $PayrollProcessType)
    {
        return $this->eloquent()->delete($PayrollProcessType->getKey());
    }

    /**
     * @return mixed
     */
    public function payrollProcessTypeList()
    {
        return $this->eloquent->all();
    }

    /**
     * @param ListedSearchParameter $parameter
     * @param bool $count
     * @return mixed
     */
    public function payrollProcessTypeListSearch(ListedSearchParameter $parameter, bool $count = false)
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
    public function payrollProcessTypePageSearch(PagedSearchParameter $parameter, bool $count = false)
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

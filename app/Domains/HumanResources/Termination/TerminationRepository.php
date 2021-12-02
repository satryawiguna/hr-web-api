<?php

namespace App\Domains\HumanResources\Termination;

use App\Core\Domains\Contracts\Pagination\ListedSearchParameter;
use App\Core\Domains\Contracts\Pagination\PagedSearchParameter;
use App\Domains\HumanResources\Termination\Contracts\TerminationRepositoryInterface;
use App\Infrastructures\HumanResources\Termination\Contracts\EloquentTerminationRepositoryInterface;
use App\Domains\HumanResources\Termination\Contracts\TerminationInterface;
use App\Domains\RepositoryAbstract;
use App\Domains\Contracts\BaseEntityInterface;
use Closure;
use Illuminate\Support\Facades\Config;

/**
 * Class TerminationRepository.
 */
class TerminationRepository extends RepositoryAbstract implements TerminationRepositoryInterface
{
    //<editor-fold desc="#constructor">

    /**
     * TerminationRepository constructor.
     *
     * @param EloquentTerminationRepositoryInterface $eloquent
     */
    public function __construct(EloquentTerminationRepositoryInterface $eloquent)
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
    public function setupPayload(TerminationInterface $Termination)
    {
        return [
            'employee_id' => $Termination->getEmployeeId(),
            'type' => $Termination->getType(),
            'termination_date' => (!is_null($Termination->getTerminationDate())) ? $Termination->getTerminationDate()->format(Config::get('datetime.format.default')) : null,
            'note' => $Termination->getNote(),
            'severance' => $Termination->getSeverance(),
            'created_by' => $Termination->getCreatedBy(),
            'modified_by' => $Termination->getModifiedBy(),
            
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function create(TerminationInterface $Termination)
    {
        $data = $this->setupPayload($Termination);

        return $this->eloquent()->create($data);
    }

    /**
     * {@inheritdoc}
     */
    public function update(TerminationInterface $Termination)
    {
        $data = $this->setupPayload($Termination);
       
        return $this->eloquent()->update($data, $Termination->getKey());
    }

    /**
     * {@inheritdoc}
     */
    public function delete(TerminationInterface $Termination)
    {
        return $this->eloquent()->delete($Termination->getKey());
    }

    /**
     * @param array $ids
     * @return mixed
     */
    public function deleteBulk(array $ids)
    {
        return $this->eloquent()->delete($ids);
    }

    /**
     * @param int|null $employeeId
     * @param string|null $type
     * @param object|null $rangeTerminationDate
     * @param object|null $rangeSeverance
     * @return mixed
     */
    public function terminationList(int $employeeId = null, string $type = null, object $rangeTerminationDate = null, object $rangeSeverance = null)
    {
        if (!is_null($employeeId)) {
            $this->eloquent->findWhereByEmployeeId($employeeId);
        }

        if (!is_null($type)) {
            $this->eloquent->findWhereByType($type);
        }

        if (!is_null($rangeTerminationDate->start) &&
            !is_null($rangeTerminationDate->end)) {
            $this->eloquent->findWhereBetweenByRangeTerminationDate($rangeTerminationDate->start, $rangeTerminationDate->end);
        }

        if (!is_null($rangeSeverance->start) &&
            !is_null($rangeSeverance->end)) {
            $this->eloquent->findWhereBetweenByRangeSeverance($rangeSeverance->start, $rangeSeverance->end);
        }

        return $this->eloquent->with(['employee'])->all();
    }

    /**
     * @param ListedSearchParameter $parameter
     * @param int|null $employeeId
     * @param string|null $type
     * @param object|null $rangeTerminationDate
     * @param object|null $rangeSeverance
     * @param bool $count
     * @return mixed
     */
    public function terminationListSearch(ListedSearchParameter $parameter, int $employeeId = null, string $type = null, object $rangeTerminationDate = null, object $rangeSeverance = null, bool $count = false)
    {
        $searchQuery = $parameter->query;

        if ($searchQuery) {
            $this->eloquent->findWhereBySearchQuery($searchQuery);
        }

        if (!is_null($employeeId)) {
            $this->eloquent->findWhereByEmployeeId($employeeId);
        }

        if (!is_null($type)) {
            $this->eloquent->findWhereByType($type);
        }

        if (!is_null($rangeTerminationDate->start) &&
            !is_null($rangeTerminationDate->end)) {
            $this->eloquent->findWhereBetweenByRangeTerminationDate($rangeTerminationDate->start, $rangeTerminationDate->end);
        }

        if (!is_null($rangeSeverance->start) &&
            !is_null($rangeSeverance->end)) {
            $this->eloquent->findWhereBetweenByRangeSeverance($rangeSeverance->start, $rangeSeverance->end);
        }

        if (!$count) {
            return $this->eloquent->with(['employee'])->all();
        } else {
            return $this->eloquent->all()->count();
        }
    }

    /**
     * @param PagedSearchParameter $parameter
     * @param int|null $employeeId
     * @param string|null $type
     * @param object|null $rangeTerminationDate
     * @param object|null $rangeSeverance
     * @param bool $count
     * @return mixed
     */
    public function terminationPageSearch(PagedSearchParameter $parameter, int $employeeId = null, string $type = null, object $rangeTerminationDate = null, object $rangeSeverance = null, bool $count = false)
    {
        if (!is_null($employeeId)) {
            $this->eloquent->findWhereByEmployeeId($employeeId);
        }

        if (!is_null($type)) {
            $this->eloquent->findWhereByType($type);
        }

        if (!is_null($rangeTerminationDate->start) &&
            !is_null($rangeTerminationDate->end)) {
            $this->eloquent->findWhereBetweenByRangeTerminationDate($rangeTerminationDate->start, $rangeTerminationDate->end);
        }

        if (!is_null($rangeSeverance->start) &&
            !is_null($rangeSeverance->end)) {
            $this->eloquent->findWhereBetweenByRangeSeverance($rangeSeverance->start, $rangeSeverance->end);
        }

        $searchQuery = !is_null($parameter->search) ? $parameter->search['value'] : $parameter->query['value'] ?? null;

        if ($searchQuery) {
            $this->eloquent->findWhereBySearchQuery($searchQuery);
        }

        if (!$count) {
            if ($parameter->draw) {
                return $this->eloquent->with(['employee'])
                    ->orderBy($parameter->columns[$parameter->order[0]['column']]['data'], $parameter->order[0]['dir'])
                    ->paginate($parameter->length, $parameter->start);
            } else {
                return $this->eloquent->with(['employee'])
                    ->orderBy($parameter->sort['field'], $parameter->sort['sort'])
                    ->paginate($parameter->pagination['perpage'], ($parameter->pagination['perpage'] * ($parameter->pagination['page'] - 1)));
            }
        } else {
            return $this->eloquent->all()->count();
        }

    }

    //</editor-fold>
}

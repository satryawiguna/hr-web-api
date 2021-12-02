<?php

namespace App\Domains\HumanResources\Element\ElementEntry;

use App\Core\Domains\Contracts\Pagination\ListedSearchParameter;
use App\Core\Domains\Contracts\Pagination\PagedSearchParameter;
use App\Domains\HumanResources\Element\ElementEntry\Contracts\ElementEntryRepositoryInterface;
use App\Infrastructures\HumanResources\Element\ElementEntry\Contracts\EloquentElementEntryRepositoryInterface;
use App\Domains\HumanResources\Element\ElementEntry\Contracts\ElementEntryInterface;
use App\Domains\RepositoryAbstract;
use App\Domains\Contracts\BaseEntityInterface;
use Closure;
use DateTime;
use Illuminate\Support\Facades\Config;

/**
 * Class ElementEntryRepository.
 */
class ElementEntryRepository extends RepositoryAbstract implements ElementEntryRepositoryInterface
{
    //<editor-fold desc="#constructor">

    /**
     * ElementEntryRepository constructor.
     *
     * @param EloquentElementEntryRepositoryInterface $eloquent
     */
    public function __construct(EloquentElementEntryRepositoryInterface $eloquent)
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
    public function setupPayload(ElementEntryInterface $ElementEntry)
    {
        return [
            'element_id' => $ElementEntry->getElementId(),
            'employee_id' => $ElementEntry->getEmployeeId(),
            'effective_start_date' => (!is_null($ElementEntry->getEfectiveStartDate())) ? $ElementEntry->getEfectiveStartDate()->format(Config::get('datetime.format.default')) : null,
            'effective_end_date' => (!is_null($ElementEntry->getEfectiveEndDate())) ? $ElementEntry->getEfectiveEndDate()->format(Config::get('datetime.format.default')) : null,
            'created_by' => $ElementEntry->getCreatedBy(),
            'modified_by' => $ElementEntry->getModifiedBy(),
            
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function create(ElementEntryInterface $ElementEntry)
    {
        $data = $this->setupPayload($ElementEntry);

        return $this->eloquent()->create($data);
    }

    /**
     * {@inheritdoc}
     */
    public function update(ElementEntryInterface $ElementEntry)
    {
        $data = $this->setupPayload($ElementEntry);
       
        return $this->eloquent()->update($data, $ElementEntry->getKey());
    }

    /**
     * {@inheritdoc}
     */
    public function delete(ElementEntryInterface $ElementEntry)
    {
        return $this->eloquent()->delete($ElementEntry->getKey());
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
     * @param int|null $elementId
     * @param int|null $employeeId
     * @param DateTime|null $date
     * @return mixed
     */
    public function elementEntryList(int $elementId = null, int $employeeId = null, DateTime $date = null)
    {
        if (!is_null($elementId)) {
            $this->eloquent->findWhereElementId($elementId);
        }

        if (!is_null($employeeId)) {
            $this->eloquent->findWhereEmployeeId($employeeId);
        }

        if (!is_null($date)) {
            $this->eloquent->findWhereEffectiveDateByDate($date);
        }

        return $this->eloquent->all();
    }

    /**
     * @param ListedSearchParameter $parameter
     * @param int|null $elementId
     * @param int|null $employeeId
     * @param DateTime|null $date
     * @param bool $count
     * @return mixed
     */
    public function elementEntryListSearch(ListedSearchParameter $parameter, int $elementId = null, int $employeeId = null, DateTime $date = null, bool $count = false)
    {
        $searchQuery = $parameter->query;

        if ($searchQuery) {
            $this->eloquent->findWhereBySearchQuery($searchQuery);
        }

        if (!is_null($elementId)) {
            $this->eloquent->findWhereElementId($elementId);
        }

        if (!is_null($employeeId)) {
            $this->eloquent->findWhereEmployeeId($employeeId);
        }

        if (!is_null($date)) {
            $this->eloquent->findWhereEffectiveDateByDate($date);
        }

        if (!$count) {
            return $this->eloquent->all();
        } else {
            return $this->eloquent->all()->count();
        }
    }

    /**
     * @param PagedSearchParameter $parameter
     * @param int|null $elementId
     * @param int|null $employeeId
     * @param DateTime|null $date
     * @param bool $count
     * @return mixed
     */
    public function elementEntryPageSearch(PagedSearchParameter $parameter, int $elementId = null, int $employeeId = null, DateTime $date = null, bool $count = false)
    {
        $searchQuery = !is_null($parameter->search) ? $parameter->search['value'] : $parameter->query['value'] ?? null;

        if ($searchQuery) {
            $this->eloquent->findWhereBySearchQuery($searchQuery);
        }

        if (!is_null($elementId)) {
            $this->eloquent->findWhereElementId($elementId);
        }

        if (!is_null($employeeId)) {
            $this->eloquent->findWhereEmployeeId($employeeId);
        }

        if (!is_null($date)) {
            $this->eloquent->findWhereEffectiveDateByDate($date);
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

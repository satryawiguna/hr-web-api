<?php

namespace App\Domains\HumanResources\Element\ElementEntryValue;

use App\Core\Domains\Contracts\Pagination\ListedSearchParameter;
use App\Core\Domains\Contracts\Pagination\PagedSearchParameter;
use App\Domains\HumanResources\Element\ElementEntryValue\Contracts\ElementEntryValueRepositoryInterface;
use App\Infrastructures\HumanResources\Element\ElementEntryValue\Contracts\EloquentElementEntryValueRepositoryInterface;
use App\Domains\HumanResources\Element\ElementEntryValue\Contracts\ElementEntryValueInterface;
use App\Domains\RepositoryAbstract;
use App\Domains\Contracts\BaseEntityInterface;
use Closure;
use DateTime;
use Illuminate\Support\Facades\Config;

/**
 * Class ElementEntryValueRepository.
 */
class ElementEntryValueRepository extends RepositoryAbstract implements ElementEntryValueRepositoryInterface
{
    //<editor-fold desc="#constructor">

    /**
     * ElementEntryValueRepository constructor.
     *
     * @param EloquentElementEntryValueRepositoryInterface $eloquent
     */
    public function __construct(EloquentElementEntryValueRepositoryInterface $eloquent)
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
    public function setupPayload(ElementEntryValueInterface $ElementEntryValue)
    {
        return [
            'element_entry_id' => $ElementEntryValue->getElementEntryId(),
            'element_value_id' => $ElementEntryValue->getElementValueId(),
            'effective_start_date' => $ElementEntryValue->getEfectiveStartDate()->format(Config::get('datetime.format.default')),
            'effective_end_date' => $ElementEntryValue->getEfectiveEndDate()->format(Config::get('datetime.format.default')),
            'value' => $ElementEntryValue->getValue(),
            'created_by' => $ElementEntryValue->getCreatedBy(),
            'modified_by' => $ElementEntryValue->getModifiedBy(),
            
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function create(ElementEntryValueInterface $ElementEntryValue)
    {
        $data = $this->setupPayload($ElementEntryValue);

        return $this->eloquent()->create($data);
    }

    /**
     * {@inheritdoc}
     */
    public function update(ElementEntryValueInterface $ElementEntryValue)
    {
        $data = $this->setupPayload($ElementEntryValue);
       
        return $this->eloquent()->update($data, $ElementEntryValue->getKey());
    }

    /**
     * {@inheritdoc}
     */
    public function delete(ElementEntryValueInterface $ElementEntryValue)
    {
        return $this->eloquent()->delete($ElementEntryValue->getKey());
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
     * @param int|null $elementEntryId
     * @param int|null $elementValueId
     * @param DateTime|null $date
     * @param object|null $rangeValue
     * @return mixed
     */
    public function elementEntryValueList(int $elementEntryId = null, int $elementValueId = null, DateTime $date = null, object $rangeValue = null)
    {
        if (!is_null($elementEntryId)) {
            $this->eloquent->findWhereElementEntryId($elementEntryId);
        }

        if (!is_null($elementValueId)) {
            $this->eloquent->findWhereElementValueId($elementValueId);
        }

        if (!is_null($date)) {
            $this->eloquent->findWhereEffectiveDateByDate($date);
        }

        if (!is_null($rangeValue->start) &&
            !is_null($rangeValue->end)) {
            $this->eloquent->findWhereBetweenByRangeValue($rangeValue->start, $rangeValue->end);
        }

        return $this->eloquent->all();
    }

    /**
     * @param ListedSearchParameter $parameter
     * @param int|null $elementEntryId
     * @param int|null $elementValueId
     * @param DateTime|null $date
     * @param object|null $rangeValue
     * @param bool $count
     * @return mixed
     */
    public function elementEntryValueListSearch(ListedSearchParameter $parameter, int $elementEntryId = null, int $elementValueId = null, DateTime $date = null, object $rangeValue = null, bool $count = false)
    {
        $searchQuery = $parameter->query;

        if ($searchQuery) {
            $this->eloquent->findWhereBySearchQuery($searchQuery);
        }

        if (!is_null($elementEntryId)) {
            $this->eloquent->findWhereElementEntryId($elementEntryId);
        }

        if (!is_null($elementValueId)) {
            $this->eloquent->findWhereElementValueId($elementValueId);
        }

        if (!is_null($date)) {
            $this->eloquent->findWhereEffectiveDateByDate($date);
        }

        if (!is_null($rangeValue->start) &&
            !is_null($rangeValue->end)) {
            $this->eloquent->findWhereBetweenByRangeValue($rangeValue->start, $rangeValue->end);
        }

        if (!$count) {
            return $this->eloquent->all();
        } else {
            return $this->eloquent->all()->count();
        }
    }

    /**
     * @param PagedSearchParameter $parameter
     * @param int|null $elementEntryId
     * @param int|null $elementValueId
     * @param DateTime|null $date
     * @param object|null $rangeValue
     * @param bool $count
     * @return mixed
     */
    public function elementEntryValuePageSearch(PagedSearchParameter $parameter, int $elementEntryId = null, int $elementValueId = null, DateTime $date = null, object $rangeValue = null, bool $count = false)
    {
        $searchQuery = !is_null($parameter->search) ? $parameter->search['value'] : $parameter->query['value'] ?? null;

        if ($searchQuery) {
            $this->eloquent->findWhereBySearchQuery($searchQuery);
        }

        if (!is_null($elementEntryId)) {
            $this->eloquent->findWhereElementEntryId($elementEntryId);
        }

        if (!is_null($elementValueId)) {
            $this->eloquent->findWhereElementValueId($elementValueId);
        }

        if (!is_null($date)) {
            $this->eloquent->findWhereEffectiveDateByDate($date);
        }

        if (!is_null($rangeValue->start) &&
            !is_null($rangeValue->end)) {
            $this->eloquent->findWhereBetweenByRangeValue($rangeValue->start, $rangeValue->end);
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

<?php

namespace App\Domains\HumanResources\Element\ElementValue;

use App\Core\Domains\Contracts\Pagination\ListedSearchParameter;
use App\Core\Domains\Contracts\Pagination\PagedSearchParameter;
use App\Domains\HumanResources\Element\ElementValue\Contracts\ElementValueRepositoryInterface;
use App\Infrastructures\HumanResources\Element\ElementValue\Contracts\EloquentElementValueRepositoryInterface;
use App\Domains\HumanResources\Element\ElementValue\Contracts\ElementValueInterface;
use App\Domains\RepositoryAbstract;
use App\Domains\Contracts\BaseEntityInterface;
use Closure;

/**
 * Class ElementValueRepository.
 */
class ElementValueRepository extends RepositoryAbstract implements ElementValueRepositoryInterface
{
    //<editor-fold desc="#constructor">

    /**
     * ElementValueRepository constructor.
     *
     * @param EloquentElementValueRepositoryInterface $eloquent
     */
    public function __construct(EloquentElementValueRepositoryInterface $eloquent)
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
    public function setupPayload(ElementValueInterface $ElementValue)
    {
        return [
            'element_id' => $ElementValue->getElementId(),
            'code' => $ElementValue->getCode(),
            'name' => $ElementValue->getName(),
            'value' => $ElementValue->getValue(),
            'seq_no' => $ElementValue->getSeqNo(),
            'created_by' => $ElementValue->getCreatedBy(),
            'modified_by' => $ElementValue->getModifiedBy(),
            
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function create(ElementValueInterface $ElementValue)
    {
        $data = $this->setupPayload($ElementValue);

        return $this->eloquent()->create($data);
    }

    /**
     * {@inheritdoc}
     */
    public function update(ElementValueInterface $ElementValue)
    {
        $data = $this->setupPayload($ElementValue);
       
        return $this->eloquent()->update($data, $ElementValue->getKey());
    }

    /**
     * {@inheritdoc}
     */
    public function delete(ElementValueInterface $ElementValue)
    {
        return $this->eloquent()->delete($ElementValue->getKey());
    }

    /**
     * @param int|null $elementId
     * @param object|null $rangeValue
     * @return mixed
     */
    public function elementValueList(int $elementId = null, object $rangeValue = null)
    {
        if (!is_null($elementId)) {
            $this->eloquent->findWhereElementId($elementId);
        }

        if (!is_null($rangeValue->start) &&
            !is_null($rangeValue->end)) {
            $this->eloquent->findWhereBetweenByRangeValue($rangeValue->start, $rangeValue->end);
        }

        return $this->eloquent->all();
    }

    /**
     * @param ListedSearchParameter $parameter
     * @param int|null $elementId
     * @param object|null $rangeValue
     * @param bool $count
     * @return mixed
     */
    public function elementValueListSearch(ListedSearchParameter $parameter, int $elementId = null, object $rangeValue = null, bool $count = false)
    {
        $searchQuery = $parameter->query;

        if ($searchQuery) {
            $this->eloquent->findWhereBySearchQuery($searchQuery);
        }

        if (!is_null($elementId)) {
            $this->eloquent->findWhereElementId($elementId);
        }

        if (!is_null($rangeValue->start) &&
            !is_null($rangeValue->end)) {
            $this->eloquent->findWhereBetweenByRangeValue($rangeValue->start, $rangeValue->end);
        }

        if (!$count) {
            return $this->eloquent->with(['formulaResults', 'element'])
                ->all();
        } else {
            return $this->eloquent->all()->count();
        }
    }

    /**
     * @param PagedSearchParameter $parameter
     * @param int|null $elementId
     * @param object|null $rangeValue
     * @param bool $count
     * @return mixed
     */
    public function elementValuePageSearch(PagedSearchParameter $parameter, int $elementId = null, object $rangeValue = null, bool $count = false)
    {
        $searchQuery = !is_null($parameter->search) ? $parameter->search['value'] : $parameter->query['value'] ?? null;

        if ($searchQuery) {
            $this->eloquent->findWhereBySearchQuery($searchQuery);
        }

        if (!is_null($elementId)) {
            $this->eloquent->findWhereElementId($elementId);
        }

        if (!is_null($rangeValue->start) &&
            !is_null($rangeValue->end)) {
            $this->eloquent->findWhereBetweenByRangeValue($rangeValue->start, $rangeValue->end);
        }

        if (!$count) {
            if ($parameter->draw) {
                return $this->eloquent->with(['formulaResults', 'element'])
                    ->orderBy($parameter->columns[$parameter->order[0]['column']]['data'], $parameter->order[0]['dir'])
                    ->paginate($parameter->length, $parameter->start);
            } else {
                return $this->eloquent->with(['formulaResults', 'element'])
                    ->orderBy($parameter->sort['field'], $parameter->sort['sort'])
                    ->paginate($parameter->pagination['perpage'], ($parameter->pagination['perpage'] * ($parameter->pagination['page'] - 1)));
            }
        } else {
            return $this->eloquent->all()->count();
        }

    }

    //</editor-fold>
}

<?php

namespace App\Domains\HumanResources\Element;

use App\Core\Domains\Contracts\Pagination\ListedSearchParameter;
use App\Core\Domains\Contracts\Pagination\PagedSearchParameter;
use App\Domains\HumanResources\Element\Contracts\ElementRepositoryInterface;
use App\Infrastructures\HumanResources\Element\Contracts\EloquentElementRepositoryInterface;
use App\Domains\HumanResources\Element\Contracts\ElementInterface;
use App\Domains\RepositoryAbstract;
use App\Domains\Contracts\BaseEntityInterface;
use Closure;

/**
 * Class ElementRepository.
 */
class ElementRepository extends RepositoryAbstract implements ElementRepositoryInterface
{
    //<editor-fold desc="#constructor">

    /**
     * ElementRepository constructor.
     *
     * @param EloquentElementRepositoryInterface $eloquent
     */
    public function __construct(EloquentElementRepositoryInterface $eloquent)
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
    public function setupPayload(ElementInterface $Element)
    {
        return [
            'code' => $Element->getCode(),
            'name' => $Element->getName(),
            'slug' => $Element->getSlug(),
            'formula_id' => $Element->getFormulaId(),
            'seq_no' => $Element->getSeqNo(),
            'created_by' => $Element->getCreatedBy(),
            'modified_by' => $Element->getModifiedBy(),
            
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function create(ElementInterface $Element)
    {
        $data = $this->setupPayload($Element);

        return $this->eloquent()->create($data);
    }

    /**
     * {@inheritdoc}
     */
    public function update(ElementInterface $Element)
    {
        $data = $this->setupPayload($Element);
       
        return $this->eloquent()->update($data, $Element->getKey());
    }

    /**
     * {@inheritdoc}
     */
    public function delete(ElementInterface $Element)
    {
        return $this->eloquent()->delete($Element->getKey());
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
     * @param int|null $formulaId
     * @return mixed
     */
    public function elementList(int $formulaId = null)
    {
        if (!is_null($formulaId)) {
            $this->eloquent->findWhereFormulaId($formulaId);
        }

        return $this->eloquent->all();
    }

    /**
     * @param ListedSearchParameter $parameter
     * @param int|null $formulaId
     * @param bool $count
     * @return mixed
     */
    public function elementListSearch(ListedSearchParameter $parameter, int $formulaId = null, bool $count = false)
    {
        $searchQuery = $parameter->query;

        if ($searchQuery) {
            $this->eloquent->findWhereBySearchQuery($searchQuery);
        }

        if (!is_null($formulaId)) {
            $this->eloquent->findWhereFormulaId($formulaId);
        }

        if (!$count) {
            return $this->eloquent->all();
        } else {
            return $this->eloquent->all()->count();
        }
    }

    /**
     * @param PagedSearchParameter $parameter
     * @param int|null $formulaId
     * @param bool $count
     * @return mixed
     */
    public function elementPageSearch(PagedSearchParameter $parameter, int $formulaId = null, bool $count = false)
    {
        $searchQuery = !is_null($parameter->search) ? $parameter->search['value'] : $parameter->query['value'] ?? null;

        if ($searchQuery) {
            $this->eloquent->findWhereBySearchQuery($searchQuery);
        }

        if (!is_null($formulaId)) {
            $this->eloquent->findWhereFormulaId($formulaId);
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

<?php

namespace App\Domains\HumanResources\Formula;

use App\Core\Domains\Contracts\Pagination\ListedSearchParameter;
use App\Core\Domains\Contracts\Pagination\PagedSearchParameter;
use App\Domains\HumanResources\Formula\Contracts\FormulaRepositoryInterface;
use App\Infrastructures\HumanResources\Formula\Contracts\EloquentFormulaRepositoryInterface;
use App\Domains\HumanResources\Formula\Contracts\FormulaInterface;
use App\Domains\RepositoryAbstract;
use App\Domains\Contracts\BaseEntityInterface;
use Closure;

/**
 * Class FormulaRepository.
 */
class FormulaRepository extends RepositoryAbstract implements FormulaRepositoryInterface
{
    //<editor-fold desc="#constructor">

    /**
     * FormulaRepository constructor.
     *
     * @param EloquentFormulaRepositoryInterface $eloquent
     */
    public function __construct(EloquentFormulaRepositoryInterface $eloquent)
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
    public function setupPayload(FormulaInterface $Formula)
    {
        return [
            'formula_category_id' => $Formula->getFormulaCategoryId(),
            'name' => $Formula->getName(),
            'slug' => $Formula->getSlug(),
            'type' => $Formula->getType(),
            'description' => $Formula->getDescription(),
            'created_by' => $Formula->getCreatedBy(),
            'modified_by' => $Formula->getModifiedBy(),
            
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function create(FormulaInterface $Formula)
    {
        $data = $this->setupPayload($Formula);

        return $this->eloquent()->create($data);
    }

    /**
     * {@inheritdoc}
     */
    public function update(FormulaInterface $Formula)
    {
        $data = $this->setupPayload($Formula);
       
        return $this->eloquent()->update($data, $Formula->getKey());
    }

    /**
     * {@inheritdoc}
     */
    public function delete(FormulaInterface $Formula)
    {
        return $this->eloquent()->delete($Formula->getKey());
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
     * @param int|null $formulaCategoryId
     * @return mixed
     */
    public function formulaList(int $formulaCategoryId = null)
    {
        if (!is_null($formulaCategoryId)) {
            $this->eloquent->findWhereFormulaCategoryId($formulaCategoryId);
        }

        return $this->eloquent->all();
    }

    /**
     * @param ListedSearchParameter $parameter
     * @param int|null $formulaCategoryId
     * @param bool $count
     * @return mixed
     */
    public function formulaListSearch(ListedSearchParameter $parameter, int $formulaCategoryId = null, bool $count = false)
    {
        $searchQuery = $parameter->query;

        if ($searchQuery) {
            $this->eloquent->findWhereBySearchQuery($searchQuery);
        }

        if (!is_null($formulaCategoryId)) {
            $this->eloquent->findWhereFormulaCategoryId($formulaCategoryId);
        }

        if (!$count) {
            return $this->eloquent->all();
        } else {
            return $this->eloquent->all()->count();
        }
    }

    /**
     * @param PagedSearchParameter $parameter
     * @param int|null $formulaCategoryId
     * @param bool $count
     * @return mixed
     */
    public function formulaPageSearch(PagedSearchParameter $parameter, int $formulaCategoryId = null, bool $count = false)
    {
        $searchQuery = !is_null($parameter->search) ? $parameter->search['value'] : $parameter->query['value'] ?? null;

        if ($searchQuery) {
            $this->eloquent->findWhereBySearchQuery($searchQuery);
        }

        if (!is_null($formulaCategoryId)) {
            $this->eloquent->findWhereFormulaCategoryId($formulaCategoryId);
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

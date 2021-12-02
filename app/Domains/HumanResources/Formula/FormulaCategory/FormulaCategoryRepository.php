<?php

namespace App\Domains\HumanResources\Formula\FormulaCategory;

use App\Core\Domains\Contracts\Pagination\ListedSearchParameter;
use App\Core\Domains\Contracts\Pagination\PagedSearchParameter;
use App\Domains\HumanResources\Formula\FormulaCategory\Contracts\FormulaCategoryRepositoryInterface;
use App\Infrastructures\HumanResources\Formula\FormulaCategory\Contracts\EloquentFormulaCategoryRepositoryInterface;
use App\Domains\HumanResources\Formula\FormulaCategory\Contracts\FormulaCategoryInterface;
use App\Domains\RepositoryAbstract;
use App\Domains\Contracts\BaseEntityInterface;
use Closure;

/**
 * Class FormulaCategoryRepository.
 */
class FormulaCategoryRepository extends RepositoryAbstract implements FormulaCategoryRepositoryInterface
{
    //<editor-fold desc="#constructor">

    /**
     * FormulaCategoryRepository constructor.
     *
     * @param EloquentFormulaCategoryRepositoryInterface $eloquent
     */
    public function __construct(EloquentFormulaCategoryRepositoryInterface $eloquent)
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
    public function setupPayload(FormulaCategoryInterface $FormulaCategory)
    {
        return [
            'name' => $FormulaCategory->getName(),
            'slug' => $FormulaCategory->getSlug(),
            'description' => $FormulaCategory->getDescription(),
            'created_by' => $FormulaCategory->getCreatedBy(),
            'modified_by' => $FormulaCategory->getModifiedBy(),
            
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function create(FormulaCategoryInterface $FormulaCategory)
    {
        $data = $this->setupPayload($FormulaCategory);

        return $this->eloquent()->create($data);
    }

    /**
     * {@inheritdoc}
     */
    public function update(FormulaCategoryInterface $FormulaCategory)
    {
        $data = $this->setupPayload($FormulaCategory);
       
        return $this->eloquent()->update($data, $FormulaCategory->getKey());
    }

    /**
     * {@inheritdoc}
     */
    public function delete(FormulaCategoryInterface $FormulaCategory)
    {
        return $this->eloquent()->delete($FormulaCategory->getKey());
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
     * @return mixed
     */
    public function formulaCategoryList()
    {
        return $this->eloquent->all();
    }

    /**
     * @param ListedSearchParameter $parameter
     * @param bool $count
     * @return mixed
     */
    public function formulaCategoryListSearch(ListedSearchParameter $parameter, bool $count = false)
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
    public function formulaCategoryPageSearch(PagedSearchParameter $parameter, bool $count = false)
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

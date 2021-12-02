<?php

namespace App\Domains\HumanResources\Formula\FormulaCategory\Contracts;

use App\Core\Domains\Contracts\Pagination\ListedSearchParameter;
use App\Core\Domains\Contracts\Pagination\PagedSearchParameter;
use App\Domains\Contracts\HasEloquentStorageRepositoryInterface;
use App\Infrastructures\HumanResources\Formula\FormulaCategory\Contracts\EloquentFormulaCategoryRepositoryInterface;
use App\Domains\Contracts\BaseEntityInterface;
use Closure;

/**
 * Interface FormulaCategoryRepositoryInterface.
 */
interface FormulaCategoryRepositoryInterface
{
    //<editor-fold desc="#constructor">

    /**
     * FormulaCategoryRepositoryInterface constructor.
     *
     * @param EloquentFormulaCategoryRepositoryInterface $eloquent
     */
    public function __construct(EloquentFormulaCategoryRepositoryInterface $eloquent);

    //</editor-fold>


    //<editor-fold desc="#public (method)">
    
    /**
     * Create FormulaCategory.
     *
     * @param FormulaCategoryInterface $FormulaCategory
     *
     * @return mixed
     */
    public function create(FormulaCategoryInterface $FormulaCategory);

    /**
     * Update FormulaCategory.
     *
     * @param FormulaCategoryInterface $FormulaCategory
     *
     * @return mixed
     */
    public function update(FormulaCategoryInterface $FormulaCategory);

    /**
     * Delete FormulaCategory.
     *
     * @param FormulaCategoryInterface $FormulaCategory
     *
     * @return mixed
     */
    public function delete(FormulaCategoryInterface $FormulaCategory);

    /**
     * @param array $ids
     * @return mixed
     */
    public function deleteBulk(array $ids);

    /**
     * @param int $id
     * @return mixed
     */
    public function find(int $id);

    /**
     * @return mixed
     */
    public function formulaCategoryList();

    /**
     * @param ListedSearchParameter $parameter
     * @param bool $count
     * @return mixed
     */
    public function formulaCategoryListSearch(ListedSearchParameter $parameter, bool $count = false);

    /**
     * @param PagedSearchParameter $parameter
     * @param bool $count
     * @return mixed
     */
    public function formulaCategoryPageSearch(PagedSearchParameter $parameter, bool $count = false);

    //</editor-fold>
}

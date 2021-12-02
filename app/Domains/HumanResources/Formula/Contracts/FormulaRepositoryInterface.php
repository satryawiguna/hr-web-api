<?php

namespace App\Domains\HumanResources\Formula\Contracts;

use App\Core\Domains\Contracts\Pagination\ListedSearchParameter;
use App\Core\Domains\Contracts\Pagination\PagedSearchParameter;
use App\Domains\Contracts\HasEloquentStorageRepositoryInterface;
use App\Infrastructures\HumanResources\Formula\Contracts\EloquentFormulaRepositoryInterface;
use App\Domains\Contracts\BaseEntityInterface;
use Closure;

/**
 * Interface FormulaRepositoryInterface.
 */
interface FormulaRepositoryInterface
{
    //<editor-fold desc="#constructor">

    /**
     * FormulaRepositoryInterface constructor.
     *
     * @param EloquentFormulaRepositoryInterface $eloquent
     */
    public function __construct(EloquentFormulaRepositoryInterface $eloquent);

    //</editor-fold>


    //<editor-fold desc="#public (method)">

    /**
     * Create Formula.
     *
     * @param FormulaInterface $Formula
     *
     * @return mixed
     */
    public function create(FormulaInterface $Formula);

    /**
     * Update Formula.
     *
     * @param FormulaInterface $Formula
     *
     * @return mixed
     */
    public function update(FormulaInterface $Formula);

    /**
     * Delete Formula.
     *
     * @param FormulaInterface $Formula
     *
     * @return mixed
     */
    public function delete(FormulaInterface $Formula);

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
     * @param int|null $formulaCategoryId
     * @return mixed
     */
    public function formulaList(int $formulaCategoryId = null);

    /**
     * @param ListedSearchParameter $parameter
     * @param int|null $formulaCategoryId
     * @param bool $count
     * @return mixed
     */
    public function formulaListSearch(ListedSearchParameter $parameter, int $formulaCategoryId = null, bool $count = false);

    /**
     * @param PagedSearchParameter $parameter
     * @param int|null $formulaCategoryId
     * @param bool $count
     * @return mixed
     */
    public function formulaPageSearch(PagedSearchParameter $parameter, int $formulaCategoryId = null, bool $count = false);

    //</editor-fold>
}

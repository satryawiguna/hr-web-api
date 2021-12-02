<?php

namespace App\Domains\HumanResources\Formula\Contracts;
use App\Core\Services\Request\ListSearchRequest;
use App\Core\Services\Request\PageSearchRequest;
use App\Core\Services\Response\GenericCollectionResponse;
use App\Core\Services\Response\GenericListSearchResponse;
use App\Core\Services\Response\ObjectResponse;
use App\Core\Services\Response\GenericPageSearchResponse;
use App\Domains\HumanResources\Formula\FormulaCategory\Contracts\FormulaCategoryInterface;

/**
 * Interface FormulaServiceInterface.
 */
interface FormulaServiceInterface
{
    //<editor-fold desc="#constructor">

    /**
     * FormulaServiceInterface constructor.
     *
     * @param FormulaRepositoryInterface $repository
     */
    public function __construct(FormulaRepositoryInterface $repository);

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
     * @return ObjectResponse
     */
    public function find(int $id): ObjectResponse;

    /**
     * @param int|null $formulaCategoryId
     * @return GenericCollectionResponse
     */
    public function formulaList(int $formulaCategoryId = null): GenericCollectionResponse;

    /**
     * @param ListSearchRequest $request
     * @param int|null $formulaCategoryId
     * @return GenericListSearchResponse
     */
    public function formulaListSearch(ListSearchRequest $request, int $formulaCategoryId = null): GenericListSearchResponse;

    /**
     * @param PageSearchRequest $request
     * @param int|null $formulaCategoryId
     * @return GenericPageSearchResponse
     */
    public function formulaPageSearch(PageSearchRequest $request, int $formulaCategoryId = null): GenericPageSearchResponse;

    /**
     * @param FormulaInterface $Formula
     * @return ObjectResponse
     */
    public function formulaSlug(FormulaInterface $Formula): ObjectResponse;

    //</editor-fold>
}

<?php

namespace App\Domains\HumanResources\Formula\FormulaCategory\Contracts;
use App\Core\Services\Request\ListSearchRequest;
use App\Core\Services\Request\PageSearchRequest;
use App\Core\Services\Response\GenericCollectionResponse;
use App\Core\Services\Response\GenericListSearchResponse;
use App\Core\Services\Response\ObjectResponse;
use App\Core\Services\Response\GenericPageSearchResponse;

/**
 * Interface FormulaCategoryServiceInterface.
 */
interface FormulaCategoryServiceInterface
{
    //<editor-fold desc="#constructor">

    /**
     * FormulaCategoryServiceInterface constructor.
     *
     * @param FormulaCategoryRepositoryInterface $repository
     */
    public function __construct(FormulaCategoryRepositoryInterface $repository);

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
     * @return ObjectResponse
     */
    public function find(int $id): ObjectResponse;

    /**
     * @return GenericCollectionResponse
     */
    public function formulaCategoryList(): GenericCollectionResponse;

    /**
     * @param ListSearchRequest $request
     * @return mixed
     */
    public function formulaCategoryListSearch(ListSearchRequest $request): GenericListSearchResponse;

    /**
     * @param PageSearchRequest $request
     * @return mixed
     */
    public function formulaCategoryPageSearch(PageSearchRequest $request): GenericPageSearchResponse;

    /**
     * @param FormulaCategoryInterface $FormulaCategory
     * @return ObjectResponse
     */
    public function formulaCategorySlug(FormulaCategoryInterface $FormulaCategory): ObjectResponse;

    //</editor-fold>
}

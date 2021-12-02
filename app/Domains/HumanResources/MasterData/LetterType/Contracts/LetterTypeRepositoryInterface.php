<?php

namespace App\Domains\HumanResources\MasterData\LetterType\Contracts;

use App\Core\Domains\Contracts\Pagination\ListedSearchParameter;
use App\Core\Domains\Contracts\Pagination\PagedSearchParameter;
use App\Domains\Contracts\HasEloquentStorageRepositoryInterface;
use App\Infrastructures\HumanResources\MasterData\LetterType\Contracts\EloquentLetterTypeRepositoryInterface;
use App\Domains\Contracts\BaseEntityInterface;
use Closure;

/**
 * Interface LetterTypeRepositoryInterface.
 */
interface LetterTypeRepositoryInterface
{
    //<editor-fold desc="#constructor">

    /**
     * LetterTypeRepositoryInterface constructor.
     *
     * @param EloquentLetterTypeRepositoryInterface $eloquent
     */
    public function __construct(EloquentLetterTypeRepositoryInterface $eloquent);

    //</editor-fold>


    //<editor-fold desc="#public (method)">

    /**
     * Create LetterType.
     *
     * @param LetterTypeInterface $LetterType
     *
     * @return mixed
     */
    public function create(LetterTypeInterface $LetterType);

    /**
     * Update LetterType.
     *
     * @param LetterTypeInterface $LetterType
     *
     * @return mixed
     */
    public function update(LetterTypeInterface $LetterType);

    /**
     * Delete LetterType.
     *
     * @param LetterTypeInterface $LetterType
     *
     * @return mixed
     */
    public function delete(LetterTypeInterface $LetterType);

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
     * @param int|null $companyId
     * @param int|null $isActive
     * @return mixed
     */
    public function letterTypeList(int $companyId = null, int $isActive = null);

    /**
     * @param ListedSearchParameter $parameter
     * @param int|null $companyId
     * @param int|null $isActive
     * @param bool $count
     * @return mixed
     */
    public function letterTypeListSearch(ListedSearchParameter $parameter, int $companyId = null, int $isActive = null, bool $count = false);

    /**
     * @param PagedSearchParameter $parameter
     * @param int|null $companyId
     * @param int|null $isActive
     * @param bool $count
     * @return mixed
     */
    public function letterTypePageSearch(PagedSearchParameter $parameter, int $companyId = null, int $isActive = null, bool $count = false);

    //</editor-fold>
}

<?php

namespace App\Domains\HumanResources\Personal\Employee\Child\Contracts;

use App\Core\Domains\Contracts\Pagination\ListedSearchParameter;
use App\Core\Domains\Contracts\Pagination\PagedSearchParameter;
use App\Domains\Contracts\HasEloquentStorageRepositoryInterface;
use App\Infrastructures\HumanResources\Personal\Employee\Child\Contracts\EloquentChildRepositoryInterface;
use App\Domains\Contracts\BaseEntityInterface;
use Closure;
use Illuminate\Support\Collection;

/**
 * Interface ChildRepositoryInterface.
 */
interface ChildRepositoryInterface
{
    //<editor-fold desc="#constructor">

    /**
     * ChildRepositoryInterface constructor.
     *
     * @param EloquentChildRepositoryInterface $eloquent
     */
    public function __construct(EloquentChildRepositoryInterface $eloquent);

    //</editor-fold>


    //<editor-fold desc="#public (method)">

    /**
     * Create Child.
     *
     * @param ChildInterface $Child
     *
     * @return mixed
     */
    public function create(ChildInterface $Child);

    /**
     * @param Collection $Childs
     * @return mixed
     */
    public function insert(Collection $Childs);

    /**
     * Update Child.
     *
     * @param ChildInterface $Child
     *
     * @return mixed
     */
    public function update(ChildInterface $Child);

    /**
     * @param ChildInterface $Child
     * @param array $params
     * @return mixed
     */
    public function updateOrCreate(ChildInterface $Child, array $params);

    /**
     * Delete Child.
     *
     * @param ChildInterface $Child
     *
     * @return mixed
     */
    public function delete(ChildInterface $Child);

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
     * @param int|null $employeeId
     * @param int|null $genderId
     * @param object|null $rangeBirthDate
     * @param object|null $rangeBPJSKesehatanDate
     * @param string|null $bpjsKesehatanClass
     * @return mixed
     */
    public function childList(int $companyId =  null, int $employeeId = null, int $genderId = null, object $rangeBirthDate = null, object $rangeBPJSKesehatanDate = null, string $bpjsKesehatanClass = null);

    /**
     * @param ListedSearchParameter $parameter
     * @param int|null $companyId
     * @param int|null $employeeId
     * @param int|null $genderId
     * @param object|null $rangeBirthDate
     * @param object|null $rangeBPJSKesehatanDate
     * @param string|null $bpjsKesehatanClass
     * @param bool $count
     * @return mixed
     */
    public function childListSearch(ListedSearchParameter $parameter, int $companyId = null, int $employeeId = null, int $genderId = null, object $rangeBirthDate = null, object $rangeBPJSKesehatanDate = null, string $bpjsKesehatanClass = null, bool $count = false);

    /**
     * @param PagedSearchParameter $parameter
     * @param int|null $companyId
     * @param int|null $employeeId
     * @param int|null $genderId
     * @param object|null $rangeBirthDate
     * @param object|null $rangeBPJSKesehatanDate
     * @param string|null $bpjsKesehatanClass
     * @param bool $count
     * @return mixed
     */
    public function childPageSearch(PagedSearchParameter $parameter, int $companyId = null, int $employeeId = null, int $genderId = null, object $rangeBirthDate = null, object $rangeBPJSKesehatanDate = null, string $bpjsKesehatanClass = null, bool $count = false);

    //</editor-fold>
}

<?php

namespace App\Domains\HumanResources\Personal\Employee\Child\Contracts;
use App\Core\Services\Request\ListSearchRequest;
use App\Core\Services\Request\PageSearchRequest;
use App\Core\Services\Response\GenericCollectionResponse;
use App\Core\Services\Response\GenericListSearchResponse;
use App\Core\Services\Response\ObjectResponse;
use App\Core\Services\Response\GenericPageSearchResponse;
use Illuminate\Support\Collection;

/**
 * Interface ChildServiceInterface.
 */
interface ChildServiceInterface
{
    //<editor-fold desc="#constructor">

    /**
     * ChildServiceInterface constructor.
     *
     * @param ChildRepositoryInterface $repository
     */
    public function __construct(ChildRepositoryInterface $repository);

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
     * @param array $params
     * @return mixed
     */
    public function update(ChildInterface $Child, array $params = []);

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
     * @return GenericCollectionResponse
     */
    public function childList(int $companyId = null, int $employeeId = null, int $genderId = null, object $rangeBirthDate = null, object $rangeBPJSKesehatanDate = null, string $bpjsKesehatanClass = null): GenericCollectionResponse;

    /**
     * @param ListSearchRequest $request
     * @param int|null $companyId
     * @param int|null $employeeId
     * @param int|null $genderId
     * @param object|null $rangeBirthDate
     * @param object|null $rangeBPJSKesehatanDate
     * @param string|null $bpjsKesehatanClass
     * @return GenericListSearchResponse
     */
    public function childListSearch(ListSearchRequest $request, int $companyId = null, int $employeeId = null, int $genderId = null, object $rangeBirthDate = null, object $rangeBPJSKesehatanDate = null, string $bpjsKesehatanClass = null): GenericListSearchResponse;

    /**
     * @param PageSearchRequest $request
     * @param int|null $companyId
     * @param int|null $employeeId
     * @param int|null $genderId
     * @param object|null $rangeBirthDate
     * @param object|null $rangeBPJSKesehatanDate
     * @param string|null $bpjsKesehatanClass
     * @return GenericPageSearchResponse
     */
    public function childPageSearch(PageSearchRequest $request, int $companyId = null, int $employeeId = null, int $genderId = null, object $rangeBirthDate = null, object $rangeBPJSKesehatanDate = null, string $bpjsKesehatanClass = null): GenericPageSearchResponse;

    //</editor-fold>
}

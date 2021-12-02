<?php

namespace App\Domains\HumanResources\MasterData\Competence\Contracts;

use App\Core\Domains\Contracts\Pagination\ListedSearchParameter;
use App\Core\Domains\Contracts\Pagination\PagedSearchParameter;
use App\Domains\Contracts\HasEloquentStorageRepositoryInterface;
use App\Infrastructures\HumanResources\MasterData\Competence\Contracts\EloquentCompetenceRepositoryInterface;
use App\Domains\Contracts\BaseEntityInterface;
use Closure;

/**
 * Interface CompetenceRepositoryInterface.
 */
interface CompetenceRepositoryInterface
{
    //<editor-fold desc="#constructor">

    /**
     * CompetenceRepositoryInterface constructor.
     *
     * @param EloquentCompetenceRepositoryInterface $eloquent
     */
    public function __construct(EloquentCompetenceRepositoryInterface $eloquent);

    //</editor-fold>


    //<editor-fold desc="#public (method)">
    
    /**
     * Create Competence.
     *
     * @param CompetenceInterface $Competence
     *
     * @return mixed
     */
    public function create(CompetenceInterface $Competence);

    /**
     * Update Competence.
     *
     * @param CompetenceInterface $Competence
     *
     * @return mixed
     */
    public function update(CompetenceInterface $Competence);

    /**
     * Delete Competence.
     *
     * @param CompetenceInterface $Competence
     *
     * @return mixed
     */
    public function delete(CompetenceInterface $Competence);

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
    public function competenceList(int $companyId = null, int $isActive = null);

    /**
     * @param ListedSearchParameter $parameter
     * @param int|null $companyId
     * @param int|null $isActive
     * @param bool $count
     * @return mixed
     */
    public function competenceListSearch(ListedSearchParameter $parameter, int $companyId = null, int $isActive = null, bool $count = false);

    /**
     * @param PagedSearchParameter $parameter
     * @param int|null $companyId
     * @param int|null $isActive
     * @param bool $count
     * @return mixed
     */
    public function competencePageSearch(PagedSearchParameter $parameter, int $companyId = null, int $isActive = null, bool $count = false);

    //</editor-fold>
}

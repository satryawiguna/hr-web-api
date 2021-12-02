<?php

namespace App\Domains\Commons\Skill\Contracts;

use App\Core\Domains\Contracts\Pagination\ListedSearchParameter;
use App\Core\Domains\Contracts\Pagination\PagedSearchParameter;
use App\Domains\Contracts\HasEloquentStorageRepositoryInterface;
use App\Infrastructures\Commons\Skill\Contracts\EloquentSkillRepositoryInterface;
use App\Domains\Contracts\BaseEntityInterface;
use Closure;

/**
 * Interface SkillRepositoryInterface.
 */
interface SkillRepositoryInterface
{
    //<editor-fold desc="#constructor">

    /**
     * SkillRepositoryInterface constructor.
     *
     * @param EloquentSkillRepositoryInterface $eloquent
     */
    public function __construct(EloquentSkillRepositoryInterface $eloquent);

    //</editor-fold>


    //<editor-fold desc="#public (method)">

    /**
     * Create Skill.
     *
     * @param SkillInterface $Skill
     *
     * @return mixed
     */
    public function create(SkillInterface $Skill);

    /**
     * Update Skill.
     *
     * @param SkillInterface $Skill
     *
     * @return mixed
     */
    public function update(SkillInterface $Skill);

    /**
     * Delete Skill.
     *
     * @param SkillInterface $Skill
     *
     * @return mixed
     */
    public function delete(SkillInterface $Skill);

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
    public function skillList();

    /**
     * @param ListedSearchParameter $parameter
     * @param bool $count
     * @return mixed
     */
    public function skillListSearch(ListedSearchParameter $parameter, bool $count = false);

    /**
     * @param PagedSearchParameter $parameter
     * @param bool $count
     * @return mixed
     */
    public function skillPageSearch(PagedSearchParameter $parameter, bool $count = false);

    //</editor-fold>
}
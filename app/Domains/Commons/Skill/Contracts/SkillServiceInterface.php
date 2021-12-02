<?php

namespace App\Domains\Commons\Skill\Contracts;

use App\Core\Services\Request\ListSearchRequest;
use App\Core\Services\Request\PageSearchRequest;
use App\Core\Services\Response\BasicResponse;
use App\Core\Services\Response\GenericCollectionResponse;
use App\Core\Services\Response\GenericListSearchResponse;
use App\Core\Services\Response\ObjectResponse;
use App\Core\Services\Response\GenericPageSearchResponse;

/**
 * Interface SkillServiceInterface.
 */
interface SkillServiceInterface
{
    //<editor-fold desc="#constructor">

    /**
     * SkillServiceInterface constructor.
     *
     * @param SkillRepositoryInterface $repository
     */
    public function __construct(SkillRepositoryInterface $repository);

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
     * @return ObjectResponse
     */
    public function find(int $id): ObjectResponse;

    /**
     * @return GenericCollectionResponse
     */
    public function skillList(): GenericCollectionResponse;

    /**
     * @param ListSearchRequest $request
     * @return GenericListSearchResponse
     */
    public function skillListSearch(ListSearchRequest $request): GenericListSearchResponse;

    /**
     * @param PageSearchRequest $request
     * @return GenericPageSearchResponse
     */
    public function skillPageSearch(PageSearchRequest $request): GenericPageSearchResponse;

    /**
     * @param SkillInterface $Skill
     * @return ObjectResponse
     */
    public function skillSlug(SkillInterface $Skill): ObjectResponse;

    //</editor-fold>
}
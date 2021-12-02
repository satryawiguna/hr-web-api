<?php
namespace App\Domains\HumanResources\MasterData\AdditionalQuestion\Contracts;

use App\Domains\Contracts\BaseEntityInterface;

interface AdditionalQuestionInterface extends BaseEntityInterface
{
    //<editor-fold desc="#constanta">

    const TABLE_NAME = 'additional_questions';
    const MORPH_NAME = 'additional_questions';

    //</editor-fold>


    //<editor-fold desc="#property">

    /**
     * Get company_id.
     *
     * @return mixed
     */
    public function getCompanyId();
    
    /**
     * Set company_id.
     *
     * @param $company_id
     *
     * @return mixed
     */
    public function setCompanyId($company_id);

    /**
     * Get question.
     *
     * @return mixed
     */
    public function getQuestion();
    
    /**
     * Set question.
     *
     * @param $question
     *
     * @return mixed
     */
    public function setQuestion($question);

    /**
     * Get is_required.
     *
     * @return mixed
     */
    public function getIsRequired();
    
    /**
     * Set is_required.
     *
     * @param $is_required
     *
     * @return mixed
     */
    public function setIsRequired($is_required);

    /**
     * Get status.
     *
     * @return mixed
     */
    public function getStatus();
    
    /**
     * Set status.
     *
     * @param $status
     *
     * @return mixed
     */
    public function setStatus($status);

    //</editor-fold>


    //<editor-fold desc="#public (method)">


    //<editor-fold desc="#belongs to relation">

    /**
     * @return mixed
     */
    public function company();

    //</editor-fold>


    //<editor-fold desc="#has many relation">
    //</editor-fold>


    //</editor-fold>
}

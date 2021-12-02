<?php
namespace App\Domains\HumanResources\Payroll\PayrollBalanceFeed\Contracts;

use App\Domains\Contracts\BaseEntityInterface;

interface PayrollBalanceFeedInterface extends BaseEntityInterface
{
    //<editor-fold desc="#constanta">

    const TABLE_NAME = 'payroll_balance_feeds';
    const MORPH_NAME = 'payroll_balance_feeds';

    //</editor-fold>


    //<editor-fold desc="#property">

    /**
     * Get payroll_balance_id.
     *
     * @return mixed
     */
    public function getPayrollBalanceId();
    
    /**
     * Set payroll_balance_id.
     *
     * @param $payroll_balance_id
     *
     * @return mixed
     */
    public function setPayrollBalanceId($payroll_balance_id);

    /**
     * Get element_id.
     *
     * @return mixed
     */
    public function getElementId();
    
    /**
     * Set element_id.
     *
     * @param $element_id
     *
     * @return mixed
     */
    public function setElementId($element_id);

    /**
     * Get element_value_id.
     *
     * @return mixed
     */
    public function getElementValueId();
    
    /**
     * Set element_value_id.
     *
     * @param $element_value_id
     *
     * @return mixed
     */
    public function setElementValueId($element_value_id);

    /**
     * Get add_or_substract.
     *
     * @return mixed
     */
    public function getAddOrSubstract();
    
    /**
     * Set add_or_substract.
     *
     * @param $add_or_substract
     *
     * @return mixed
     */
    public function setAddOrSubstract($add_or_substract);

    /**
     * Get created_by.
     *
     * @return mixed
     */
    public function getCreatedBy();
    
    /**
     * Set created_by.
     *
     * @param $created_by
     *
     * @return mixed
     */
    public function setCreatedBy($created_by);

    /**
     * Get modified_by.
     *
     * @return mixed
     */
    public function getModifiedBy();
    
    /**
     * Set modified_by.
     *
     * @param $modified_by
     *
     * @return mixed
     */
    public function setModifiedBy($modified_by);

    //</editor-fold>


    //<editor-fold desc="#public (method)">

    //<editor-fold desc="#belongs to relation">

    /**
     * @return mixed
     */
    public function payrollBalance();

    /**
     * @return mixed
     */
    public function element();

    /**
     * @return mixed
     */
    public function elementValue();

    //</editor-fold>

    //</editor-fold>
}

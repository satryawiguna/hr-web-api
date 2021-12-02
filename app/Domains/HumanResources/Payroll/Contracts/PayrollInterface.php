<?php
namespace App\Domains\HumanResources\Payroll\Contracts;

use App\Domains\Contracts\BaseEntityInterface;

interface PayrollInterface extends BaseEntityInterface
{
    //<editor-fold desc="#constanta">

    const TABLE_NAME = 'payrolls';
    const MORPH_NAME = 'payrolls';

    //</editor-fold>


    //<editor-fold desc="#property">

    /**
     * Get employee_id.
     *
     * @return mixed
     */
    public function getEmployeeId();
    
    /**
     * Set employee_id.
     *
     * @param $employee_id
     *
     * @return mixed
     */
    public function setEmployeeId($employee_id);

    /**
     * Get payroll_batch_id.
     *
     * @return mixed
     */
    public function getPayrollBatchId();
    
    /**
     * Set payroll_batch_id.
     *
     * @param $payroll_batch_id
     *
     * @return mixed
     */
    public function setPayrollBatchId($payroll_batch_id);

    /**
     * Get pay_period.
     *
     * @return mixed
     */
    public function getPayPeriod();
    
    /**
     * Set pay_period.
     *
     * @param $pay_period
     *
     * @return mixed
     */
    public function setPayPeriod($pay_period);

    /**
     * Get process_date.
     *
     * @return mixed
     */
    public function getProcessDate();
    
    /**
     * Set process_date.
     *
     * @param $process_date
     *
     * @return mixed
     */
    public function setProcessDate($process_date);

    /**
     * Get payroll_process_type_id.
     *
     * @return mixed
     */
    public function getPayrollProcessTypeId();
    
    /**
     * Set payroll_process_type_id.
     *
     * @param $payroll_process_type_id
     *
     * @return mixed
     */
    public function setPayrollProcessTypeId($payroll_process_type_id);

    /**
     * Get description.
     *
     * @return mixed
     */
    public function getDescription();
    
    /**
     * Set description.
     *
     * @param $description
     *
     * @return mixed
     */
    public function setDescription($description);

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

    public function payrollBatchs();

    public function payrollProcessTypes();

    //</editor-fold>

    //</editor-fold>
}

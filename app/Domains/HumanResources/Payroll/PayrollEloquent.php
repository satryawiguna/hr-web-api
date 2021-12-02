<?php

namespace App\Domains\HumanResources\Payroll;

use App\Domains\HumanResources\Payroll\Contracts\PayrollInterface;
use App\Domains\PayrollBatch\PayrollBatchEloquent;
use App\Domains\HumanResources\Payroll\PayrollProcessType\PayrollProcessTypeEloquent;
use App\Infrastructures\EloquentAbstract;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * PayrollEloquent.
 */
class PayrollEloquent extends EloquentAbstract implements PayrollInterface
{
    use SoftDeletes, Sluggable;

    //<editor-fold desc="#field">

    /**
     * Table name.
     *
     * @var string
     */
    protected $table =  PayrollInterface::TABLE_NAME;

    protected $primaryKey = 'id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'employee_id', 'payroll_batch_id', 'pay_period', 'process_date', 'payroll_process_type_id', 'description', 'created_by', 'modified_by'
    ];

    protected $searchable = [
        'employee_id', 'payroll_batch_id', 'pay_period', 'process_date', 'payroll_process_type_id', 'description', 'created_by', 'modified_by'
    ];

    protected $orderable = [
        'employee_id', 'payroll_batch_id', 'pay_period', 'process_date', 'payroll_process_type_id', 'description', 'created_by', 'modified_by'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [];

    protected $dates = [
        'deleted_at'
    ];

    //</editor-fold>


    //<editor-fold desc="#property">

    /**
     * {@inheritdoc}
     */
    public function getEmployeeId()
    {
        return $this->employee_id;
    }
    
    /**
     * {@inheritdoc}
     */
    public function setEmployeeId($employee_id)
    {
        $this->employee_id = $employee_id;
        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getPayrollBatchId()
    {
        return $this->payroll_batch_id;
    }
    
    /**
     * {@inheritdoc}
     */
    public function setPayrollBatchId($payroll_batch_id)
    {
        $this->payroll_batch_id = $payroll_batch_id;
        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getPayPeriod()
    {
        return $this->pay_period;
    }
    
    /**
     * {@inheritdoc}
     */
    public function setPayPeriod($pay_period)
    {
        $this->pay_period = $pay_period;
        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getProcessDate()
    {
        return $this->process_date;
    }
    
    /**
     * {@inheritdoc}
     */
    public function setProcessDate($process_date)
    {
        $this->process_date = $process_date;
        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getPayrollProcessTypeId()
    {
        return $this->payroll_process_type_id;
    }
    
    /**
     * {@inheritdoc}
     */
    public function setPayrollProcessTypeId($payroll_process_type_id)
    {
        $this->payroll_process_type_id = $payroll_process_type_id;
        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getDescription()
    {
        return $this->description;
    }
    
    /**
     * {@inheritdoc}
     */
    public function setDescription($description)
    {
        $this->description = $description;
        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getCreatedBy()
    {
        return $this->created_by;
    }
    
    /**
     * {@inheritdoc}
     */
    public function setCreatedBy($created_by)
    {
        $this->created_by = $created_by;
        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getModifiedBy()
    {
        return $this->modified_by;
    }
    
    /**
     * {@inheritdoc}
     */
    public function setModifiedBy($modified_by)
    {
        $this->modified_by = $modified_by;
        return $this;
    }

    //</editor-fold>


    //<editor-fold desc="#public (method)">

    //<editor-fold desc="#has many relation">

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function payrollBatchs()
    {
        return $this->belongsTo(PayrollBatchEloquent::class, 'payroll_batch_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function payrollProcessTypes()
    {
        return $this->belongsTo(PayrollProcessTypeEloquent::class, 'payroll_process_type_id');
    }

    //</editor-fold>

    /**
     * @return array
     */
    public function sluggable()
    {
        return [
            'slug' => [
                'source' => 'name'
            ]
        ];
    }

    //</editor-fold>
}

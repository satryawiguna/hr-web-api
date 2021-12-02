<?php

namespace App\Domains\HumanResources\Payroll\PayrollBalanceFeed;

use App\Domains\HumanResources\Element\ElementEloquent;
use App\Domains\HumanResources\Element\ElementValue\ElementValueEloquent;
use App\Domains\HumanResources\Payroll\PayrollBalance\PayrollBalanceEloquent;
use App\Domains\HumanResources\Payroll\PayrollBalanceFeed\Contracts\PayrollBalanceFeedInterface;
use App\Infrastructures\EloquentAbstract;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * PayrollBalanceFeedEloquent.
 */
class PayrollBalanceFeedEloquent extends EloquentAbstract implements PayrollBalanceFeedInterface
{
    use SoftDeletes;

    //<editor-fold desc="#field">

    /**
     * Table name.
     *
     * @var string
     */
    protected $table =  PayrollBalanceFeedInterface::TABLE_NAME;

    protected $primaryKey = 'id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'payroll_balance_id', 'element_id', 'element_value_id', 'add_or_substract', 'created_by', 'modified_by'
    ];

    protected $searchable = [
        'payroll_balance_id', 'element_id', 'element_value_id', 'add_or_substract', 'created_by', 'modified_by'
    ];

    protected $orderable = [
        'payroll_balance_id', 'element_id', 'element_value_id', 'add_or_substract', 'created_by', 'modified_by'
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
    public function getPayrollBalanceId()
    {
        return $this->payroll_balance_id;
    }
    
    /**
     * {@inheritdoc}
     */
    public function setPayrollBalanceId($payroll_balance_id)
    {
        $this->payroll_balance_id = $payroll_balance_id;
        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getElementId()
    {
        return $this->element_id;
    }
    
    /**
     * {@inheritdoc}
     */
    public function setElementId($element_id)
    {
        $this->element_id = $element_id;
        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getElementValueId()
    {
        return $this->element_value_id;
    }
    
    /**
     * {@inheritdoc}
     */
    public function setElementValueId($element_value_id)
    {
        $this->element_value_id = $element_value_id;
        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getAddOrSubstract()
    {
        return $this->add_or_substract;
    }
    
    /**
     * {@inheritdoc}
     */
    public function setAddOrSubstract($add_or_substract)
    {
        $this->add_or_substract = $add_or_substract;
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

    //<editor-fold desc="#belongs to relation">

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo|mixed
     */
    public function payrollBalance()
    {
        return $this->belongsTo(PayrollBalanceEloquent::class, 'payroll_balance_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo|mixed
     */
    public function element()
    {
        return $this->belongsTo(ElementEloquent::class, 'element_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo|mixed
     */
    public function elementValue()
    {
        return $this->belongsTo(ElementValueEloquent::class, 'element_value_id');
    }

    //</editor-fold>

    //</editor-fold>
}

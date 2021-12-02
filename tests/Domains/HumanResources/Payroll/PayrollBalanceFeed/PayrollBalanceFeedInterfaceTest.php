<?php
namespace Tests\Domains\HumanResources\Payroll\PayrollBalanceFeed;

use App\Domains\HumanResources\Payroll\PayrollBalanceFeed\PayrollBalanceFeedEloquent;
use Tests\TestCase;
use Mockery as m;

class PayrollBalanceFeedInterfaceTest extends TestCase
{
    /**
     * Set up test.
     */
    protected function setUp()
    {
        parent::setUp();
        $this->modelUnderTest = new PayrollBalanceFeedEloquent();
    }

                
    public function testGetPayrollBalanceId()
    {
        $controlValue = rand(1, 999);
        $this->modelUnderTest->setPayrollBalanceId($controlValue);
        $this->assertEquals($controlValue, $this->modelUnderTest->getPayrollBalanceId());
    }
            
    public function testGetElementId()
    {
        $controlValue = rand(1, 999);
        $this->modelUnderTest->setElementId($controlValue);
        $this->assertEquals($controlValue, $this->modelUnderTest->getElementId());
    }
            
    public function testGetElementValueId()
    {
        $controlValue = rand(1, 999);
        $this->modelUnderTest->setElementValueId($controlValue);
        $this->assertEquals($controlValue, $this->modelUnderTest->getElementValueId());
    }
            
    public function testGetAddOrSubstract()
    {
        $controlValue = rand(1, 999);
        $this->modelUnderTest->setAddOrSubstract($controlValue);
        $this->assertEquals($controlValue, $this->modelUnderTest->getAddOrSubstract());
    }
            
    public function testGetCreatedBy()
    {
        $controlValue = rand(1, 999);
        $this->modelUnderTest->setCreatedBy($controlValue);
        $this->assertEquals($controlValue, $this->modelUnderTest->getCreatedBy());
    }
            
    public function testGetModifiedBy()
    {
        $controlValue = rand(1, 999);
        $this->modelUnderTest->setModifiedBy($controlValue);
        $this->assertEquals($controlValue, $this->modelUnderTest->getModifiedBy());
    }

}

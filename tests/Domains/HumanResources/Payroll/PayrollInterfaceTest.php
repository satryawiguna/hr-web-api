<?php
namespace Tests\Domains\HumanResources\Payroll;

use App\Domains\HumanResources\Payroll\PayrollEloquent;
use Tests\TestCase;
use Mockery as m;

class PayrollInterfaceTest extends TestCase
{
    /**
     * Set up test.
     */
    protected function setUp()
    {
        parent::setUp();
        $this->modelUnderTest = new PayrollEloquent();
    }

                
    public function testGetEmployeeId()
    {
        $controlValue = rand(1, 999);
        $this->modelUnderTest->setEmployeeId($controlValue);
        $this->assertEquals($controlValue, $this->modelUnderTest->getEmployeeId());
    }
            
    public function testGetPayrollBatchId()
    {
        $controlValue = rand(1, 999);
        $this->modelUnderTest->setPayrollBatchId($controlValue);
        $this->assertEquals($controlValue, $this->modelUnderTest->getPayrollBatchId());
    }
            
    public function testGetPayPeriod()
    {
        $controlValue = rand(1, 999);
        $this->modelUnderTest->setPayPeriod($controlValue);
        $this->assertEquals($controlValue, $this->modelUnderTest->getPayPeriod());
    }
            
    public function testGetProcessDate()
    {
        $controlValue = rand(1, 999);
        $this->modelUnderTest->setProcessDate($controlValue);
        $this->assertEquals($controlValue, $this->modelUnderTest->getProcessDate());
    }
            
    public function testGetPayrollProcessTypeId()
    {
        $controlValue = rand(1, 999);
        $this->modelUnderTest->setPayrollProcessTypeId($controlValue);
        $this->assertEquals($controlValue, $this->modelUnderTest->getPayrollProcessTypeId());
    }
            
    public function testGetDescription()
    {
        $controlValue = rand(1, 999);
        $this->modelUnderTest->setDescription($controlValue);
        $this->assertEquals($controlValue, $this->modelUnderTest->getDescription());
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

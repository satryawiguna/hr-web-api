<?php
namespace Tests\Domains\HumanResources\Payroll\PayrollBalance;

use App\Domains\HumanResources\Payroll\PayrollBalance\PayrollBalanceEloquent;
use Tests\TestCase;
use Mockery as m;

class PayrollBalanceInterfaceTest extends TestCase
{
    /**
     * Set up test.
     */
    protected function setUp()
    {
        parent::setUp();
        $this->modelUnderTest = new PayrollBalanceEloquent();
    }

                
    public function testGetName()
    {
        $controlValue = rand(1, 999);
        $this->modelUnderTest->setName($controlValue);
        $this->assertEquals($controlValue, $this->modelUnderTest->getName());
    }
            
    public function testGetSlug()
    {
        $controlValue = rand(1, 999);
        $this->modelUnderTest->setSlug($controlValue);
        $this->assertEquals($controlValue, $this->modelUnderTest->getSlug());
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

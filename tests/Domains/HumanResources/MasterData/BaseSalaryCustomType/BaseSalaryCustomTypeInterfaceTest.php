<?php
namespace Tests\Domains\HumanResources\MasterData\BaseSalaryCustomType;

use App\Domains\HumanResources\MasterData\BaseSalaryCustomType\BaseSalaryCustomTypeEloquent;
use Tests\TestCase;
use Mockery as m;

class BaseSalaryCustomTypeInterfaceTest extends TestCase
{
    /**
     * Set up test.
     */
    protected function setUp()
    {
        parent::setUp();
        $this->modelUnderTest = new BaseSalaryCustomTypeEloquent();
    }

                
    public function testGetCompanyId()
    {
        $controlValue = rand(1, 999);
        $this->modelUnderTest->setCompanyId($controlValue);
        $this->assertEquals($controlValue, $this->modelUnderTest->getCompanyId());
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
            
    public function testGetIsActive()
    {
        $controlValue = rand(1, 999);
        $this->modelUnderTest->setIsActive($controlValue);
        $this->assertEquals($controlValue, $this->modelUnderTest->getIsActive());
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

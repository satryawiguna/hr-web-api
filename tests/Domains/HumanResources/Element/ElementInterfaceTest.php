<?php
namespace Tests\Domains\HumanResources\Element;

use App\Domains\HumanResources\Element\ElementEloquent;
use Tests\TestCase;
use Mockery as m;

class ElementInterfaceTest extends TestCase
{
    /**
     * Set up test.
     */
    protected function setUp()
    {
        parent::setUp();
        $this->modelUnderTest = new ElementEloquent();
    }

                
    public function testGetCode()
    {
        $controlValue = rand(1, 999);
        $this->modelUnderTest->setCode($controlValue);
        $this->assertEquals($controlValue, $this->modelUnderTest->getCode());
    }
            
    public function testGetName()
    {
        $controlValue = rand(1, 999);
        $this->modelUnderTest->setName($controlValue);
        $this->assertEquals($controlValue, $this->modelUnderTest->getName());
    }
            
    public function testGetFormulaId()
    {
        $controlValue = rand(1, 999);
        $this->modelUnderTest->setFormulaId($controlValue);
        $this->assertEquals($controlValue, $this->modelUnderTest->getFormulaId());
    }
            
    public function testGetSeqNo()
    {
        $controlValue = rand(1, 999);
        $this->modelUnderTest->setSeqNo($controlValue);
        $this->assertEquals($controlValue, $this->modelUnderTest->getSeqNo());
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

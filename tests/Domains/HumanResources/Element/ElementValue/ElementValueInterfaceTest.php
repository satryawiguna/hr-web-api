<?php
namespace Tests\Domains\HumanResources\Element\ElementValue;

use App\Domains\HumanResources\Element\ElementValue\ElementValueEloquent;
use Tests\TestCase;
use Mockery as m;

class ElementValueInterfaceTest extends TestCase
{
    /**
     * Set up test.
     */
    protected function setUp()
    {
        parent::setUp();
        $this->modelUnderTest = new ElementValueEloquent();
    }

                
    public function testGetElementId()
    {
        $controlValue = rand(1, 999);
        $this->modelUnderTest->setElementId($controlValue);
        $this->assertEquals($controlValue, $this->modelUnderTest->getElementId());
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
            
    public function testGetValue()
    {
        $controlValue = rand(1, 999);
        $this->modelUnderTest->setValue($controlValue);
        $this->assertEquals($controlValue, $this->modelUnderTest->getValue());
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

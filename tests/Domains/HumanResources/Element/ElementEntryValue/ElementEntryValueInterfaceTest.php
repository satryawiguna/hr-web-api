<?php
namespace Tests\Domains\HumanResources\Element\ElementEntryValue;

use App\Domains\HumanResources\Element\ElementEntryValue\ElementEntryValueEloquent;
use Tests\TestCase;
use Mockery as m;

class ElementEntryValueInterfaceTest extends TestCase
{
    /**
     * Set up test.
     */
    protected function setUp()
    {
        parent::setUp();
        $this->modelUnderTest = new ElementEntryValueEloquent();
    }

                
    public function testGetElementEntryId()
    {
        $controlValue = rand(1, 999);
        $this->modelUnderTest->setElementEntryId($controlValue);
        $this->assertEquals($controlValue, $this->modelUnderTest->getElementEntryId());
    }
            
    public function testGetElementValueId()
    {
        $controlValue = rand(1, 999);
        $this->modelUnderTest->setElementValueId($controlValue);
        $this->assertEquals($controlValue, $this->modelUnderTest->getElementValueId());
    }
            
    public function testGetEfectiveStart()
    {
        $controlValue = rand(1, 999);
        $this->modelUnderTest->setEfectiveStart($controlValue);
        $this->assertEquals($controlValue, $this->modelUnderTest->getEfectiveStart());
    }
            
    public function testGetEfectiveEnd()
    {
        $controlValue = rand(1, 999);
        $this->modelUnderTest->setEfectiveEnd($controlValue);
        $this->assertEquals($controlValue, $this->modelUnderTest->getEfectiveEnd());
    }
            
    public function testGetValue()
    {
        $controlValue = rand(1, 999);
        $this->modelUnderTest->setValue($controlValue);
        $this->assertEquals($controlValue, $this->modelUnderTest->getValue());
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

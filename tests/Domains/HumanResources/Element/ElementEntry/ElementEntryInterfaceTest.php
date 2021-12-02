<?php
namespace Tests\Domains\HumanResources\Element\ElementEntry;

use App\Domains\HumanResources\Element\ElementEntry\ElementEntryEloquent;
use Tests\TestCase;
use Mockery as m;

class ElementEntryInterfaceTest extends TestCase
{
    /**
     * Set up test.
     */
    protected function setUp()
    {
        parent::setUp();
        $this->modelUnderTest = new ElementEntryEloquent();
    }

                
    public function testGetElementId()
    {
        $controlValue = rand(1, 999);
        $this->modelUnderTest->setElementId($controlValue);
        $this->assertEquals($controlValue, $this->modelUnderTest->getElementId());
    }
            
    public function testGetEmployeeId()
    {
        $controlValue = rand(1, 999);
        $this->modelUnderTest->setEmployeeId($controlValue);
        $this->assertEquals($controlValue, $this->modelUnderTest->getEmployeeId());
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

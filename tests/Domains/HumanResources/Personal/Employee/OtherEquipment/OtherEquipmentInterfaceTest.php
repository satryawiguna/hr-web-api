<?php
namespace Tests\Infrastructures\HumanResources\Personal\Employee\OtherEquipment;

use App\Infrastructures\HumanResources\Personal\Employee\OtherEquipment\OtherEquipmentEloquent;
use Tests\TestCase;
use Mockery as m;

class OtherEquipmentInterfaceTest extends TestCase
{
    /**
     * Set up test.
     */
    protected function setUp()
    {
        parent::setUp();
        $this->modelUnderTest = new OtherEquipmentEloquent();
    }

                
    public function testGetEmployeeId()
    {
        $controlValue = rand(1, 999);
        $this->modelUnderTest->setEmployeeId($controlValue);
        $this->assertEquals($controlValue, $this->modelUnderTest->getEmployeeId());
    }
            
    public function testGetName()
    {
        $controlValue = rand(1, 999);
        $this->modelUnderTest->setName($controlValue);
        $this->assertEquals($controlValue, $this->modelUnderTest->getName());
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

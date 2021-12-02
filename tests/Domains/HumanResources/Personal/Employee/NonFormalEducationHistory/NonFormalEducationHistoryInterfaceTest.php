<?php
namespace Tests\Domains\HumanResources\Personal\Employee\NonFormalEducationHistory;

use App\Domains\HumanResources\Personal\Employee\NonFormalEducationHistory\NonFormalEducationHistoryEloquent;
use Tests\TestCase;
use Mockery as m;

class NonFormalEducationHistoryInterfaceTest extends TestCase
{
    /**
     * Set up test.
     */
    protected function setUp()
    {
        parent::setUp();
        $this->modelUnderTest = new NonFormalEducationHistoryEloquent();
    }

                
    public function testGetEmployeeId()
    {
        $controlValue = rand(1, 999);
        $this->modelUnderTest->setEmployeeId($controlValue);
        $this->assertEquals($controlValue, $this->modelUnderTest->getEmployeeId());
    }
            
    public function testGetType()
    {
        $controlValue = rand(1, 999);
        $this->modelUnderTest->setType($controlValue);
        $this->assertEquals($controlValue, $this->modelUnderTest->getType());
    }
            
    public function testGetName()
    {
        $controlValue = rand(1, 999);
        $this->modelUnderTest->setName($controlValue);
        $this->assertEquals($controlValue, $this->modelUnderTest->getName());
    }
            
    public function testGetDate()
    {
        $controlValue = rand(1, 999);
        $this->modelUnderTest->setDate($controlValue);
        $this->assertEquals($controlValue, $this->modelUnderTest->getDate());
    }
            
    public function testGetDuration()
    {
        $controlValue = rand(1, 999);
        $this->modelUnderTest->setDuration($controlValue);
        $this->assertEquals($controlValue, $this->modelUnderTest->getDuration());
    }
            
    public function testGetOrganizer()
    {
        $controlValue = rand(1, 999);
        $this->modelUnderTest->setOrganizer($controlValue);
        $this->assertEquals($controlValue, $this->modelUnderTest->getOrganizer());
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

<?php
namespace Tests\Domains\HumanResources\Personal\Employee\FormalEducationHistory;

use App\Domains\HumanResources\Personal\Employee\FormalEducationHistory\FormalEducationHistoryEloquent;
use Tests\TestCase;
use Mockery as m;

class FormalEducationHistoryInterfaceTest extends TestCase
{
    /**
     * Set up test.
     */
    protected function setUp()
    {
        parent::setUp();
        $this->modelUnderTest = new FormalEducationHistoryEloquent();
    }

                
    public function testGetEmployeeId()
    {
        $controlValue = rand(1, 999);
        $this->modelUnderTest->setEmployeeId($controlValue);
        $this->assertEquals($controlValue, $this->modelUnderTest->getEmployeeId());
    }
            
    public function testGetDegreeId()
    {
        $controlValue = rand(1, 999);
        $this->modelUnderTest->setDegreeId($controlValue);
        $this->assertEquals($controlValue, $this->modelUnderTest->getDegreeId());
    }
            
    public function testGetMajorId()
    {
        $controlValue = rand(1, 999);
        $this->modelUnderTest->setMajorId($controlValue);
        $this->assertEquals($controlValue, $this->modelUnderTest->getMajorId());
    }
            
    public function testGetName()
    {
        $controlValue = rand(1, 999);
        $this->modelUnderTest->setName($controlValue);
        $this->assertEquals($controlValue, $this->modelUnderTest->getName());
    }
            
    public function testGetStartDate()
    {
        $controlValue = rand(1, 999);
        $this->modelUnderTest->setStartDate($controlValue);
        $this->assertEquals($controlValue, $this->modelUnderTest->getStartDate());
    }
            
    public function testGetEndDate()
    {
        $controlValue = rand(1, 999);
        $this->modelUnderTest->setEndDate($controlValue);
        $this->assertEquals($controlValue, $this->modelUnderTest->getEndDate());
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

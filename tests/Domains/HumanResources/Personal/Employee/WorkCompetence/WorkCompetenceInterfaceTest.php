<?php
namespace Tests\Domains\HumanResources\Personal\Employee\WorkCompetence;

use App\Domains\HumanResources\Personal\Employee\WorkCompetence\WorkCompetenceEloquent;
use Tests\TestCase;
use Mockery as m;

class WorkCompetenceInterfaceTest extends TestCase
{
    /**
     * Set up test.
     */
    protected function setUp()
    {
        parent::setUp();
        $this->modelUnderTest = new WorkCompetenceEloquent();
    }

                
    public function testGetEmployeeId()
    {
        $controlValue = rand(1, 999);
        $this->modelUnderTest->setEmployeeId($controlValue);
        $this->assertEquals($controlValue, $this->modelUnderTest->getEmployeeId());
    }
            
    public function testGetCompetenceId()
    {
        $controlValue = rand(1, 999);
        $this->modelUnderTest->setCompetenceId($controlValue);
        $this->assertEquals($controlValue, $this->modelUnderTest->getCompetenceId());
    }
            
    public function testGetReferenceNumber()
    {
        $controlValue = rand(1, 999);
        $this->modelUnderTest->setReferenceNumber($controlValue);
        $this->assertEquals($controlValue, $this->modelUnderTest->getReferenceNumber());
    }
            
    public function testGetDate()
    {
        $controlValue = rand(1, 999);
        $this->modelUnderTest->setDate($controlValue);
        $this->assertEquals($controlValue, $this->modelUnderTest->getDate());
    }
            
    public function testGetTimeVaidity()
    {
        $controlValue = rand(1, 999);
        $this->modelUnderTest->setTimeVaidity($controlValue);
        $this->assertEquals($controlValue, $this->modelUnderTest->getTimeVaidity());
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

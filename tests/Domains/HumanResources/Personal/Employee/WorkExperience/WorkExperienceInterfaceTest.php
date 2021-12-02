<?php
namespace Tests\Domains\HumanResources\Personal\Employee\WorkExperience;

use App\Domains\HumanResources\Personal\Employee\WorkExperience\WorkExperienceEloquent;
use Tests\TestCase;
use Mockery as m;

class WorkExperienceInterfaceTest extends TestCase
{
    /**
     * Set up test.
     */
    protected function setUp()
    {
        parent::setUp();
        $this->modelUnderTest = new WorkExperienceEloquent();
    }

                
    public function testGetCompanyId()
    {
        $controlValue = rand(1, 999);
        $this->modelUnderTest->setCompanyId($controlValue);
        $this->assertEquals($controlValue, $this->modelUnderTest->getCompanyId());
    }
            
    public function testGetCompany()
    {
        $controlValue = rand(1, 999);
        $this->modelUnderTest->setCompany($controlValue);
        $this->assertEquals($controlValue, $this->modelUnderTest->getCompany());
    }
            
    public function testGetBusiness()
    {
        $controlValue = rand(1, 999);
        $this->modelUnderTest->setBusiness($controlValue);
        $this->assertEquals($controlValue, $this->modelUnderTest->getBusiness());
    }
            
    public function testGetPosition()
    {
        $controlValue = rand(1, 999);
        $this->modelUnderTest->setPosition($controlValue);
        $this->assertEquals($controlValue, $this->modelUnderTest->getPosition());
    }
            
    public function testGetDate()
    {
        $controlValue = rand(1, 999);
        $this->modelUnderTest->setDate($controlValue);
        $this->assertEquals($controlValue, $this->modelUnderTest->getDate());
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

<?php
namespace Tests\Domains\Vacancy;

use App\Domains\Vacancy\VacancyEloquent;
use Tests\TestCase;
use Mockery as m;

class VacancyInterfaceTest extends TestCase
{
    /**
     * Set up test.
     */
    protected function setUp()
    {
        parent::setUp();
        $this->modelUnderTest = new VacancyEloquent();
    }

                
    public function testGetCompanyId()
    {
        $controlValue = rand(1, 999);
        $this->modelUnderTest->setCompanyId($controlValue);
        $this->assertEquals($controlValue, $this->modelUnderTest->getCompanyId());
    }
            
    public function testGetPositionId()
    {
        $controlValue = rand(1, 999);
        $this->modelUnderTest->setPositionId($controlValue);
        $this->assertEquals($controlValue, $this->modelUnderTest->getPositionId());
    }
            
    public function testGetDegreeId()
    {
        $controlValue = rand(1, 999);
        $this->modelUnderTest->setDegreeId($controlValue);
        $this->assertEquals($controlValue, $this->modelUnderTest->getDegreeId());
    }
            
    public function testGetPublishDate()
    {
        $controlValue = rand(1, 999);
        $this->modelUnderTest->setPublishDate($controlValue);
        $this->assertEquals($controlValue, $this->modelUnderTest->getPublishDate());
    }
            
    public function testGetExpiredDate()
    {
        $controlValue = rand(1, 999);
        $this->modelUnderTest->setExpiredDate($controlValue);
        $this->assertEquals($controlValue, $this->modelUnderTest->getExpiredDate());
    }
            
    public function testGetIntro()
    {
        $controlValue = rand(1, 999);
        $this->modelUnderTest->setIntro($controlValue);
        $this->assertEquals($controlValue, $this->modelUnderTest->getIntro());
    }
            
    public function testGetDescription()
    {
        $controlValue = rand(1, 999);
        $this->modelUnderTest->setDescription($controlValue);
        $this->assertEquals($controlValue, $this->modelUnderTest->getDescription());
    }
            
    public function testGetResponsibility()
    {
        $controlValue = rand(1, 999);
        $this->modelUnderTest->setResponsibility($controlValue);
        $this->assertEquals($controlValue, $this->modelUnderTest->getResponsibility());
    }
            
    public function testGetRequirement()
    {
        $controlValue = rand(1, 999);
        $this->modelUnderTest->setRequirement($controlValue);
        $this->assertEquals($controlValue, $this->modelUnderTest->getRequirement());
    }
            
    public function testGetCareer()
    {
        $controlValue = rand(1, 999);
        $this->modelUnderTest->setCareer($controlValue);
        $this->assertEquals($controlValue, $this->modelUnderTest->getCareer());
    }
            
    public function testGetSalary()
    {
        $controlValue = rand(1, 999);
        $this->modelUnderTest->setSalary($controlValue);
        $this->assertEquals($controlValue, $this->modelUnderTest->getSalary());
    }
            
    public function testGetFacilityAndAllowance()
    {
        $controlValue = rand(1, 999);
        $this->modelUnderTest->setFacilityAndAllowance($controlValue);
        $this->assertEquals($controlValue, $this->modelUnderTest->getFacilityAndAllowance());
    }
            
    public function testGetExpertise()
    {
        $controlValue = rand(1, 999);
        $this->modelUnderTest->setExpertise($controlValue);
        $this->assertEquals($controlValue, $this->modelUnderTest->getExpertise());
    }
            
    public function testGetPlacement()
    {
        $controlValue = rand(1, 999);
        $this->modelUnderTest->setPlacement($controlValue);
        $this->assertEquals($controlValue, $this->modelUnderTest->getPlacement());
    }
            
    public function testGetWorkTime()
    {
        $controlValue = rand(1, 999);
        $this->modelUnderTest->setWorkTime($controlValue);
        $this->assertEquals($controlValue, $this->modelUnderTest->getWorkTime());
    }
            
    public function testGetWorkType()
    {
        $controlValue = rand(1, 999);
        $this->modelUnderTest->setWorkType($controlValue);
        $this->assertEquals($controlValue, $this->modelUnderTest->getWorkType());
    }
            
    public function testGetLanguage()
    {
        $controlValue = rand(1, 999);
        $this->modelUnderTest->setLanguage($controlValue);
        $this->assertEquals($controlValue, $this->modelUnderTest->getLanguage());
    }
            
    public function testGetApperance()
    {
        $controlValue = rand(1, 999);
        $this->modelUnderTest->setApperance($controlValue);
        $this->assertEquals($controlValue, $this->modelUnderTest->getApperance());
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

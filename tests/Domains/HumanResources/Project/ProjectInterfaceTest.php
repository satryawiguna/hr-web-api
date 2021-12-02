<?php
namespace Tests\Domains\HumanResources\Project;

use App\Domains\HumanResources\Project\ProjectEloquent;
use Tests\TestCase;
use Mockery as m;

class ProjectInterfaceTest extends TestCase
{
    /**
     * Set up test.
     */
    protected function setUp()
    {
        parent::setUp();
        $this->modelUnderTest = new ProjectEloquent();
    }

                
    public function testGetParentId()
    {
        $controlValue = rand(1, 999);
        $this->modelUnderTest->setParentId($controlValue);
        $this->assertEquals($controlValue, $this->modelUnderTest->getParentId());
    }
            
    public function testGetCompanyId()
    {
        $controlValue = rand(1, 999);
        $this->modelUnderTest->setCompanyId($controlValue);
        $this->assertEquals($controlValue, $this->modelUnderTest->getCompanyId());
    }
            
    public function testGetIsContract()
    {
        $controlValue = rand(1, 999);
        $this->modelUnderTest->setIsContract($controlValue);
        $this->assertEquals($controlValue, $this->modelUnderTest->getIsContract());
    }
            
    public function testGetName()
    {
        $controlValue = rand(1, 999);
        $this->modelUnderTest->setName($controlValue);
        $this->assertEquals($controlValue, $this->modelUnderTest->getName());
    }
            
    public function testGetFirstParty()
    {
        $controlValue = rand(1, 999);
        $this->modelUnderTest->setFirstParty($controlValue);
        $this->assertEquals($controlValue, $this->modelUnderTest->getFirstParty());
    }
            
    public function testGetSecondParty()
    {
        $controlValue = rand(1, 999);
        $this->modelUnderTest->setSecondParty($controlValue);
        $this->assertEquals($controlValue, $this->modelUnderTest->getSecondParty());
    }
            
    public function testGetIssueDate()
    {
        $controlValue = rand(1, 999);
        $this->modelUnderTest->setIssueDate($controlValue);
        $this->assertEquals($controlValue, $this->modelUnderTest->getIssueDate());
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
            
    public function testGetJobDescription()
    {
        $controlValue = rand(1, 999);
        $this->modelUnderTest->setJobDescription($controlValue);
        $this->assertEquals($controlValue, $this->modelUnderTest->getJobDescription());
    }
            
    public function testGetRate()
    {
        $controlValue = rand(1, 999);
        $this->modelUnderTest->setRate($controlValue);
        $this->assertEquals($controlValue, $this->modelUnderTest->getRate());
    }
            
    public function testGetContractType()
    {
        $controlValue = rand(1, 999);
        $this->modelUnderTest->setContractType($controlValue);
        $this->assertEquals($controlValue, $this->modelUnderTest->getContractType());
    }
            
    public function testGetRatePerContractType()
    {
        $controlValue = rand(1, 999);
        $this->modelUnderTest->setRatePerContractType($controlValue);
        $this->assertEquals($controlValue, $this->modelUnderTest->getRatePerContractType());
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

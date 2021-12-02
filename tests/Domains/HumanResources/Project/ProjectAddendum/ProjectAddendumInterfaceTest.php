<?php
namespace Tests\Domains\HumanResources\Project\ProjectAddendum;

use App\Domains\HumanResources\Project\ProjectAddendum\ProjectAddendumEloquent;
use Tests\TestCase;
use Mockery as m;

class ProjectAddendumInterfaceTest extends TestCase
{
    /**
     * Set up test.
     */
    protected function setUp()
    {
        parent::setUp();
        $this->modelUnderTest = new ProjectAddendumEloquent();
    }

                
    public function testGetProjectId()
    {
        $controlValue = rand(1, 999);
        $this->modelUnderTest->setProjectId($controlValue);
        $this->assertEquals($controlValue, $this->modelUnderTest->getProjectId());
    }
            
    public function testGetReferenceNumber()
    {
        $controlValue = rand(1, 999);
        $this->modelUnderTest->setReferenceNumber($controlValue);
        $this->assertEquals($controlValue, $this->modelUnderTest->getReferenceNumber());
    }
            
    public function testGetName()
    {
        $controlValue = rand(1, 999);
        $this->modelUnderTest->setName($controlValue);
        $this->assertEquals($controlValue, $this->modelUnderTest->getName());
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
            
    public function testGetDescription()
    {
        $controlValue = rand(1, 999);
        $this->modelUnderTest->setDescription($controlValue);
        $this->assertEquals($controlValue, $this->modelUnderTest->getDescription());
    }
            
    public function testGetValue()
    {
        $controlValue = rand(1, 999);
        $this->modelUnderTest->setValue($controlValue);
        $this->assertEquals($controlValue, $this->modelUnderTest->getValue());
    }
            
    public function testGetDocument()
    {
        $controlValue = rand(1, 999);
        $this->modelUnderTest->setDocument($controlValue);
        $this->assertEquals($controlValue, $this->modelUnderTest->getDocument());
    }
            
    public function testGetValueByContractTerms()
    {
        $controlValue = rand(1, 999);
        $this->modelUnderTest->setValueByContractTerms($controlValue);
        $this->assertEquals($controlValue, $this->modelUnderTest->getValueByContractTerms());
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

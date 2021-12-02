<?php
namespace Tests\Domains\HumanResources\Project\ProjectTerms;

use App\Domains\HumanResources\Project\ProjectTerms\ProjectTermsEloquent;
use Tests\TestCase;
use Mockery as m;

class ProjectTermsInterfaceTest extends TestCase
{
    /**
     * Set up test.
     */
    protected function setUp()
    {
        parent::setUp();
        $this->modelUnderTest = new ProjectTermsEloquent();
    }

                
    public function testGetProjectId()
    {
        $controlValue = rand(1, 999);
        $this->modelUnderTest->setProjectId($controlValue);
        $this->assertEquals($controlValue, $this->modelUnderTest->getProjectId());
    }
            
    public function testGetTermsOrder()
    {
        $controlValue = rand(1, 999);
        $this->modelUnderTest->setTermsOrder($controlValue);
        $this->assertEquals($controlValue, $this->modelUnderTest->getTermsOrder());
    }
            
    public function testGetName()
    {
        $controlValue = rand(1, 999);
        $this->modelUnderTest->setName($controlValue);
        $this->assertEquals($controlValue, $this->modelUnderTest->getName());
    }
            
    public function testGetValue()
    {
        $controlValue = rand(1, 999);
        $this->modelUnderTest->setValue($controlValue);
        $this->assertEquals($controlValue, $this->modelUnderTest->getValue());
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

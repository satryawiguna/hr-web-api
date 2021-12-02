<?php
namespace Tests\Domains\HumanResources\Personal\Employee\OrganizationHistory;

use App\Domains\HumanResources\Personal\Employee\OrganizationHistory\OrganizationHistoryEloquent;
use Tests\TestCase;
use Mockery as m;

class OrganizationHistoryInterfaceTest extends TestCase
{
    /**
     * Set up test.
     */
    protected function setUp()
    {
        parent::setUp();
        $this->modelUnderTest = new OrganizationHistoryEloquent();
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
            
    public function testGetDate()
    {
        $controlValue = rand(1, 999);
        $this->modelUnderTest->setDate($controlValue);
        $this->assertEquals($controlValue, $this->modelUnderTest->getDate());
    }
            
    public function testGetActivity()
    {
        $controlValue = rand(1, 999);
        $this->modelUnderTest->setActivity($controlValue);
        $this->assertEquals($controlValue, $this->modelUnderTest->getActivity());
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

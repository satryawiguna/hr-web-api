<?php
namespace Tests\Domains\HumanResources\Mutation\WorkUnitMutation;

use App\Domains\HumanResources\Mutation\WorkUnitMutation\WorkUnitMutationEloquent;
use Tests\TestCase;
use Mockery as m;

class WorkUnitMutationInterfaceTest extends TestCase
{
    /**
     * Set up test.
     */
    protected function setUp()
    {
        parent::setUp();
        $this->modelUnderTest = new WorkUnitMutationEloquent();
    }

                
    public function testGetEmployeeId()
    {
        $controlValue = rand(1, 999);
        $this->modelUnderTest->setEmployeeId($controlValue);
        $this->assertEquals($controlValue, $this->modelUnderTest->getEmployeeId());
    }
            
    public function testGetWorkUnitId()
    {
        $controlValue = rand(1, 999);
        $this->modelUnderTest->setWorkUnitId($controlValue);
        $this->assertEquals($controlValue, $this->modelUnderTest->getWorkUnitId());
    }
            
    public function testGetMutationDate()
    {
        $controlValue = rand(1, 999);
        $this->modelUnderTest->setMutationDate($controlValue);
        $this->assertEquals($controlValue, $this->modelUnderTest->getMutationDate());
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

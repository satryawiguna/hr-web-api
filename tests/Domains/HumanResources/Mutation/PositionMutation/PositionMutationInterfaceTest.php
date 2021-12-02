<?php
namespace Tests\Domains\HumanResources\Mutation\PositionMutation;

use App\Domains\HumanResources\Mutation\PositionMutation\PositionMutationEloquent;
use Tests\TestCase;
use Mockery as m;

class PositionMutationInterfaceTest extends TestCase
{
    /**
     * Set up test.
     */
    protected function setUp()
    {
        parent::setUp();
        $this->modelUnderTest = new PositionMutationEloquent();
    }

                
    public function testGetEmployeeId()
    {
        $controlValue = rand(1, 999);
        $this->modelUnderTest->setEmployeeId($controlValue);
        $this->assertEquals($controlValue, $this->modelUnderTest->getEmployeeId());
    }
            
    public function testGetPositionId()
    {
        $controlValue = rand(1, 999);
        $this->modelUnderTest->setPositionId($controlValue);
        $this->assertEquals($controlValue, $this->modelUnderTest->getPositionId());
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

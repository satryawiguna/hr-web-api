<?php
namespace Tests\Domains\HumanResources\Personal\Employee\Child;

use App\Domains\HumanResources\Personal\Employee\Child\ChildEloquent;
use Tests\TestCase;
use Mockery as m;

class ChildInterfaceTest extends TestCase
{
    /**
     * Set up test.
     */
    protected function setUp()
    {
        parent::setUp();
        $this->modelUnderTest = new ChildEloquent();
    }

                
    public function testGetEmployeeId()
    {
        $controlValue = rand(1, 999);
        $this->modelUnderTest->setEmployeeId($controlValue);
        $this->assertEquals($controlValue, $this->modelUnderTest->getEmployeeId());
    }
            
    public function testGetGenderId()
    {
        $controlValue = rand(1, 999);
        $this->modelUnderTest->setGenderId($controlValue);
        $this->assertEquals($controlValue, $this->modelUnderTest->getGenderId());
    }
            
    public function testGetFullName()
    {
        $controlValue = rand(1, 999);
        $this->modelUnderTest->setFullName($controlValue);
        $this->assertEquals($controlValue, $this->modelUnderTest->getFullName());
    }
            
    public function testGetNickName()
    {
        $controlValue = rand(1, 999);
        $this->modelUnderTest->setNickName($controlValue);
        $this->assertEquals($controlValue, $this->modelUnderTest->getNickName());
    }
            
    public function testGetChildAs()
    {
        $controlValue = rand(1, 999);
        $this->modelUnderTest->setChildAs($controlValue);
        $this->assertEquals($controlValue, $this->modelUnderTest->getChildAs());
    }
            
    public function testGetBirthPlace()
    {
        $controlValue = rand(1, 999);
        $this->modelUnderTest->setBirthPlace($controlValue);
        $this->assertEquals($controlValue, $this->modelUnderTest->getBirthPlace());
    }
            
    public function testGetBirthDate()
    {
        $controlValue = rand(1, 999);
        $this->modelUnderTest->setBirthDate($controlValue);
        $this->assertEquals($controlValue, $this->modelUnderTest->getBirthDate());
    }
            
    public function testGetHasBpjsKesehatan()
    {
        $controlValue = rand(1, 999);
        $this->modelUnderTest->setHasBpjsKesehatan($controlValue);
        $this->assertEquals($controlValue, $this->modelUnderTest->getHasBpjsKesehatan());
    }
            
    public function testGetBpjsKesehatanNumber()
    {
        $controlValue = rand(1, 999);
        $this->modelUnderTest->setBpjsKesehatanNumber($controlValue);
        $this->assertEquals($controlValue, $this->modelUnderTest->getBpjsKesehatanNumber());
    }
            
    public function testGetBpjsKesehatanDate()
    {
        $controlValue = rand(1, 999);
        $this->modelUnderTest->setBpjsKesehatanDate($controlValue);
        $this->assertEquals($controlValue, $this->modelUnderTest->getBpjsKesehatanDate());
    }
            
    public function testGetBpjsKesehatanClass()
    {
        $controlValue = rand(1, 999);
        $this->modelUnderTest->setBpjsKesehatanClass($controlValue);
        $this->assertEquals($controlValue, $this->modelUnderTest->getBpjsKesehatanClass());
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

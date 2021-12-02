<?php
namespace Tests\Domains\Commons\Module;

use App\Domains\Commons\Module\ModuleEloquent;
use Tests\TestCase;
use Mockery as m;

class ModuleInterfaceTest extends TestCase
{
    /**
     * Set up test.
     */
    protected function setUp()
    {
        parent::setUp();
        $this->modelUnderTest = new ModuleEloquent();
    }

                
    public function testGetApplicationId()
    {
        $controlValue = rand(1, 999);
        $this->modelUnderTest->setApplicationId($controlValue);
        $this->assertEquals($controlValue, $this->modelUnderTest->getApplicationId());
    }
            
    public function testGetName()
    {
        $controlValue = rand(1, 999);
        $this->modelUnderTest->setName($controlValue);
        $this->assertEquals($controlValue, $this->modelUnderTest->getName());
    }
            
    public function testGetSlug()
    {
        $controlValue = rand(1, 999);
        $this->modelUnderTest->setSlug($controlValue);
        $this->assertEquals($controlValue, $this->modelUnderTest->getSlug());
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

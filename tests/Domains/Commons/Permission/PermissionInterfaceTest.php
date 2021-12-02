<?php
namespace Tests\Domains\Commons\Permission;

use App\Domains\Commons\Permission\PermissionEloquent;
use Tests\TestCase;
use Mockery as m;

class PermissionInterfaceTest extends TestCase
{
    /**
     * Set up test.
     */
    protected function setUp()
    {
        parent::setUp();
        $this->modelUnderTest = new PermissionEloquent();
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
            
    public function testGetCategory()
    {
        $controlValue = rand(1, 999);
        $this->modelUnderTest->setCategory($controlValue);
        $this->assertEquals($controlValue, $this->modelUnderTest->getCategory());
    }
            
    public function testGetType()
    {
        $controlValue = rand(1, 999);
        $this->modelUnderTest->setType($controlValue);
        $this->assertEquals($controlValue, $this->modelUnderTest->getType());
    }
            
    public function testGetDescription()
    {
        $controlValue = rand(1, 999);
        $this->modelUnderTest->setDescription($controlValue);
        $this->assertEquals($controlValue, $this->modelUnderTest->getDescription());
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

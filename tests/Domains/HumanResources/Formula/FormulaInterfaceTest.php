<?php
namespace Tests\Domains\HumanResources\Formula;

use App\Domains\HumanResources\Formula\FormulaEloquent;
use Tests\TestCase;
use Mockery as m;

class FormulaInterfaceTest extends TestCase
{
    /**
     * Set up test.
     */
    protected function setUp()
    {
        parent::setUp();
        $this->modelUnderTest = new FormulaEloquent();
    }

                
    public function testGetFormulaCategoryId()
    {
        $controlValue = rand(1, 999);
        $this->modelUnderTest->setFormulaCategoryId($controlValue);
        $this->assertEquals($controlValue, $this->modelUnderTest->getFormulaCategoryId());
    }
            
    public function testGetName()
    {
        $controlValue = rand(1, 999);
        $this->modelUnderTest->setName($controlValue);
        $this->assertEquals($controlValue, $this->modelUnderTest->getName());
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

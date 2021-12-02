<?php
namespace Tests\Domains\HumanResources\MasterData\WorkArea;

use App\Domains\HumanResources\MasterData\WorkArea\WorkAreaEloquent;
use Tests\TestCase;
use Mockery as m;

class WorkAreaInterfaceTest extends TestCase
{
    /**
     * Set up test.
     */
    protected function setUp()
    {
        parent::setUp();
        $this->modelUnderTest = new WorkAreaEloquent();
    }

                
    public function testGetCompanyId()
    {
        $controlValue = rand(1, 999);
        $this->modelUnderTest->setCompanyId($controlValue);
        $this->assertEquals($controlValue, $this->modelUnderTest->getCompanyId());
    }
            
    public function testGetCode()
    {
        $controlValue = rand(1, 999);
        $this->modelUnderTest->setCode($controlValue);
        $this->assertEquals($controlValue, $this->modelUnderTest->getCode());
    }
            
    public function testGetTitle()
    {
        $controlValue = rand(1, 999);
        $this->modelUnderTest->setTitle($controlValue);
        $this->assertEquals($controlValue, $this->modelUnderTest->getTitle());
    }
            
    public function testGetSlug()
    {
        $controlValue = rand(1, 999);
        $this->modelUnderTest->setSlug($controlValue);
        $this->assertEquals($controlValue, $this->modelUnderTest->getSlug());
    }
            
    public function testGetCountry()
    {
        $controlValue = rand(1, 999);
        $this->modelUnderTest->setCountry($controlValue);
        $this->assertEquals($controlValue, $this->modelUnderTest->getCountry());
    }
            
    public function testGetState()
    {
        $controlValue = rand(1, 999);
        $this->modelUnderTest->setState($controlValue);
        $this->assertEquals($controlValue, $this->modelUnderTest->getState());
    }
            
    public function testGetCity()
    {
        $controlValue = rand(1, 999);
        $this->modelUnderTest->setCity($controlValue);
        $this->assertEquals($controlValue, $this->modelUnderTest->getCity());
    }
            
    public function testGetAddress()
    {
        $controlValue = rand(1, 999);
        $this->modelUnderTest->setAddress($controlValue);
        $this->assertEquals($controlValue, $this->modelUnderTest->getAddress());
    }
            
    public function testGetPostcode()
    {
        $controlValue = rand(1, 999);
        $this->modelUnderTest->setPostcode($controlValue);
        $this->assertEquals($controlValue, $this->modelUnderTest->getPostcode());
    }
            
    public function testGetPhone()
    {
        $controlValue = rand(1, 999);
        $this->modelUnderTest->setPhone($controlValue);
        $this->assertEquals($controlValue, $this->modelUnderTest->getPhone());
    }
            
    public function testGetFax()
    {
        $controlValue = rand(1, 999);
        $this->modelUnderTest->setFax($controlValue);
        $this->assertEquals($controlValue, $this->modelUnderTest->getFax());
    }
            
    public function testGetEmail()
    {
        $controlValue = rand(1, 999);
        $this->modelUnderTest->setEmail($controlValue);
        $this->assertEquals($controlValue, $this->modelUnderTest->getEmail());
    }
            
    public function testGetUrl()
    {
        $controlValue = rand(1, 999);
        $this->modelUnderTest->setUrl($controlValue);
        $this->assertEquals($controlValue, $this->modelUnderTest->getUrl());
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

<?php
namespace Tests\Domains\Commons\Office;

use App\Domains\Commons\Office\OfficeEloquent;
use Tests\TestCase;
use Mockery as m;

class OfficeInterfaceTest extends TestCase
{
    /**
     * Set up test.
     */
    protected function setUp()
    {
        parent::setUp();
        $this->modelUnderTest = new OfficeEloquent();
    }

                
    public function testGetCompanyId()
    {
        $controlValue = rand(1, 999);
        $this->modelUnderTest->setCompanyId($controlValue);
        $this->assertEquals($controlValue, $this->modelUnderTest->getCompanyId());
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
            
    public function testGetCountry()
    {
        $controlValue = rand(1, 999);
        $this->modelUnderTest->setCountry($controlValue);
        $this->assertEquals($controlValue, $this->modelUnderTest->getCountry());
    }
            
    public function testGetStateOrProvince()
    {
        $controlValue = rand(1, 999);
        $this->modelUnderTest->setStateOrProvince($controlValue);
        $this->assertEquals($controlValue, $this->modelUnderTest->getStateOrProvince());
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
            
    public function testGetLatitude()
    {
        $controlValue = rand(1, 999);
        $this->modelUnderTest->setLatitude($controlValue);
        $this->assertEquals($controlValue, $this->modelUnderTest->getLatitude());
    }
            
    public function testGetLongitude()
    {
        $controlValue = rand(1, 999);
        $this->modelUnderTest->setLongitude($controlValue);
        $this->assertEquals($controlValue, $this->modelUnderTest->getLongitude());
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

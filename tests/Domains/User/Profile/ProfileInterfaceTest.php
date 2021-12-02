<?php
namespace Tests\Domains\User\Profile;

use App\Domains\User\Profile\ProfileEloquent;
use Tests\TestCase;
use Mockery as m;

class ProfileInterfaceTest extends TestCase
{
    /**
     * Set up test.
     */
    protected function setUp()
    {
        parent::setUp();
        $this->modelUnderTest = new ProfileEloquent();
    }

                
    public function testGetUserId()
    {
        $controlValue = rand(1, 999);
        $this->modelUnderTest->setUserId($controlValue);
        $this->assertEquals($controlValue, $this->modelUnderTest->getUserId());
    }
            
    public function testGetFirstName()
    {
        $controlValue = rand(1, 999);
        $this->modelUnderTest->setFirstName($controlValue);
        $this->assertEquals($controlValue, $this->modelUnderTest->getFirstName());
    }
            
    public function testGetLastName()
    {
        $controlValue = rand(1, 999);
        $this->modelUnderTest->setLastName($controlValue);
        $this->assertEquals($controlValue, $this->modelUnderTest->getLastName());
    }
            
    public function testGetDisplayName()
    {
        $controlValue = rand(1, 999);
        $this->modelUnderTest->setDisplayName($controlValue);
        $this->assertEquals($controlValue, $this->modelUnderTest->getDisplayName());
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
            
    public function testGetMobile()
    {
        $controlValue = rand(1, 999);
        $this->modelUnderTest->setMobile($controlValue);
        $this->assertEquals($controlValue, $this->modelUnderTest->getMobile());
    }
            
    public function testGetPicture()
    {
        $controlValue = rand(1, 999);
        $this->modelUnderTest->setPicture($controlValue);
        $this->assertEquals($controlValue, $this->modelUnderTest->getPicture());
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

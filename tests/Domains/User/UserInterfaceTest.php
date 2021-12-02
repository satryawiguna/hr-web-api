<?php
namespace Tests\Domains\User;

use App\Domains\User\UserEloquent;
use Tests\TestCase;
use Mockery as m;

class UserInterfaceTest extends TestCase
{
    /**
     * Set up test.
     */
    protected function setUp()
    {
        parent::setUp();
        $this->modelUnderTest = new UserEloquent();
    }

                
    public function testGetName()
    {
        $controlValue = rand(1, 999);
        $this->modelUnderTest->setName($controlValue);
        $this->assertEquals($controlValue, $this->modelUnderTest->getName());
    }
            
    public function testGetEmail()
    {
        $controlValue = rand(1, 999);
        $this->modelUnderTest->setEmail($controlValue);
        $this->assertEquals($controlValue, $this->modelUnderTest->getEmail());
    }
            
    public function testGetPassword()
    {
        $controlValue = rand(1, 999);
        $this->modelUnderTest->setPassword($controlValue);
        $this->assertEquals($controlValue, $this->modelUnderTest->getPassword());
    }
            
    public function testGetRememberToken()
    {
        $controlValue = rand(1, 999);
        $this->modelUnderTest->setRememberToken($controlValue);
        $this->assertEquals($controlValue, $this->modelUnderTest->getRememberToken());
    }

}

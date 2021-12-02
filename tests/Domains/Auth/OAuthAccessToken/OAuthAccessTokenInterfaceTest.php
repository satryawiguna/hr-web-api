<?php
namespace Tests\Domains\OAuthAccessToken;

use App\Domains\Auth\OAuthAccessToken\OAuthAccessTokenEloquent;
use Tests\TestCase;
use Mockery as m;

class OAuthAccessTokenInterfaceTest extends TestCase
{
    /**
     * Set up test.
     */
    protected function setUp()
    {
        parent::setUp();
        $this->modelUnderTest = new OAuthAccessTokenEloquent();
    }

                
    public function testGetUserId()
    {
        $controlValue = rand(1, 999);
        $this->modelUnderTest->setUserId($controlValue);
        $this->assertEquals($controlValue, $this->modelUnderTest->getUserId());
    }
            
    public function testGetClientId()
    {
        $controlValue = rand(1, 999);
        $this->modelUnderTest->setClientId($controlValue);
        $this->assertEquals($controlValue, $this->modelUnderTest->getClientId());
    }
            
    public function testGetName()
    {
        $controlValue = rand(1, 999);
        $this->modelUnderTest->setName($controlValue);
        $this->assertEquals($controlValue, $this->modelUnderTest->getName());
    }
            
    public function testGetScopes()
    {
        $controlValue = rand(1, 999);
        $this->modelUnderTest->setScopes($controlValue);
        $this->assertEquals($controlValue, $this->modelUnderTest->getScopes());
    }
            
    public function testGetRevoked()
    {
        $controlValue = rand(1, 999);
        $this->modelUnderTest->setRevoked($controlValue);
        $this->assertEquals($controlValue, $this->modelUnderTest->getRevoked());
    }
            
    public function testGetExpiresAt()
    {
        $controlValue = rand(1, 999);
        $this->modelUnderTest->setExpiresAt($controlValue);
        $this->assertEquals($controlValue, $this->modelUnderTest->getExpiresAt());
    }

}

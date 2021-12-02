<?php
namespace Tests\Domains\Applicant;

use App\Domains\Applicant\ApplicantEloquent;
use Tests\TestCase;
use Mockery as m;

class ApplicantInterfaceTest extends TestCase
{
    /**
     * Set up test.
     */
    protected function setUp()
    {
        parent::setUp();
        $this->modelUnderTest = new ApplicantEloquent();
    }

                
    public function testGetVacancyId()
    {
        $controlValue = rand(1, 999);
        $this->modelUnderTest->setVacancyId($controlValue);
        $this->assertEquals($controlValue, $this->modelUnderTest->getVacancyId());
    }
            
    public function testGetGenderId()
    {
        $controlValue = rand(1, 999);
        $this->modelUnderTest->setGenderId($controlValue);
        $this->assertEquals($controlValue, $this->modelUnderTest->getGenderId());
    }
            
    public function testGetReligionId()
    {
        $controlValue = rand(1, 999);
        $this->modelUnderTest->setReligionId($controlValue);
        $this->assertEquals($controlValue, $this->modelUnderTest->getReligionId());
    }
            
    public function testGetMaritalStatusId()
    {
        $controlValue = rand(1, 999);
        $this->modelUnderTest->setMaritalStatusId($controlValue);
        $this->assertEquals($controlValue, $this->modelUnderTest->getMaritalStatusId());
    }
            
    public function testGetNik()
    {
        $controlValue = rand(1, 999);
        $this->modelUnderTest->setNik($controlValue);
        $this->assertEquals($controlValue, $this->modelUnderTest->getNik());
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
            
    public function testGetCitizen()
    {
        $controlValue = rand(1, 999);
        $this->modelUnderTest->setCitizen($controlValue);
        $this->assertEquals($controlValue, $this->modelUnderTest->getCitizen());
    }
            
    public function testGetBirthDate()
    {
        $controlValue = rand(1, 999);
        $this->modelUnderTest->setBirthDate($controlValue);
        $this->assertEquals($controlValue, $this->modelUnderTest->getBirthDate());
    }
            
    public function testGetBirthPlace()
    {
        $controlValue = rand(1, 999);
        $this->modelUnderTest->setBirthPlace($controlValue);
        $this->assertEquals($controlValue, $this->modelUnderTest->getBirthPlace());
    }
            
    public function testGetAge()
    {
        $controlValue = rand(1, 999);
        $this->modelUnderTest->setAge($controlValue);
        $this->assertEquals($controlValue, $this->modelUnderTest->getAge());
    }
            
    public function testGetWeight()
    {
        $controlValue = rand(1, 999);
        $this->modelUnderTest->setWeight($controlValue);
        $this->assertEquals($controlValue, $this->modelUnderTest->getWeight());
    }
            
    public function testGetHeight()
    {
        $controlValue = rand(1, 999);
        $this->modelUnderTest->setHeight($controlValue);
        $this->assertEquals($controlValue, $this->modelUnderTest->getHeight());
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
            
    public function testGetEmail()
    {
        $controlValue = rand(1, 999);
        $this->modelUnderTest->setEmail($controlValue);
        $this->assertEquals($controlValue, $this->modelUnderTest->getEmail());
    }
            
    public function testGetLinkedin()
    {
        $controlValue = rand(1, 999);
        $this->modelUnderTest->setLinkedin($controlValue);
        $this->assertEquals($controlValue, $this->modelUnderTest->getLinkedin());
    }
            
    public function testGetWebsite()
    {
        $controlValue = rand(1, 999);
        $this->modelUnderTest->setWebsite($controlValue);
        $this->assertEquals($controlValue, $this->modelUnderTest->getWebsite());
    }
            
    public function testGetPhoto()
    {
        $controlValue = rand(1, 999);
        $this->modelUnderTest->setPhoto($controlValue);
        $this->assertEquals($controlValue, $this->modelUnderTest->getPhoto());
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

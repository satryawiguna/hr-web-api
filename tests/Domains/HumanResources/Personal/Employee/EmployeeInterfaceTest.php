<?php
namespace Tests\Domains\HumanResources\Personal\Employee;

use App\Domains\HumanResources\Personal\Employee\EmployeeEloquent;
use Tests\TestCase;
use Mockery as m;

class EmployeeInterfaceTest extends TestCase
{
    /**
     * Set up test.
     */
    protected function setUp()
    {
        parent::setUp();
        $this->modelUnderTest = new EmployeeEloquent();
    }

                
    public function testGetCompanyId()
    {
        $controlValue = rand(1, 999);
        $this->modelUnderTest->setCompanyId($controlValue);
        $this->assertEquals($controlValue, $this->modelUnderTest->getCompanyId());
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
            
    public function testGetBankId()
    {
        $controlValue = rand(1, 999);
        $this->modelUnderTest->setBankId($controlValue);
        $this->assertEquals($controlValue, $this->modelUnderTest->getBankId());
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
            
    public function testGetAddress()
    {
        $controlValue = rand(1, 999);
        $this->modelUnderTest->setAddress($controlValue);
        $this->assertEquals($controlValue, $this->modelUnderTest->getAddress());
    }
            
    public function testGetIdentityNumber()
    {
        $controlValue = rand(1, 999);
        $this->modelUnderTest->setIdentityNumber($controlValue);
        $this->assertEquals($controlValue, $this->modelUnderTest->getIdentityNumber());
    }
            
    public function testGetIdentityDate()
    {
        $controlValue = rand(1, 999);
        $this->modelUnderTest->setIdentityDate($controlValue);
        $this->assertEquals($controlValue, $this->modelUnderTest->getIdentityDate());
    }
            
    public function testGetIdentityAddress()
    {
        $controlValue = rand(1, 999);
        $this->modelUnderTest->setIdentityAddress($controlValue);
        $this->assertEquals($controlValue, $this->modelUnderTest->getIdentityAddress());
    }
            
    public function testGetHasDriveLicenseA()
    {
        $controlValue = rand(1, 999);
        $this->modelUnderTest->setHasDriveLicenseA($controlValue);
        $this->assertEquals($controlValue, $this->modelUnderTest->getHasDriveLicenseA());
    }
            
    public function testGetDriveLicenseANumber()
    {
        $controlValue = rand(1, 999);
        $this->modelUnderTest->setDriveLicenseANumber($controlValue);
        $this->assertEquals($controlValue, $this->modelUnderTest->getDriveLicenseANumber());
    }
            
    public function testGetDriveLicenseADate()
    {
        $controlValue = rand(1, 999);
        $this->modelUnderTest->setDriveLicenseADate($controlValue);
        $this->assertEquals($controlValue, $this->modelUnderTest->getDriveLicenseADate());
    }
            
    public function testGetHasDriveLicenseC()
    {
        $controlValue = rand(1, 999);
        $this->modelUnderTest->setHasDriveLicenseC($controlValue);
        $this->assertEquals($controlValue, $this->modelUnderTest->getHasDriveLicenseC());
    }
            
    public function testGetDriveLicenseCNumber()
    {
        $controlValue = rand(1, 999);
        $this->modelUnderTest->setDriveLicenseCNumber($controlValue);
        $this->assertEquals($controlValue, $this->modelUnderTest->getDriveLicenseCNumber());
    }
            
    public function testGetDriveLicenseCDate()
    {
        $controlValue = rand(1, 999);
        $this->modelUnderTest->setDriveLicenseCDate($controlValue);
        $this->assertEquals($controlValue, $this->modelUnderTest->getDriveLicenseCDate());
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
            
    public function testGetMateAs()
    {
        $controlValue = rand(1, 999);
        $this->modelUnderTest->setMateAs($controlValue);
        $this->assertEquals($controlValue, $this->modelUnderTest->getMateAs());
    }
            
    public function testGetMateFiratName()
    {
        $controlValue = rand(1, 999);
        $this->modelUnderTest->setMateFiratName($controlValue);
        $this->assertEquals($controlValue, $this->modelUnderTest->getMateFiratName());
    }
            
    public function testGetMateLastName()
    {
        $controlValue = rand(1, 999);
        $this->modelUnderTest->setMateLastName($controlValue);
        $this->assertEquals($controlValue, $this->modelUnderTest->getMateLastName());
    }
            
    public function testGetMateBirthPlace()
    {
        $controlValue = rand(1, 999);
        $this->modelUnderTest->setMateBirthPlace($controlValue);
        $this->assertEquals($controlValue, $this->modelUnderTest->getMateBirthPlace());
    }
            
    public function testGetMateBirthDate()
    {
        $controlValue = rand(1, 999);
        $this->modelUnderTest->setMateBirthDate($controlValue);
        $this->assertEquals($controlValue, $this->modelUnderTest->getMateBirthDate());
    }
            
    public function testGetHasNpwp()
    {
        $controlValue = rand(1, 999);
        $this->modelUnderTest->setHasNpwp($controlValue);
        $this->assertEquals($controlValue, $this->modelUnderTest->getHasNpwp());
    }
            
    public function testGetNpwpNumber()
    {
        $controlValue = rand(1, 999);
        $this->modelUnderTest->setNpwpNumber($controlValue);
        $this->assertEquals($controlValue, $this->modelUnderTest->getNpwpNumber());
    }
            
    public function testGetNpwpDate()
    {
        $controlValue = rand(1, 999);
        $this->modelUnderTest->setNpwpDate($controlValue);
        $this->assertEquals($controlValue, $this->modelUnderTest->getNpwpDate());
    }
            
    public function testGetNpwpStatus()
    {
        $controlValue = rand(1, 999);
        $this->modelUnderTest->setNpwpStatus($controlValue);
        $this->assertEquals($controlValue, $this->modelUnderTest->getNpwpStatus());
    }
            
    public function testGetHasEmploymentBpjs()
    {
        $controlValue = rand(1, 999);
        $this->modelUnderTest->setHasEmploymentBpjs($controlValue);
        $this->assertEquals($controlValue, $this->modelUnderTest->getHasEmploymentBpjs());
    }
            
    public function testGetEmploymentBpjsNumber()
    {
        $controlValue = rand(1, 999);
        $this->modelUnderTest->setEmploymentBpjsNumber($controlValue);
        $this->assertEquals($controlValue, $this->modelUnderTest->getEmploymentBpjsNumber());
    }
            
    public function testGetEmploymentBpjsDate()
    {
        $controlValue = rand(1, 999);
        $this->modelUnderTest->setEmploymentBpjsDate($controlValue);
        $this->assertEquals($controlValue, $this->modelUnderTest->getEmploymentBpjsDate());
    }
            
    public function testGetEmploymentBpjsClass()
    {
        $controlValue = rand(1, 999);
        $this->modelUnderTest->setEmploymentBpjsClass($controlValue);
        $this->assertEquals($controlValue, $this->modelUnderTest->getEmploymentBpjsClass());
    }
            
    public function testGetHasWellnessBpjs()
    {
        $controlValue = rand(1, 999);
        $this->modelUnderTest->setHasWellnessBpjs($controlValue);
        $this->assertEquals($controlValue, $this->modelUnderTest->getHasWellnessBpjs());
    }
            
    public function testGetWellnessBpjsNumber()
    {
        $controlValue = rand(1, 999);
        $this->modelUnderTest->setWellnessBpjsNumber($controlValue);
        $this->assertEquals($controlValue, $this->modelUnderTest->getWellnessBpjsNumber());
    }
            
    public function testGetWellnessBpjsDate()
    {
        $controlValue = rand(1, 999);
        $this->modelUnderTest->setWellnessBpjsDate($controlValue);
        $this->assertEquals($controlValue, $this->modelUnderTest->getWellnessBpjsDate());
    }
            
    public function testGetWellnessBpjsClass()
    {
        $controlValue = rand(1, 999);
        $this->modelUnderTest->setWellnessBpjsClass($controlValue);
        $this->assertEquals($controlValue, $this->modelUnderTest->getWellnessBpjsClass());
    }
            
    public function testGetMateWellnessBpjsNumber()
    {
        $controlValue = rand(1, 999);
        $this->modelUnderTest->setMateWellnessBpjsNumber($controlValue);
        $this->assertEquals($controlValue, $this->modelUnderTest->getMateWellnessBpjsNumber());
    }
            
    public function testGetMateWellnessBpjsDate()
    {
        $controlValue = rand(1, 999);
        $this->modelUnderTest->setMateWellnessBpjsDate($controlValue);
        $this->assertEquals($controlValue, $this->modelUnderTest->getMateWellnessBpjsDate());
    }
            
    public function testGetMateWellnessBpjsClass()
    {
        $controlValue = rand(1, 999);
        $this->modelUnderTest->setMateWellnessBpjsClass($controlValue);
        $this->assertEquals($controlValue, $this->modelUnderTest->getMateWellnessBpjsClass());
    }
            
    public function testGetDplkNumber()
    {
        $controlValue = rand(1, 999);
        $this->modelUnderTest->setDplkNumber($controlValue);
        $this->assertEquals($controlValue, $this->modelUnderTest->getDplkNumber());
    }
            
    public function testGetCollectiveNumber()
    {
        $controlValue = rand(1, 999);
        $this->modelUnderTest->setCollectiveNumber($controlValue);
        $this->assertEquals($controlValue, $this->modelUnderTest->getCollectiveNumber());
    }
            
    public function testGetEnglishAbility()
    {
        $controlValue = rand(1, 999);
        $this->modelUnderTest->setEnglishAbility($controlValue);
        $this->assertEquals($controlValue, $this->modelUnderTest->getEnglishAbility());
    }
            
    public function testGetComputerAbility()
    {
        $controlValue = rand(1, 999);
        $this->modelUnderTest->setComputerAbility($controlValue);
        $this->assertEquals($controlValue, $this->modelUnderTest->getComputerAbility());
    }
            
    public function testGetOtherAbility()
    {
        $controlValue = rand(1, 999);
        $this->modelUnderTest->setOtherAbility($controlValue);
        $this->assertEquals($controlValue, $this->modelUnderTest->getOtherAbility());
    }
            
    public function testGetAccountNumber()
    {
        $controlValue = rand(1, 999);
        $this->modelUnderTest->setAccountNumber($controlValue);
        $this->assertEquals($controlValue, $this->modelUnderTest->getAccountNumber());
    }

}

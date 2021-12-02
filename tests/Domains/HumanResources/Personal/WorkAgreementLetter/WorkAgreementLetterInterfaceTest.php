<?php
namespace Tests\Domains\WorkAgreementLetter;

use App\Domains\WorkAgreementLetter\WorkAgreementLetterEloquent;
use Tests\TestCase;
use Mockery as m;

class WorkAgreementLetterInterfaceTest extends TestCase
{
    /**
     * Set up test.
     */
    protected function setUp()
    {
        parent::setUp();
        $this->modelUnderTest = new WorkAgreementLetterEloquent();
    }

                
    public function testGetEmployeeId()
    {
        $controlValue = rand(1, 999);
        $this->modelUnderTest->setEmployeeId($controlValue);
        $this->assertEquals($controlValue, $this->modelUnderTest->getEmployeeId());
    }
            
    public function testGetLetterTypeId()
    {
        $controlValue = rand(1, 999);
        $this->modelUnderTest->setLetterTypeId($controlValue);
        $this->assertEquals($controlValue, $this->modelUnderTest->getLetterTypeId());
    }
            
    public function testGetReferenceNumber()
    {
        $controlValue = rand(1, 999);
        $this->modelUnderTest->setReferenceNumber($controlValue);
        $this->assertEquals($controlValue, $this->modelUnderTest->getReferenceNumber());
    }
            
    public function testGetStartDate()
    {
        $controlValue = rand(1, 999);
        $this->modelUnderTest->setStartDate($controlValue);
        $this->assertEquals($controlValue, $this->modelUnderTest->getStartDate());
    }
            
    public function testGetEndDate()
    {
        $controlValue = rand(1, 999);
        $this->modelUnderTest->setEndDate($controlValue);
        $this->assertEquals($controlValue, $this->modelUnderTest->getEndDate());
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

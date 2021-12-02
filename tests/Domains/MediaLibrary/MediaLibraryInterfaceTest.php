<?php
namespace Tests\Domains\MediaLibrary;

use App\Domains\MediaLibrary\MediaLibraryEloquent;
use Tests\TestCase;
use Mockery as m;

class MediaLibraryInterfaceTest extends TestCase
{
    /**
     * Set up test.
     */
    protected function setUp()
    {
        parent::setUp();
        $this->modelUnderTest = new MediaLibraryEloquent();
    }

                
    public function testGetCompanyId()
    {
        $controlValue = rand(1, 999);
        $this->modelUnderTest->setCompanyId($controlValue);
        $this->assertEquals($controlValue, $this->modelUnderTest->getCompanyId());
    }
            
    public function testGetCollection()
    {
        $controlValue = rand(1, 999);
        $this->modelUnderTest->setCollection($controlValue);
        $this->assertEquals($controlValue, $this->modelUnderTest->getCollection());
    }
            
    public function testGetCategory()
    {
        $controlValue = rand(1, 999);
        $this->modelUnderTest->setCategory($controlValue);
        $this->assertEquals($controlValue, $this->modelUnderTest->getCategory());
    }
            
    public function testGetOriginalName()
    {
        $controlValue = rand(1, 999);
        $this->modelUnderTest->setOriginalName($controlValue);
        $this->assertEquals($controlValue, $this->modelUnderTest->getOriginalName());
    }
            
    public function testGetGenerateName()
    {
        $controlValue = rand(1, 999);
        $this->modelUnderTest->setGenerateName($controlValue);
        $this->assertEquals($controlValue, $this->modelUnderTest->getGenerateName());
    }
            
    public function testGetExtension()
    {
        $controlValue = rand(1, 999);
        $this->modelUnderTest->setExtension($controlValue);
        $this->assertEquals($controlValue, $this->modelUnderTest->getExtension());
    }
            
    public function testGetMimeType()
    {
        $controlValue = rand(1, 999);
        $this->modelUnderTest->setMimeType($controlValue);
        $this->assertEquals($controlValue, $this->modelUnderTest->getMimeType());
    }
            
    public function testGetDisk()
    {
        $controlValue = rand(1, 999);
        $this->modelUnderTest->setDisk($controlValue);
        $this->assertEquals($controlValue, $this->modelUnderTest->getDisk());
    }
            
    public function testGetSize()
    {
        $controlValue = rand(1, 999);
        $this->modelUnderTest->setSize($controlValue);
        $this->assertEquals($controlValue, $this->modelUnderTest->getSize());
    }
            
    public function testGetUrl()
    {
        $controlValue = rand(1, 999);
        $this->modelUnderTest->setUrl($controlValue);
        $this->assertEquals($controlValue, $this->modelUnderTest->getUrl());
    }
            
    public function testGetThumb()
    {
        $controlValue = rand(1, 999);
        $this->modelUnderTest->setThumb($controlValue);
        $this->assertEquals($controlValue, $this->modelUnderTest->getThumb());
    }
            
    public function testGetIcon()
    {
        $controlValue = rand(1, 999);
        $this->modelUnderTest->setIcon($controlValue);
        $this->assertEquals($controlValue, $this->modelUnderTest->getIcon());
    }
            
    public function testGetGenerateThumb()
    {
        $controlValue = rand(1, 999);
        $this->modelUnderTest->setGenerateThumb($controlValue);
        $this->assertEquals($controlValue, $this->modelUnderTest->getGenerateThumb());
    }
            
    public function testGetGenerateIcon()
    {
        $controlValue = rand(1, 999);
        $this->modelUnderTest->setGenerateIcon($controlValue);
        $this->assertEquals($controlValue, $this->modelUnderTest->getGenerateIcon());
    }

}

<?php
namespace Tests\Domains\HumanResources\Element\ElementEntryValue;

use App\Domains\HumanResources\Element\ElementEntryValue\Contracts\ElementEntryValueInterface;
use App\Domains\HumanResources\Element\ElementEntryValue\Contracts\ElementEntryValueRepositoryInterface;
use App\Domains\HumanResources\Element\ElementEntryValue\Contracts\ElementEntryValueServiceInterface;
use App\Domains\HumanResources\Element\ElementEntryValue\ElementEntryValueEloquent;
use App\Domains\HumanResources\Element\ElementEntryValue\ElementEntryValueService;
use Mockery as m;
use Tests\TestCase;

class ElementEntryValueServiceTest extends TestCase
{
    private $repository;
    private $service;

    /**
     * Set up test.
     */
    protected function setUp()
    {
        parent::setUp();

        $this->repository = m::mock(ElementEntryValueRepositoryInterface::class);
        $this->service = new ElementEntryValueService(
            $this->repository
        );
    }

    /**
     * Callback after finish test.
     */
    protected function tearDown()
    {
        m::close();
    }

    /**
     * Test constructor.
     */
    public function testConstructor()
    {
        $this->assertInstanceOf(ElementEntryValueServiceInterface::class, $this->service);
    }

    /**
     * Test create notes.
     */
    public function testCreate()
    {
        $object = m::mock(ElementEntryValueInterface::class);
        $this->repository->shouldReceive('create')->with($object)->andReturn($object);
        $result = $this->service->create($object);
        $this->assertInstanceOf(ElementEntryValueInterface::class, $result);
        $this->assertEquals($object, $result);
    }

    /**
     * Test delete notes.
     */
    public function testDelete()
    {
        $object = m::mock(ElementEntryValueInterface::class);
        $this->repository->shouldReceive('delete')->with($object)->andReturn(true);
        $result = $this->service->delete($object);
        $this->assertTrue($result);
    }

    /**
     * Test update notes.
     */
    public function testUpdate()
    {
        $object = m::mock(ElementEntryValueInterface::class);
        $this->repository->shouldReceive('update')->with($object)->andReturn($object);
        $result = $this->service->update($object);
        $this->assertEquals($object, $result);
    }
}

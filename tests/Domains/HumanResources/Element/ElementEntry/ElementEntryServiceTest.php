<?php
namespace Tests\Domains\HumanResources\Element\ElementEntry;

use App\Domains\HumanResources\Element\ElementEntry\Contracts\ElementEntryInterface;
use App\Domains\HumanResources\Element\ElementEntry\Contracts\ElementEntryRepositoryInterface;
use App\Domains\HumanResources\Element\ElementEntry\Contracts\ElementEntryServiceInterface;
use App\Domains\HumanResources\Element\ElementEntry\ElementEntryEloquent;
use App\Domains\HumanResources\Element\ElementEntry\ElementEntryService;
use Mockery as m;
use Tests\TestCase;

class ElementEntryServiceTest extends TestCase
{
    private $repository;
    private $service;

    /**
     * Set up test.
     */
    protected function setUp()
    {
        parent::setUp();

        $this->repository = m::mock(ElementEntryRepositoryInterface::class);
        $this->service = new ElementEntryService(
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
        $this->assertInstanceOf(ElementEntryServiceInterface::class, $this->service);
    }

    /**
     * Test create notes.
     */
    public function testCreate()
    {
        $object = m::mock(ElementEntryInterface::class);
        $this->repository->shouldReceive('create')->with($object)->andReturn($object);
        $result = $this->service->create($object);
        $this->assertInstanceOf(ElementEntryInterface::class, $result);
        $this->assertEquals($object, $result);
    }

    /**
     * Test delete notes.
     */
    public function testDelete()
    {
        $object = m::mock(ElementEntryInterface::class);
        $this->repository->shouldReceive('delete')->with($object)->andReturn(true);
        $result = $this->service->delete($object);
        $this->assertTrue($result);
    }

    /**
     * Test update notes.
     */
    public function testUpdate()
    {
        $object = m::mock(ElementEntryInterface::class);
        $this->repository->shouldReceive('update')->with($object)->andReturn($object);
        $result = $this->service->update($object);
        $this->assertEquals($object, $result);
    }
}

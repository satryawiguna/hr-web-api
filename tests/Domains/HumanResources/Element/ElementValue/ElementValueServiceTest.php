<?php
namespace Tests\Domains\HumanResources\Element\ElementValue;

use App\Domains\HumanResources\Element\ElementValue\Contracts\ElementValueInterface;
use App\Domains\HumanResources\Element\ElementValue\Contracts\ElementValueRepositoryInterface;
use App\Domains\HumanResources\Element\ElementValue\Contracts\ElementValueServiceInterface;
use App\Domains\HumanResources\Element\ElementValue\ElementValueEloquent;
use App\Domains\HumanResources\Element\ElementValue\ElementValueService;
use Mockery as m;
use Tests\TestCase;

class ElementValueServiceTest extends TestCase
{
    private $repository;
    private $service;

    /**
     * Set up test.
     */
    protected function setUp()
    {
        parent::setUp();

        $this->repository = m::mock(ElementValueRepositoryInterface::class);
        $this->service = new ElementValueService(
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
        $this->assertInstanceOf(ElementValueServiceInterface::class, $this->service);
    }

    /**
     * Test create notes.
     */
    public function testCreate()
    {
        $object = m::mock(ElementValueInterface::class);
        $this->repository->shouldReceive('create')->with($object)->andReturn($object);
        $result = $this->service->create($object);
        $this->assertInstanceOf(ElementValueInterface::class, $result);
        $this->assertEquals($object, $result);
    }

    /**
     * Test delete notes.
     */
    public function testDelete()
    {
        $object = m::mock(ElementValueInterface::class);
        $this->repository->shouldReceive('delete')->with($object)->andReturn(true);
        $result = $this->service->delete($object);
        $this->assertTrue($result);
    }

    /**
     * Test update notes.
     */
    public function testUpdate()
    {
        $object = m::mock(ElementValueInterface::class);
        $this->repository->shouldReceive('update')->with($object)->andReturn($object);
        $result = $this->service->update($object);
        $this->assertEquals($object, $result);
    }
}

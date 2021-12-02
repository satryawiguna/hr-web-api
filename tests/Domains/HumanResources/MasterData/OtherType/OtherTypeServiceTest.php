<?php
namespace Tests\Domains\HumanResources\MasterData\OtherType;

use App\Domains\HumanResources\MasterData\OtherType\Contracts\OtherTypeInterface;
use App\Domains\HumanResources\MasterData\OtherType\Contracts\OtherTypeRepositoryInterface;
use App\Domains\HumanResources\MasterData\OtherType\Contracts\OtherTypeServiceInterface;
use App\Domains\HumanResources\MasterData\OtherType\OtherTypeEloquent;
use App\Domains\HumanResources\MasterData\OtherType\OtherTypeService;
use Mockery as m;
use Tests\TestCase;

class OtherTypeServiceTest extends TestCase
{
    private $repository;
    private $service;

    /**
     * Set up test.
     */
    protected function setUp()
    {
        parent::setUp();

        $this->repository = m::mock(OtherTypeRepositoryInterface::class);
        $this->service = new OtherTypeService(
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
        $this->assertInstanceOf(OtherTypeServiceInterface::class, $this->service);
    }

    /**
     * Test create notes.
     */
    public function testCreate()
    {
        $object = m::mock(OtherTypeInterface::class);
        $this->repository->shouldReceive('create')->with($object)->andReturn($object);
        $result = $this->service->create($object);
        $this->assertInstanceOf(OtherTypeInterface::class, $result);
        $this->assertEquals($object, $result);
    }

    /**
     * Test delete notes.
     */
    public function testDelete()
    {
        $object = m::mock(OtherTypeInterface::class);
        $this->repository->shouldReceive('delete')->with($object)->andReturn(true);
        $result = $this->service->delete($object);
        $this->assertTrue($result);
    }

    /**
     * Test update notes.
     */
    public function testUpdate()
    {
        $object = m::mock(OtherTypeInterface::class);
        $this->repository->shouldReceive('update')->with($object)->andReturn($object);
        $result = $this->service->update($object);
        $this->assertEquals($object, $result);
    }
}

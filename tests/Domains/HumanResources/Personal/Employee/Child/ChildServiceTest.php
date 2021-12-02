<?php
namespace Tests\Domains\Child;

use App\Domains\HumanResources\Personal\Employee\Child\Contracts\ChildInterface;
use App\Domains\HumanResources\Personal\Employee\Child\Contracts\ChildRepositoryInterface;
use App\Domains\HumanResources\Personal\Employee\Child\Contracts\ChildServiceInterface;
use App\Domains\HumanResources\Personal\Employee\Child\ChildEloquent;
use App\Domains\HumanResources\Personal\Employee\Child\ChildService;
use Mockery as m;
use Tests\TestCase;

class ChildServiceTest extends TestCase
{
    private $repository;
    private $service;

    /**
     * Set up test.
     */
    protected function setUp()
    {
        parent::setUp();

        $this->repository = m::mock(ChildRepositoryInterface::class);
        $this->service = new ChildService(
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
        $this->assertInstanceOf(ChildServiceInterface::class, $this->service);
    }

    /**
     * Test create notes.
     */
    public function testCreate()
    {
        $object = m::mock(ChildInterface::class);
        $this->repository->shouldReceive('create')->with($object)->andReturn($object);
        $result = $this->service->create($object);
        $this->assertInstanceOf(ChildInterface::class, $result);
        $this->assertEquals($object, $result);
    }

    /**
     * Test delete notes.
     */
    public function testDelete()
    {
        $object = m::mock(ChildInterface::class);
        $this->repository->shouldReceive('delete')->with($object)->andReturn(true);
        $result = $this->service->delete($object);
        $this->assertTrue($result);
    }

    /**
     * Test update notes.
     */
    public function testUpdate()
    {
        $object = m::mock(ChildInterface::class);
        $this->repository->shouldReceive('update')->with($object)->andReturn($object);
        $result = $this->service->update($object);
        $this->assertEquals($object, $result);
    }
}

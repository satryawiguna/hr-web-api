<?php
namespace Tests\Domains\Commons\Permission;

use App\Domains\Commons\Permission\Contracts\PermissionInterface;
use App\Domains\Commons\Permission\Contracts\PermissionRepositoryInterface;
use App\Domains\Commons\Permission\Contracts\PermissionServiceInterface;
use App\Domains\Commons\Permission\PermissionEloquent;
use App\Domains\Commons\Permission\PermissionService;
use Mockery as m;
use Tests\TestCase;

class PermissionServiceTest extends TestCase
{
    private $repository;
    private $service;

    /**
     * Set up test.
     */
    protected function setUp()
    {
        parent::setUp();

        $this->repository = m::mock(PermissionRepositoryInterface::class);
        $this->service = new PermissionService(
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
        $this->assertInstanceOf(PermissionServiceInterface::class, $this->service);
    }

    /**
     * Test create notes.
     */
    public function testCreate()
    {
        $object = m::mock(PermissionInterface::class);
        $this->repository->shouldReceive('create')->with($object)->andReturn($object);
        $result = $this->service->create($object);
        $this->assertInstanceOf(PermissionInterface::class, $result);
        $this->assertEquals($object, $result);
    }

    /**
     * Test delete notes.
     */
    public function testDelete()
    {
        $object = m::mock(PermissionInterface::class);
        $this->repository->shouldReceive('delete')->with($object)->andReturn(true);
        $result = $this->service->delete($object);
        $this->assertTrue($result);
    }

    /**
     * Test update notes.
     */
    public function testUpdate()
    {
        $object = m::mock(PermissionInterface::class);
        $this->repository->shouldReceive('update')->with($object)->andReturn($object);
        $result = $this->service->update($object);
        $this->assertEquals($object, $result);
    }
}

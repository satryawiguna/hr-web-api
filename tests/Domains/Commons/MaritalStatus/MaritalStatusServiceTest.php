<?php
namespace Tests\Domains\Commons\Status;

use App\Domains\Commons\MaritalStatus\Contracts\MaritalStatusInterface;
use App\Domains\Commons\MaritalStatus\Contracts\MaritalStatusRepositoryInterface;
use App\Domains\Commons\MaritalStatus\Contracts\MaritalStatusServiceInterface;
use App\Domains\Commons\MaritalStatus\MaritalStatusEloquent;
use App\Domains\Commons\MaritalStatus\MaritalStatusService;
use Mockery as m;
use Tests\TestCase;

class StatusServiceTest extends TestCase
{
    private $repository;
    private $service;

    /**
     * Set up test.
     */
    protected function setUp()
    {
        parent::setUp();

        $this->repository = m::mock(MaritalStatusRepositoryInterface::class);
        $this->service = new MaritalStatusService(
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
        $this->assertInstanceOf(MaritalStatusServiceInterface::class, $this->service);
    }

    /**
     * Test create notes.
     */
    public function testCreate()
    {
        $object = m::mock(MaritalStatusInterface::class);
        $this->repository->shouldReceive('create')->with($object)->andReturn($object);
        $result = $this->service->create($object);
        $this->assertInstanceOf(StatusInterface::class, $result);
        $this->assertEquals($object, $result);
    }

    /**
     * Test delete notes.
     */
    public function testDelete()
    {
        $object = m::mock(MaritalStatusInterface::class);
        $this->repository->shouldReceive('delete')->with($object)->andReturn(true);
        $result = $this->service->delete($object);
        $this->assertTrue($result);
    }

    /**
     * Test update notes.
     */
    public function testUpdate()
    {
        $object = m::mock(MaritalStatusInterface::class);
        $this->repository->shouldReceive('update')->with($object)->andReturn($object);
        $result = $this->service->update($object);
        $this->assertEquals($object, $result);
    }
}

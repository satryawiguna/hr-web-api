<?php
namespace Tests\Domains\Commons\Application;

use App\Domains\Commons\Application\Contracts\ApplicationInterface;
use App\Domains\Commons\Application\Contracts\ApplicationRepositoryInterface;
use App\Domains\Commons\Application\Contracts\ApplicationServiceInterface;
use App\Domains\Commons\Application\ApplicationEloquent;
use App\Domains\Commons\Application\ApplicationService;
use Mockery as m;
use Tests\TestCase;

class ApplicationServiceTest extends TestCase
{
    private $repository;
    private $service;

    /**
     * Set up test.
     */
    protected function setUp()
    {
        parent::setUp();

        $this->repository = m::mock(ApplicationRepositoryInterface::class);
        $this->service = new ApplicationService(
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
        $this->assertInstanceOf(ApplicationServiceInterface::class, $this->service);
    }

    /**
     * Test create notes.
     */
    public function testCreate()
    {
        $object = m::mock(ApplicationInterface::class);
        $this->repository->shouldReceive('create')->with($object)->andReturn($object);
        $result = $this->service->create($object);
        $this->assertInstanceOf(ApplicationInterface::class, $result);
        $this->assertEquals($object, $result);
    }

    /**
     * Test delete notes.
     */
    public function testDelete()
    {
        $object = m::mock(ApplicationInterface::class);
        $this->repository->shouldReceive('delete')->with($object)->andReturn(true);
        $result = $this->service->delete($object);
        $this->assertTrue($result);
    }

    /**
     * Test update notes.
     */
    public function testUpdate()
    {
        $object = m::mock(ApplicationInterface::class);
        $this->repository->shouldReceive('update')->with($object)->andReturn($object);
        $result = $this->service->update($object);
        $this->assertEquals($object, $result);
    }
}

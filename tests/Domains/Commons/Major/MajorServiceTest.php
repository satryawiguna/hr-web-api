<?php
namespace Tests\Domains\Commons\Major;

use App\Domains\Commons\Major\Contracts\MajorInterface;
use App\Domains\Commons\Major\Contracts\MajorRepositoryInterface;
use App\Domains\Commons\Major\Contracts\MajorServiceInterface;
use App\Domains\Commons\Major\MajorEloquent;
use App\Domains\Commons\Major\MajorService;
use Mockery as m;
use Tests\TestCase;

class MajorServiceTest extends TestCase
{
    private $repository;
    private $service;

    /**
     * Set up test.
     */
    protected function setUp()
    {
        parent::setUp();

        $this->repository = m::mock(MajorRepositoryInterface::class);
        $this->service = new MajorService(
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
        $this->assertInstanceOf(MajorServiceInterface::class, $this->service);
    }

    /**
     * Test create notes.
     */
    public function testCreate()
    {
        $object = m::mock(MajorInterface::class);
        $this->repository->shouldReceive('create')->with($object)->andReturn($object);
        $result = $this->service->create($object);
        $this->assertInstanceOf(MajorInterface::class, $result);
        $this->assertEquals($object, $result);
    }

    /**
     * Test delete notes.
     */
    public function testDelete()
    {
        $object = m::mock(MajorInterface::class);
        $this->repository->shouldReceive('delete')->with($object)->andReturn(true);
        $result = $this->service->delete($object);
        $this->assertTrue($result);
    }

    /**
     * Test update notes.
     */
    public function testUpdate()
    {
        $object = m::mock(MajorInterface::class);
        $this->repository->shouldReceive('update')->with($object)->andReturn($object);
        $result = $this->service->update($object);
        $this->assertEquals($object, $result);
    }
}

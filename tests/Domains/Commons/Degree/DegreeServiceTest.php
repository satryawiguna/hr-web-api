<?php
namespace Tests\Domains\Commons\Degree;

use App\Domains\Commons\Degree\Contracts\DegreeInterface;
use App\Domains\Commons\Degree\Contracts\DegreeRepositoryInterface;
use App\Domains\Commons\Degree\Contracts\DegreeServiceInterface;
use App\Domains\Commons\Degree\DegreeEloquent;
use App\Domains\Commons\Degree\DegreeService;
use Mockery as m;
use Tests\TestCase;

class DegreeServiceTest extends TestCase
{
    private $repository;
    private $service;

    /**
     * Set up test.
     */
    protected function setUp()
    {
        parent::setUp();

        $this->repository = m::mock(DegreeRepositoryInterface::class);
        $this->service = new DegreeService(
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
        $this->assertInstanceOf(DegreeServiceInterface::class, $this->service);
    }

    /**
     * Test create notes.
     */
    public function testCreate()
    {
        $object = m::mock(DegreeInterface::class);
        $this->repository->shouldReceive('create')->with($object)->andReturn($object);
        $result = $this->service->create($object);
        $this->assertInstanceOf(DegreeInterface::class, $result);
        $this->assertEquals($object, $result);
    }

    /**
     * Test delete notes.
     */
    public function testDelete()
    {
        $object = m::mock(DegreeInterface::class);
        $this->repository->shouldReceive('delete')->with($object)->andReturn(true);
        $result = $this->service->delete($object);
        $this->assertTrue($result);
    }

    /**
     * Test update notes.
     */
    public function testUpdate()
    {
        $object = m::mock(DegreeInterface::class);
        $this->repository->shouldReceive('update')->with($object)->andReturn($object);
        $result = $this->service->update($object);
        $this->assertEquals($object, $result);
    }
}

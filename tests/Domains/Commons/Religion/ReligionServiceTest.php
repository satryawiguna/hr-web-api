<?php
namespace Tests\Domains\Commons\Commons\Religion;

use App\Domains\Commons\Religion\Contracts\ReligionInterface;
use App\Domains\Commons\Religion\Contracts\ReligionRepositoryInterface;
use App\Domains\Commons\Religion\Contracts\ReligionServiceInterface;
use App\Domains\Commons\Religion\ReligionEloquent;
use App\Domains\Commons\Religion\ReligionService;
use Mockery as m;
use Tests\TestCase;

class ReligionServiceTest extends TestCase
{
    private $repository;
    private $service;

    /**
     * Set up test.
     */
    protected function setUp()
    {
        parent::setUp();

        $this->repository = m::mock(ReligionRepositoryInterface::class);
        $this->service = new ReligionService(
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
        $this->assertInstanceOf(ReligionServiceInterface::class, $this->service);
    }

    /**
     * Test create notes.
     */
    public function testCreate()
    {
        $object = m::mock(ReligionInterface::class);
        $this->repository->shouldReceive('create')->with($object)->andReturn($object);
        $result = $this->service->create($object);
        $this->assertInstanceOf(ReligionInterface::class, $result);
        $this->assertEquals($object, $result);
    }

    /**
     * Test delete notes.
     */
    public function testDelete()
    {
        $object = m::mock(ReligionInterface::class);
        $this->repository->shouldReceive('delete')->with($object)->andReturn(true);
        $result = $this->service->delete($object);
        $this->assertTrue($result);
    }

    /**
     * Test update notes.
     */
    public function testUpdate()
    {
        $object = m::mock(ReligionInterface::class);
        $this->repository->shouldReceive('update')->with($object)->andReturn($object);
        $result = $this->service->update($object);
        $this->assertEquals($object, $result);
    }
}

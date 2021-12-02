<?php
namespace Tests\Domains\HumanResources\MasterData\Grade;

use App\Domains\HumanResources\MasterData\Grade\Contracts\GradeInterface;
use App\Domains\HumanResources\MasterData\Grade\Contracts\GradeRepositoryInterface;
use App\Domains\HumanResources\MasterData\Grade\Contracts\GradeServiceInterface;
use App\Domains\HumanResources\MasterData\Grade\GradeEloquent;
use App\Domains\HumanResources\MasterData\Grade\GradeService;
use Mockery as m;
use Tests\TestCase;

class GradeServiceTest extends TestCase
{
    private $repository;
    private $service;

    /**
     * Set up test.
     */
    protected function setUp()
    {
        parent::setUp();

        $this->repository = m::mock(GradeRepositoryInterface::class);
        $this->service = new GradeService(
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
        $this->assertInstanceOf(GradeServiceInterface::class, $this->service);
    }

    /**
     * Test create notes.
     */
    public function testCreate()
    {
        $object = m::mock(GradeInterface::class);
        $this->repository->shouldReceive('create')->with($object)->andReturn($object);
        $result = $this->service->create($object);
        $this->assertInstanceOf(GradeInterface::class, $result);
        $this->assertEquals($object, $result);
    }

    /**
     * Test delete notes.
     */
    public function testDelete()
    {
        $object = m::mock(GradeInterface::class);
        $this->repository->shouldReceive('delete')->with($object)->andReturn(true);
        $result = $this->service->delete($object);
        $this->assertTrue($result);
    }

    /**
     * Test update notes.
     */
    public function testUpdate()
    {
        $object = m::mock(GradeInterface::class);
        $this->repository->shouldReceive('update')->with($object)->andReturn($object);
        $result = $this->service->update($object);
        $this->assertEquals($object, $result);
    }
}

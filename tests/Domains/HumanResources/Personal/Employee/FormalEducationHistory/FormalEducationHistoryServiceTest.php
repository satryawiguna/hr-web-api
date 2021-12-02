<?php
namespace Tests\Domains\HumanResources\Personal\Employee\FormalEducationHistory;

use App\Domains\HumanResources\Personal\Employee\FormalEducationHistory\Contracts\FormalEducationHistoryInterface;
use App\Domains\HumanResources\Personal\Employee\FormalEducationHistory\Contracts\FormalEducationHistoryRepositoryInterface;
use App\Domains\HumanResources\Personal\Employee\FormalEducationHistory\Contracts\FormalEducationHistoryServiceInterface;
use App\Domains\HumanResources\Personal\Employee\FormalEducationHistory\FormalEducationHistoryEloquent;
use App\Domains\HumanResources\Personal\Employee\FormalEducationHistory\FormalEducationHistoryService;
use Mockery as m;
use Tests\TestCase;

class FormalEducationHistoryServiceTest extends TestCase
{
    private $repository;
    private $service;

    /**
     * Set up test.
     */
    protected function setUp()
    {
        parent::setUp();

        $this->repository = m::mock(FormalEducationHistoryRepositoryInterface::class);
        $this->service = new FormalEducationHistoryService(
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
        $this->assertInstanceOf(FormalEducationHistoryServiceInterface::class, $this->service);
    }

    /**
     * Test create notes.
     */
    public function testCreate()
    {
        $object = m::mock(FormalEducationHistoryInterface::class);
        $this->repository->shouldReceive('create')->with($object)->andReturn($object);
        $result = $this->service->create($object);
        $this->assertInstanceOf(FormalEducationHistoryInterface::class, $result);
        $this->assertEquals($object, $result);
    }

    /**
     * Test delete notes.
     */
    public function testDelete()
    {
        $object = m::mock(FormalEducationHistoryInterface::class);
        $this->repository->shouldReceive('delete')->with($object)->andReturn(true);
        $result = $this->service->delete($object);
        $this->assertTrue($result);
    }

    /**
     * Test update notes.
     */
    public function testUpdate()
    {
        $object = m::mock(FormalEducationHistoryInterface::class);
        $this->repository->shouldReceive('update')->with($object)->andReturn($object);
        $result = $this->service->update($object);
        $this->assertEquals($object, $result);
    }
}

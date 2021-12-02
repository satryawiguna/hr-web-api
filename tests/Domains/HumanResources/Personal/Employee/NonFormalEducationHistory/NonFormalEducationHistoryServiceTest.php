<?php
namespace Tests\Domains\HumanResources\Personal\Employee\NonFormalEducationHistory;

use App\Domains\HumanResources\Personal\Employee\NonFormalEducationHistory\Contracts\NonFormalEducationHistoryInterface;
use App\Domains\HumanResources\Personal\Employee\NonFormalEducationHistory\Contracts\NonFormalEducationHistoryRepositoryInterface;
use App\Domains\HumanResources\Personal\Employee\NonFormalEducationHistory\Contracts\NonFormalEducationHistoryServiceInterface;
use App\Domains\HumanResources\Personal\Employee\NonFormalEducationHistory\NonFormalEducationHistoryEloquent;
use App\Domains\HumanResources\Personal\Employee\NonFormalEducationHistory\NonFormalEducationHistoryService;
use Mockery as m;
use Tests\TestCase;

class NonFormalEducationHistoryServiceTest extends TestCase
{
    private $repository;
    private $service;

    /**
     * Set up test.
     */
    protected function setUp()
    {
        parent::setUp();

        $this->repository = m::mock(NonFormalEducationHistoryRepositoryInterface::class);
        $this->service = new NonFormalEducationHistoryService(
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
        $this->assertInstanceOf(NonFormalEducationHistoryServiceInterface::class, $this->service);
    }

    /**
     * Test create notes.
     */
    public function testCreate()
    {
        $object = m::mock(NonFormalEducationHistoryInterface::class);
        $this->repository->shouldReceive('create')->with($object)->andReturn($object);
        $result = $this->service->create($object);
        $this->assertInstanceOf(NonFormalEducationHistoryInterface::class, $result);
        $this->assertEquals($object, $result);
    }

    /**
     * Test delete notes.
     */
    public function testDelete()
    {
        $object = m::mock(NonFormalEducationHistoryInterface::class);
        $this->repository->shouldReceive('delete')->with($object)->andReturn(true);
        $result = $this->service->delete($object);
        $this->assertTrue($result);
    }

    /**
     * Test update notes.
     */
    public function testUpdate()
    {
        $object = m::mock(NonFormalEducationHistoryInterface::class);
        $this->repository->shouldReceive('update')->with($object)->andReturn($object);
        $result = $this->service->update($object);
        $this->assertEquals($object, $result);
    }
}

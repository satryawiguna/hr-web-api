<?php
namespace Tests\Domains\HumanResources\Personal\Employee\WorkCompetence;

use App\Domains\HumanResources\Personal\Employee\WorkCompetence\Contracts\WorkCompetenceInterface;
use App\Domains\HumanResources\Personal\Employee\WorkCompetence\Contracts\WorkCompetenceRepositoryInterface;
use App\Domains\HumanResources\Personal\Employee\WorkCompetence\Contracts\WorkCompetenceServiceInterface;
use App\Domains\HumanResources\Personal\Employee\WorkCompetence\WorkCompetenceEloquent;
use App\Domains\HumanResources\Personal\Employee\WorkCompetence\WorkCompetenceService;
use Mockery as m;
use Tests\TestCase;

class WorkCompetenceServiceTest extends TestCase
{
    private $repository;
    private $service;

    /**
     * Set up test.
     */
    protected function setUp()
    {
        parent::setUp();

        $this->repository = m::mock(WorkCompetenceRepositoryInterface::class);
        $this->service = new WorkCompetenceService(
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
        $this->assertInstanceOf(WorkCompetenceServiceInterface::class, $this->service);
    }

    /**
     * Test create notes.
     */
    public function testCreate()
    {
        $object = m::mock(WorkCompetenceInterface::class);
        $this->repository->shouldReceive('create')->with($object)->andReturn($object);
        $result = $this->service->create($object);
        $this->assertInstanceOf(WorkCompetenceInterface::class, $result);
        $this->assertEquals($object, $result);
    }

    /**
     * Test delete notes.
     */
    public function testDelete()
    {
        $object = m::mock(WorkCompetenceInterface::class);
        $this->repository->shouldReceive('delete')->with($object)->andReturn(true);
        $result = $this->service->delete($object);
        $this->assertTrue($result);
    }

    /**
     * Test update notes.
     */
    public function testUpdate()
    {
        $object = m::mock(WorkCompetenceInterface::class);
        $this->repository->shouldReceive('update')->with($object)->andReturn($object);
        $result = $this->service->update($object);
        $this->assertEquals($object, $result);
    }
}

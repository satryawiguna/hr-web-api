<?php
namespace Tests\Domains\HumanResources\Personal\Employee\WorkExperience;

use App\Domains\HumanResources\Personal\Employee\WorkExperience\Contracts\WorkExperienceInterface;
use App\Domains\HumanResources\Personal\Employee\WorkExperience\Contracts\WorkExperienceRepositoryInterface;
use App\Domains\HumanResources\Personal\Employee\WorkExperience\Contracts\WorkExperienceServiceInterface;
use App\Domains\HumanResources\Personal\Employee\WorkExperience\WorkExperienceEloquent;
use App\Domains\HumanResources\Personal\Employee\WorkExperience\WorkExperienceService;
use Mockery as m;
use Tests\TestCase;

class WorkExperienceServiceTest extends TestCase
{
    private $repository;
    private $service;

    /**
     * Set up test.
     */
    protected function setUp()
    {
        parent::setUp();

        $this->repository = m::mock(WorkExperienceRepositoryInterface::class);
        $this->service = new WorkExperienceService(
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
        $this->assertInstanceOf(WorkExperienceServiceInterface::class, $this->service);
    }

    /**
     * Test create notes.
     */
    public function testCreate()
    {
        $object = m::mock(WorkExperienceInterface::class);
        $this->repository->shouldReceive('create')->with($object)->andReturn($object);
        $result = $this->service->create($object);
        $this->assertInstanceOf(WorkExperienceInterface::class, $result);
        $this->assertEquals($object, $result);
    }

    /**
     * Test delete notes.
     */
    public function testDelete()
    {
        $object = m::mock(WorkExperienceInterface::class);
        $this->repository->shouldReceive('delete')->with($object)->andReturn(true);
        $result = $this->service->delete($object);
        $this->assertTrue($result);
    }

    /**
     * Test update notes.
     */
    public function testUpdate()
    {
        $object = m::mock(WorkExperienceInterface::class);
        $this->repository->shouldReceive('update')->with($object)->andReturn($object);
        $result = $this->service->update($object);
        $this->assertEquals($object, $result);
    }
}

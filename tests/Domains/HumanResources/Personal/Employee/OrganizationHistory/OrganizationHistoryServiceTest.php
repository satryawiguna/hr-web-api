<?php
namespace Tests\Domains\HumanResources\Personal\Employee\OrganizationHistory;

use App\Domains\HumanResources\Personal\Employee\OrganizationHistory\Contracts\OrganizationHistoryInterface;
use App\Domains\HumanResources\Personal\Employee\OrganizationHistory\Contracts\OrganizationHistoryRepositoryInterface;
use App\Domains\HumanResources\Personal\Employee\OrganizationHistory\Contracts\OrganizationHistoryServiceInterface;
use App\Domains\HumanResources\Personal\Employee\OrganizationHistory\OrganizationHistoryEloquent;
use App\Domains\HumanResources\Personal\Employee\OrganizationHistory\OrganizationHistoryService;
use Mockery as m;
use Tests\TestCase;

class OrganizationHistoryServiceTest extends TestCase
{
    private $repository;
    private $service;

    /**
     * Set up test.
     */
    protected function setUp()
    {
        parent::setUp();

        $this->repository = m::mock(OrganizationHistoryRepositoryInterface::class);
        $this->service = new OrganizationHistoryService(
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
        $this->assertInstanceOf(OrganizationHistoryServiceInterface::class, $this->service);
    }

    /**
     * Test create notes.
     */
    public function testCreate()
    {
        $object = m::mock(OrganizationHistoryInterface::class);
        $this->repository->shouldReceive('create')->with($object)->andReturn($object);
        $result = $this->service->create($object);
        $this->assertInstanceOf(OrganizationHistoryInterface::class, $result);
        $this->assertEquals($object, $result);
    }

    /**
     * Test delete notes.
     */
    public function testDelete()
    {
        $object = m::mock(OrganizationHistoryInterface::class);
        $this->repository->shouldReceive('delete')->with($object)->andReturn(true);
        $result = $this->service->delete($object);
        $this->assertTrue($result);
    }

    /**
     * Test update notes.
     */
    public function testUpdate()
    {
        $object = m::mock(OrganizationHistoryInterface::class);
        $this->repository->shouldReceive('update')->with($object)->andReturn($object);
        $result = $this->service->update($object);
        $this->assertEquals($object, $result);
    }
}

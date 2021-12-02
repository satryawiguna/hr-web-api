<?php
namespace Tests\Domains\HumanResources\MasterData\Competence;

use App\Domains\HumanResources\MasterData\Competence\Contracts\CompetenceInterface;
use App\Domains\HumanResources\MasterData\Competence\Contracts\CompetenceRepositoryInterface;
use App\Domains\HumanResources\MasterData\Competence\Contracts\CompetenceServiceInterface;
use App\Domains\HumanResources\MasterData\Competence\CompetenceEloquent;
use App\Domains\HumanResources\MasterData\Competence\CompetenceService;
use Mockery as m;
use Tests\TestCase;

class CompetenceServiceTest extends TestCase
{
    private $repository;
    private $service;

    /**
     * Set up test.
     */
    protected function setUp()
    {
        parent::setUp();

        $this->repository = m::mock(CompetenceRepositoryInterface::class);
        $this->service = new CompetenceService(
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
        $this->assertInstanceOf(CompetenceServiceInterface::class, $this->service);
    }

    /**
     * Test create notes.
     */
    public function testCreate()
    {
        $object = m::mock(CompetenceInterface::class);
        $this->repository->shouldReceive('create')->with($object)->andReturn($object);
        $result = $this->service->create($object);
        $this->assertInstanceOf(CompetenceInterface::class, $result);
        $this->assertEquals($object, $result);
    }

    /**
     * Test delete notes.
     */
    public function testDelete()
    {
        $object = m::mock(CompetenceInterface::class);
        $this->repository->shouldReceive('delete')->with($object)->andReturn(true);
        $result = $this->service->delete($object);
        $this->assertTrue($result);
    }

    /**
     * Test update notes.
     */
    public function testUpdate()
    {
        $object = m::mock(CompetenceInterface::class);
        $this->repository->shouldReceive('update')->with($object)->andReturn($object);
        $result = $this->service->update($object);
        $this->assertEquals($object, $result);
    }
}

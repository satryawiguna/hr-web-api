<?php
namespace Tests\Domains\HumanResources\Formula;

use App\Domains\HumanResources\Formula\Contracts\FormulaInterface;
use App\Domains\HumanResources\Formula\Contracts\FormulaRepositoryInterface;
use App\Domains\HumanResources\Formula\Contracts\FormulaServiceInterface;
use App\Domains\HumanResources\Formula\FormulaEloquent;
use App\Domains\HumanResources\Formula\FormulaService;
use Mockery as m;
use Tests\TestCase;

class FormulaServiceTest extends TestCase
{
    private $repository;
    private $service;

    /**
     * Set up test.
     */
    protected function setUp()
    {
        parent::setUp();

        $this->repository = m::mock(FormulaRepositoryInterface::class);
        $this->service = new FormulaService(
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
        $this->assertInstanceOf(FormulaServiceInterface::class, $this->service);
    }

    /**
     * Test create notes.
     */
    public function testCreate()
    {
        $object = m::mock(FormulaInterface::class);
        $this->repository->shouldReceive('create')->with($object)->andReturn($object);
        $result = $this->service->create($object);
        $this->assertInstanceOf(FormulaInterface::class, $result);
        $this->assertEquals($object, $result);
    }

    /**
     * Test delete notes.
     */
    public function testDelete()
    {
        $object = m::mock(FormulaInterface::class);
        $this->repository->shouldReceive('delete')->with($object)->andReturn(true);
        $result = $this->service->delete($object);
        $this->assertTrue($result);
    }

    /**
     * Test update notes.
     */
    public function testUpdate()
    {
        $object = m::mock(FormulaInterface::class);
        $this->repository->shouldReceive('update')->with($object)->andReturn($object);
        $result = $this->service->update($object);
        $this->assertEquals($object, $result);
    }
}

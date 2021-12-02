<?php
namespace Tests\Domains\Commons\EmployeeNumberScale;

use App\Domains\Commons\EmployeeNumberScale\Contracts\EmployeeNumberScaleInterface;
use App\Domains\Commons\EmployeeNumberScale\Contracts\EmployeeNumberScaleRepositoryInterface;
use App\Domains\Commons\EmployeeNumberScale\Contracts\EmployeeNumberScaleServiceInterface;
use App\Domains\Commons\EmployeeNumberScale\EmployeeNumberScaleEloquent;
use App\Domains\Commons\EmployeeNumberScale\EmployeeNumberScaleService;
use Mockery as m;
use Tests\TestCase;

class EmployeeNumberScaleServiceTest extends TestCase
{
    private $repository;
    private $service;

    /**
     * Set up test.
     */
    protected function setUp()
    {
        parent::setUp();

        $this->repository = m::mock(EmployeeNumberScaleRepositoryInterface::class);
        $this->service = new EmployeeNumberScaleService(
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
        $this->assertInstanceOf(EmployeeNumberScaleServiceInterface::class, $this->service);
    }

    /**
     * Test create notes.
     */
    public function testCreate()
    {
        $object = m::mock(EmployeeNumberScaleInterface::class);
        $this->repository->shouldReceive('create')->with($object)->andReturn($object);
        $result = $this->service->create($object);
        $this->assertInstanceOf(EmployeeNumberScaleInterface::class, $result);
        $this->assertEquals($object, $result);
    }

    /**
     * Test delete notes.
     */
    public function testDelete()
    {
        $object = m::mock(EmployeeNumberScaleInterface::class);
        $this->repository->shouldReceive('delete')->with($object)->andReturn(true);
        $result = $this->service->delete($object);
        $this->assertTrue($result);
    }

    /**
     * Test update notes.
     */
    public function testUpdate()
    {
        $object = m::mock(EmployeeNumberScaleInterface::class);
        $this->repository->shouldReceive('update')->with($object)->andReturn($object);
        $result = $this->service->update($object);
        $this->assertEquals($object, $result);
    }
}

<?php
namespace Tests\Domains\HumanResources\MasterData\BaseSalaryCustomType;

use App\Domains\HumanResources\MasterData\BaseSalaryCustomType\Contracts\BaseSalaryCustomTypeInterface;
use App\Domains\HumanResources\MasterData\BaseSalaryCustomType\Contracts\BaseSalaryCustomTypeRepositoryInterface;
use App\Domains\HumanResources\MasterData\BaseSalaryCustomType\Contracts\BaseSalaryCustomTypeServiceInterface;
use App\Domains\HumanResources\MasterData\BaseSalaryCustomType\BaseSalaryCustomTypeEloquent;
use App\Domains\HumanResources\MasterData\BaseSalaryCustomType\BaseSalaryCustomTypeService;
use Mockery as m;
use Tests\TestCase;

class BaseSalaryCustomTypeServiceTest extends TestCase
{
    private $repository;
    private $service;

    /**
     * Set up test.
     */
    protected function setUp()
    {
        parent::setUp();

        $this->repository = m::mock(BaseSalaryCustomTypeRepositoryInterface::class);
        $this->service = new BaseSalaryCustomTypeService(
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
        $this->assertInstanceOf(BaseSalaryCustomTypeServiceInterface::class, $this->service);
    }

    /**
     * Test create notes.
     */
    public function testCreate()
    {
        $object = m::mock(BaseSalaryCustomTypeInterface::class);
        $this->repository->shouldReceive('create')->with($object)->andReturn($object);
        $result = $this->service->create($object);
        $this->assertInstanceOf(BaseSalaryCustomTypeInterface::class, $result);
        $this->assertEquals($object, $result);
    }

    /**
     * Test delete notes.
     */
    public function testDelete()
    {
        $object = m::mock(BaseSalaryCustomTypeInterface::class);
        $this->repository->shouldReceive('delete')->with($object)->andReturn(true);
        $result = $this->service->delete($object);
        $this->assertTrue($result);
    }

    /**
     * Test update notes.
     */
    public function testUpdate()
    {
        $object = m::mock(BaseSalaryCustomTypeInterface::class);
        $this->repository->shouldReceive('update')->with($object)->andReturn($object);
        $result = $this->service->update($object);
        $this->assertEquals($object, $result);
    }
}

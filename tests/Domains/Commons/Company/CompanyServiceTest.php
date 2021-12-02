<?php
namespace Tests\Domains\Commons\Company;

use App\Domains\Commons\Company\Contracts\CompanyInterface;
use App\Domains\Commons\Company\Contracts\CompanyRepositoryInterface;
use App\Domains\Commons\Company\Contracts\CompanyServiceInterface;
use App\Domains\Commons\Company\CompanyEloquent;
use App\Domains\Commons\Company\CompanyService;
use Mockery as m;
use Tests\TestCase;

class CompanyServiceTest extends TestCase
{
    private $repository;
    private $service;

    /**
     * Set up test.
     */
    protected function setUp()
    {
        parent::setUp();

        $this->repository = m::mock(CompanyRepositoryInterface::class);
        $this->service = new CompanyService(
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
        $this->assertInstanceOf(CompanyServiceInterface::class, $this->service);
    }

    /**
     * Test create notes.
     */
    public function testCreate()
    {
        $object = m::mock(CompanyInterface::class);
        $this->repository->shouldReceive('create')->with($object)->andReturn($object);
        $result = $this->service->create($object);
        $this->assertInstanceOf(CompanyInterface::class, $result);
        $this->assertEquals($object, $result);
    }

    /**
     * Test delete notes.
     */
    public function testDelete()
    {
        $object = m::mock(CompanyInterface::class);
        $this->repository->shouldReceive('delete')->with($object)->andReturn(true);
        $result = $this->service->delete($object);
        $this->assertTrue($result);
    }

    /**
     * Test update notes.
     */
    public function testUpdate()
    {
        $object = m::mock(CompanyInterface::class);
        $this->repository->shouldReceive('update')->with($object)->andReturn($object);
        $result = $this->service->update($object);
        $this->assertEquals($object, $result);
    }
}

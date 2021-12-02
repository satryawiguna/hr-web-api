<?php
namespace Tests\Domains\Commons\CompanyCategory;

use App\Domains\Commons\CompanyCategory\Contracts\CompanyCategoryInterface;
use App\Domains\Commons\CompanyCategory\Contracts\CompanyCategoryRepositoryInterface;
use App\Domains\Commons\CompanyCategory\Contracts\CompanyCategoryServiceInterface;
use App\Domains\Commons\CompanyCategory\CompanyCategoryEloquent;
use App\Domains\Commons\CompanyCategory\CompanyCategoryService;
use Mockery as m;
use Tests\TestCase;

class CompanyCategoryServiceTest extends TestCase
{
    private $repository;
    private $service;

    /**
     * Set up test.
     */
    protected function setUp()
    {
        parent::setUp();

        $this->repository = m::mock(CompanyCategoryRepositoryInterface::class);
        $this->service = new CompanyCategoryService(
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
        $this->assertInstanceOf(CompanyCategoryServiceInterface::class, $this->service);
    }

    /**
     * Test create notes.
     */
    public function testCreate()
    {
        $object = m::mock(CompanyCategoryInterface::class);
        $this->repository->shouldReceive('create')->with($object)->andReturn($object);
        $result = $this->service->create($object);
        $this->assertInstanceOf(CompanyCategoryInterface::class, $result);
        $this->assertEquals($object, $result);
    }

    /**
     * Test delete notes.
     */
    public function testDelete()
    {
        $object = m::mock(CompanyCategoryInterface::class);
        $this->repository->shouldReceive('delete')->with($object)->andReturn(true);
        $result = $this->service->delete($object);
        $this->assertTrue($result);
    }

    /**
     * Test update notes.
     */
    public function testUpdate()
    {
        $object = m::mock(CompanyCategoryInterface::class);
        $this->repository->shouldReceive('update')->with($object)->andReturn($object);
        $result = $this->service->update($object);
        $this->assertEquals($object, $result);
    }
}

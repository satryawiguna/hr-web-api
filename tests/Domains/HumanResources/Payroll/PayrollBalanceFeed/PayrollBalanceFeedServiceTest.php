<?php
namespace Tests\Domains\HumanResources\Payroll\PayrollBalanceFeed;

use App\Domains\HumanResources\Payroll\PayrollBalanceFeed\Contracts\PayrollBalanceFeedInterface;
use App\Domains\HumanResources\Payroll\PayrollBalanceFeed\Contracts\PayrollBalanceFeedRepositoryInterface;
use App\Domains\HumanResources\Payroll\PayrollBalanceFeed\Contracts\PayrollBalanceFeedServiceInterface;
use App\Domains\HumanResources\Payroll\PayrollBalanceFeed\PayrollBalanceFeedEloquent;
use App\Domains\HumanResources\Payroll\PayrollBalanceFeed\PayrollBalanceFeedService;
use Mockery as m;
use Tests\TestCase;

class PayrollBalanceFeedServiceTest extends TestCase
{
    private $repository;
    private $service;

    /**
     * Set up test.
     */
    protected function setUp()
    {
        parent::setUp();

        $this->repository = m::mock(PayrollBalanceFeedRepositoryInterface::class);
        $this->service = new PayrollBalanceFeedService(
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
        $this->assertInstanceOf(PayrollBalanceFeedServiceInterface::class, $this->service);
    }

    /**
     * Test create notes.
     */
    public function testCreate()
    {
        $object = m::mock(PayrollBalanceFeedInterface::class);
        $this->repository->shouldReceive('create')->with($object)->andReturn($object);
        $result = $this->service->create($object);
        $this->assertInstanceOf(PayrollBalanceFeedInterface::class, $result);
        $this->assertEquals($object, $result);
    }

    /**
     * Test delete notes.
     */
    public function testDelete()
    {
        $object = m::mock(PayrollBalanceFeedInterface::class);
        $this->repository->shouldReceive('delete')->with($object)->andReturn(true);
        $result = $this->service->delete($object);
        $this->assertTrue($result);
    }

    /**
     * Test update notes.
     */
    public function testUpdate()
    {
        $object = m::mock(PayrollBalanceFeedInterface::class);
        $this->repository->shouldReceive('update')->with($object)->andReturn($object);
        $result = $this->service->update($object);
        $this->assertEquals($object, $result);
    }
}

<?php
namespace Tests\Domains\HumanResources\Payroll\PayrollBalance;

use App\Domains\HumanResources\Payroll\PayrollBalance\Contracts\PayrollBalanceInterface;
use App\Domains\HumanResources\Payroll\PayrollBalance\Contracts\PayrollBalanceRepositoryInterface;
use App\Domains\HumanResources\Payroll\PayrollBalance\Contracts\PayrollBalanceServiceInterface;
use App\Domains\HumanResources\Payroll\PayrollBalance\PayrollBalanceEloquent;
use App\Domains\HumanResources\Payroll\PayrollBalance\PayrollBalanceService;
use Mockery as m;
use Tests\TestCase;

class PayrollBalanceServiceTest extends TestCase
{
    private $repository;
    private $service;

    /**
     * Set up test.
     */
    protected function setUp()
    {
        parent::setUp();

        $this->repository = m::mock(PayrollBalanceRepositoryInterface::class);
        $this->service = new PayrollBalanceService(
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
        $this->assertInstanceOf(PayrollBalanceServiceInterface::class, $this->service);
    }

    /**
     * Test create notes.
     */
    public function testCreate()
    {
        $object = m::mock(PayrollBalanceInterface::class);
        $this->repository->shouldReceive('create')->with($object)->andReturn($object);
        $result = $this->service->create($object);
        $this->assertInstanceOf(PayrollBalanceInterface::class, $result);
        $this->assertEquals($object, $result);
    }

    /**
     * Test delete notes.
     */
    public function testDelete()
    {
        $object = m::mock(PayrollBalanceInterface::class);
        $this->repository->shouldReceive('delete')->with($object)->andReturn(true);
        $result = $this->service->delete($object);
        $this->assertTrue($result);
    }

    /**
     * Test update notes.
     */
    public function testUpdate()
    {
        $object = m::mock(PayrollBalanceInterface::class);
        $this->repository->shouldReceive('update')->with($object)->andReturn($object);
        $result = $this->service->update($object);
        $this->assertEquals($object, $result);
    }
}

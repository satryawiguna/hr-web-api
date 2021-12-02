<?php
namespace Tests\Domains\WorkAgreementLetter;

use App\Domains\WorkAgreementLetter\Contracts\WorkAgreementLetterInterface;
use App\Domains\WorkAgreementLetter\Contracts\WorkAgreementLetterRepositoryInterface;
use App\Domains\WorkAgreementLetter\Contracts\WorkAgreementLetterServiceInterface;
use App\Domains\WorkAgreementLetter\WorkAgreementLetterEloquent;
use App\Domains\WorkAgreementLetter\WorkAgreementLetterService;
use Mockery as m;
use Tests\TestCase;

class WorkAgreementLetterServiceTest extends TestCase
{
    private $repository;
    private $service;

    /**
     * Set up test.
     */
    protected function setUp()
    {
        parent::setUp();

        $this->repository = m::mock(WorkAgreementLetterRepositoryInterface::class);
        $this->service = new WorkAgreementLetterService(
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
        $this->assertInstanceOf(WorkAgreementLetterServiceInterface::class, $this->service);
    }

    /**
     * Test create notes.
     */
    public function testCreate()
    {
        $object = m::mock(WorkAgreementLetterInterface::class);
        $this->repository->shouldReceive('create')->with($object)->andReturn($object);
        $result = $this->service->create($object);
        $this->assertInstanceOf(WorkAgreementLetterInterface::class, $result);
        $this->assertEquals($object, $result);
    }

    /**
     * Test delete notes.
     */
    public function testDelete()
    {
        $object = m::mock(WorkAgreementLetterInterface::class);
        $this->repository->shouldReceive('delete')->with($object)->andReturn(true);
        $result = $this->service->delete($object);
        $this->assertTrue($result);
    }

    /**
     * Test update notes.
     */
    public function testUpdate()
    {
        $object = m::mock(WorkAgreementLetterInterface::class);
        $this->repository->shouldReceive('update')->with($object)->andReturn($object);
        $result = $this->service->update($object);
        $this->assertEquals($object, $result);
    }
}

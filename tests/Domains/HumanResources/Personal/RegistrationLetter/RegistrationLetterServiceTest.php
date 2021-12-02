<?php
namespace Tests\Domains\RegistrationLetter;

use App\Domains\RegistrationLetter\Contracts\RegistrationLetterInterface;
use App\Domains\RegistrationLetter\Contracts\RegistrationLetterRepositoryInterface;
use App\Domains\RegistrationLetter\Contracts\RegistrationLetterServiceInterface;
use App\Domains\RegistrationLetter\RegistrationLetterEloquent;
use App\Domains\RegistrationLetter\RegistrationLetterService;
use Mockery as m;
use Tests\TestCase;

class RegistrationLetterServiceTest extends TestCase
{
    private $repository;
    private $service;

    /**
     * Set up test.
     */
    protected function setUp()
    {
        parent::setUp();

        $this->repository = m::mock(RegistrationLetterRepositoryInterface::class);
        $this->service = new RegistrationLetterService(
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
        $this->assertInstanceOf(RegistrationLetterServiceInterface::class, $this->service);
    }

    /**
     * Test create notes.
     */
    public function testCreate()
    {
        $object = m::mock(RegistrationLetterInterface::class);
        $this->repository->shouldReceive('create')->with($object)->andReturn($object);
        $result = $this->service->create($object);
        $this->assertInstanceOf(RegistrationLetterInterface::class, $result);
        $this->assertEquals($object, $result);
    }

    /**
     * Test delete notes.
     */
    public function testDelete()
    {
        $object = m::mock(RegistrationLetterInterface::class);
        $this->repository->shouldReceive('delete')->with($object)->andReturn(true);
        $result = $this->service->delete($object);
        $this->assertTrue($result);
    }

    /**
     * Test update notes.
     */
    public function testUpdate()
    {
        $object = m::mock(RegistrationLetterInterface::class);
        $this->repository->shouldReceive('update')->with($object)->andReturn($object);
        $result = $this->service->update($object);
        $this->assertEquals($object, $result);
    }
}

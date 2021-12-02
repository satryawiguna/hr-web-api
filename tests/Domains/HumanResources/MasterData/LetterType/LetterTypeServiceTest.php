<?php
namespace Tests\Domains\HumanResources\MasterData\LetterType;

use App\Domains\HumanResources\MasterData\LetterType\Contracts\LetterTypeInterface;
use App\Domains\HumanResources\MasterData\LetterType\Contracts\LetterTypeRepositoryInterface;
use App\Domains\HumanResources\MasterData\LetterType\Contracts\LetterTypeServiceInterface;
use App\Domains\HumanResources\MasterData\LetterType\LetterTypeEloquent;
use App\Domains\HumanResources\MasterData\LetterType\LetterTypeService;
use Mockery as m;
use Tests\TestCase;

class LetterTypeServiceTest extends TestCase
{
    private $repository;
    private $service;

    /**
     * Set up test.
     */
    protected function setUp()
    {
        parent::setUp();

        $this->repository = m::mock(LetterTypeRepositoryInterface::class);
        $this->service = new LetterTypeService(
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
        $this->assertInstanceOf(LetterTypeServiceInterface::class, $this->service);
    }

    /**
     * Test create notes.
     */
    public function testCreate()
    {
        $object = m::mock(LetterTypeInterface::class);
        $this->repository->shouldReceive('create')->with($object)->andReturn($object);
        $result = $this->service->create($object);
        $this->assertInstanceOf(LetterTypeInterface::class, $result);
        $this->assertEquals($object, $result);
    }

    /**
     * Test delete notes.
     */
    public function testDelete()
    {
        $object = m::mock(LetterTypeInterface::class);
        $this->repository->shouldReceive('delete')->with($object)->andReturn(true);
        $result = $this->service->delete($object);
        $this->assertTrue($result);
    }

    /**
     * Test update notes.
     */
    public function testUpdate()
    {
        $object = m::mock(LetterTypeInterface::class);
        $this->repository->shouldReceive('update')->with($object)->andReturn($object);
        $result = $this->service->update($object);
        $this->assertEquals($object, $result);
    }
}

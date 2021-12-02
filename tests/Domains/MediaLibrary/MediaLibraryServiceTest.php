<?php
namespace Tests\Domains\MediaLibrary;

use App\Domains\MediaLibrary\Contracts\MediaLibraryInterface;
use App\Domains\MediaLibrary\Contracts\MediaLibraryRepositoryInterface;
use App\Domains\MediaLibrary\Contracts\MediaLibraryServiceInterface;
use App\Domains\MediaLibrary\MediaLibraryEloquent;
use App\Domains\MediaLibrary\MediaLibraryService;
use Mockery as m;
use Tests\TestCase;

class MediaLibraryServiceTest extends TestCase
{
    private $repository;
    private $service;

    /**
     * Set up test.
     */
    protected function setUp()
    {
        parent::setUp();

        $this->repository = m::mock(MediaLibraryRepositoryInterface::class);
        $this->service = new MediaLibraryService(
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
        $this->assertInstanceOf(MediaLibraryServiceInterface::class, $this->service);
    }

    /**
     * Test create notes.
     */
    public function testCreate()
    {
        $object = m::mock(MediaLibraryInterface::class);
        $this->repository->shouldReceive('create')->with($object)->andReturn($object);
        $result = $this->service->create($object);
        $this->assertInstanceOf(MediaLibraryInterface::class, $result);
        $this->assertEquals($object, $result);
    }

    /**
     * Test delete notes.
     */
    public function testDelete()
    {
        $object = m::mock(MediaLibraryInterface::class);
        $this->repository->shouldReceive('delete')->with($object)->andReturn(true);
        $result = $this->service->delete($object);
        $this->assertTrue($result);
    }

    /**
     * Test update notes.
     */
    public function testUpdate()
    {
        $object = m::mock(MediaLibraryInterface::class);
        $this->repository->shouldReceive('update')->with($object)->andReturn($object);
        $result = $this->service->update($object);
        $this->assertEquals($object, $result);
    }
}

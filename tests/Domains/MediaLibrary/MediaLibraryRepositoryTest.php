<?php
namespace Tests\Domains\MediaLibrary;

use Mockery as m;
use Tests\TestCase;
use App\Infrastructures\MediaLibrary\Contracts\EloquentMediaLibraryRepositoryInterface;
use App\Domains\MediaLibrary\MediaLibraryRepository;
use App\Domains\MediaLibrary\MediaLibraryEloquent;
use App\Domains\MediaLibrary\Contracts\MediaLibraryInterface;
use App\Domains\MediaLibrary\Contracts\MediaLibraryRepositoryInterface;

class MediaLibraryRepositoryTest extends TestCase
{
    private $eloquent;
    private $repository;

    protected function setUp()
    {
        parent::setUp();
        $this->eloquent = m::mock(EloquentMediaLibraryRepositoryInterface::class);
        $this->repository = new MediaLibraryRepository($this->eloquent);
    }

    protected function tearDown()
    {
        m::close();
    }

    public function testConstructor()
    {
        $this->assertInstanceOf(MediaLibraryRepositoryInterface::class, $this->repository);
    }

    /**
     * Test create MediaLibrary
     */
    public function testCreate()
    {
        $object = m::mock(MediaLibraryInterface::class);

        $data = ['company_id' => 1,'collection' => 1,'category' => 1,'original_name' => 1,'generate_name' => 1,'extension' => 1,'mime_type' => 1,'disk' => 1,'size' => 1,'url' => 1,'thumb' => 1,'icon' => 1,'generate_thumb' => 1,'generate_icon' => 1,];

        $object
            ->shouldReceive('getCompanyId')->andReturn($data['company_id'])
            ->shouldReceive('getCollection')->andReturn($data['collection'])
            ->shouldReceive('getCategory')->andReturn($data['category'])
            ->shouldReceive('getOriginalName')->andReturn($data['original_name'])
            ->shouldReceive('getGenerateName')->andReturn($data['generate_name'])
            ->shouldReceive('getExtension')->andReturn($data['extension'])
            ->shouldReceive('getMimeType')->andReturn($data['mime_type'])
            ->shouldReceive('getDisk')->andReturn($data['disk'])
            ->shouldReceive('getSize')->andReturn($data['size'])
            ->shouldReceive('getUrl')->andReturn($data['url'])
            ->shouldReceive('getThumb')->andReturn($data['thumb'])
            ->shouldReceive('getIcon')->andReturn($data['icon'])
            ->shouldReceive('getGenerateThumb')->andReturn($data['generate_thumb'])
            ->shouldReceive('getGenerateIcon')->andReturn($data['generate_icon']);

        $this->eloquent->shouldReceive('create')->with($data)->andReturn($object);

        $result = $this->repository->create($object);
        $this->assertInstanceOf(MediaLibraryInterface::class, $result);
        $this->assertEquals($object, $result);
    }

    /**
     * Test delete MediaLibrary
     */
    public function testDelete()
    {
        $note = m::mock(MediaLibraryInterface::class);
        $note->shouldReceive('getKey')->andReturn(1);
        $this->eloquent->shouldReceive('delete')->with(1)->andReturn(true);
        $result = $this->repository->delete($note);
        $this->assertTrue($result);
    }

    /**
     * Test Update MediaLibrary
     */
    public function testUpdate()
    {
        $id = 1;
        $data = ['company_id' => 1,'collection' => 1,'category' => 1,'original_name' => 1,'generate_name' => 1,'extension' => 1,'mime_type' => 1,'disk' => 1,'size' => 1,'url' => 1,'thumb' => 1,'icon' => 1,'generate_thumb' => 1,'generate_icon' => 1,];

        $object = m::mock(MediaLibraryInterface::class);
        $object->shouldReceive('getKey')->andReturn($id);

        $object
            ->shouldReceive('getCompanyId')->andReturn($data['company_id'])
            ->shouldReceive('getCollection')->andReturn($data['collection'])
            ->shouldReceive('getCategory')->andReturn($data['category'])
            ->shouldReceive('getOriginalName')->andReturn($data['original_name'])
            ->shouldReceive('getGenerateName')->andReturn($data['generate_name'])
            ->shouldReceive('getExtension')->andReturn($data['extension'])
            ->shouldReceive('getMimeType')->andReturn($data['mime_type'])
            ->shouldReceive('getDisk')->andReturn($data['disk'])
            ->shouldReceive('getSize')->andReturn($data['size'])
            ->shouldReceive('getUrl')->andReturn($data['url'])
            ->shouldReceive('getThumb')->andReturn($data['thumb'])
            ->shouldReceive('getIcon')->andReturn($data['icon'])
            ->shouldReceive('getGenerateThumb')->andReturn($data['generate_thumb'])
            ->shouldReceive('getGenerateIcon')->andReturn($data['generate_icon']);

        $this->eloquent->shouldReceive('update')->with($data, $id)->andReturn($object);

        $result = $this->repository->update($object);
        $this->assertEquals($object, $result);
    }
}

<?php
namespace Tests\Domains\Commons\CompanyCategory;

use Mockery as m;
use Tests\TestCase;
use App\Infrastructures\Commons\CompanyCategory\Contracts\EloquentCompanyCategoryRepositoryInterface;
use App\Domains\Commons\CompanyCategory\CompanyCategoryRepository;
use App\Domains\Commons\CompanyCategory\CompanyCategoryEloquent;
use App\Domains\Commons\CompanyCategory\Contracts\CompanyCategoryInterface;
use App\Domains\Commons\CompanyCategory\Contracts\CompanyCategoryRepositoryInterface;

class CompanyCategoryRepositoryTest extends TestCase
{
    private $eloquent;
    private $repository;

    protected function setUp()
    {
        parent::setUp();
        $this->eloquent = m::mock(EloquentCompanyCategoryRepositoryInterface::class);
        $this->repository = new CompanyCategoryRepository($this->eloquent);
    }

    protected function tearDown()
    {
        m::close();
    }

    public function testConstructor()
    {
        $this->assertInstanceOf(CompanyCategoryRepositoryInterface::class, $this->repository);
    }

    /**
     * Test create CompanyCategory
     */
    public function testCreate()
    {
        $object = m::mock(CompanyCategoryInterface::class);

        $data = ['name' => 1,'slug' => 1,'is_active' => 1,'created_by' => 1,'modified_by' => 1,];

        $object
            ->shouldReceive('getName')->andReturn($data['name'])
            ->shouldReceive('getSlug')->andReturn($data['slug'])
            ->shouldReceive('getIsActive')->andReturn($data['is_active'])
            ->shouldReceive('getCreatedBy')->andReturn($data['created_by'])
            ->shouldReceive('getModifiedBy')->andReturn($data['modified_by']);

        $this->eloquent->shouldReceive('create')->with($data)->andReturn($object);

        $result = $this->repository->create($object);
        $this->assertInstanceOf(CompanyCategoryInterface::class, $result);
        $this->assertEquals($object, $result);
    }

    /**
     * Test delete CompanyCategory
     */
    public function testDelete()
    {
        $note = m::mock(CompanyCategoryInterface::class);
        $note->shouldReceive('getKey')->andReturn(1);
        $this->eloquent->shouldReceive('delete')->with(1)->andReturn(true);
        $result = $this->repository->delete($note);
        $this->assertTrue($result);
    }

    /**
     * Test Update CompanyCategory
     */
    public function testUpdate()
    {
        $id = 1;
        $data = ['name' => 1,'slug' => 1,'is_active' => 1,'created_by' => 1,'modified_by' => 1,];

        $object = m::mock(CompanyCategoryInterface::class);
        $object->shouldReceive('getKey')->andReturn($id);

        $object
            ->shouldReceive('getName')->andReturn($data['name'])
            ->shouldReceive('getSlug')->andReturn($data['slug'])
            ->shouldReceive('getIsActive')->andReturn($data['is_active'])
            ->shouldReceive('getCreatedBy')->andReturn($data['created_by'])
            ->shouldReceive('getModifiedBy')->andReturn($data['modified_by']);

        $this->eloquent->shouldReceive('update')->with($data, $id)->andReturn($object);

        $result = $this->repository->update($object);
        $this->assertEquals($object, $result);
    }
}

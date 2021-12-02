<?php
namespace Tests\Domains\HumanResources\MasterData\Grade;

use Mockery as m;
use Tests\TestCase;
use App\Infrastructures\HumanResources\MasterData\Grade\Contracts\EloquentGradeRepositoryInterface;
use App\Domains\HumanResources\MasterData\Grade\GradeRepository;
use App\Domains\HumanResources\MasterData\Grade\GradeEloquent;
use App\Domains\HumanResources\MasterData\Grade\Contracts\GradeInterface;
use App\Domains\HumanResources\MasterData\Grade\Contracts\GradeRepositoryInterface;

class GradeRepositoryTest extends TestCase
{
    private $eloquent;
    private $repository;

    protected function setUp()
    {
        parent::setUp();
        $this->eloquent = m::mock(EloquentGradeRepositoryInterface::class);
        $this->repository = new GradeRepository($this->eloquent);
    }

    protected function tearDown()
    {
        m::close();
    }

    public function testConstructor()
    {
        $this->assertInstanceOf(GradeRepositoryInterface::class, $this->repository);
    }

    /**
     * Test create Grade
     */
    public function testCreate()
    {
        $object = m::mock(GradeInterface::class);

        $data = ['company_id' => 1,'name' => 1,'slug' => 1,'description' => 1,'created_by' => 1,'modified_by' => 1,];

        $object
            ->shouldReceive('getCompanyId')->andReturn($data['company_id'])
            ->shouldReceive('getName')->andReturn($data['name'])
            ->shouldReceive('getSlug')->andReturn($data['slug'])
            ->shouldReceive('getDescription')->andReturn($data['description'])
            ->shouldReceive('getCreatedBy')->andReturn($data['created_by'])
            ->shouldReceive('getModifiedBy')->andReturn($data['modified_by']);

        $this->eloquent->shouldReceive('create')->with($data)->andReturn($object);

        $result = $this->repository->create($object);
        $this->assertInstanceOf(GradeInterface::class, $result);
        $this->assertEquals($object, $result);
    }

    /**
     * Test delete Grade
     */
    public function testDelete()
    {
        $note = m::mock(GradeInterface::class);
        $note->shouldReceive('getKey')->andReturn(1);
        $this->eloquent->shouldReceive('delete')->with(1)->andReturn(true);
        $result = $this->repository->delete($note);
        $this->assertTrue($result);
    }

    /**
     * Test Update Grade
     */
    public function testUpdate()
    {
        $id = 1;
        $data = ['company_id' => 1,'name' => 1,'slug' => 1,'description' => 1,'created_by' => 1,'modified_by' => 1,];

        $object = m::mock(GradeInterface::class);
        $object->shouldReceive('getKey')->andReturn($id);

        $object
            ->shouldReceive('getCompanyId')->andReturn($data['company_id'])
            ->shouldReceive('getName')->andReturn($data['name'])
            ->shouldReceive('getSlug')->andReturn($data['slug'])
            ->shouldReceive('getDescription')->andReturn($data['description'])
            ->shouldReceive('getCreatedBy')->andReturn($data['created_by'])
            ->shouldReceive('getModifiedBy')->andReturn($data['modified_by']);

        $this->eloquent->shouldReceive('update')->with($data, $id)->andReturn($object);

        $result = $this->repository->update($object);
        $this->assertEquals($object, $result);
    }
}

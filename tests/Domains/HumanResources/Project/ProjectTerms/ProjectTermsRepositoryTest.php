<?php
namespace Tests\Domains\HumanResources\Project\ProjectTerms;

use Mockery as m;
use Tests\TestCase;
use App\Infrastructures\HumanResources\Project\ProjectTerms\Contracts\EloquentProjectTermsRepositoryInterface;
use App\Domains\HumanResources\Project\ProjectTerms\ProjectTermsRepository;
use App\Domains\HumanResources\Project\ProjectTerms\ProjectTermsEloquent;
use App\Domains\HumanResources\Project\ProjectTerms\Contracts\ProjectTermsInterface;
use App\Domains\HumanResources\Project\ProjectTerms\Contracts\ProjectTermsRepositoryInterface;

class ProjectTermsRepositoryTest extends TestCase
{
    private $eloquent;
    private $repository;

    protected function setUp()
    {
        parent::setUp();
        $this->eloquent = m::mock(EloquentProjectTermsRepositoryInterface::class);
        $this->repository = new ProjectTermsRepository($this->eloquent);
    }

    protected function tearDown()
    {
        m::close();
    }

    public function testConstructor()
    {
        $this->assertInstanceOf(ProjectTermsRepositoryInterface::class, $this->repository);
    }

    /**
     * Test create ProjectTerms
     */
    public function testCreate()
    {
        $object = m::mock(ProjectTermsInterface::class);

        $data = ['project_id' => 1,'terms_order' => 1,'name' => 1,'value' => 1,'description' => 1,'created_by' => 1,'modified_by' => 1,];

        $object
            ->shouldReceive('getProjectId')->andReturn($data['project_id'])
            ->shouldReceive('getTermsOrder')->andReturn($data['terms_order'])
            ->shouldReceive('getName')->andReturn($data['name'])
            ->shouldReceive('getValue')->andReturn($data['value'])
            ->shouldReceive('getDescription')->andReturn($data['description'])
            ->shouldReceive('getCreatedBy')->andReturn($data['created_by'])
            ->shouldReceive('getModifiedBy')->andReturn($data['modified_by']);

        $this->eloquent->shouldReceive('create')->with($data)->andReturn($object);

        $result = $this->repository->create($object);
        $this->assertInstanceOf(ProjectTermsInterface::class, $result);
        $this->assertEquals($object, $result);
    }

    /**
     * Test delete ProjectTerms
     */
    public function testDelete()
    {
        $note = m::mock(ProjectTermsInterface::class);
        $note->shouldReceive('getKey')->andReturn(1);
        $this->eloquent->shouldReceive('delete')->with(1)->andReturn(true);
        $result = $this->repository->delete($note);
        $this->assertTrue($result);
    }

    /**
     * Test Update ProjectTerms
     */
    public function testUpdate()
    {
        $id = 1;
        $data = ['project_id' => 1,'terms_order' => 1,'name' => 1,'value' => 1,'description' => 1,'created_by' => 1,'modified_by' => 1,];

        $object = m::mock(ProjectTermsInterface::class);
        $object->shouldReceive('getKey')->andReturn($id);

        $object
            ->shouldReceive('getProjectId')->andReturn($data['project_id'])
            ->shouldReceive('getTermsOrder')->andReturn($data['terms_order'])
            ->shouldReceive('getName')->andReturn($data['name'])
            ->shouldReceive('getValue')->andReturn($data['value'])
            ->shouldReceive('getDescription')->andReturn($data['description'])
            ->shouldReceive('getCreatedBy')->andReturn($data['created_by'])
            ->shouldReceive('getModifiedBy')->andReturn($data['modified_by']);

        $this->eloquent->shouldReceive('update')->with($data, $id)->andReturn($object);

        $result = $this->repository->update($object);
        $this->assertEquals($object, $result);
    }
}

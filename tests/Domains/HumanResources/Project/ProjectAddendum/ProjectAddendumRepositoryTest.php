<?php
namespace Tests\Domains\HumanResources\Project\ProjectAddendum;

use Mockery as m;
use Tests\TestCase;
use App\Infrastructures\HumanResources\Project\ProjectAddendum\Contracts\EloquentProjectAddendumRepositoryInterface;
use App\Domains\HumanResources\Project\ProjectAddendum\ProjectAddendumRepository;
use App\Domains\HumanResources\Project\ProjectAddendum\ProjectAddendumEloquent;
use App\Domains\HumanResources\Project\ProjectAddendum\Contracts\ProjectAddendumInterface;
use App\Domains\HumanResources\Project\ProjectAddendum\Contracts\ProjectAddendumRepositoryInterface;

class ProjectAddendumRepositoryTest extends TestCase
{
    private $eloquent;
    private $repository;

    protected function setUp()
    {
        parent::setUp();
        $this->eloquent = m::mock(EloquentProjectAddendumRepositoryInterface::class);
        $this->repository = new ProjectAddendumRepository($this->eloquent);
    }

    protected function tearDown()
    {
        m::close();
    }

    public function testConstructor()
    {
        $this->assertInstanceOf(ProjectAddendumRepositoryInterface::class, $this->repository);
    }

    /**
     * Test create ProjectAddendum
     */
    public function testCreate()
    {
        $object = m::mock(ProjectAddendumInterface::class);

        $data = ['project_id' => 1,'reference_number' => 1,'name' => 1,'issue_date' => 1,'start_date' => 1,'end_date' => 1,'description' => 1,'value' => 1,'document' => 1,'value_by_contract_terms' => 1,'created_by' => 1,'modified_by' => 1,];

        $object
            ->shouldReceive('getProjectId')->andReturn($data['project_id'])
            ->shouldReceive('getReferenceNumber')->andReturn($data['reference_number'])
            ->shouldReceive('getName')->andReturn($data['name'])
            ->shouldReceive('getIssueDate')->andReturn($data['issue_date'])
            ->shouldReceive('getStartDate')->andReturn($data['start_date'])
            ->shouldReceive('getEndDate')->andReturn($data['end_date'])
            ->shouldReceive('getDescription')->andReturn($data['description'])
            ->shouldReceive('getValue')->andReturn($data['value'])
            ->shouldReceive('getDocument')->andReturn($data['document'])
            ->shouldReceive('getValueByContractTerms')->andReturn($data['value_by_contract_terms'])
            ->shouldReceive('getCreatedBy')->andReturn($data['created_by'])
            ->shouldReceive('getModifiedBy')->andReturn($data['modified_by']);

        $this->eloquent->shouldReceive('create')->with($data)->andReturn($object);

        $result = $this->repository->create($object);
        $this->assertInstanceOf(ProjectAddendumInterface::class, $result);
        $this->assertEquals($object, $result);
    }

    /**
     * Test delete ProjectAddendum
     */
    public function testDelete()
    {
        $note = m::mock(ProjectAddendumInterface::class);
        $note->shouldReceive('getKey')->andReturn(1);
        $this->eloquent->shouldReceive('delete')->with(1)->andReturn(true);
        $result = $this->repository->delete($note);
        $this->assertTrue($result);
    }

    /**
     * Test Update ProjectAddendum
     */
    public function testUpdate()
    {
        $id = 1;
        $data = ['project_id' => 1,'reference_number' => 1,'name' => 1,'issue_date' => 1,'start_date' => 1,'end_date' => 1,'description' => 1,'value' => 1,'document' => 1,'value_by_contract_terms' => 1,'created_by' => 1,'modified_by' => 1,];

        $object = m::mock(ProjectAddendumInterface::class);
        $object->shouldReceive('getKey')->andReturn($id);

        $object
            ->shouldReceive('getProjectId')->andReturn($data['project_id'])
            ->shouldReceive('getReferenceNumber')->andReturn($data['reference_number'])
            ->shouldReceive('getName')->andReturn($data['name'])
            ->shouldReceive('getIssueDate')->andReturn($data['issue_date'])
            ->shouldReceive('getStartDate')->andReturn($data['start_date'])
            ->shouldReceive('getEndDate')->andReturn($data['end_date'])
            ->shouldReceive('getDescription')->andReturn($data['description'])
            ->shouldReceive('getValue')->andReturn($data['value'])
            ->shouldReceive('getDocument')->andReturn($data['document'])
            ->shouldReceive('getValueByContractTerms')->andReturn($data['value_by_contract_terms'])
            ->shouldReceive('getCreatedBy')->andReturn($data['created_by'])
            ->shouldReceive('getModifiedBy')->andReturn($data['modified_by']);

        $this->eloquent->shouldReceive('update')->with($data, $id)->andReturn($object);

        $result = $this->repository->update($object);
        $this->assertEquals($object, $result);
    }
}

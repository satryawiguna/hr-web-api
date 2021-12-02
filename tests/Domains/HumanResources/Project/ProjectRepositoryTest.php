<?php
namespace Tests\Domains\HumanResources\Project;

use Mockery as m;
use Tests\TestCase;
use App\Infrastructures\HumanResources\Project\Contracts\EloquentProjectRepositoryInterface;
use App\Domains\HumanResources\Project\ProjectRepository;
use App\Domains\HumanResources\Project\ProjectEloquent;
use App\Domains\HumanResources\Project\Contracts\ProjectInterface;
use App\Domains\HumanResources\Project\Contracts\ProjectRepositoryInterface;

class ProjectRepositoryTest extends TestCase
{
    private $eloquent;
    private $repository;

    protected function setUp()
    {
        parent::setUp();
        $this->eloquent = m::mock(EloquentProjectRepositoryInterface::class);
        $this->repository = new ProjectRepository($this->eloquent);
    }

    protected function tearDown()
    {
        m::close();
    }

    public function testConstructor()
    {
        $this->assertInstanceOf(ProjectRepositoryInterface::class, $this->repository);
    }

    /**
     * Test create Project
     */
    public function testCreate()
    {
        $object = m::mock(ProjectInterface::class);

        $data = ['parent_id' => 1,'company_id' => 1,'is_contract' => 1,'name' => 1,'first_party' => 1,'second_party' => 1,'issue_date' => 1,'start_date' => 1,'end_date' => 1,'job_description' => 1,'rate' => 1,'contract_type' => 1,'rate_per_contract_type' => 1,'created_by' => 1,'modified_by' => 1,];

        $object
            ->shouldReceive('getParentId')->andReturn($data['parent_id'])
            ->shouldReceive('getCompanyId')->andReturn($data['company_id'])
            ->shouldReceive('getIsContract')->andReturn($data['is_contract'])
            ->shouldReceive('getName')->andReturn($data['name'])
            ->shouldReceive('getFirstParty')->andReturn($data['first_party'])
            ->shouldReceive('getSecondParty')->andReturn($data['second_party'])
            ->shouldReceive('getIssueDate')->andReturn($data['issue_date'])
            ->shouldReceive('getStartDate')->andReturn($data['start_date'])
            ->shouldReceive('getEndDate')->andReturn($data['end_date'])
            ->shouldReceive('getJobDescription')->andReturn($data['job_description'])
            ->shouldReceive('getRate')->andReturn($data['rate'])
            ->shouldReceive('getContractType')->andReturn($data['contract_type'])
            ->shouldReceive('getRatePerContractType')->andReturn($data['rate_per_contract_type'])
            ->shouldReceive('getCreatedBy')->andReturn($data['created_by'])
            ->shouldReceive('getModifiedBy')->andReturn($data['modified_by']);

        $this->eloquent->shouldReceive('create')->with($data)->andReturn($object);

        $result = $this->repository->create($object);
        $this->assertInstanceOf(ProjectInterface::class, $result);
        $this->assertEquals($object, $result);
    }

    /**
     * Test delete Project
     */
    public function testDelete()
    {
        $note = m::mock(ProjectInterface::class);
        $note->shouldReceive('getKey')->andReturn(1);
        $this->eloquent->shouldReceive('delete')->with(1)->andReturn(true);
        $result = $this->repository->delete($note);
        $this->assertTrue($result);
    }

    /**
     * Test Update Project
     */
    public function testUpdate()
    {
        $id = 1;
        $data = ['parent_id' => 1,'company_id' => 1,'is_contract' => 1,'name' => 1,'first_party' => 1,'second_party' => 1,'issue_date' => 1,'start_date' => 1,'end_date' => 1,'job_description' => 1,'rate' => 1,'contract_type' => 1,'rate_per_contract_type' => 1,'created_by' => 1,'modified_by' => 1,];

        $object = m::mock(ProjectInterface::class);
        $object->shouldReceive('getKey')->andReturn($id);

        $object
            ->shouldReceive('getParentId')->andReturn($data['parent_id'])
            ->shouldReceive('getCompanyId')->andReturn($data['company_id'])
            ->shouldReceive('getIsContract')->andReturn($data['is_contract'])
            ->shouldReceive('getName')->andReturn($data['name'])
            ->shouldReceive('getFirstParty')->andReturn($data['first_party'])
            ->shouldReceive('getSecondParty')->andReturn($data['second_party'])
            ->shouldReceive('getIssueDate')->andReturn($data['issue_date'])
            ->shouldReceive('getStartDate')->andReturn($data['start_date'])
            ->shouldReceive('getEndDate')->andReturn($data['end_date'])
            ->shouldReceive('getJobDescription')->andReturn($data['job_description'])
            ->shouldReceive('getRate')->andReturn($data['rate'])
            ->shouldReceive('getContractType')->andReturn($data['contract_type'])
            ->shouldReceive('getRatePerContractType')->andReturn($data['rate_per_contract_type'])
            ->shouldReceive('getCreatedBy')->andReturn($data['created_by'])
            ->shouldReceive('getModifiedBy')->andReturn($data['modified_by']);

        $this->eloquent->shouldReceive('update')->with($data, $id)->andReturn($object);

        $result = $this->repository->update($object);
        $this->assertEquals($object, $result);
    }
}

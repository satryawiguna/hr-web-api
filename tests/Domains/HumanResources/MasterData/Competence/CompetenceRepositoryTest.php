<?php
namespace Tests\Domains\HumanResources\MasterData\Competence;

use Mockery as m;
use Tests\TestCase;
use App\Infrastructures\HumanResources\MasterData\Competence\Contracts\EloquentCompetenceRepositoryInterface;
use App\Domains\HumanResources\MasterData\Competence\CompetenceRepository;
use App\Domains\HumanResources\MasterData\Competence\CompetenceEloquent;
use App\Domains\HumanResources\MasterData\Competence\Contracts\CompetenceInterface;
use App\Domains\HumanResources\MasterData\Competence\Contracts\CompetenceRepositoryInterface;

class CompetenceRepositoryTest extends TestCase
{
    private $eloquent;
    private $repository;

    protected function setUp()
    {
        parent::setUp();
        $this->eloquent = m::mock(EloquentCompetenceRepositoryInterface::class);
        $this->repository = new CompetenceRepository($this->eloquent);
    }

    protected function tearDown()
    {
        m::close();
    }

    public function testConstructor()
    {
        $this->assertInstanceOf(CompetenceRepositoryInterface::class, $this->repository);
    }

    /**
     * Test create Competence
     */
    public function testCreate()
    {
        $object = m::mock(CompetenceInterface::class);

        $data = ['company_id' => 1,'code' => 1,'name' => 1,'description' => 1,'is_active' => 1,'created_by' => 1,'modified_by' => 1,];

        $object
            ->shouldReceive('getCompanyId')->andReturn($data['company_id'])
            ->shouldReceive('getCode')->andReturn($data['code'])
            ->shouldReceive('getName')->andReturn($data['name'])
            ->shouldReceive('getDescription')->andReturn($data['description'])
            ->shouldReceive('getIsActive')->andReturn($data['is_active'])
            ->shouldReceive('getCreatedBy')->andReturn($data['created_by'])
            ->shouldReceive('getModifiedBy')->andReturn($data['modified_by']);

        $this->eloquent->shouldReceive('create')->with($data)->andReturn($object);

        $result = $this->repository->create($object);
        $this->assertInstanceOf(CompetenceInterface::class, $result);
        $this->assertEquals($object, $result);
    }

    /**
     * Test delete Competence
     */
    public function testDelete()
    {
        $note = m::mock(CompetenceInterface::class);
        $note->shouldReceive('getKey')->andReturn(1);
        $this->eloquent->shouldReceive('delete')->with(1)->andReturn(true);
        $result = $this->repository->delete($note);
        $this->assertTrue($result);
    }

    /**
     * Test Update Competence
     */
    public function testUpdate()
    {
        $id = 1;
        $data = ['company_id' => 1,'code' => 1,'name' => 1,'description' => 1,'is_active' => 1,'created_by' => 1,'modified_by' => 1,];

        $object = m::mock(CompetenceInterface::class);
        $object->shouldReceive('getKey')->andReturn($id);

        $object
            ->shouldReceive('getCompanyId')->andReturn($data['company_id'])
            ->shouldReceive('getCode')->andReturn($data['code'])
            ->shouldReceive('getName')->andReturn($data['name'])
            ->shouldReceive('getDescription')->andReturn($data['description'])
            ->shouldReceive('getIsActive')->andReturn($data['is_active'])
            ->shouldReceive('getCreatedBy')->andReturn($data['created_by'])
            ->shouldReceive('getModifiedBy')->andReturn($data['modified_by']);

        $this->eloquent->shouldReceive('update')->with($data, $id)->andReturn($object);

        $result = $this->repository->update($object);
        $this->assertEquals($object, $result);
    }
}

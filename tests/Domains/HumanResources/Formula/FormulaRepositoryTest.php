<?php
namespace Tests\Domains\HumanResources\Formula;

use Mockery as m;
use Tests\TestCase;
use App\Infrastructures\HumanResources\Formula\Contracts\EloquentFormulaRepositoryInterface;
use App\Domains\HumanResources\Formula\FormulaRepository;
use App\Domains\HumanResources\Formula\FormulaEloquent;
use App\Domains\HumanResources\Formula\Contracts\FormulaInterface;
use App\Domains\HumanResources\Formula\Contracts\FormulaRepositoryInterface;

class FormulaRepositoryTest extends TestCase
{
    private $eloquent;
    private $repository;

    protected function setUp()
    {
        parent::setUp();
        $this->eloquent = m::mock(EloquentFormulaRepositoryInterface::class);
        $this->repository = new FormulaRepository($this->eloquent);
    }

    protected function tearDown()
    {
        m::close();
    }

    public function testConstructor()
    {
        $this->assertInstanceOf(FormulaRepositoryInterface::class, $this->repository);
    }

    /**
     * Test create Formula
     */
    public function testCreate()
    {
        $object = m::mock(FormulaInterface::class);

        $data = ['formula_category_id' => 1,'name' => 1,'type' => 1,'description' => 1,'created_by' => 1,'modified_by' => 1,];

        $object
            ->shouldReceive('getFormulaCategoryId')->andReturn($data['formula_category_id'])
            ->shouldReceive('getName')->andReturn($data['name'])
            ->shouldReceive('getType')->andReturn($data['type'])
            ->shouldReceive('getDescription')->andReturn($data['description'])
            ->shouldReceive('getCreatedBy')->andReturn($data['created_by'])
            ->shouldReceive('getModifiedBy')->andReturn($data['modified_by']);

        $this->eloquent->shouldReceive('create')->with($data)->andReturn($object);

        $result = $this->repository->create($object);
        $this->assertInstanceOf(FormulaInterface::class, $result);
        $this->assertEquals($object, $result);
    }

    /**
     * Test delete Formula
     */
    public function testDelete()
    {
        $note = m::mock(FormulaInterface::class);
        $note->shouldReceive('getKey')->andReturn(1);
        $this->eloquent->shouldReceive('delete')->with(1)->andReturn(true);
        $result = $this->repository->delete($note);
        $this->assertTrue($result);
    }

    /**
     * Test Update Formula
     */
    public function testUpdate()
    {
        $id = 1;
        $data = ['formula_category_id' => 1,'name' => 1,'type' => 1,'description' => 1,'created_by' => 1,'modified_by' => 1,];

        $object = m::mock(FormulaInterface::class);
        $object->shouldReceive('getKey')->andReturn($id);

        $object
            ->shouldReceive('getFormulaCategoryId')->andReturn($data['formula_category_id'])
            ->shouldReceive('getName')->andReturn($data['name'])
            ->shouldReceive('getType')->andReturn($data['type'])
            ->shouldReceive('getDescription')->andReturn($data['description'])
            ->shouldReceive('getCreatedBy')->andReturn($data['created_by'])
            ->shouldReceive('getModifiedBy')->andReturn($data['modified_by']);

        $this->eloquent->shouldReceive('update')->with($data, $id)->andReturn($object);

        $result = $this->repository->update($object);
        $this->assertEquals($object, $result);
    }
}

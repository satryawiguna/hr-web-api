<?php
namespace Tests\Domains\HumanResources\Formula\FormulaCategory;

use Mockery as m;
use Tests\TestCase;
use App\Infrastructures\HumanResources\Formula\FormulaCategory\Contracts\EloquentFormulaCategoryRepositoryInterface;
use App\Domains\HumanResources\Formula\FormulaCategory\FormulaCategoryRepository;
use App\Domains\HumanResources\Formula\FormulaCategory\FormulaCategoryEloquent;
use App\Domains\HumanResources\Formula\FormulaCategory\Contracts\FormulaCategoryInterface;
use App\Domains\HumanResources\Formula\FormulaCategory\Contracts\FormulaCategoryRepositoryInterface;

class FormulaCategoryRepositoryTest extends TestCase
{
    private $eloquent;
    private $repository;

    protected function setUp()
    {
        parent::setUp();
        $this->eloquent = m::mock(EloquentFormulaCategoryRepositoryInterface::class);
        $this->repository = new FormulaCategoryRepository($this->eloquent);
    }

    protected function tearDown()
    {
        m::close();
    }

    public function testConstructor()
    {
        $this->assertInstanceOf(FormulaCategoryRepositoryInterface::class, $this->repository);
    }

    /**
     * Test create FormulaCategory
     */
    public function testCreate()
    {
        $object = m::mock(FormulaCategoryInterface::class);

        $data = ['name' => 1,'slug' => 1,'description' => 1,'created_by' => 1,'modified_by' => 1,];

        $object
            ->shouldReceive('getName')->andReturn($data['name'])
            ->shouldReceive('getSlug')->andReturn($data['slug'])
            ->shouldReceive('getDescription')->andReturn($data['description'])
            ->shouldReceive('getCreatedBy')->andReturn($data['created_by'])
            ->shouldReceive('getModifiedBy')->andReturn($data['modified_by']);

        $this->eloquent->shouldReceive('create')->with($data)->andReturn($object);

        $result = $this->repository->create($object);
        $this->assertInstanceOf(FormulaCategoryInterface::class, $result);
        $this->assertEquals($object, $result);
    }

    /**
     * Test delete FormulaCategory
     */
    public function testDelete()
    {
        $note = m::mock(FormulaCategoryInterface::class);
        $note->shouldReceive('getKey')->andReturn(1);
        $this->eloquent->shouldReceive('delete')->with(1)->andReturn(true);
        $result = $this->repository->delete($note);
        $this->assertTrue($result);
    }

    /**
     * Test Update FormulaCategory
     */
    public function testUpdate()
    {
        $id = 1;
        $data = ['name' => 1,'slug' => 1,'description' => 1,'created_by' => 1,'modified_by' => 1,];

        $object = m::mock(FormulaCategoryInterface::class);
        $object->shouldReceive('getKey')->andReturn($id);

        $object
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

<?php
namespace Tests\Domains\HumanResources\Element;

use Mockery as m;
use Tests\TestCase;
use App\Infrastructures\HumanResources\Element\Contracts\EloquentElementRepositoryInterface;
use App\Domains\HumanResources\Element\ElementRepository;
use App\Domains\HumanResources\Element\ElementEloquent;
use App\Domains\HumanResources\Element\Contracts\ElementInterface;
use App\Domains\HumanResources\Element\Contracts\ElementRepositoryInterface;

class ElementRepositoryTest extends TestCase
{
    private $eloquent;
    private $repository;

    protected function setUp()
    {
        parent::setUp();
        $this->eloquent = m::mock(EloquentElementRepositoryInterface::class);
        $this->repository = new ElementRepository($this->eloquent);
    }

    protected function tearDown()
    {
        m::close();
    }

    public function testConstructor()
    {
        $this->assertInstanceOf(ElementRepositoryInterface::class, $this->repository);
    }

    /**
     * Test create Element
     */
    public function testCreate()
    {
        $object = m::mock(ElementInterface::class);

        $data = ['code' => 1,'name' => 1,'formula_id' => 1,'seq_no' => 1,'created_by' => 1,'modified_by' => 1,];

        $object
            ->shouldReceive('getCode')->andReturn($data['code'])
            ->shouldReceive('getName')->andReturn($data['name'])
            ->shouldReceive('getFormulaId')->andReturn($data['formula_id'])
            ->shouldReceive('getSeqNo')->andReturn($data['seq_no'])
            ->shouldReceive('getCreatedBy')->andReturn($data['created_by'])
            ->shouldReceive('getModifiedBy')->andReturn($data['modified_by']);

        $this->eloquent->shouldReceive('create')->with($data)->andReturn($object);

        $result = $this->repository->create($object);
        $this->assertInstanceOf(ElementInterface::class, $result);
        $this->assertEquals($object, $result);
    }

    /**
     * Test delete Element
     */
    public function testDelete()
    {
        $note = m::mock(ElementInterface::class);
        $note->shouldReceive('getKey')->andReturn(1);
        $this->eloquent->shouldReceive('delete')->with(1)->andReturn(true);
        $result = $this->repository->delete($note);
        $this->assertTrue($result);
    }

    /**
     * Test Update Element
     */
    public function testUpdate()
    {
        $id = 1;
        $data = ['code' => 1,'name' => 1,'formula_id' => 1,'seq_no' => 1,'created_by' => 1,'modified_by' => 1,];

        $object = m::mock(ElementInterface::class);
        $object->shouldReceive('getKey')->andReturn($id);

        $object
            ->shouldReceive('getCode')->andReturn($data['code'])
            ->shouldReceive('getName')->andReturn($data['name'])
            ->shouldReceive('getFormulaId')->andReturn($data['formula_id'])
            ->shouldReceive('getSeqNo')->andReturn($data['seq_no'])
            ->shouldReceive('getCreatedBy')->andReturn($data['created_by'])
            ->shouldReceive('getModifiedBy')->andReturn($data['modified_by']);

        $this->eloquent->shouldReceive('update')->with($data, $id)->andReturn($object);

        $result = $this->repository->update($object);
        $this->assertEquals($object, $result);
    }
}

<?php
namespace Tests\Domains\HumanResources\Element\ElementValue;

use Mockery as m;
use Tests\TestCase;
use App\Infrastructures\HumanResources\Element\ElementValue\Contracts\EloquentElementValueRepositoryInterface;
use App\Domains\HumanResources\Element\ElementValue\ElementValueRepository;
use App\Domains\HumanResources\Element\ElementValue\ElementValueEloquent;
use App\Domains\HumanResources\Element\ElementValue\Contracts\ElementValueInterface;
use App\Domains\HumanResources\Element\ElementValue\Contracts\ElementValueRepositoryInterface;

class ElementValueRepositoryTest extends TestCase
{
    private $eloquent;
    private $repository;

    protected function setUp()
    {
        parent::setUp();
        $this->eloquent = m::mock(EloquentElementValueRepositoryInterface::class);
        $this->repository = new ElementValueRepository($this->eloquent);
    }

    protected function tearDown()
    {
        m::close();
    }

    public function testConstructor()
    {
        $this->assertInstanceOf(ElementValueRepositoryInterface::class, $this->repository);
    }

    /**
     * Test create ElementValue
     */
    public function testCreate()
    {
        $object = m::mock(ElementValueInterface::class);

        $data = ['element_id' => 1,'code' => 1,'name' => 1,'value' => 1,'seq_no' => 1,'created_by' => 1,'modified_by' => 1,];

        $object
            ->shouldReceive('getElementId')->andReturn($data['element_id'])
            ->shouldReceive('getCode')->andReturn($data['code'])
            ->shouldReceive('getName')->andReturn($data['name'])
            ->shouldReceive('getValue')->andReturn($data['value'])
            ->shouldReceive('getSeqNo')->andReturn($data['seq_no'])
            ->shouldReceive('getCreatedBy')->andReturn($data['created_by'])
            ->shouldReceive('getModifiedBy')->andReturn($data['modified_by']);

        $this->eloquent->shouldReceive('create')->with($data)->andReturn($object);

        $result = $this->repository->create($object);
        $this->assertInstanceOf(ElementValueInterface::class, $result);
        $this->assertEquals($object, $result);
    }

    /**
     * Test delete ElementValue
     */
    public function testDelete()
    {
        $note = m::mock(ElementValueInterface::class);
        $note->shouldReceive('getKey')->andReturn(1);
        $this->eloquent->shouldReceive('delete')->with(1)->andReturn(true);
        $result = $this->repository->delete($note);
        $this->assertTrue($result);
    }

    /**
     * Test Update ElementValue
     */
    public function testUpdate()
    {
        $id = 1;
        $data = ['element_id' => 1,'code' => 1,'name' => 1,'value' => 1,'seq_no' => 1,'created_by' => 1,'modified_by' => 1,];

        $object = m::mock(ElementValueInterface::class);
        $object->shouldReceive('getKey')->andReturn($id);

        $object
            ->shouldReceive('getElementId')->andReturn($data['element_id'])
            ->shouldReceive('getCode')->andReturn($data['code'])
            ->shouldReceive('getName')->andReturn($data['name'])
            ->shouldReceive('getValue')->andReturn($data['value'])
            ->shouldReceive('getSeqNo')->andReturn($data['seq_no'])
            ->shouldReceive('getCreatedBy')->andReturn($data['created_by'])
            ->shouldReceive('getModifiedBy')->andReturn($data['modified_by']);

        $this->eloquent->shouldReceive('update')->with($data, $id)->andReturn($object);

        $result = $this->repository->update($object);
        $this->assertEquals($object, $result);
    }
}

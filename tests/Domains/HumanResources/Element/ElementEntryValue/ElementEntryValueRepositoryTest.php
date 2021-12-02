<?php
namespace Tests\Domains\HumanResources\Element\ElementEntryValue;

use Mockery as m;
use Tests\TestCase;
use App\Infrastructures\HumanResources\Element\ElementEntryValue\Contracts\EloquentElementEntryValueRepositoryInterface;
use App\Domains\HumanResources\Element\ElementEntryValue\ElementEntryValueRepository;
use App\Domains\HumanResources\Element\ElementEntryValue\ElementEntryValueEloquent;
use App\Domains\HumanResources\Element\ElementEntryValue\Contracts\ElementEntryValueInterface;
use App\Domains\HumanResources\Element\ElementEntryValue\Contracts\ElementEntryValueRepositoryInterface;

class ElementEntryValueRepositoryTest extends TestCase
{
    private $eloquent;
    private $repository;

    protected function setUp()
    {
        parent::setUp();
        $this->eloquent = m::mock(EloquentElementEntryValueRepositoryInterface::class);
        $this->repository = new ElementEntryValueRepository($this->eloquent);
    }

    protected function tearDown()
    {
        m::close();
    }

    public function testConstructor()
    {
        $this->assertInstanceOf(ElementEntryValueRepositoryInterface::class, $this->repository);
    }

    /**
     * Test create ElementEntryValue
     */
    public function testCreate()
    {
        $object = m::mock(ElementEntryValueInterface::class);

        $data = ['element_entry_id' => 1,'element_value_id' => 1,'efective_start' => 1,'efective_end' => 1,'value' => 1,'created_by' => 1,'modified_by' => 1,];

        $object
            ->shouldReceive('getElementEntryId')->andReturn($data['element_entry_id'])
            ->shouldReceive('getElementValueId')->andReturn($data['element_value_id'])
            ->shouldReceive('getEfectiveStart')->andReturn($data['efective_start'])
            ->shouldReceive('getEfectiveEnd')->andReturn($data['efective_end'])
            ->shouldReceive('getValue')->andReturn($data['value'])
            ->shouldReceive('getCreatedBy')->andReturn($data['created_by'])
            ->shouldReceive('getModifiedBy')->andReturn($data['modified_by']);

        $this->eloquent->shouldReceive('create')->with($data)->andReturn($object);

        $result = $this->repository->create($object);
        $this->assertInstanceOf(ElementEntryValueInterface::class, $result);
        $this->assertEquals($object, $result);
    }

    /**
     * Test delete ElementEntryValue
     */
    public function testDelete()
    {
        $note = m::mock(ElementEntryValueInterface::class);
        $note->shouldReceive('getKey')->andReturn(1);
        $this->eloquent->shouldReceive('delete')->with(1)->andReturn(true);
        $result = $this->repository->delete($note);
        $this->assertTrue($result);
    }

    /**
     * Test Update ElementEntryValue
     */
    public function testUpdate()
    {
        $id = 1;
        $data = ['element_entry_id' => 1,'element_value_id' => 1,'efective_start' => 1,'efective_end' => 1,'value' => 1,'created_by' => 1,'modified_by' => 1,];

        $object = m::mock(ElementEntryValueInterface::class);
        $object->shouldReceive('getKey')->andReturn($id);

        $object
            ->shouldReceive('getElementEntryId')->andReturn($data['element_entry_id'])
            ->shouldReceive('getElementValueId')->andReturn($data['element_value_id'])
            ->shouldReceive('getEfectiveStart')->andReturn($data['efective_start'])
            ->shouldReceive('getEfectiveEnd')->andReturn($data['efective_end'])
            ->shouldReceive('getValue')->andReturn($data['value'])
            ->shouldReceive('getCreatedBy')->andReturn($data['created_by'])
            ->shouldReceive('getModifiedBy')->andReturn($data['modified_by']);

        $this->eloquent->shouldReceive('update')->with($data, $id)->andReturn($object);

        $result = $this->repository->update($object);
        $this->assertEquals($object, $result);
    }
}

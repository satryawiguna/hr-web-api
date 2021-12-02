<?php
namespace Tests\Domains\HumanResources\Element\ElementEntry;

use Mockery as m;
use Tests\TestCase;
use App\Infrastructures\HumanResources\Element\ElementEntry\Contracts\EloquentElementEntryRepositoryInterface;
use App\Domains\HumanResources\Element\ElementEntry\ElementEntryRepository;
use App\Domains\HumanResources\Element\ElementEntry\ElementEntryEloquent;
use App\Domains\HumanResources\Element\ElementEntry\Contracts\ElementEntryInterface;
use App\Domains\HumanResources\Element\ElementEntry\Contracts\ElementEntryRepositoryInterface;

class ElementEntryRepositoryTest extends TestCase
{
    private $eloquent;
    private $repository;

    protected function setUp()
    {
        parent::setUp();
        $this->eloquent = m::mock(EloquentElementEntryRepositoryInterface::class);
        $this->repository = new ElementEntryRepository($this->eloquent);
    }

    protected function tearDown()
    {
        m::close();
    }

    public function testConstructor()
    {
        $this->assertInstanceOf(ElementEntryRepositoryInterface::class, $this->repository);
    }

    /**
     * Test create ElementEntry
     */
    public function testCreate()
    {
        $object = m::mock(ElementEntryInterface::class);

        $data = ['element_id' => 1,'employee_id' => 1,'efective_start' => 1,'efective_end' => 1,'created_by' => 1,'modified_by' => 1,];

        $object
            ->shouldReceive('getElementId')->andReturn($data['element_id'])
            ->shouldReceive('getEmployeeId')->andReturn($data['employee_id'])
            ->shouldReceive('getEfectiveStart')->andReturn($data['efective_start'])
            ->shouldReceive('getEfectiveEnd')->andReturn($data['efective_end'])
            ->shouldReceive('getCreatedBy')->andReturn($data['created_by'])
            ->shouldReceive('getModifiedBy')->andReturn($data['modified_by']);

        $this->eloquent->shouldReceive('create')->with($data)->andReturn($object);

        $result = $this->repository->create($object);
        $this->assertInstanceOf(ElementEntryInterface::class, $result);
        $this->assertEquals($object, $result);
    }

    /**
     * Test delete ElementEntry
     */
    public function testDelete()
    {
        $note = m::mock(ElementEntryInterface::class);
        $note->shouldReceive('getKey')->andReturn(1);
        $this->eloquent->shouldReceive('delete')->with(1)->andReturn(true);
        $result = $this->repository->delete($note);
        $this->assertTrue($result);
    }

    /**
     * Test Update ElementEntry
     */
    public function testUpdate()
    {
        $id = 1;
        $data = ['element_id' => 1,'employee_id' => 1,'efective_start' => 1,'efective_end' => 1,'created_by' => 1,'modified_by' => 1,];

        $object = m::mock(ElementEntryInterface::class);
        $object->shouldReceive('getKey')->andReturn($id);

        $object
            ->shouldReceive('getElementId')->andReturn($data['element_id'])
            ->shouldReceive('getEmployeeId')->andReturn($data['employee_id'])
            ->shouldReceive('getEfectiveStart')->andReturn($data['efective_start'])
            ->shouldReceive('getEfectiveEnd')->andReturn($data['efective_end'])
            ->shouldReceive('getCreatedBy')->andReturn($data['created_by'])
            ->shouldReceive('getModifiedBy')->andReturn($data['modified_by']);

        $this->eloquent->shouldReceive('update')->with($data, $id)->andReturn($object);

        $result = $this->repository->update($object);
        $this->assertEquals($object, $result);
    }
}

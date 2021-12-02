<?php
namespace Tests\Domains\HumanResources\Personal\Employee\Child;

use Mockery as m;
use Tests\TestCase;
use App\Infrastructures\HumanResources\Personal\Employee\Child\Contracts\EloquentChildRepositoryInterface;
use App\Domains\HumanResources\Personal\Employee\Child\ChildRepository;
use App\Domains\HumanResources\Personal\Employee\Child\ChildEloquent;
use App\Domains\HumanResources\Personal\Employee\Child\Contracts\ChildInterface;
use App\Domains\HumanResources\Personal\Employee\Child\Contracts\ChildRepositoryInterface;

class ChildRepositoryTest extends TestCase
{
    private $eloquent;
    private $repository;

    protected function setUp()
    {
        parent::setUp();
        $this->eloquent = m::mock(EloquentChildRepositoryInterface::class);
        $this->repository = new ChildRepository($this->eloquent);
    }

    protected function tearDown()
    {
        m::close();
    }

    public function testConstructor()
    {
        $this->assertInstanceOf(ChildRepositoryInterface::class, $this->repository);
    }

    /**
     * Test create Child
     */
    public function testCreate()
    {
        $object = m::mock(ChildInterface::class);

        $data = ['employee_id' => 1,'gender_id' => 1,'full_name' => 1,'nick_name' => 1,'child_as' => 1,'birth_place' => 1,'birth_date' => 1,'has_bpjs_kesehatan' => 1,'bpjs_kesehatan_number' => 1,'bpjs_kesehatan_date' => 1,'bpjs_kesehatan_class' => 1,'created_by' => 1,'modified_by' => 1,];

        $object
            ->shouldReceive('getEmployeeId')->andReturn($data['employee_id'])
            ->shouldReceive('getGenderId')->andReturn($data['gender_id'])
            ->shouldReceive('getFullName')->andReturn($data['full_name'])
            ->shouldReceive('getNickName')->andReturn($data['nick_name'])
            ->shouldReceive('getChildAs')->andReturn($data['child_as'])
            ->shouldReceive('getBirthPlace')->andReturn($data['birth_place'])
            ->shouldReceive('getBirthDate')->andReturn($data['birth_date'])
            ->shouldReceive('getHasBpjsKesehatan')->andReturn($data['has_bpjs_kesehatan'])
            ->shouldReceive('getBpjsKesehatanNumber')->andReturn($data['bpjs_kesehatan_number'])
            ->shouldReceive('getBpjsKesehatanDate')->andReturn($data['bpjs_kesehatan_date'])
            ->shouldReceive('getBpjsKesehatanClass')->andReturn($data['bpjs_kesehatan_class'])
            ->shouldReceive('getCreatedBy')->andReturn($data['created_by'])
            ->shouldReceive('getModifiedBy')->andReturn($data['modified_by']);

        $this->eloquent->shouldReceive('create')->with($data)->andReturn($object);

        $result = $this->repository->create($object);
        $this->assertInstanceOf(ChildInterface::class, $result);
        $this->assertEquals($object, $result);
    }

    /**
     * Test delete Child
     */
    public function testDelete()
    {
        $note = m::mock(ChildInterface::class);
        $note->shouldReceive('getKey')->andReturn(1);
        $this->eloquent->shouldReceive('delete')->with(1)->andReturn(true);
        $result = $this->repository->delete($note);
        $this->assertTrue($result);
    }

    /**
     * Test Update Child
     */
    public function testUpdate()
    {
        $id = 1;
        $data = ['employee_id' => 1,'gender_id' => 1,'full_name' => 1,'nick_name' => 1,'child_as' => 1,'birth_place' => 1,'birth_date' => 1,'has_bpjs_kesehatan' => 1,'bpjs_kesehatan_number' => 1,'bpjs_kesehatan_date' => 1,'bpjs_kesehatan_class' => 1,'created_by' => 1,'modified_by' => 1,];

        $object = m::mock(ChildInterface::class);
        $object->shouldReceive('getKey')->andReturn($id);

        $object
            ->shouldReceive('getEmployeeId')->andReturn($data['employee_id'])
            ->shouldReceive('getGenderId')->andReturn($data['gender_id'])
            ->shouldReceive('getFullName')->andReturn($data['full_name'])
            ->shouldReceive('getNickName')->andReturn($data['nick_name'])
            ->shouldReceive('getChildAs')->andReturn($data['child_as'])
            ->shouldReceive('getBirthPlace')->andReturn($data['birth_place'])
            ->shouldReceive('getBirthDate')->andReturn($data['birth_date'])
            ->shouldReceive('getHasBpjsKesehatan')->andReturn($data['has_bpjs_kesehatan'])
            ->shouldReceive('getBpjsKesehatanNumber')->andReturn($data['bpjs_kesehatan_number'])
            ->shouldReceive('getBpjsKesehatanDate')->andReturn($data['bpjs_kesehatan_date'])
            ->shouldReceive('getBpjsKesehatanClass')->andReturn($data['bpjs_kesehatan_class'])
            ->shouldReceive('getCreatedBy')->andReturn($data['created_by'])
            ->shouldReceive('getModifiedBy')->andReturn($data['modified_by']);

        $this->eloquent->shouldReceive('update')->with($data, $id)->andReturn($object);

        $result = $this->repository->update($object);
        $this->assertEquals($object, $result);
    }
}

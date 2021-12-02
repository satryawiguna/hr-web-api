<?php
namespace Tests\Domains\HumanResources\MasterData\LetterType;

use Mockery as m;
use Tests\TestCase;
use App\Infrastructures\HumanResources\MasterData\LetterType\Contracts\EloquentLetterTypeRepositoryInterface;
use App\Domains\HumanResources\MasterData\LetterType\LetterTypeRepository;
use App\Domains\HumanResources\MasterData\LetterType\LetterTypeEloquent;
use App\Domains\HumanResources\MasterData\LetterType\Contracts\LetterTypeInterface;
use App\Domains\HumanResources\MasterData\LetterType\Contracts\LetterTypeRepositoryInterface;

class LetterTypeRepositoryTest extends TestCase
{
    private $eloquent;
    private $repository;

    protected function setUp()
    {
        parent::setUp();
        $this->eloquent = m::mock(EloquentLetterTypeRepositoryInterface::class);
        $this->repository = new LetterTypeRepository($this->eloquent);
    }

    protected function tearDown()
    {
        m::close();
    }

    public function testConstructor()
    {
        $this->assertInstanceOf(LetterTypeRepositoryInterface::class, $this->repository);
    }

    /**
     * Test create LetterType
     */
    public function testCreate()
    {
        $object = m::mock(LetterTypeInterface::class);

        $data = ['company_id' => 1,'code' => 1,'name' => 1,'slug' => 1,'created_by' => 1,'modified_by' => 1,];

        $object
            ->shouldReceive('getCompanyId')->andReturn($data['company_id'])
            ->shouldReceive('getCode')->andReturn($data['code'])
            ->shouldReceive('getName')->andReturn($data['name'])
            ->shouldReceive('getSlug')->andReturn($data['slug'])
            ->shouldReceive('getCreatedBy')->andReturn($data['created_by'])
            ->shouldReceive('getModifiedBy')->andReturn($data['modified_by']);

        $this->eloquent->shouldReceive('create')->with($data)->andReturn($object);

        $result = $this->repository->create($object);
        $this->assertInstanceOf(LetterTypeInterface::class, $result);
        $this->assertEquals($object, $result);
    }

    /**
     * Test delete LetterType
     */
    public function testDelete()
    {
        $note = m::mock(LetterTypeInterface::class);
        $note->shouldReceive('getKey')->andReturn(1);
        $this->eloquent->shouldReceive('delete')->with(1)->andReturn(true);
        $result = $this->repository->delete($note);
        $this->assertTrue($result);
    }

    /**
     * Test Update LetterType
     */
    public function testUpdate()
    {
        $id = 1;
        $data = ['company_id' => 1,'code' => 1,'name' => 1,'slug' => 1,'created_by' => 1,'modified_by' => 1,];

        $object = m::mock(LetterTypeInterface::class);
        $object->shouldReceive('getKey')->andReturn($id);

        $object
            ->shouldReceive('getCompanyId')->andReturn($data['company_id'])
            ->shouldReceive('getCode')->andReturn($data['code'])
            ->shouldReceive('getName')->andReturn($data['name'])
            ->shouldReceive('getSlug')->andReturn($data['slug'])
            ->shouldReceive('getCreatedBy')->andReturn($data['created_by'])
            ->shouldReceive('getModifiedBy')->andReturn($data['modified_by']);

        $this->eloquent->shouldReceive('update')->with($data, $id)->andReturn($object);

        $result = $this->repository->update($object);
        $this->assertEquals($object, $result);
    }
}

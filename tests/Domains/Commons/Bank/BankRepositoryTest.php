<?php
namespace Tests\Domains\Commons\Bank;

use Mockery as m;
use Tests\TestCase;
use App\Infrastructures\Commons\Bank\Contracts\EloquentBankRepositoryInterface;
use App\Domains\Commons\Bank\BankRepository;
use App\Domains\Commons\Bank\BankEloquent;
use App\Domains\Commons\Bank\Contracts\BankInterface;
use App\Domains\Commons\Bank\Contracts\BankRepositoryInterface;

class BankRepositoryTest extends TestCase
{
    private $eloquent;
    private $repository;

    protected function setUp()
    {
        parent::setUp();
        $this->eloquent = m::mock(EloquentBankRepositoryInterface::class);
        $this->repository = new BankRepository($this->eloquent);
    }

    protected function tearDown()
    {
        m::close();
    }

    public function testConstructor()
    {
        $this->assertInstanceOf(BankRepositoryInterface::class, $this->repository);
    }

    /**
     * Test create Bank
     */
    public function testCreate()
    {
        $object = m::mock(BankInterface::class);

        $data = ['name' => 1,'slug' => 1,'is_active' => 1,'created_by' => 1,'modified_by' => 1,];

        $object
            ->shouldReceive('getName')->andReturn($data['name'])
            ->shouldReceive('getSlug')->andReturn($data['slug'])
            ->shouldReceive('getIsActive')->andReturn($data['is_active'])
            ->shouldReceive('getCreatedBy')->andReturn($data['created_by'])
            ->shouldReceive('getModifiedBy')->andReturn($data['modified_by']);

        $this->eloquent->shouldReceive('create')->with($data)->andReturn($object);

        $result = $this->repository->create($object);
        $this->assertInstanceOf(BankInterface::class, $result);
        $this->assertEquals($object, $result);
    }

    /**
     * Test delete Bank
     */
    public function testDelete()
    {
        $note = m::mock(BankInterface::class);
        $note->shouldReceive('getKey')->andReturn(1);
        $this->eloquent->shouldReceive('delete')->with(1)->andReturn(true);
        $result = $this->repository->delete($note);
        $this->assertTrue($result);
    }

    /**
     * Test Update Bank
     */
    public function testUpdate()
    {
        $id = 1;
        $data = ['name' => 1,'slug' => 1,'is_active' => 1,'created_by' => 1,'modified_by' => 1,];

        $object = m::mock(BankInterface::class);
        $object->shouldReceive('getKey')->andReturn($id);

        $object
            ->shouldReceive('getName')->andReturn($data['name'])
            ->shouldReceive('getSlug')->andReturn($data['slug'])
            ->shouldReceive('getIsActive')->andReturn($data['is_active'])
            ->shouldReceive('getCreatedBy')->andReturn($data['created_by'])
            ->shouldReceive('getModifiedBy')->andReturn($data['modified_by']);

        $this->eloquent->shouldReceive('update')->with($data, $id)->andReturn($object);

        $result = $this->repository->update($object);
        $this->assertEquals($object, $result);
    }
}

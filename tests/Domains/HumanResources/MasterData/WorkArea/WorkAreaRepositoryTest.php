<?php
namespace Tests\Domains\HumanResources\MasterData\WorkArea;

use Mockery as m;
use Tests\TestCase;
use App\Infrastructures\HumanResources\MasterData\WorkArea\Contracts\EloquentWorkAreaRepositoryInterface;
use App\Domains\HumanResources\MasterData\WorkArea\WorkAreaRepository;
use App\Domains\HumanResources\MasterData\WorkArea\WorkAreaEloquent;
use App\Domains\HumanResources\MasterData\WorkArea\Contracts\WorkAreaInterface;
use App\Domains\HumanResources\MasterData\WorkArea\Contracts\WorkAreaRepositoryInterface;

class WorkAreaRepositoryTest extends TestCase
{
    private $eloquent;
    private $repository;

    protected function setUp()
    {
        parent::setUp();
        $this->eloquent = m::mock(EloquentWorkAreaRepositoryInterface::class);
        $this->repository = new WorkAreaRepository($this->eloquent);
    }

    protected function tearDown()
    {
        m::close();
    }

    public function testConstructor()
    {
        $this->assertInstanceOf(WorkAreaRepositoryInterface::class, $this->repository);
    }

    /**
     * Test create WorkArea
     */
    public function testCreate()
    {
        $object = m::mock(WorkAreaInterface::class);

        $data = ['company_id' => 1,'code' => 1,'title' => 1,'slug' => 1,'country' => 1,'state' => 1,'city' => 1,'address' => 1,'postcode' => 1,'phone' => 1,'fax' => 1,'email' => 1,'url' => 1,'is_active' => 1,'created_by' => 1,'modified_by' => 1,];

        $object
            ->shouldReceive('getCompanyId')->andReturn($data['company_id'])
            ->shouldReceive('getCode')->andReturn($data['code'])
            ->shouldReceive('getTitle')->andReturn($data['title'])
            ->shouldReceive('getSlug')->andReturn($data['slug'])
            ->shouldReceive('getCountry')->andReturn($data['country'])
            ->shouldReceive('getState')->andReturn($data['state'])
            ->shouldReceive('getCity')->andReturn($data['city'])
            ->shouldReceive('getAddress')->andReturn($data['address'])
            ->shouldReceive('getPostcode')->andReturn($data['postcode'])
            ->shouldReceive('getPhone')->andReturn($data['phone'])
            ->shouldReceive('getFax')->andReturn($data['fax'])
            ->shouldReceive('getEmail')->andReturn($data['email'])
            ->shouldReceive('getUrl')->andReturn($data['url'])
            ->shouldReceive('getIsActive')->andReturn($data['is_active'])
            ->shouldReceive('getCreatedBy')->andReturn($data['created_by'])
            ->shouldReceive('getModifiedBy')->andReturn($data['modified_by']);

        $this->eloquent->shouldReceive('create')->with($data)->andReturn($object);

        $result = $this->repository->create($object);
        $this->assertInstanceOf(WorkAreaInterface::class, $result);
        $this->assertEquals($object, $result);
    }

    /**
     * Test delete WorkArea
     */
    public function testDelete()
    {
        $note = m::mock(WorkAreaInterface::class);
        $note->shouldReceive('getKey')->andReturn(1);
        $this->eloquent->shouldReceive('delete')->with(1)->andReturn(true);
        $result = $this->repository->delete($note);
        $this->assertTrue($result);
    }

    /**
     * Test Update WorkArea
     */
    public function testUpdate()
    {
        $id = 1;
        $data = ['company_id' => 1,'code' => 1,'title' => 1,'slug' => 1,'country' => 1,'state' => 1,'city' => 1,'address' => 1,'postcode' => 1,'phone' => 1,'fax' => 1,'email' => 1,'url' => 1,'is_active' => 1,'created_by' => 1,'modified_by' => 1,];

        $object = m::mock(WorkAreaInterface::class);
        $object->shouldReceive('getKey')->andReturn($id);

        $object
            ->shouldReceive('getCompanyId')->andReturn($data['company_id'])
            ->shouldReceive('getCode')->andReturn($data['code'])
            ->shouldReceive('getTitle')->andReturn($data['title'])
            ->shouldReceive('getSlug')->andReturn($data['slug'])
            ->shouldReceive('getCountry')->andReturn($data['country'])
            ->shouldReceive('getState')->andReturn($data['state'])
            ->shouldReceive('getCity')->andReturn($data['city'])
            ->shouldReceive('getAddress')->andReturn($data['address'])
            ->shouldReceive('getPostcode')->andReturn($data['postcode'])
            ->shouldReceive('getPhone')->andReturn($data['phone'])
            ->shouldReceive('getFax')->andReturn($data['fax'])
            ->shouldReceive('getEmail')->andReturn($data['email'])
            ->shouldReceive('getUrl')->andReturn($data['url'])
            ->shouldReceive('getIsActive')->andReturn($data['is_active'])
            ->shouldReceive('getCreatedBy')->andReturn($data['created_by'])
            ->shouldReceive('getModifiedBy')->andReturn($data['modified_by']);

        $this->eloquent->shouldReceive('update')->with($data, $id)->andReturn($object);

        $result = $this->repository->update($object);
        $this->assertEquals($object, $result);
    }
}

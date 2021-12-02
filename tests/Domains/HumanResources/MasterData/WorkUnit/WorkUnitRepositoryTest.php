<?php
namespace Tests\Domains\HumanResources\MasterData\WorkUnit;

use Mockery as m;
use Tests\TestCase;
use App\Infrastructures\HumanResources\MasterData\WorkUnit\Contracts\EloquentWorkUnitRepositoryInterface;
use App\Domains\HumanResources\MasterData\WorkUnit\WorkUnitRepository;
use App\Domains\HumanResources\MasterData\WorkUnit\WorkUnitEloquent;
use App\Domains\HumanResources\MasterData\WorkUnit\Contracts\WorkUnitInterface;
use App\Domains\HumanResources\MasterData\WorkUnit\Contracts\WorkUnitRepositoryInterface;

class WorkUnitRepositoryTest extends TestCase
{
    private $eloquent;
    private $repository;

    protected function setUp()
    {
        parent::setUp();
        $this->eloquent = m::mock(EloquentWorkUnitRepositoryInterface::class);
        $this->repository = new WorkUnitRepository($this->eloquent);
    }

    protected function tearDown()
    {
        m::close();
    }

    public function testConstructor()
    {
        $this->assertInstanceOf(WorkUnitRepositoryInterface::class, $this->repository);
    }

    /**
     * Test create WorkUnit
     */
    public function testCreate()
    {
        $object = m::mock(WorkUnitInterface::class);

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
        $this->assertInstanceOf(WorkUnitInterface::class, $result);
        $this->assertEquals($object, $result);
    }

    /**
     * Test delete WorkUnit
     */
    public function testDelete()
    {
        $note = m::mock(WorkUnitInterface::class);
        $note->shouldReceive('getKey')->andReturn(1);
        $this->eloquent->shouldReceive('delete')->with(1)->andReturn(true);
        $result = $this->repository->delete($note);
        $this->assertTrue($result);
    }

    /**
     * Test Update WorkUnit
     */
    public function testUpdate()
    {
        $id = 1;
        $data = ['company_id' => 1,'code' => 1,'title' => 1,'slug' => 1,'country' => 1,'state' => 1,'city' => 1,'address' => 1,'postcode' => 1,'phone' => 1,'fax' => 1,'email' => 1,'url' => 1,'is_active' => 1,'created_by' => 1,'modified_by' => 1,];

        $object = m::mock(WorkUnitInterface::class);
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

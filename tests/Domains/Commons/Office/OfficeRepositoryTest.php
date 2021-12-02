<?php
namespace Tests\Domains\Commons\Office;

use Mockery as m;
use Tests\TestCase;
use App\Infrastructures\Commons\Office\Contracts\EloquentOfficeRepositoryInterface;
use App\Domains\Commons\Office\OfficeRepository;
use App\Domains\Commons\Office\OfficeEloquent;
use App\Domains\Commons\Office\Contracts\OfficeInterface;
use App\Domains\Commons\Office\Contracts\OfficeRepositoryInterface;

class OfficeRepositoryTest extends TestCase
{
    private $eloquent;
    private $repository;

    protected function setUp()
    {
        parent::setUp();
        $this->eloquent = m::mock(EloquentOfficeRepositoryInterface::class);
        $this->repository = new OfficeRepository($this->eloquent);
    }

    protected function tearDown()
    {
        m::close();
    }

    public function testConstructor()
    {
        $this->assertInstanceOf(OfficeRepositoryInterface::class, $this->repository);
    }

    /**
     * Test create Office
     */
    public function testCreate()
    {
        $object = m::mock(OfficeInterface::class);

        $data = ['company_id' => 1,'name' => 1,'slug' => 1,'country' => 1,'state_or_province' => 1,'city' => 1,'address' => 1,'postcode' => 1,'phone' => 1,'fax' => 1,'email' => 1,'latitude' => 1,'longitude' => 1,'is_active' => 1,'created_by' => 1,'modified_by' => 1,];

        $object
            ->shouldReceive('getCompanyId')->andReturn($data['company_id'])
            ->shouldReceive('getName')->andReturn($data['name'])
            ->shouldReceive('getSlug')->andReturn($data['slug'])
            ->shouldReceive('getCountry')->andReturn($data['country'])
            ->shouldReceive('getStateOrProvince')->andReturn($data['state_or_province'])
            ->shouldReceive('getCity')->andReturn($data['city'])
            ->shouldReceive('getAddress')->andReturn($data['address'])
            ->shouldReceive('getPostcode')->andReturn($data['postcode'])
            ->shouldReceive('getPhone')->andReturn($data['phone'])
            ->shouldReceive('getFax')->andReturn($data['fax'])
            ->shouldReceive('getEmail')->andReturn($data['email'])
            ->shouldReceive('getLatitude')->andReturn($data['latitude'])
            ->shouldReceive('getLongitude')->andReturn($data['longitude'])
            ->shouldReceive('getIsActive')->andReturn($data['is_active'])
            ->shouldReceive('getCreatedBy')->andReturn($data['created_by'])
            ->shouldReceive('getModifiedBy')->andReturn($data['modified_by']);

        $this->eloquent->shouldReceive('create')->with($data)->andReturn($object);

        $result = $this->repository->create($object);
        $this->assertInstanceOf(OfficeInterface::class, $result);
        $this->assertEquals($object, $result);
    }

    /**
     * Test delete Office
     */
    public function testDelete()
    {
        $note = m::mock(OfficeInterface::class);
        $note->shouldReceive('getKey')->andReturn(1);
        $this->eloquent->shouldReceive('delete')->with(1)->andReturn(true);
        $result = $this->repository->delete($note);
        $this->assertTrue($result);
    }

    /**
     * Test Update Office
     */
    public function testUpdate()
    {
        $id = 1;
        $data = ['company_id' => 1,'name' => 1,'slug' => 1,'country' => 1,'state_or_province' => 1,'city' => 1,'address' => 1,'postcode' => 1,'phone' => 1,'fax' => 1,'email' => 1,'latitude' => 1,'longitude' => 1,'is_active' => 1,'created_by' => 1,'modified_by' => 1,];

        $object = m::mock(OfficeInterface::class);
        $object->shouldReceive('getKey')->andReturn($id);

        $object
            ->shouldReceive('getCompanyId')->andReturn($data['company_id'])
            ->shouldReceive('getName')->andReturn($data['name'])
            ->shouldReceive('getSlug')->andReturn($data['slug'])
            ->shouldReceive('getCountry')->andReturn($data['country'])
            ->shouldReceive('getStateOrProvince')->andReturn($data['state_or_province'])
            ->shouldReceive('getCity')->andReturn($data['city'])
            ->shouldReceive('getAddress')->andReturn($data['address'])
            ->shouldReceive('getPostcode')->andReturn($data['postcode'])
            ->shouldReceive('getPhone')->andReturn($data['phone'])
            ->shouldReceive('getFax')->andReturn($data['fax'])
            ->shouldReceive('getEmail')->andReturn($data['email'])
            ->shouldReceive('getLatitude')->andReturn($data['latitude'])
            ->shouldReceive('getLongitude')->andReturn($data['longitude'])
            ->shouldReceive('getIsActive')->andReturn($data['is_active'])
            ->shouldReceive('getCreatedBy')->andReturn($data['created_by'])
            ->shouldReceive('getModifiedBy')->andReturn($data['modified_by']);

        $this->eloquent->shouldReceive('update')->with($data, $id)->andReturn($object);

        $result = $this->repository->update($object);
        $this->assertEquals($object, $result);
    }
}

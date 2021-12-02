<?php
namespace Tests\Domains\Commons\Company;

use Mockery as m;
use Tests\TestCase;
use App\Infrastructures\Commons\Company\Contracts\EloquentCompanyRepositoryInterface;
use App\Domains\Commons\Company\CompanyRepository;
use App\Domains\Commons\Company\CompanyEloquent;
use App\Domains\Commons\Company\Contracts\CompanyInterface;
use App\Domains\Commons\Company\Contracts\CompanyRepositoryInterface;

class CompanyRepositoryTest extends TestCase
{
    private $eloquent;
    private $repository;

    protected function setUp()
    {
        parent::setUp();
        $this->eloquent = m::mock(EloquentCompanyRepositoryInterface::class);
        $this->repository = new CompanyRepository($this->eloquent);
    }

    protected function tearDown()
    {
        m::close();
    }

    public function testConstructor()
    {
        $this->assertInstanceOf(CompanyRepositoryInterface::class, $this->repository);
    }

    /**
     * Test create Company
     */
    public function testCreate()
    {
        $object = m::mock(CompanyInterface::class);

        $data = ['company_size_id' => 1,'name' => 1,'country' => 1,'state' => 1,'city' => 1,'address' => 1,'postcode' => 1,'phone' => 1,'fax' => 1,'url' => 1,'is_active' => 1,'created_by' => 1,'modified_by' => 1,];

        $object
            ->shouldReceive('getCompanySizeId')->andReturn($data['company_size_id'])
            ->shouldReceive('getName')->andReturn($data['name'])
            ->shouldReceive('getCountry')->andReturn($data['country'])
            ->shouldReceive('getState')->andReturn($data['state'])
            ->shouldReceive('getCity')->andReturn($data['city'])
            ->shouldReceive('getAddress')->andReturn($data['address'])
            ->shouldReceive('getPostcode')->andReturn($data['postcode'])
            ->shouldReceive('getPhone')->andReturn($data['phone'])
            ->shouldReceive('getFax')->andReturn($data['fax'])
            ->shouldReceive('getUrl')->andReturn($data['url'])
            ->shouldReceive('getIsActive')->andReturn($data['is_active'])
            ->shouldReceive('getCreatedBy')->andReturn($data['created_by'])
            ->shouldReceive('getModifiedBy')->andReturn($data['modified_by']);

        $this->eloquent->shouldReceive('create')->with($data)->andReturn($object);

        $result = $this->repository->create($object);
        $this->assertInstanceOf(CompanyInterface::class, $result);
        $this->assertEquals($object, $result);
    }

    /**
     * Test delete Company
     */
    public function testDelete()
    {
        $note = m::mock(CompanyInterface::class);
        $note->shouldReceive('getKey')->andReturn(1);
        $this->eloquent->shouldReceive('delete')->with(1)->andReturn(true);
        $result = $this->repository->delete($note);
        $this->assertTrue($result);
    }

    /**
     * Test Update Company
     */
    public function testUpdate()
    {
        $id = 1;
        $data = ['company_size_id' => 1,'name' => 1,'country' => 1,'state' => 1,'city' => 1,'address' => 1,'postcode' => 1,'phone' => 1,'fax' => 1,'url' => 1,'is_active' => 1,'created_by' => 1,'modified_by' => 1,];

        $object = m::mock(CompanyInterface::class);
        $object->shouldReceive('getKey')->andReturn($id);

        $object
            ->shouldReceive('getCompanySizeId')->andReturn($data['company_size_id'])
            ->shouldReceive('getName')->andReturn($data['name'])
            ->shouldReceive('getCountry')->andReturn($data['country'])
            ->shouldReceive('getState')->andReturn($data['state'])
            ->shouldReceive('getCity')->andReturn($data['city'])
            ->shouldReceive('getAddress')->andReturn($data['address'])
            ->shouldReceive('getPostcode')->andReturn($data['postcode'])
            ->shouldReceive('getPhone')->andReturn($data['phone'])
            ->shouldReceive('getFax')->andReturn($data['fax'])
            ->shouldReceive('getUrl')->andReturn($data['url'])
            ->shouldReceive('getIsActive')->andReturn($data['is_active'])
            ->shouldReceive('getCreatedBy')->andReturn($data['created_by'])
            ->shouldReceive('getModifiedBy')->andReturn($data['modified_by']);

        $this->eloquent->shouldReceive('update')->with($data, $id)->andReturn($object);

        $result = $this->repository->update($object);
        $this->assertEquals($object, $result);
    }
}

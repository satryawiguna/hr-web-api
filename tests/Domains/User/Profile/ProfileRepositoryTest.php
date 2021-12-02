<?php
namespace Tests\Domains\User\Profile;

use Mockery as m;
use Tests\TestCase;
use App\Infrastructures\User\Profile\Contracts\EloquentProfileRepositoryInterface;
use App\Domains\User\Profile\ProfileRepository;
use App\Domains\User\Profile\ProfileEloquent;
use App\Domains\User\Profile\Contracts\ProfileInterface;
use App\Domains\User\Profile\Contracts\ProfileRepositoryInterface;

class ProfileRepositoryTest extends TestCase
{
    private $eloquent;
    private $repository;

    protected function setUp()
    {
        parent::setUp();
        $this->eloquent = m::mock(EloquentProfileRepositoryInterface::class);
        $this->repository = new ProfileRepository($this->eloquent);
    }

    protected function tearDown()
    {
        m::close();
    }

    public function testConstructor()
    {
        $this->assertInstanceOf(ProfileRepositoryInterface::class, $this->repository);
    }

    /**
     * Test create Profile
     */
    public function testCreate()
    {
        $object = m::mock(ProfileInterface::class);

        $data = ['user_id' => 1,'first_name' => 1,'last_name' => 1,'display_name' => 1,'state' => 1,'city' => 1,'address' => 1,'postcode' => 1,'phone' => 1,'mobile' => 1,'picture' => 1,'created_by' => 1,'modified_by' => 1,];

        $object
            ->shouldReceive('getUserId')->andReturn($data['user_id'])
            ->shouldReceive('getFirstName')->andReturn($data['first_name'])
            ->shouldReceive('getLastName')->andReturn($data['last_name'])
            ->shouldReceive('getDisplayName')->andReturn($data['display_name'])
            ->shouldReceive('getState')->andReturn($data['state'])
            ->shouldReceive('getCity')->andReturn($data['city'])
            ->shouldReceive('getAddress')->andReturn($data['address'])
            ->shouldReceive('getPostcode')->andReturn($data['postcode'])
            ->shouldReceive('getPhone')->andReturn($data['phone'])
            ->shouldReceive('getMobile')->andReturn($data['mobile'])
            ->shouldReceive('getPicture')->andReturn($data['picture'])
            ->shouldReceive('getCreatedBy')->andReturn($data['created_by'])
            ->shouldReceive('getModifiedBy')->andReturn($data['modified_by']);

        $this->eloquent->shouldReceive('create')->with($data)->andReturn($object);

        $result = $this->repository->create($object);
        $this->assertInstanceOf(ProfileInterface::class, $result);
        $this->assertEquals($object, $result);
    }

    /**
     * Test delete Profile
     */
    public function testDelete()
    {
        $note = m::mock(ProfileInterface::class);
        $note->shouldReceive('getKey')->andReturn(1);
        $this->eloquent->shouldReceive('delete')->with(1)->andReturn(true);
        $result = $this->repository->delete($note);
        $this->assertTrue($result);
    }

    /**
     * Test Update Profile
     */
    public function testUpdate()
    {
        $id = 1;
        $data = ['user_id' => 1,'first_name' => 1,'last_name' => 1,'display_name' => 1,'state' => 1,'city' => 1,'address' => 1,'postcode' => 1,'phone' => 1,'mobile' => 1,'picture' => 1,'created_by' => 1,'modified_by' => 1,];

        $object = m::mock(ProfileInterface::class);
        $object->shouldReceive('getKey')->andReturn($id);

        $object
            ->shouldReceive('getUserId')->andReturn($data['user_id'])
            ->shouldReceive('getFirstName')->andReturn($data['first_name'])
            ->shouldReceive('getLastName')->andReturn($data['last_name'])
            ->shouldReceive('getDisplayName')->andReturn($data['display_name'])
            ->shouldReceive('getState')->andReturn($data['state'])
            ->shouldReceive('getCity')->andReturn($data['city'])
            ->shouldReceive('getAddress')->andReturn($data['address'])
            ->shouldReceive('getPostcode')->andReturn($data['postcode'])
            ->shouldReceive('getPhone')->andReturn($data['phone'])
            ->shouldReceive('getMobile')->andReturn($data['mobile'])
            ->shouldReceive('getPicture')->andReturn($data['picture'])
            ->shouldReceive('getCreatedBy')->andReturn($data['created_by'])
            ->shouldReceive('getModifiedBy')->andReturn($data['modified_by']);

        $this->eloquent->shouldReceive('update')->with($data, $id)->andReturn($object);

        $result = $this->repository->update($object);
        $this->assertEquals($object, $result);
    }
}

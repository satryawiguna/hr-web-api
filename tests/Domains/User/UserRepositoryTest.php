<?php
namespace Tests\Domains\User;

use Mockery as m;
use Tests\TestCase;
use App\Infrastructures\User\Contracts\EloquentUserRepositoryInterface;
use App\Domains\User\UserRepository;
use App\Domains\User\UserEloquent;
use App\Domains\User\Contracts\UserInterface;
use App\Domains\User\Contracts\UserRepositoryInterface;

class UserRepositoryTest extends TestCase
{
    private $eloquent;
    private $repository;

    protected function setUp()
    {
        parent::setUp();
        $this->eloquent = m::mock(EloquentUserRepositoryInterface::class);
        $this->repository = new UserRepository($this->eloquent);
    }

    protected function tearDown()
    {
        m::close();
    }

    public function testConstructor()
    {
        $this->assertInstanceOf(UserRepositoryInterface::class, $this->repository);
    }

    /**
     * Test create User
     */
    public function testCreate()
    {
        $object = m::mock(UserInterface::class);

        $data = ['name' => 1,'email' => 1,'password' => 1,'remember_token' => 1,];

        $object
            ->shouldReceive('getName')->andReturn($data['name'])
            ->shouldReceive('getEmail')->andReturn($data['email'])
            ->shouldReceive('getPassword')->andReturn($data['password'])
            ->shouldReceive('getRememberToken')->andReturn($data['remember_token']);

        $this->eloquent->shouldReceive('create')->with($data)->andReturn($object);

        $result = $this->repository->create($object);
        $this->assertInstanceOf(UserInterface::class, $result);
        $this->assertEquals($object, $result);
    }

    /**
     * Test delete User
     */
    public function testDelete()
    {
        $note = m::mock(UserInterface::class);
        $note->shouldReceive('getKey')->andReturn(1);
        $this->eloquent->shouldReceive('delete')->with(1)->andReturn(true);
        $result = $this->repository->delete($note);
        $this->assertTrue($result);
    }

    /**
     * Test Update User
     */
    public function testUpdate()
    {
        $id = 1;
        $data = ['name' => 1,'email' => 1,'password' => 1,'remember_token' => 1,];

        $object = m::mock(UserInterface::class);
        $object->shouldReceive('getKey')->andReturn($id);

        $object
            ->shouldReceive('getName')->andReturn($data['name'])
            ->shouldReceive('getEmail')->andReturn($data['email'])
            ->shouldReceive('getPassword')->andReturn($data['password'])
            ->shouldReceive('getRememberToken')->andReturn($data['remember_token']);

        $this->eloquent->shouldReceive('update')->with($data, $id)->andReturn($object);

        $result = $this->repository->update($object);
        $this->assertEquals($object, $result);
    }
}

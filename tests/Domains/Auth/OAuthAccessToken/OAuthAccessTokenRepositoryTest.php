<?php
namespace Tests\Domains\OAuthAccessToken;

use Mockery as m;
use Tests\TestCase;
use App\Infrastructures\Auth\OAuthAccessToken\Contracts\EloquentOAuthAccessTokenRepositoryInterface;
use App\Domains\Auth\OAuthAccessToken\OAuthAccessTokenRepository;
use App\Domains\Auth\OAuthAccessToken\OAuthAccessTokenEloquent;
use App\Domains\Auth\OAuthAccessToken\Contracts\OAuthAccessTokenInterface;
use App\Domains\Auth\OAuthAccessToken\Contracts\OAuthAccessTokenRepositoryInterface;

class OAuthAccessTokenRepositoryTest extends TestCase
{
    private $eloquent;
    private $repository;

    protected function setUp()
    {
        parent::setUp();
        $this->eloquent = m::mock(EloquentOAuthAccessTokenRepositoryInterface::class);
        $this->repository = new OAuthAccessTokenRepository($this->eloquent);
    }

    protected function tearDown()
    {
        m::close();
    }

    public function testConstructor()
    {
        $this->assertInstanceOf(OAuthAccessTokenRepositoryInterface::class, $this->repository);
    }

    /**
     * Test create OAuthAccessToken
     */
    public function testCreate()
    {
        $object = m::mock(OAuthAccessTokenInterface::class);

        $data = ['user_id' => 1,'client_id' => 1,'name' => 1,'scopes' => 1,'revoked' => 1,'expires_at' => 1,];

        $object
            ->shouldReceive('getUserId')->andReturn($data['user_id'])
            ->shouldReceive('getClientId')->andReturn($data['client_id'])
            ->shouldReceive('getName')->andReturn($data['name'])
            ->shouldReceive('getScopes')->andReturn($data['scopes'])
            ->shouldReceive('getRevoked')->andReturn($data['revoked'])
            ->shouldReceive('getExpiresAt')->andReturn($data['expires_at']);

        $this->eloquent->shouldReceive('create')->with($data)->andReturn($object);

        $result = $this->repository->create($object);
        $this->assertInstanceOf(OAuthAccessTokenInterface::class, $result);
        $this->assertEquals($object, $result);
    }

    /**
     * Test delete OAuthAccessToken
     */
    public function testDelete()
    {
        $note = m::mock(OAuthAccessTokenInterface::class);
        $note->shouldReceive('getKey')->andReturn(1);
        $this->eloquent->shouldReceive('delete')->with(1)->andReturn(true);
        $result = $this->repository->delete($note);
        $this->assertTrue($result);
    }

    /**
     * Test Update OAuthAccessToken
     */
    public function testUpdate()
    {
        $id = 1;
        $data = ['user_id' => 1,'client_id' => 1,'name' => 1,'scopes' => 1,'revoked' => 1,'expires_at' => 1,];

        $object = m::mock(OAuthAccessTokenInterface::class);
        $object->shouldReceive('getKey')->andReturn($id);

        $object
            ->shouldReceive('getUserId')->andReturn($data['user_id'])
            ->shouldReceive('getClientId')->andReturn($data['client_id'])
            ->shouldReceive('getName')->andReturn($data['name'])
            ->shouldReceive('getScopes')->andReturn($data['scopes'])
            ->shouldReceive('getRevoked')->andReturn($data['revoked'])
            ->shouldReceive('getExpiresAt')->andReturn($data['expires_at']);

        $this->eloquent->shouldReceive('update')->with($data, $id)->andReturn($object);

        $result = $this->repository->update($object);
        $this->assertEquals($object, $result);
    }
}

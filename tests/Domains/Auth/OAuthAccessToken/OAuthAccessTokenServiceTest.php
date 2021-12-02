<?php
namespace Tests\Domains\OAuthAccessToken;

use App\Domains\Auth\OAuthAccessToken\Contracts\OAuthAccessTokenInterface;
use App\Domains\Auth\OAuthAccessToken\Contracts\OAuthAccessTokenRepositoryInterface;
use App\Domains\Auth\OAuthAccessToken\Contracts\OAuthAccessTokenServiceInterface;
use App\Domains\Auth\OAuthAccessToken\OAuthAccessTokenEloquent;
use App\Domains\Auth\OAuthAccessToken\OAuthAccessTokenService;
use Mockery as m;
use Tests\TestCase;

class OAuthAccessTokenServiceTest extends TestCase
{
    private $repository;
    private $service;

    /**
     * Set up test.
     */
    protected function setUp()
    {
        parent::setUp();

        $this->repository = m::mock(OAuthAccessTokenRepositoryInterface::class);
        $this->service = new OAuthAccessTokenService(
            $this->repository
        );
    }

    /**
     * Callback after finish test.
     */
    protected function tearDown()
    {
        m::close();
    }

    /**
     * Test constructor.
     */
    public function testConstructor()
    {
        $this->assertInstanceOf(OAuthAccessTokenServiceInterface::class, $this->service);
    }

    /**
     * Test create notes.
     */
    public function testCreate()
    {
        $object = m::mock(OAuthAccessTokenInterface::class);
        $this->repository->shouldReceive('create')->with($object)->andReturn($object);
        $result = $this->service->create($object);
        $this->assertInstanceOf(OAuthAccessTokenInterface::class, $result);
        $this->assertEquals($object, $result);
    }

    /**
     * Test delete notes.
     */
    public function testDelete()
    {
        $object = m::mock(OAuthAccessTokenInterface::class);
        $this->repository->shouldReceive('delete')->with($object)->andReturn(true);
        $result = $this->service->delete($object);
        $this->assertTrue($result);
    }

    /**
     * Test update notes.
     */
    public function testUpdate()
    {
        $object = m::mock(OAuthAccessTokenInterface::class);
        $this->repository->shouldReceive('update')->with($object)->andReturn($object);
        $result = $this->service->update($object);
        $this->assertEquals($object, $result);
    }
}

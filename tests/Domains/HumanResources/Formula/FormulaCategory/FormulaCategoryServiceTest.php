<?php
namespace Tests\Domains\HumanResources\Formula\FormulaCategory;


use App\Domains\HumanResources\Formula\FormulaCategory\Contracts\FormulaCategoryInterface;
use App\Domains\HumanResources\Formula\FormulaCategory\Contracts\FormulaCategoryRepositoryInterface;
use App\Domains\HumanResources\Formula\FormulaCategory\Contracts\FormulaCategoryServiceInterface;
use App\Domains\HumanResources\Formula\FormulaCategory\FormulaCategoryEloquent;
use App\Domains\HumanResources\Formula\FormulaCategory\FormulaCategoryService;
use Mockery as m;
use Tests\TestCase;

class FormulaCategoryServiceTest extends TestCase
{
    private $repository;
    private $service;

    /**
     * Set up test.
     */
    protected function setUp()
    {
        parent::setUp();

        $this->repository = m::mock(FormulaCategoryRepositoryInterface::class);
        $this->service = new FormulaCategoryService(
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
        $this->assertInstanceOf(FormulaCategoryServiceInterface::class, $this->service);
    }

    /**
     * Test create notes.
     */
    public function testCreate()
    {
        $object = m::mock(FormulaCategoryInterface::class);
        $this->repository->shouldReceive('create')->with($object)->andReturn($object);
        $result = $this->service->create($object);
        $this->assertInstanceOf(FormulaCategoryInterface::class, $result);
        $this->assertEquals($object, $result);
    }

    /**
     * Test delete notes.
     */
    public function testDelete()
    {
        $object = m::mock(FormulaCategoryInterface::class);
        $this->repository->shouldReceive('delete')->with($object)->andReturn(true);
        $result = $this->service->delete($object);
        $this->assertTrue($result);
    }

    /**
     * Test update notes.
     */
    public function testUpdate()
    {
        $object = m::mock(FormulaCategoryInterface::class);
        $this->repository->shouldReceive('update')->with($object)->andReturn($object);
        $result = $this->service->update($object);
        $this->assertEquals($object, $result);
    }
}

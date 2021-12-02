<?php
namespace Tests\Domains\HumanResources\Mutation\ProjectMutation;

use App\Domains\HumanResources\Mutation\ProjectMutation\ProjectMutationEloquent;
use Tests\TestCase;
use Mockery as m;

class ProjectMutationInterfaceTest extends TestCase
{
    /**
     * Set up test.
     */
    protected function setUp()
    {
        parent::setUp();
        $this->modelUnderTest = new ProjectMutationEloquent();
    }

    
}

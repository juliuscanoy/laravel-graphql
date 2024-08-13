<?php declare(strict_types=1);

namespace Tests\Unit\Task;

use App\GraphQL\Mutations\TaskMutator;
use App\Services\Task\DeleteTaskService;
use App\Services\Task\GetTaskByAuthUserService;
use Illuminate\Support\Facades\DB;
use Mockery;
use Nuwave\Lighthouse\Support\Contracts\GraphQLContext;
use Tests\TestCase;
use App\Models\User;
use App\Models\Task; // Assuming the Task model exists

class DeleteTasktTest extends TestCase
{
    protected function tearDown(): void
    {
        Mockery::close();
        parent::tearDown();
    }

    protected function setUp(): void
    {
        parent::setUp();

        // Mock DB facade methods
        
    }

    public function testDeleteTaskSuccessful()
    {
        // Arrange
        $args = ['id' => '1'];

        // Create a mock for the User model
        $user = Mockery::mock(User::class);

        // Create a mock for GetTaskByAuthUserService
        $getTaskService = Mockery::mock(GetTaskByAuthUserService::class);
        $getTaskService->shouldReceive('run')->with($args['id'])->andReturn(new Task());

        // Create a mock for DeleteTaskService
        $deleteTaskService = Mockery::mock(DeleteTaskService::class);
        $deleteTaskService->shouldReceive('run')->with(Mockery::type(Task::class))->once();

        // Create a mock for the GraphQLContext
        $context = Mockery::mock(GraphQLContext::class);
        $context->shouldReceive('user')->andReturn($user);

        // Mock the service instances
        $taskMutator = new TaskMutator();
        
        // Act
        $result = $taskMutator->delete(null, $args, $context);

        DB::shouldReceive('beginTransaction')->once();
        DB::shouldReceive('commit')->once();


        // Assert
        $this->assertTrue($result);
    }

    public function testDeleteTaskFails()
    {
        // Arrange
        $args = ['id' => '1'];

        // Create a mock for the User model
        $user = Mockery::mock(User::class);

        // Create a mock for GetTaskByAuthUserService
        $getTaskService = Mockery::mock(GetTaskByAuthUserService::class);
        $getTaskService->shouldReceive('run')->with($args['id'])->andReturn(new Task());

        // Create a mock for DeleteTaskService
        $deleteTaskService = Mockery::mock(DeleteTaskService::class);
        $deleteTaskService->shouldReceive('run')->with(Mockery::type(Task::class))->andThrow(new \Exception('Deletion failed'));

        // Create a mock for the GraphQLContext
        $context = Mockery::mock(GraphQLContext::class);
        $context->shouldReceive('user')->andReturn($user);

        // Use mock for DB to expect rollBack call
        DB::shouldReceive('beginTransaction')->once();
        DB::shouldReceive('rollBack')->once();

        // Mock the service instances
        $taskMutator = new TaskMutator();

        // Assert
        $this->expectException(\Exception::class);

        // Act
        $taskMutator->delete(null, $args, $context);
    }
}

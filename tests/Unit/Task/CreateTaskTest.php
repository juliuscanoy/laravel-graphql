<?php declare(strict_types=1);

namespace Tests\Unit\Task;

use App\GraphQL\Mutations\TaskMutator;
use App\Models\Task;
use App\Services\Task\CreateTaskService;
use Illuminate\Support\Facades\DB;
use Mockery;
use Nuwave\Lighthouse\Support\Contracts\GraphQLContext;
use Tests\TestCase;
use App\Models\User;

class CreateTaskTest extends TestCase
{
    protected function tearDown(): void
    {
        Mockery::close();
        parent::tearDown();
    }

    public function testCreateTaskSuccessful()
    {
        // Arrange
        $args = ['name' => 'New Task'];

        // Create a mock for the User model
        $user = Mockery::mock(User::class);

        // Create a mock for the tasks() relationship
        $taskRelationship = Mockery::mock();
        $user->shouldReceive('tasks')->andReturn($taskRelationship);

        // Create a mock Task object
        $task = Mockery::mock(Task::class);
        
        // Mock the save() method to accept the task object
        $taskRelationship->shouldReceive('save')->with(Mockery::type(Task::class))->once();
  
        // Create a mock for the GraphQLContext
        $context = Mockery::mock(GraphQLContext::class);
        $context->shouldReceive('user')->andReturn($user);

        DB::shouldReceive('commit')->once();

        $task = (object) ['id' => 1, 'name' => 'New Task', 'status' => 'todo'];

        // Mock CreateTaskService
        $service = Mockery::mock(CreateTaskService::class);
        $service->shouldReceive('run')->with($args, $user)->andReturn($task);

        $taskMutator = new TaskMutator();

       
        // Act
        $result = $taskMutator->create(null, $args, $context);

        DB::shouldReceive('beginTransaction')->once();
        DB::shouldReceive('commit')->once(); // Adjust based on test scenario
        // Assert
        $this->assertEquals($task->name, $result->name);
    }

    public function testCreateTaskFails()
    {
        // Arrange
        $args = ['name' => 'New Task'];

        // Create a mock for the User model
        $user = Mockery::mock(User::class);

        // Create a mock for the GraphQLContext
        $context = Mockery::mock(GraphQLContext::class);
        $context->shouldReceive('user')->andReturn($user);

        $exception = new \Exception('Something went wrong');

        // Mock CreateTaskService
        $service = Mockery::mock(CreateTaskService::class);
        $service->shouldReceive('run')->with($args, $user)->andThrow($exception);
        
        DB::shouldReceive('beginTransaction')->once();
        DB::shouldReceive('rollBack')->once(); // Adjust based on test scenario

        $taskMutator = new TaskMutator();

        // Assert
        $this->expectException(\Exception::class);

        // Act
        $taskMutator->create(null, $args, $context);
    }
}

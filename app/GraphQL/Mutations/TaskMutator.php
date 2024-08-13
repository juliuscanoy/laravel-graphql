<?php declare(strict_types=1);

namespace App\GraphQL\Mutations;

use App\Services\Task\UpdateTaskService;
use App\Services\Task\CreateTaskService;
use App\Services\Task\DeleteTasksByAuthUserService;
use App\Services\Task\DeleteTasksByUserService;
use App\Services\Task\DeleteTaskService;
use App\Services\Task\GetTaskByAuthUserService;
use Exception;
use Illuminate\Support\Facades\DB;
use Nuwave\Lighthouse\Support\Contracts\GraphQLContext;

final readonly class TaskMutator
{
    /**
     * Return a value for the field.
     *
     * @param  null  $rootValue
     * @param  mixed[]  $args
     * @param  \Nuwave\Lighthouse\Support\Contracts\GraphQLContext  $context 
     * @return mixed
     */
    public function create(null $_, array $args, GraphQLContext $context)
    {
        DB::beginTransaction();

        try {

            $service = new CreateTaskService();

            $task = $service->run(
                $args,
                $context->user(),
            );
    
            DB::commit();

            return $task;
        }catch(Exception $exception){
            DB::rollBack();

            throw $exception;
        }
       
    }

    public function update(null $_, array $args) {
        DB::beginTransaction();

        try {

            $getTaskService = new GetTaskByAuthUserService();
            $updateTaskService = new UpdateTaskService();

            $task = $updateTaskService->run(
                $getTaskService->run(
                    $args['id'],
                ),
                $args['status']
            );

            DB::commit();

            return $task;

        }catch(Exception $exception){
            DB::rollBack();

            throw $exception;
        }
    }

    public function delete(null $_, array $args) {
        DB::beginTransaction();

        try {

            $getTaskService = new GetTaskByAuthUserService();
            $deleteTaskService = new DeleteTaskService();

            $deleteTaskService->run(
                $getTaskService->run(
                    $args['id']
                )
            );

            DB::commit();

            return true;
        } catch(Exception $exception){
            DB::rollBack();

            throw $exception;
        }
    }

    public function deleteTasksByAuthUser(null $_, array $args) {
        DB::beginTransaction();

        try {

            $deleteTasksByUser = new DeleteTasksByUserService();

            $deleteTasksByUser->run(
                auth()->user(),
                $args['status'] ?? null
            );

            DB::commit();

            return true;
        } catch(Exception $exception){
            DB::rollBack();

            throw $exception;
        }
    }
}

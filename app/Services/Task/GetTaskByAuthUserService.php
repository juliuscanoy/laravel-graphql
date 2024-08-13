<?php

namespace App\Services\Task;

use App\Models\Task;
use App\Repositories\Task\TaskRepositoryInterface;
use Exception;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\App;

class GetTaskByAuthUserService {

    public function run(string $id): Task {

        $repository = App::make(TaskRepositoryInterface::class);

        $task = $repository->findByAuthUser($id);

        if(!$task) {
            throw new Exception(
                'Task not found', 
                Response::HTTP_BAD_REQUEST
            );
        }

        return $task;
    }
    
}
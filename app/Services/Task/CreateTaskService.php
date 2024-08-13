<?php

namespace App\Services\Task;

use App\Models\Task;
use App\Models\User;

class CreateTaskService {

    public function run(array $data, User $user): Task {

        $task = new Task();

        $task->name = $data['name'];
        $task->status = 'todo';

        $user->tasks()->save($task);

        return $task;
    }
}
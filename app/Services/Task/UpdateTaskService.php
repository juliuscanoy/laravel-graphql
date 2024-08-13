<?php

namespace App\Services\Task;

use App\Models\Task;

class UpdateTaskService {

    public function run(Task $task): Task {

        $task->status = 'done';
        $task->save();

        return $task;
    }
    
}
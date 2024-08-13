<?php

namespace App\Services\Task;

use App\Models\Task;

class DeleteTaskService {

    public function run(Task $task): void {
        $task->delete();
    }
    
}
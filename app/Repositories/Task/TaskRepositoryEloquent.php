<?php

namespace App\Repositories\Task;

use App\Models\Task;
use App\Repositories\BaseRepositoryEloquent;
use App\Repositories\Task\TaskRepositoryInterface;

class TaskRepositoryEloquent extends BaseRepositoryEloquent implements TaskRepositoryInterface
{
    /**
     * TaskRepositoryEloquent constructor.
     * @param Task $task
     */
    public function __construct(Task $task)
    {
        parent::__construct($task);
    }
     
    public function findByAuthUser(int $id): ?Task
    {
        return $this->model()
            ->where('id', $id)
            ->byAuthUser()
            ->first();
    }
}

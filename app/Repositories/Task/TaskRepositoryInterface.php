<?php

namespace App\Repositories\Task;

use App\Models\Task;

/**
 * Interface TaskRepositoryInterface
 * @package App\Repositories\Task
 */
interface TaskRepositoryInterface
{

    /**
     * Find function
     *
     * @param integer $id
     * @return Task
     */
    public function findByAuthUser(int $id);
}

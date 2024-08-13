<?php

namespace App\Services\Task;

use App\Models\User;

class DeleteTasksByUserService {

    public function run(User $user, string $status = null): void {

        $query = $user->tasks();

        if($status) {
            $query = $query->where('status', $status);
        }

        $query->delete();
    }
    
}
<?php

namespace App\Providers;

use App\Repositories\Task\TaskRepositoryEloquent;
use App\Repositories\Task\TaskRepositoryInterface;
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Repositories mapping.
     *
     * @var array|string[] $repositories
     */
    protected array $repositories = [
        TaskRepositoryInterface::class => TaskRepositoryEloquent::class,
    ];

    /**
     * Registering the repositories by binding its abstraction and concretion.
     */
    public function register(): void
    {
        foreach ($this->repositories as $abstraction => $concretion) {
            $this->app->bind($abstraction, $concretion);
        }
    }
}

<?php

namespace App\Repos\User;

use App\Repos\RepoInterface;

interface UserRepo extends RepoInterface
{
    /**
     * Iterate over all Users by chunk.
     *
     * @param  int  $count
     * @param  callable  $callback
     * @param  string[]  $with
     * @param  string[]  $columns
     * @param  int|null  $userId
     * @return bool
     */
    public function chunkAll(int $count, callable $callback, ?int $userId = null, array $with = [], array $columns = ['*']): bool;
}

<?php

namespace App\Repos\User;

use App\Repos\EloquentAbstractRepo;

class EloquentUser extends EloquentAbstractRepo implements UserRepo
{
    /**
     * {@inheritdoc}
     */
    public function chunkAll(int $count, callable $callback, ?int $userId = null, array $with = [], array $columns = ['*']): bool
    {
        return $this->model->withSelect($with, $columns)
            ->when(isset($userId), function ($query) use ($userId) {
                $query->where('id', '=', $userId);
            })
            ->chunk($count, $callback);
    }
}

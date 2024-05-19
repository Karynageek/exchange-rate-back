<?php

namespace App\Repos;

interface RepoInterface
{
    /**
     * @param array $data
     */
    public function create(array $data);

    /**
     * Get the model by the specified key.
     *
     * @param string $key
     * @param  $value
     * @param array $with
     * @param array $columns
     * @param bool $withTrashed
     * @return mixed
     */
    public function firstBy(string $key, $value, array $with = [], array $columns = ['*'], bool $withTrashed = false);

    public function firstByOrNull(string $key, $value, array $with = [], array $columns = ['*'], bool $withTrashed = false);
}

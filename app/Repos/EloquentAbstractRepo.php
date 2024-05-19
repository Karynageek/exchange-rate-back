<?php

namespace App\Repos;

use App\Models\BaseModel as Model;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\Eloquent\SoftDeletes;

abstract class EloquentAbstractRepo implements RepoInterface
{
    public function __construct(protected Model $model)
    {
    }

    /**
     * @param array $data
     * @return Model
     */
    public function create(array $data): Model
    {
        $data = $this->model->getUpdatable($data);

        $model = $this->model->create($data);

        if ($this->model->refreshModel) {
            $model = $model->refresh();
        }

        return $model;
    }

    public function firstByOrNull(string $key, $value, array $with = [], array $columns = ['*'], bool $withTrashed = false)
    {
        try {
            return $this->firstBy($key, $value, $with, $columns, $withTrashed);
        } catch (ModelNotFoundException $e) {
            return;
        }
    }

    public function firstBy(string $key, $value, array $with = [], array $columns = ['*'], bool $withTrashed = false): Model
    {
        $query = $this->model->where($key, '=', $value)
            ->withSelect($with, $columns);

        // Get deleted models as well
        if ($withTrashed && in_array(SoftDeletes::class, class_uses($this->model))) {
            $query->withTrashed();
        }

        return $query->firstOrFail();
    }
}

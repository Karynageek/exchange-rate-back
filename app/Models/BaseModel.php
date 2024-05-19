<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @method static \Illuminate\Database\Eloquent\Builder|BaseModel newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|BaseModel newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|BaseModel query()
 * @method static \Illuminate\Database\Eloquent\Builder|BaseModel withSelect(array $with, array $columns)
 *
 * @mixin \Eloquent
 */
class BaseModel extends Model
{
    public $refreshModel = false;

    public function scopeWithSelect($query, array $with, array $columns)
    {
        return $query->with($with)->select($columns);
    }

    /**
     * Get only attributes that are either fillable
     * or not guarded.
     */
    public function getUpdatable($data)
    {
        $fillable = $this->getFillable();
        if (count($fillable)) {
            $data = array_only($data, $fillable);
        } else {
            $data = array_except($data, $this->getGuarded());
        }

        return $data;
    }
}

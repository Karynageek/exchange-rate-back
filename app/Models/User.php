<?php

namespace App\Models;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Builder as EloquentBuilder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\Access\Authorizable;
use Illuminate\Notifications\Notifiable;

/**
 * @property int $id
 * @property string|null $email
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 *
 * @method static EloquentBuilder|User newModelQuery()
 * @method static EloquentBuilder|User newQuery()
 * @method static EloquentBuilder|User whereEmail($value)
 * @method static EloquentBuilder|User whereId($value)
 * @method static EloquentBuilder|User whereCreatedAt($value)
 * @method static EloquentBuilder|User whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BaseModel withSelect(array $with, array $columns)
 *
 * @mixin \Eloquent
 */
class User extends BaseModel
{
    use Authenticatable, Authorizable, Notifiable, HasFactory;

    protected $table = 'user';

    protected $fillable = [
        'email',
    ];
}

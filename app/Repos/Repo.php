<?php

namespace App\Repos;

use App\Repos\User\UserRepo;

class Repo
{
    /**
     * @return UserRepo
     */
    public static function user(): UserRepo
    {
        return app(UserRepo::class);
    }
}

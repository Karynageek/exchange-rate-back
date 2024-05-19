<?php

namespace App\Providers;

use App\Models\User;
use App\Repos\User\EloquentUser;
use App\Repos\User\UserRepo;
use Illuminate\Support\ServiceProvider;

class RepoServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->bind(UserRepo::class, function () {
            return new EloquentUser(
                new User()
            );
        });
    }
}

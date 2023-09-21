<?php

namespace App\Providers;

use App\Models\Classroom;
use App\Models\Post;
use App\Models\Classwork;
use App\Models\User;
use Illuminate\Support\Facades\App;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\ServiceProvider;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Http\Resources\Json\ResourceCollection;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {

        // ResourceCollection::withoutWrapping();

        // Paginator::useBootstrapFive();
        Paginator::defaultView('vendor.pagination.bootstrap-5');
        // Paginator::defaultSimpleView('vendor.pagination.simple-bootstrap-5');

        Relation::enforceMorphMap([
            'classwork' => Classwork::class,
            'post' => Post::class,
            'user' => User::class,
            'classroom' => Classroom::class
        ]);
    }
}

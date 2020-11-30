<?php

namespace App\Providers;

use App\Article;
use App\Policies\ArticlePolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        Article::class => ArticlePolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        //
        Gate::define('article.create',  ArticlePolicy::class.'@create');
        Gate::define('article.update',  ArticlePolicy::class.'@update');
        Gate::define('article.delete',  ArticlePolicy::class.'@delete');
        Gate::define('article.destroy', ArticlePolicy::class.'@forceDelete');
        Gate::define('article.publish', ArticlePolicy::class.'@publish');
        Gate::define('article.draft',   ArticlePolicy::class.'@draft');
    }
}

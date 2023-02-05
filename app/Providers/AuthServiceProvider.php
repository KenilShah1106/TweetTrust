<?php

namespace App\Providers;

use App\Models\Replies;
use App\Models\Tweet;
use App\Models\Tag;
use App\Models\User;
use App\Policies\RepliesPolicy;
use App\Policies\TweetPolicy;
use App\Policies\TagPolicy;
use App\Policies\UserPolicy;
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
        // 'App\Models\Model' => 'App\Policies\ModelPolicy',
        Tweet::class => TweetPolicy::class,
        Replies::class => RepliesPolicy::class,
        User::class => UserPolicy::class,
        Tag::class => TagPolicy::class,
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
    }
}

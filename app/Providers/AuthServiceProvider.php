<?php

namespace App\Providers;

use App\Models\Topic;
use App\Models\TopicReply;
use App\Models\User;
use App\Policies\TopicReplyPolicy;
use App\Policies\TopicPolicy;
use App\Policies\UserPolicy;
use Auth;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        TopicReply::class => TopicReplyPolicy::class,
        Topic::class => TopicPolicy::class,
        User::class  => UserPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();
    }
}

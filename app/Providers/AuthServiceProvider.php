<?php

namespace App\Providers;

use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        'App\Model' => 'App\Policies\ModelPolicy',
        \App\Models\Template::class => \App\Policies\TemplatePolicy::class,
        \App\Models\Campaign::class => \App\Policies\CampaignPolicy::class,
        \App\Models\Bunch::class => \App\Policies\BunchPolicy::class,
        \App\Models\Subscriber::class => \App\Policies\SubscriberPolicy::class,
        \App\Models\Report::class => \App\Policies\ReportPolicy::class,
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

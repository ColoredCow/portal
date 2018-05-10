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
        'App\Models\Client' => 'App\Policies\ClientPolicy',
        'App\Models\Finance\Invoice' => 'App\Policies\Finance\InvoicePolicy',
        'App\Models\Project' => 'App\Policies\ProjectPolicy',
        'App\Models\WeeklyDose' => 'App\Policies\WeeklyDosePolicy',
        'App\Models\HR\Job' => 'App\Policies\HR\JobPolicy',
        'App\Models\HR\Applicant' => 'App\Policies\HR\ApplicantPolicy',
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

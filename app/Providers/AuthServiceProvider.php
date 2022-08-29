<?php

namespace App\Providers;

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
        'App\Models\Client' => 'App\Policies\ClientPolicy',
        'App\Models\Finance\Invoice' => 'App\Policies\Finance\InvoicePolicy',
        'App\model\EmployeeSalary' => 'App\Policies\EmployeeSalaryPolicy',
        'App\Models\Project' => 'App\Policies\ProjectPolicy',
        'App\Models\KnowledgeCafe\WeeklyDose' => 'App\Policies\KnowledgeCafe\WeeklyDosePolicy',
        'App\Models\KnowledgeCafe\Library\Book' => 'App\Policies\KnowledgeCafe\Library\BookPolicy',
        'App\Models\KnowledgeCafe\Library\BookCategory' => 'App\Policies\KnowledgeCafe\Library\BookCategoryPolicy',
        'App\Models\Setting' => 'App\Policies\SettingPolicy',
        'App\Http\Controllers\Finance\ReportsController' => 'App\Policies\Finance\ReportPolicy',
        'App\Http\Controllers\UserController' => 'App\Policies\UserPolicy',
        'Modules\Infrastructure\Http\Controllers\InfrastructureController' =>'App\Policies\Infrastructure\BillingsPolicy'
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();
        Gate::before(function ($user, $ability) {
            return $user->hasRole('super-admin') ? true : null;
        });
    }
}

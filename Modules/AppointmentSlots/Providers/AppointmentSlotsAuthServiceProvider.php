<?php
namespace Modules\AppointmentSlots\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Modules\AppointmentSlots\Entities\AppointmentSlot;
use Modules\AppointmentSlots\Policies\AppointmentSlotsPolicy;

class AppointmentSlotsAuthServiceProvider extends ServiceProvider
{
    protected $policies = [
        AppointmentSlot::class => AppointmentSlotsPolicy::class,
    ];

    public function boot()
    {
        $this->registerPolicies();
    }
}

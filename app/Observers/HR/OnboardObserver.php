<?php

namespace App\Observers\HR;

use App\Services\GSuiteUserService;
use App\User;

class OnboardObserver
{
    /**
     * Handle to the gsuite user service "created" event.
     *
     * @param  \App\GsuiteUserService  $gsuiteUserService
     * @return void
     */
    public function created(GsuiteUserService $gsuiteUserService)
    {
        User::firstOrCreate([
            'email' => $gsuiteUser->email,
            'name' => $gsuiteUser->name,
            'password' => $gsuiteUser->password,
            'provider' => 'google',
            'provider_id' => '',
        ]);
    }

    /**
     * Handle the gsuite user service "updated" event.
     *
     * @param  \App\GsuiteUserService  $gsuiteUserService
     * @return void
     */
    public function updated(GsuiteUserService $gsuiteUserService)
    {
        //
    }

    /**
     * Handle the gsuite user service "deleted" event.
     *
     * @param  \App\GsuiteUserService  $gsuiteUserService
     * @return void
     */
    public function deleted(GsuiteUserService $gsuiteUserService)
    {
        //
    }
}

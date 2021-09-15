<?php

namespace App\Listeners;

use Corcel\Model\Post as WPPost;
use Corcel\Model\User as WPUser;

class RemoveUserFromWebsite
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle($event)
    {
        if (env('WORDPRESS_ENABLED') == true) {
            $wpUser = WPUser::where('user_email', $event->user->email)->first();
            if (! $wpUser) {
                return;
            }

            $admin = WPUser::where('user_login', config('website.admin_login_name'))->first();
            if (! $wpUser) {
                return;
            }

            WPPost::where('post_author', $wpUser->ID)->update(['post_author' => $admin->ID]);
        }
    }
}

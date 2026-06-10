<?php

namespace App\Listeners;

use App\Models\WordPress\WpPost;
use App\Models\WordPress\WpUser;

class RemoveUserFromWebsite
{
    public function __construct()
    {
    }

    public function handle($event)
    {
        if (! config('database.connections.wordpress.enabled')) {
            return;
        }

        $wpUser = WpUser::where('user_email', $event->user->email)->first();
        $admin = WpUser::where('user_login', config('website.admin_login_name'))->first();

        if ($wpUser && $admin) {
            WpPost::where('post_author', $wpUser->ID)->update(['post_author' => $admin->ID]);
        }
    }
}

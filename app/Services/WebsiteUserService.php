<?php

namespace App\Services;

use App\Models\WordPress\WpUser;

class WebsiteUserService
{
    protected $user;

    public function __construct()
    {
        if (config('database.connections.wordpress.enabled')) {
            $this->user = WpUser::with('meta')->where('user_email', auth()->user()->email)->first();
        }
    }

    public function get()
    {
        return $this->user;
    }

    public function getMeta($key)
    {
        $userMeta = $this->user->meta->where('meta_key', $key)->first() ?: null;

        if ($userMeta) {
            return $userMeta->meta_value;
        }

        return '';
    }
}

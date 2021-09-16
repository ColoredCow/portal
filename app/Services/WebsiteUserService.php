<?php

namespace App\Services;

use Corcel\Laravel\Auth\AuthUserProvider;

class WebsiteUserService
{
    public $user;

    public function __construct()
    {
        if (env('WORDPRESS_ENABLED') == true) {
            $userProvider = new AuthUserProvider;
            $this->user = $userProvider->retrieveByCredentials(['email' => auth()->user()->email]);
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

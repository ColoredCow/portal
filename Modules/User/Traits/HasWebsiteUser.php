<?php

namespace Modules\User\Traits;

use Illuminate\Support\Str;

trait HasWebsiteUser
{
    public function getWebsiteUserAttribute()
    {
        if (env('WORDPRESS_ENABLED') == true) {
            if (! class_exists('Corcel\Laravel\Auth\AuthUserProvider')) {
                return;
            }

            $userProvider = new \Corcel\Laravel\Auth\AuthUserProvider;

            try {
                return $userProvider->retrieveByCredentials(['email' => $this->email]);
            } catch (\Throwable $th) {
                return;
            }
        }
    }

    public function getWebsiteUserMeta($key = null)
    {
        if (! $this->website_user) {
            return '';
        }

        if (! $key) {
            return $this->website_user->meta;
        }

        $userMeta = $this->website_user->meta->where('meta_key', $key)->first() ?: null;
        if ($userMeta) {
            return $userMeta->meta_value;
        }

        return '';
    }

    public function getWebsiteUserRole()
    {
        $roleKey = config('database.connections.wordpress.prefix') . 'capabilities';
        $roles = unserialize($this->getWebsiteUserMeta($roleKey));
        if ($roles) {
            return Str::title(head(array_keys($roles)));
        }
    }

    public function getWebsiteUserRoleAttribute()
    {
        $roleKey = config('database.connections.wordpress.prefix') . 'capabilities';
        $role = $this->getWebsiteUserMeta($roleKey);
        if (! $role) {
            return '';
        }
        $roles = unserialize($role);
        if ($roles) {
            return 'CCWeb- ' . Str::title(head(array_keys($roles)));
        }
    }

    public function canAccessWebsite()
    {
        return $this->website_user_role;
    }
}

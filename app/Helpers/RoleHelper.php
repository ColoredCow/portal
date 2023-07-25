<?php

namespace App\Helpers;

class RoleHelper
{
    public static function hasAnyRole($user, $roles)
    {
        foreach ($roles as $role) {
            if ($user->hasRole($role)) {
                return true;
            }
        }

        return false;
    }
}

<?php

namespace App\Helpers;

class OrganizationHelper
{
   
    public static function resolveDomainName($email) {
        return head(explode('.', $email));
    }

    public static function getDomainUrl($domain = '') {
        return request()->getScheme(). '://' . $domain . '.' . request()->getHost() . '/home';
    }
}

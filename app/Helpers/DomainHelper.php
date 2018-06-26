<?php

namespace App\Helpers;

class DomainHelper
{
   
    public static function resolveName($email) {
        return head(explode('.', $email));
    }

    public static function getDomainUrl($domain = '') {
        return request()->getScheme(). '://' . $domain . '.' . request()->getHost() . '/home';
    }

    public function getCurrentDomain() {
        
    }


}

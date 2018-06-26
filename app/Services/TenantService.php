<?php

namespace App\Services;

use App\Models\Organization;

class TenantService
{
    public $domain;
    protected $organization;

    public function __construct()
    {
        $this->setCurrentDomain();

        if ($this->domain) {
            $this->setOrganization();
        }
    }

    public function setUpForDomain($domain)
    {
        if (!$domain) {
            return false;
        }

        $this->setCurrentDomain($domain);
        $this->setOrganization();
        $this->updateSession($domain);
    }

    public function setCurrentDomain($domain = null)
    {
        if ($domain) {
            $this->domain = $domain;
            return $domain;
        }

        $currentHost = request()->getHost();
        $subDomains = explode('.', $currentHost);
        if (count($subDomains) < 3) {
            $this->domain = null;
            return false;
        }

        $this->domain = head($subDomains);
    }

    public function setOrganization()
    {
        $this->organization = Organization::findBySlug($this->domain);
    }

    public function organization()
    {
        if ($this->organization) {
            $this->setOrganization();
        }
        return $this->organization;
    }

    public function __toString()
    {
        return $this->domain;
    }

    public function configuration($key = '')
    {
        // ToDO: add array support
        if ($key) {
            return $this->organization->configurations()
                ->where('key', $key)
                ->pluck('value');
        }

        return $this->organization->configurations;
    }

    public static function resolveName($email)
    {
        return head(explode('.', $email));
    }

    public static function getUrl($domain = '')
    {
        return request()->getScheme() . '://' . $domain . '.' . request()->getHost();
    }

    public function getCurrentDomain()
    {
        return $this->domain;
    }

    public function updateSession($domain)
    {
        session(['domain' => $domain]);
    }

    public function check()
    {
        $currentDomain = session('domain');
        $currentUrl = request()->url();
        return str_is("*$currentDomain.*", $currentUrl);
    }

    public function getFullUrl()
    {
        $currentDomain = session('domain');
        $domainUrl = self::getUrl($currentDomain);
        $path = request()->path();
        $queryString = request()->getQueryString();
        $path = ($queryString) ? $path . '?' . $queryString : $path;
        return $domainUrl . '/' . $path;
    }

}

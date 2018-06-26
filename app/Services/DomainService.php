<?php

namespace App\Services;

use App\Models\Organization;

class DomainService
{
    public $domain;
    protected $dbRow;

    public function __construct()
    {
        $this->setCurrentDomain();
    }

    public function setCurrentDomain()
    {
        $currentHost = request()->getHost();
        $subDomains = explode('.', $currentHost);
        if (count($subDomains) < 3) {
            $this->domain = null;
            return false;
        }

        $this->domain = head($subDomains);
        $this->setDBRow();
    }

    public function setDBRow()
    {
        $this->dbRow = Organization::findBySlug($this->domain);
    }

    public function organization()
    {
        return $this->dbRow;
    }

    public function __toString()
    {
        return $this->domain;
    }

    public function configuration($key = '')
    {
        // ToDO: add array support
        if ($key) {
            return $this->dbRow->configurations()
                ->where('key', $key)
                ->pluck('value');
        }

        return $this->dbRow->configurations;
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
        return str_is('*' . $currentDomain . '.*', $currentUrl);
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

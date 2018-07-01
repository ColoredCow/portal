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
            $this->setUpDBConnection();
        }
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

    public function setUpForDomain($domain)
    {
        if (!$domain) {
            return false;
        }

        $this->setCurrentDomain($domain);
        $this->setOrganization();
        $this->updateSession($domain);
        $this->setUpDBConnection();

    }

    public function setUpDBConnection()
    {
        if (!$this->organization) {
            return false;
        }

        $databaseName =  $this->organization->database_name;

        if(app()->environment('testing')) {
            $databaseName = 'emp_org_tenant_test';
        }

        $connection = config('database.connections.default');
        $connection['database'] = $databaseName;
        config(['database.connections.' . $this->organization->connection_name => $connection]);
        \Config::set('database.default', $this->organization->connection_name);
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

    public function configuration($key = '')
    {
        if (!$this->organization) {
            return false;
        }
        if (is_string($key)) {
            $configuration = $this->organization->configurations()
                ->where('key', $key)->first();
            return (empty($configuration)) ? '' : $configuration->value;
        }
        if (is_array($key)) {
            return $this->organization->configurations()
                ->whereIn('key', $key)->get();
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
      //  session()->put('domain', $domain);
       // session()->put('active_connection', $this->organization()->connection_name);
        
        //session(['domain' => $domain , 'active_connection' => $this->organization()->connection_name]);
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

    public function __toString()
    {
        return $this->domain;
    }

}

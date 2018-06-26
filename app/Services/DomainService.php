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

        if ($subDomains < 3) {
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

    public function organization() {

        return  $this->dbRow;
    }
    
    public function __toString()
    {
        return $this->domain;
    }
}

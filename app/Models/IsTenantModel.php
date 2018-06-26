<?php

namespace App\Models;

trait IsTenantModel
{
    public function __construct()
    {
        $this->connection = session('active_connection', 'master');
    }
}

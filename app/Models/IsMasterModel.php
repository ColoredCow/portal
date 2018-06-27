<?php

namespace App\Models;

trait IsMasterModel
{
    public function __construct()
    {
        parent::__construct();
        $this->connection = session('active_master_connection', 'master');
    }
}

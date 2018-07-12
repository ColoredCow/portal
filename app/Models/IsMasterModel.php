<?php

namespace App\Models;

trait IsMasterModel
{
    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        $this->connection = 'master';

        if (app()->environment('testing')) {
            $this->connection = 'master_test';
        }
    }
}

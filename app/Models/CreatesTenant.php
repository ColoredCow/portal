<?php

namespace App\Models;

use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;

trait CreatesTenant
{
    protected static function bootCreatesTenant()
    {
        static::created(function ($model) {
            $model->createConnection();
            $model->migrateSchema();
            $model->seedSchema();
        });
    }

    public function createConnection()
    {
        $connection = config('database.connections.default');
        $connection['database'] = $this->database_name;
        config(['database.connections.' . $this->connection_name => $connection]);
        $this->configurations()->create(['key' => 'database', 'value' => $this->database_name]);
    }

    public function getConnectionNameAttribute()
    {
        return "org_{$this->slug}";
    }

    public function getDatabaseNameAttribute()
    {
        return "emp_org_{$this->slug}";
    }

    # Do we want to create the organization database programatically? @rudresh @vaibhav @pankaj
    public function initSchema()
    {
        DB::raw("CREATE DATABASE {$this->database_name}");
    }

    public function migrateSchema()
    {
        Artisan::call('migrate', array('--database' => $this->connection_name, '--path' => 'database/migrations/'));
    }

    public function seedSchema()
    {
        Artisan::call('db:seed');
    }
}

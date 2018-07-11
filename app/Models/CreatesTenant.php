<?php

namespace App\Models;

use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;

trait CreatesTenant
{
    protected static function bootCreatesTenant()
    {
        static::created(function ($model) {
            $model->initSchema();
            $model->createConnection();
            $model->migrateSchema();
            $model->seedSchema();
        });
    }

    public function createConnection()
    {
        $connection = config('database.connections.default');
        $connection['database'] = $this->generateDatabaseName();
        config(['database.connections.' . $this->generateConnectionName() => $connection]);
        $this->configurations()->create(['key' => 'connection', 'value' => $this->generateConnectionName()]);
        $this->configurations()->create(['key' => 'database', 'value' => $this->generateDatabaseName()]);
    }

    public function generateConnectionName()
    {
        return config('constants.tenants.prefixes.connection') . $this->slug;
    }

    public function getConnectionNameAttribute()
    {
        return $this->configurations()->where('key', 'connection')->first()->value;
    }

    public function generateDatabaseName()
    {
        if (app()->environment('testing')) {
            return 'emp_org_tenant_test';
        }

        return config('constants.tenants.prefixes.db') . $this->slug;
    }

    public function getDatabaseNameAttribute()
    {
        return $this->configurations()->where('key', 'database')->first()->value;
    }

    public function initSchema()
    {
        DB::statement(DB::raw('CREATE DATABASE IF NOT EXISTS ' . $this->generateDatabaseName()));
    }

    public function migrateSchema()
    {
        Artisan::call('migrate', ['--force' => true, '--database' => $this->connection_name, '--path' => 'database/migrations/']);
    }

    public function seedSchema()
    {
        Artisan::call('db:seed', ['--database' => $this->connection_name]);
    }
}

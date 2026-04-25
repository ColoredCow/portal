<?php

namespace Modules\Client\Entities;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Modules\Client\Database\Factories\ClientContractFactory;

class ClientContract extends Model
{
    use HasFactory;

    protected $fillable = ['client_id', 'contract_file_path', 'start_date', 'end_date', 'uuid'];

    protected $casts = [
        'start_date' => 'datetime',
        'end_date' => 'datetime',
    ];

    public function getRouteKeyName()
    {
        return 'uuid';
    }

    protected static function booted()
    {
        static::creating(function (ClientContract $contract) {
            if (empty($contract->uuid)) {
                $contract->uuid = (string) Str::uuid();
            }
        });
    }

    protected static function newFactory()
    {
        return ClientContractFactory::new();
    }

    public function client()
    {
        return $this->belongsTo(Client::class);
    }
}

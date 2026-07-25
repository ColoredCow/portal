<?php

namespace App\Models\Finance;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    protected $guarded = [];

    protected $casts = [
        'paid_at' => 'datetime',
        'deleted_at' => 'datetime',
    ];

    public function invoice()
    {
        return $this->belongsTo(Invoice::class);
    }

    public function mode()
    {
        return $this->morphTo();
    }
}

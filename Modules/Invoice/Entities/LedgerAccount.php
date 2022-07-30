<?php

namespace Modules\Invoice\Entities;

use App\Traits\Encryptable;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Database\Eloquent\Model;
use App\Casts\Decrypted;

class LedgerAccount extends Model implements Arrayable
{
    use Encryptable;

    protected $fillable = ['client_id', 'project_id', 'particulars', 'date', 'credit', 'debit', 'balance'];

    protected $encryptable = [
        'credit', 'debit', 'balance'
    ];

    protected $casts = [
        'credit' => Decrypted::class,
        'debit' => Decrypted::class,
        'balance' => Decrypted::class,
    ];

    public function scopeQuarter($query, $quarter = null)
    {
        if ($quarter == null) {
            return $query;
        }

        $quarter = $quarter ?? now()->quarter;

        $startDate = today()->startOfYear()->addQuarters($quarter - 1)->startOfQuarter();
        $endDate = today()->startOfYear()->addQuarters($quarter - 1)->endOfQuarter();

        return $query->where('date', '>=', $startDate)->where('date', '<=', $endDate);
    }
}

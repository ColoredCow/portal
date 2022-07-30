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
}

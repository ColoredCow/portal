<?php

namespace Modules\ProjectContract\Entities;

use Illuminate\Database\Eloquent\Model;

class ContractReview extends Model
{
    protected $table = 'contract_review';

    protected $fillable = [
        'contract_id',
        'comment_id',
        'comment',
        'comment_by'
    ];

    public function reviewtable()
    {
        return $this->morphTo();
    }
}

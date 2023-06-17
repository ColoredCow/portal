<?php

namespace Modules\ProjectContract\Entities;

use Illuminate\Database\Eloquent\Model;
use Modules\ProjectContract\Entities\ContractReview;

class ContractInternalReview extends Model
{
    protected $table = 'contract_internal_review';

    protected $fillable = [
        'contract_id',
        'name',
        'email',
        'user_id'
    ];

    public function contractReviews()
    {
        return $this->morphMany(ContractReview::class, 'reviewtable');
    }
}

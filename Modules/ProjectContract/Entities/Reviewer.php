<?php

namespace Modules\ProjectContract\Entities;

use Illuminate\Database\Eloquent\Model;

class Reviewer extends Model
{
    protected $table = 'contract_reviewer';

    protected $fillable = [
        'contract_id',
        'name',
        'email'
    ];

    public function contractReviews()
    {
        return $this->morphMany(ContractReview::class, 'comment');
    }
}

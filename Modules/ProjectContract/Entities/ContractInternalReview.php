<?php

namespace Modules\ProjectContract\Entities;

use Illuminate\Database\Eloquent\Model;
use Modules\User\Entities\User;

class ContractInternalReview extends Model
{
    protected $table = 'contract_internal_reviewer';

    protected $fillable = [
        'contract_id',
        'name',
        'email',
        'user_id'
    ];

    public function contractReviews()
    {
        return $this->morphMany(ContractReview::class, 'comment');
    }
    public function contract()
    {
        return $this->belongsTo(Contract::class, 'contract_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}

<?php
namespace Modules\ProjectContract\Entities;

use Illuminate\Database\Eloquent\Model;
use Modules\User\Entities\User;

class Contract extends Model
{
    protected $guarded = [];

    public function contractMeta()
    {
        return $this->hasMany(ContractMeta::class, 'contract_id');
    }
    public function contractMetaHistory()
    {
        return $this->hasMany(ContractMetaHistory::class, 'contract_id');
    }
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function internalReviewers()
    {
        return $this->hasMany(ContractInternalReview::class, 'contract_id');
    }
    public function statusReviewers($type)
    {
        return $this->internalReviewers()->where('user_type', $type);
    }
    public function contractReviewers()
    {
        return $this->hasMany(Reviewer::class, 'contract_id');
    }
}

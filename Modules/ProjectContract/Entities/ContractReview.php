<?php

namespace Modules\ProjectContract\Entities;

use Illuminate\Database\Eloquent\Model;
use Modules\ProjectContract\Entities\ContractInternalReview;
use Modules\ProjectContract\Entities\Reviewer;

class ContractReview extends Model
{
    protected $table = 'contract_review';

    protected $fillable = [
        'contract_id',
        'comment_id',
        'comment',
        'comment_by'
    ];

    public function comment()
    {
        return $this->morphTo();
    }

    public function getMorphClass()
    {
        if ($this->comment_by === 'Internal') {
            return ContractInternalReview::class;
        } elseif ($this->comment_by === 'Client') {
            return Reviewer::class;
        }

        return parent::getMorphClass();
    }
}

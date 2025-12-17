<?php

namespace Modules\ProjectContract\Entities;

use Illuminate\Database\Eloquent\Model;

class ContractReview extends Model
{
    protected $table = 'contract_review';

    protected $guarded = [];

    public function comment()
    {
        return $this->morphTo();
    }

    public function getMorphClass()
    {
        if ($this->comment_by === 'Internal') {
            return ContractInternalReview::class;
        }
        if ($this->comment_by === 'Client') {
            return Reviewer::class;
        }

        return parent::getMorphClass();
    }
}

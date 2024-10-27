<?php
namespace Modules\ProjectContract\Entities;

use Illuminate\Database\Eloquent\Model;

class Reviewer extends Model
{
    protected $table = 'contract_reviewer';

    protected $guarded = [];

    public function contractReviews()
    {
        return $this->morphMany(ContractReview::class, 'comment');
    }
}

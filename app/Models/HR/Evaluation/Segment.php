<?php

namespace App\Models\HR\Evaluation;

use App\Models\HR\Round;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Segment extends Model
{
    use SoftDeletes;

    protected $fillable = ['name'];

    protected $table = 'hr_evaluation_segments';

    protected $dates = ['deleted_at'];

    public function rounds()
    {
        return $this->belongsToMany(Round::class, 'hr_round_segment', 'segment_id', 'round_id');
    }

    public function parameter()
    {
        return $this->hasMany(Parameter::class, 'segment_id');
    }
}

<?php

namespace App\Models\HR\Evaluation;

use App\Models\HR\Round;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Segment extends Model
{
    use SoftDeletes;

    protected $fillable = ['name', 'round_id'];

    protected $table = 'hr_evaluation_segments';

    protected $dates = ['deleted_at'];

    public function round()
    {
        return $this->belongsTo(Round::class);
    }

    public function parameters()
    {
        return $this->hasMany(Parameter::class, 'segment_id');
    }
}

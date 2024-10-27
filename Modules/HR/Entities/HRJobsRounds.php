<?php
namespace Modules\HR\Entities;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HRJobsRounds extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $table = 'hr_jobs_rounds';

    protected $fillable = ['hr_job_id', 'hr_round_id', 'hr_round_interviewer_id'];
}

<?php

namespace App\Models\HR;

use App\Models\HR\Application;
use Illuminate\Database\Eloquent\Model;

class ApplicationMeta extends Model
{
    protected $fillable = ['hr_application_id', 'value', 'key'];

    protected $table = 'hr_application_meta';

    public function application()
    {
    	return $this->belongsTo(Application::class, 'hr_application_id');
    }

    public static function scopeFormData($query)
    {
        return $query->where('key', config('constants.hr.application-meta.keys.form-data'));
    }

    public static function scopeJobChanged($query)
    {
        return $query->where('key', config('constants.hr.application-meta.keys.change-job'));
    }

    /**
     * Get details of communication mail if application meta is for change job
     *
     * @return mixed
     */
    public function getJobChangedCommunicationMailAttribute()
    {
        if ($this->key != config('constants.hr.application-meta.keys.change-job')) {
            return false;
        }
        $this->load('application', 'application.applicant');

        return [
            'modal-id' => 'job_change_' . $this->id,
            'mail-to' => $this->application->applicant->email,
            'mail-subject' => $this->value->job_change_mail_subject,
            'mail-body' => $this->value->job_change_mail_body,
            'mail-sender' => $this->value->user,
            'mail-date' => $this->created_at,
        ];
    }
}

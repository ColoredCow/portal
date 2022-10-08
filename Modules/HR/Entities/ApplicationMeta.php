<?php

namespace Modules\HR\Entities;

use Illuminate\Database\Eloquent\Model;
use Modules\HR\Database\Factories\HrApplicationMetaFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ApplicationMeta extends Model
{
    use HasFactory;
    protected $fillable = ['hr_application_id', 'value', 'key'];

    protected $table = 'hr_application_meta';

    public function application()
    {
        return $this->belongsTo(Application::class, 'hr_application_id');
    }

    public static function scopeFormData($query)
    {
        return $query->where('key', config('hr.application-meta.keys.form-data'));
    }

    public static function scopeJobChanged($query)
    {
        return $query->where('key', config('constants.hr.application-meta.keys.change-job'));
    }

    public static function scopeNoShow($query)
    {
        return $query->where('key', config('constants.hr.status.no-show.label'));
    }

    public static function scopeSentForApproval($query)
    {
        return $query->where('key', config('constants.hr.status.sent-for-approval.label'));
    }

    public static function scopeApproved($query)
    {
        return $query->where('key', config('constants.hr.status.approved.label'));
    }

    public static function scopeOnboarded($query)
    {
        return $query->where('key', config('constants.hr.status.onboarded.label'));
    }

    public static function scopeEmployee($query)
    {
        return $query->where('key', config('constants.hr.roles.employee.label'));
    }

    public static function newFactory()
    {
        return new HrApplicationMetaFactory();
    }

    public static function scopeCustomMail($query)
    {
        return $query->where('key', config('constants.hr.status.custom-mail.label'));
    }

    /**
     * Get details of communication mail if application meta is for change job.
     *
     * @return mixed
     */
    public function getCommunicationMailAttribute()
    {
        $this->load('application', 'application.applicant');

        $attr = [
            'mail-to' => $this->application->applicant->email,
            'mail-sender' => $this->value->user ?? null,
            'mail-date' => $this->updated_at,
        ];

        switch ($this->key) {
            case config('constants.hr.application-meta.keys.change-job'):
                $attr['modal-id'] = 'job_change_' . $this->id;
                $attr['mail-subject'] = $this->value->job_change_mail_subject;
                $attr['mail-body'] = $this->value->job_change_mail_body;
                break;

            case config('constants.hr.application-meta.keys.no-show'):
                $attr['modal-id'] = 'round_not_conducted_' . $this->id;
                $attr['mail-subject'] = $this->value->mail_subject ?? null;
                $attr['mail-body'] = $this->value->mail_body ?? null;
                break;

            default:
                return false;
        }

        return $attr;
    }
}

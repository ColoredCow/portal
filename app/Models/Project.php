<?php

namespace App\Models;

use App\Models\HR\Employee;
use App\Models\Finance\Invoice;
use Illuminate\Database\Eloquent\Model;
use App\Models\Project\ProjectTimesheet;
use App\Models\Project\ProjectBillingInfo;

class Project extends Model
{
    protected $guarded = [];
    protected $appends = ['invoice_number'];

    /**
     * Get the client that owns the project.
     */
    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    /**
     * Get details to list projects
     *
     * @return self
     */
    public static function getList()
    {
        return self::with(['client' => function ($query) {
            $query->select('id', 'name');
        }])
            ->orderBy('id', 'desc')
            ->paginate(config('constants.pagination_size'));
    }

    /**
     * Get the stages for the project.
     */
    public function stages()
    {
        return $this->hasMany(ProjectStage::class);
    }

    /**
     * Get the employees for the project.
     */
    public function employees()
    {
        return $this->belongsToMany(Employee::class)->withPivot('contribution_type');
    }

    /**
     * Get all project timesheets.
     */
    public function timesheets()
    {
        return $this->hasMany(ProjectTimesheet::class);
    }

    public function billingInfo()
    {
        return $this->hasOne(ProjectBillingInfo::class);
    }

    public function getClientProjectIdAttribute($value)
    {
        return sprintf('%03d', $value);
    }

    public function getInvoiceNumberAttribute()
    {
        $totalInvoicesCountNumber = $this->getTotalInvoiceCount() ?:1;
        return sprintf('%05d', $totalInvoicesCountNumber);
    }

    public function getTotalInvoiceCount()
    {
        return $this->invoices()->count();
    }

    public function invoices()
    {
        //ToDO:: Add relationship with invoices
        return Invoice::all();
    }
}
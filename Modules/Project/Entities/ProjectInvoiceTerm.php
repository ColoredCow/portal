<?php

namespace Modules\Project\Entities;

use App\Models\Comment;
use Carbon\Carbon;
use Modules\Invoice\Entities\Invoice;
use Illuminate\Database\Eloquent\Model;

class ProjectInvoiceTerm extends Model
{
    protected $fillable = [
        'project_id', 'invoice_id', 'invoice_date', 'status',
        'client_acceptance_required', 'amount', 'is_accepted',
        'report_required', 'delivery_report',
    ];

    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    public function getCurrentStatusAttribute()
    {
        return Carbon::now() > $this->invoice_date ? 'overdue' : $this->status;
    }

    public function invoice()
    {
        return $this->belongsTo(Invoice::class);
    }

    public function comment()
    {
        return $this->morphOne(Comment::class, 'commentable');
    }
}

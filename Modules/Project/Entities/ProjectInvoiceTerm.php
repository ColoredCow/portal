<?php

namespace Modules\Project\Entities;

use App\Models\Comment;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Modules\Invoice\Entities\Invoice;
use Modules\Project\Database\Factories\ProjectInvoiceTermFactory;

class ProjectInvoiceTerm extends Model
{
    use HasFactory;

    protected $fillable = [
        'project_id', 'invoice_id', 'invoice_date', 'status',
        'client_acceptance_required', 'amount', 'is_accepted',
        'report_required', 'delivery_report', 'uuid',
    ];

    public function getRouteKeyName()
    {
        return 'uuid';
    }

    protected static function booted()
    {
        static::creating(function (ProjectInvoiceTerm $term) {
            if (empty($term->uuid)) {
                $term->uuid = (string) Str::uuid();
            }
        });
    }

    protected static function newFactory()
    {
        return ProjectInvoiceTermFactory::new();
    }

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

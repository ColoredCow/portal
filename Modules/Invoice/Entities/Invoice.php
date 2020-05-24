<?php

namespace Modules\Invoice\Entities;

use App\Traits\Encryptable;
use Modules\Client\Entities\Client;
use Modules\Project\Entities\Project;
use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    use Encryptable;

    protected $fillable = ['client_id', 'project_id', 'status', 'currency', 'amount', 'sent_on', 'due_on', 'gst', 'file_path', 'comments'];
    protected $dates = ['sent_on', 'due_on'];

    protected $encryptable = [
        'amount', 'gst',
    ];

    public function scopeStatus($query, $status)
    {
        return $query->where('status', $status);
    }

    public function scopeYear($query, $year)
    {
        return $query->whereYear('sent_on', $year);
    }

    public function scopeMonth($query, $month)
    {
        return $query->whereMonth('sent_on', $month);
    }

    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    public function getDisplayAmountAttribute()
    {
        $country = optional($this->client)->country;
        return $this->amount . ' ' . optional($country)->currency_symbol;
    }
}

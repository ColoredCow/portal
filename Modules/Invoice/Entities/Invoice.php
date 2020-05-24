<?php

namespace Modules\Invoice\Entities;

use Modules\Client\Entities\Client;
use Modules\Project\Entities\Project;
use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    protected $fillable = ['client_id', 'project_id', 'status', 'currency', 'amount', 'sent_on', 'due_on', 'gst', 'file_path', 'comments'];
    protected $dates = ['sent_on', 'due_on'];

    public function scopeStatus($query, $status)
    {
        return $query->where('status', $status);
    }

    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    public function client()
    {
        return $this->belongsTo(Client::class);
    }
}

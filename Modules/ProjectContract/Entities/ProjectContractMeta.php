<?php

namespace Modules\ProjectContract\Entities;

use App\Models\Client;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProjectContractMeta extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'project_contract_meta';

    protected $fillable = [
        'client_id',
        'website_url',
        'logo_img',
        'authority_name',
        'contract_date_for_signing',
        'contract_date_for_effective',
        'contract_expiry_date', 
        'attributes'
    ];

    protected $guarded = [];

    public function client()
    {
        return $this->belongsTo(Client::class, 'client_id');
    }
}

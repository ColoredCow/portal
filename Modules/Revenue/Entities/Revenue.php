<?php

namespace Modules\Revenue\Entities;

use Illuminate\Database\Eloquent\Model;

class Revenue extends Model
{
    protected $table = 'revenue';

    protected $guarded = [];

    protected $fillable = ['name', 'category', 'currency', 'amount', 'recieved_at', 'notes'];
}

<?php

namespace Modules\Revenue\Entities;

use Illuminate\Database\Eloquent\Model;

class RevenueProceed extends Model
{
    protected $table = 'revenue_proceeds';

    protected $guarded = [];

    protected $fillable = ['name', 'category', 'currency', 'amount', 'recieved_at', 'notes'];
}

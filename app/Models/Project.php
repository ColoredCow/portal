<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    $fillable = ['name', 'started_on', 'invoice_email', 'status'];
}

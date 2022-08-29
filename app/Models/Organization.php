<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Organization extends Model
{
    use HasFactory;

    protected $table = 'organizations';
    protected $fillable = ['id', 'name', 'address', 'annual_sales', 'members', 'industry', 'email', 'billing_details', 'website'];
}

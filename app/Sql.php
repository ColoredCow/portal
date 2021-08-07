<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sql extends Model
{
    protected $table = 'hr_applicants';
    public $timestamps = false;
    protected $fillable = ["id","name","created_at","updated_at"];
}

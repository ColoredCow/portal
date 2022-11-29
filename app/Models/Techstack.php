<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Techstack extends Model
{
    use HasFactory;
    protected $table="techstacks";
    protected $primarykey="techstacks_id";
    protected $fillable = ['name'];
}
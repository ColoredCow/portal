<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    protected $guarded = [];

    public function scopeSlug($query, $slug)
    {
        return $query->where('slug', $slug);
    }

    public function getTextColorAttribute($hexColor)
    {
        $hexColor = str_replace('#', '', $this->background_color);
        $r = hexdec(substr($hexColor, 1, 2));
        $g = hexdec(substr($hexColor, 3, 2));
        $b = hexdec(substr($hexColor, 5, 2));
        $yiq = (($r * 299) + ($g * 587) + ($b * 114)) / 1000;

        return $yiq >= 128 ? '#000000' : '#FFFFFF';
    }
}

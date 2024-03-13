<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PageVisit extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'page_path', 'visit_count'];

    public static function updateVisitCount($userId, $pagePath)
    {
        $today = now()->today();
        
        $visit = self::where('user_id', $userId)->where('page_path', $pagePath)->whereDate('created_at', $today)->first();

        if (! $visit) {
            $visit = new self;
            $visit->user_id = $userId;
            $visit->page_path = $pagePath;
        }

        $visit->visit_count++;
        $visit->save();
    }
}

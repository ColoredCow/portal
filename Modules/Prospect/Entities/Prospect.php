<?php

namespace Modules\Prospect\Entities;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Modules\Client\Entities\Client;
use Modules\User\Entities\User;

class Prospect extends Model
{
    protected $fillable = [];
    protected $table = 'prospects';

    public function pocUser()
    {
        return $this->belongsTo(User::class, 'poc_user_id');
    }

    public function comments()
    {
        return $this->hasMany(ProspectComment::class);
    }

    public function getFormattedDate($date)
    {
        return $date ? Carbon::parse($date)->format('M d, Y')
            : '-';
    }

    public function client()
    {
        return $this->belongsTo(Client::class, 'client_id');
    }

    public function getProspectDisplayName()
    {
        return $this->organization_name ?? optional($this->client)->name ?? 'N/A';
    }

    public function getFormattedBudgetAttribute()
    {
        $budget = (string) $this->budget;
        $currency = $this->currency;

        // if currency is less than one thousand
        if (strlen($budget) <= 3) {
            return $budget;
        }

        if ($currency == 'INR') {
            $formattedBudget = preg_replace('/\B(?=(\d{2})+(?!\d))/', ',', substr($budget, 0, -3)) .
                    ',' . substr($budget, -3);
        } else {
            $formattedBudget = number_format($budget, 0);
        }

        return $formattedBudget;
    }

    public function insights()
    {
        return $this->hasMany(ProspectInsight::class);
    }
}

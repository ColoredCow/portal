<?php

namespace Modules\Expense\Entities;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class RecurringExpense extends Model
{
    use HasFactory;

    protected $casts = [
        'initial_due_date' => 'date',
    ];

    protected $fillable = [
        'name',
        'status',
        'frequency',
        'initial_due_date',
        'currency',
        'amount',
        'description',
    ];

    public function getDueDateAttribute() {
        $initialDueDate = $this->initial_due_date;
        $frequency = $this->frequency;

        if(now()->lt($initialDueDate)) {
            return $initialDueDate;
        }

        if($frequency == 'monthly' && now()->gt($initialDueDate)) {
           $month = date('m');
           return Carbon::parse($initialDueDate->format("Y-$month-d"));
        } 
        
        if($frequency == 'yearly') {
            $year = date('Y');
            return Carbon::parse($initialDueDate->format("$year-m-d"));
        }

        return $initialDueDate;
    }
}

<?php

namespace App\Http\Controllers\Settings;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Cron\CronExpression;
use Illuminate\Support\Facades\Artisan;


class CronController extends Controller
{
    public function index()
    {
        app()->make(\Illuminate\Contracts\Console\Kernel::class);
        $schedule = app()->make(\Illuminate\Console\Scheduling\Schedule::class);
        
        foreach(Artisan::all() as $key=>$command)
        {
            var_dump($key);
            var_dump(class_basename($command));

            // dd(Modules\HR\Console\Recruitment\ApplicationNoShow::class);
        }

        $events = collect($schedule->events())->map(function($event) 
        {
            $cron = CronExpression::factory($event->expression);
            $date = Carbon::now();
            if ($event->timezone) {
                $date->setTimezone($event->timezone);
            }
            return (object)[
                'expression' => $event->expression,
                'command' => str_after($event->command, '\'artisan\' '),
                'next_run_at' => $cron->getNextRunDate()->format('Y-m-d H:i:s'),
                'description' => $event->description,
            ];
        });
        dd($events);
        return view('settings.cron.index')->with('events',$events);
    }
}

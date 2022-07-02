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

        $events = collect($schedule->events())->map(function ($event) {
            $command = str_after($event->command, '\'artisan\' ');
            $commandDescription = '';
            foreach (Artisan::all() as $artisanCommand => $commandDetails) {
                if ($artisanCommand == $command) {
                    $commandDescription = $commandDetails->getDescription();
                    break;
                }
            }
            $cron = CronExpression::factory($event->expression);
            $date = Carbon::now();
            if ($event->timezone) {
                $date->setTimezone($event->timezone);
            }

            return (object) [
                'expression' => $event->expression,
                'command' => $command,
                'next_run_at' => $cron->getNextRunDate()->format('d, M, Y, g:i A'),
                'description' => $commandDescription,
            ];
        });

        return view('settings.cron.index')->with('events', $events);
    }

    public function run($command)
    {
        Artisan::call($command);

        return redirect()->route('settings.cron')->with('success', 'Command executed successfully');
    }
}

<?php

namespace App\Http\Controllers\Settings;

use App\Http\Controllers\Controller;
use Cron\CronExpression;
use Illuminate\Support\Facades\Artisan;

class CronController extends Controller
{
    public function index()
    {
        $this->authorize('index', Cron::class);
        // Collects all the content  from the kernel class.
        app()->make(\Illuminate\Contracts\Console\Kernel::class);

        // Collects all the commands from the schedule class.
        $schedule = app()->make(\Illuminate\Console\Scheduling\Schedule::class);

        $events = collect($schedule->events())->map(function ($event) {

            // Removes the excess characters in the command.
            $command = str_after($event->command, '\'artisan\' ');
            $commandDescription = '';

            // Loops through the artisan commands and gets the description.
            foreach (Artisan::all() as $artisanCommand => $commandDetails) {
                if ($artisanCommand == $command) {
                    $commandDescription = $commandDetails->getDescription();
                    break;
                }
            }
            // CRON expression parser that can determine whether or not a CRON expression.
            $cron = CronExpression::factory($event->expression);

            return (object) [
                'expression' => $event->expression,
                'command' => $command,
                'next_run_at' => $cron->getNextRunDate()->format('d, M, Y, g:i A'), // Converts the cron expression to a human readable date.
                'description' => $commandDescription,
            ];
        });

        return view('settings.cron.index')->with('events', $events);
    }

    public function run(string $command)
    {
        $this->authorize('run', Cron::class);
        Artisan::call($command);

        return redirect()->route('settings.cron')->with('success', 'Command executed successfully');
    }
}

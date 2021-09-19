<?php

namespace Modules\AppointmentSlots\Console;

use Illuminate\Console\Command;
use Modules\User\Entities\User;
use Symfony\Component\Console\Input\InputArgument;
use Modules\AppointmentSlots\Services\AppointmentSlotsService;

class CreateUserAppointmentSlots extends Command
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'appointmentslots:create';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Creates appointment slots for the provided user.';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $userId = $this->argument('user');
        $user = User::find($userId);
        $freeSlots = AppointmentSlotsService::getUserFreeSlots($userId);

        if ($freeSlots->isEmpty()) {
            $this->info('No free slots available. Creating new ones.');
            AppointmentSlotsService::fillUserSchedule($userId);
        } elseif ($freeSlots->count() < 15) {
            $this->info('Free slots less than 15. Creating new ones.');
            $startDateTime = $freeSlots->last()->start_time->addDays(1)->setTime(11, 0);
            AppointmentSlotsService::fillUserSchedule($userId, $startDateTime);
        }
        $this->info('All done!');
    }

    /**
     * Get the console command arguments.
     *
     * @return array
     */
    protected function getArguments()
    {
        return [
            ['user', InputArgument::REQUIRED, '1'],
        ];
    }

    /**
     * Get the console command options.
     *
     * @return array
     */
    protected function getOptions()
    {
        return [];
    }
}

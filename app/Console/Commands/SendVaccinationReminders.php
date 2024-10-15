<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Vaccination;
use Carbon\Carbon;
use App\Notifications\VaccinationReminderNotification;

class SendVaccinationReminders extends Command
{
    protected $signature = 'vaccination:send-reminders';

    protected $description = 'Send vaccination reminders to users';

    public function handle()
    {
        $tomorrow = Carbon::now()->addDay()->toDateString();

        $vaccinations = Vaccination::where('scheduled_date', $tomorrow)->get();

        foreach ($vaccinations as $vaccination) {
            $vaccination->user->notify(new VaccinationReminderNotification($vaccination));
        }

        $this->info('Reminders sent successfully.');
    }
}


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
        try {
            $tomorrow = Carbon::tomorrow();

            $vaccinations = Vaccination::where('scheduled_date', $tomorrow)->get();

            foreach ($vaccinations as $vaccination) {
                $vaccination->user->notify(new VaccinationReminderNotification($vaccination));
            }

            $this->info('Vaccination Reminders sent successfully.');
        } catch (\Exception $e) {
            $this->error('An error occurred while scheduling vaccinations: ' . $e->getMessage());
        }
    }
}

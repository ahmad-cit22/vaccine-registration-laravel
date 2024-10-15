<?php

namespace App\Services;

use App\Models\Vaccination;
use App\Models\VaccineCenter;
use App\Notifications\VaccinationScheduledNotification;
use Carbon\Carbon;

class VaccinationScheduler
{
    public function schedule()
    {
        $tomorrow = Carbon::tomorrow();
        $centers = VaccineCenter::all();
        $nextAvailableDate = $this->getNextAvailableWeekday($tomorrow);

        foreach ($centers as $center) {
            $vaccinations = Vaccination::where('vaccine_center_id', $center->id)
                ->whereNull('scheduled_date')
                ->orderBy('created_at')
                ->take($center->daily_limit)
                ->get();

            foreach ($vaccinations as $vaccination) {
                $vaccination->scheduled_date = $nextAvailableDate;
                $vaccination->status = 'Scheduled';
                $vaccination->save();

                $user = $vaccination->user;
                $user->notify(new VaccinationScheduledNotification($vaccination));
            }
        }
    }

    private function getNextAvailableWeekday(Carbon $date)
    {
        while ($date->isFriday() || $date->isSaturday()) {
            $date->addDay();
        }

        return $date;
    }
}

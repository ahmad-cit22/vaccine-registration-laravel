<?php

namespace App\Services;

use App\Models\Vaccination;
use App\Models\VaccineCenter;
use Carbon\Carbon;

class VaccinationScheduler
{
    public function schedule()
    {
        $today = Carbon::now();
        $nextAvailableDate = $today->copy()->nextWeekday(); // Get the next available weekday
        $centers = VaccineCenter::all();

        foreach ($centers as $center) {
            $vaccinations = Vaccination::where('vaccine_center_id', $center->id)
                ->whereNull('scheduled_date')
                ->take($center->daily_limit)
                ->get();

            foreach ($vaccinations as $vaccination) {
                $vaccination->scheduled_date = $nextAvailableDate;
                $vaccination->status = 'Scheduled';
                $vaccination->save();
            }
        }
    }
}

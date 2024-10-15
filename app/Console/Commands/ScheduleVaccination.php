<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\VaccinationScheduler;

class ScheduleVaccination extends Command
{
    protected $signature = 'vaccination:schedule';

    protected $description = 'Schedule vaccinations for users';

    protected $scheduler;

    public function __construct(VaccinationScheduler $scheduler)
    {
        parent::__construct();
        $this->scheduler = $scheduler;
    }

    public function handle()
    {
        try {
            $this->scheduler->schedule();
            $this->info('Vaccinations have been scheduled.');
        } catch (\Exception $e) {
            $this->error('An error occurred while scheduling vaccinations: ' . $e->getMessage());
        }
    }
}


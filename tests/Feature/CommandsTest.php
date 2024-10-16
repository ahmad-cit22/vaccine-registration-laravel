<?php

namespace Tests\Feature;

use App\Console\Commands\ScheduleVaccination;
use App\Console\Commands\SendVaccinationReminders;
use Tests\TestCase;

class CommandsTest extends TestCase
{
    /** @test */
    public function it_runs_the_vaccination_scheduler_command()
    {
        $this->artisan(ScheduleVaccination::class)
            ->expectsOutput('Vaccinations have been scheduled.')
            ->assertExitCode(0);
    }

    /** @test */
    public function it_sends_vaccination_reminders()
    {
        $this->artisan(SendVaccinationReminders::class)
            ->expectsOutput('Vaccination Reminders sent successfully.')
            ->assertExitCode(0);
    }
}


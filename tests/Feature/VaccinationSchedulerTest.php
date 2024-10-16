<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Vaccination;
use App\Models\VaccineCenter;
use App\Notifications\VaccinationScheduledNotification;
use Carbon\Carbon;
use Illuminate\Support\Facades\Notification;
use Tests\TestCase;

class VaccinationSchedulerTest extends TestCase
{
    /** @test */
    public function it_schedules_vaccinations_for_the_next_available_weekday()
    {
        $center = VaccineCenter::factory()->create(['daily_limit' => 2]);
        $users = User::factory()->count(3)->create();
        foreach ($users as $user) {
            Vaccination::factory()->create([
                'user_id' => $user->id,
                'vaccine_center_id' => $center->id,
                'scheduled_date' => null,
            ]);
        }

        $this->artisan('vaccination:schedule');

        $scheduledVaccinations = Vaccination::whereNotNull('scheduled_date')->get();
        $this->assertCount(2, $scheduledVaccinations);
        $this->assertEquals(Carbon::tomorrow()->format('Y-m-d'), $scheduledVaccinations->first()->scheduled_date->format('Y-m-d'));
    }

    /** @test */
    public function it_schedules_vaccinations_and_sends_notifications()
    {
        Notification::fake();

        $center = VaccineCenter::factory()->create(['daily_limit' => 2]);
        $users = User::factory()->count(2)->create();

        foreach ($users as $user) {
            Vaccination::factory()->create([
                'user_id' => $user->id,
                'vaccine_center_id' => $center->id,
                'scheduled_date' => null,
            ]);
        }

        $this->artisan('vaccination:schedule');

        $this->assertDatabaseHas('vaccinations', ['status' => 'Scheduled']);

        Notification::assertSentTo(
            [$users[0], $users[1]],
            VaccinationScheduledNotification::class
        );
    }
}


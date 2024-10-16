<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Vaccination;
use App\Models\VaccineCenter;
use App\Notifications\VaccinationReminderNotification;
use Illuminate\Support\Facades\Notification;
use Tests\TestCase;
use Carbon\Carbon;

class VaccinationReminderTest extends TestCase
{
    /** @test */
    public function it_sends_reminder_notifications_for_tomorrows_vaccinations()
    {
        Notification::fake();

        $center = VaccineCenter::factory()->create();
        $user = User::factory()->create();

        Vaccination::factory()->create([
            'user_id' => $user->id,
            'vaccine_center_id' => $center->id,
            'scheduled_date' => Carbon::tomorrow(),
        ]);

        $this->artisan('vaccination:send-reminders');

        Notification::assertSentTo(
            [$user],
            VaccinationReminderNotification::class
        );
    }
}


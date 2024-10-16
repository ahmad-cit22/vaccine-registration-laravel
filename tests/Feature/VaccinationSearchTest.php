<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Vaccination;
use App\Models\VaccineCenter;
use Tests\TestCase;

class VaccinationSearchTest extends TestCase
{
    /** @test */
    public function it_displays_the_search_page()
    {
        $response = $this->get(route('search.view'));

        $response->assertStatus(200);
        $response->assertViewIs('pages.search');
    }

    /** @test */
    public function it_returns_validation_error_for_invalid_nid_format()
    {
        $response = $this->post(route('search'), ['nid' => '12345']);

        $response->assertStatus(200)
            ->assertJson([
                'status' => 'validationFailed',
                'message' => 'You must enter a valid NID number containing numbers (at least 10 digits).',
            ]);
    }

    /** @test */
    public function it_returns_validation_error_for_non_numeric_nid()
    {
        $response = $this->post(route('search'), ['nid' => 'abcd123456']);

        $response->assertStatus(200)
            ->assertJson([
                'status' => 'validationFailed',
                'message' => 'You must enter a valid NID number containing numbers (at least 10 digits).',
            ]);
    }

    /** @test */
    public function it_returns_not_registered_message_for_unregistered_nid()
    {
        $response = $this->post(route('search'), ['nid' => '1234567890']);

        $response->assertStatus(200)
            ->assertJson([
                'status' => 'Not registered',
                'message' => 'This NID is not registered for vaccination yet. Please register first.',
            ]);
    }

    /** @test */
    public function it_returns_vaccination_not_scheduled_message()
    {
        $center = VaccineCenter::factory()->create();
        $user = User::factory()->create(['nid' => '1234567890']);
        Vaccination::factory()->create([
            'user_id' => $user->id,
            'vaccine_center_id' => $center->id,
            'scheduled_date' => null
        ]);

        $response = $this->post(route('search'), ['nid' => '1234567890']);

        $response->assertStatus(200)
            ->assertJson([
                'status' => 'Not scheduled',
                'message' => 'You are registered but your vaccination is not scheduled yet. We will notify you via email soon when scheduled.',
            ]);
    }

    /** @test */
    public function it_returns_vaccination_status_for_today()
    {
        $user = User::factory()->create(['nid' => '1234567890']);
        $center = VaccineCenter::factory()->create();
        Vaccination::factory()->create([
            'user_id' => $user->id,
            'vaccine_center_id' => $center->id,
            'scheduled_date' => today(),
            'status' => 'Scheduled',
        ]);

        $response = $this->post(route('search'), ['nid' => '1234567890']);

        $response->assertStatus(200)
            ->assertJson([
                'status' => 'Scheduled',
                'message' => 'Your vaccination is scheduled on today at ' . $center->name . ' center.',
            ]);
    }

    /** @test */
    public function it_returns_vaccination_status_for_future_date()
    {
        $user = User::factory()->create(['nid' => '1234567890']);
        $center = VaccineCenter::factory()->create();
        $vaccination = Vaccination::factory()->create([
            'user_id' => $user->id,
            'vaccine_center_id' => $center->id,
            'scheduled_date' => now()->addDays(3),
            'status' => 'Scheduled',
        ]);

        $response = $this->post(route('search'), ['nid' => '1234567890']);

        $response->assertStatus(200)
            ->assertJson([
                'status' => 'Scheduled',
                'message' => 'Your vaccination is scheduled on ' . $vaccination->scheduled_date->format('F j, Y') . ' at ' . $center->name . ' center.',
            ]);
    }

    /** @test */
    public function it_updates_status_if_vaccination_date_has_passed()
    {
        $user = User::factory()->create(['nid' => '1234567890']);
        $center = VaccineCenter::factory()->create();
        $vaccination = Vaccination::factory()->create([
            'user_id' => $user->id,
            'vaccine_center_id' => $center->id,
            'scheduled_date' => now()->subDays(1),
            'status' => 'Scheduled',
        ]);

        $response = $this->post(route('search'), ['nid' => '1234567890']);

        $response->assertStatus(200)
            ->assertJson([
                'status' => 'Vaccinated',
                'message' => 'You have been vaccinated on ' . $vaccination->scheduled_date->format('F j, Y') . ' at ' . $center->name . ' center.',
            ]);

        $vaccination->refresh();
        $this->assertEquals('Vaccinated', $vaccination->status);
    }
}

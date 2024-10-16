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
    public function it_searches_for_a_registered_user()
    {
        $center = VaccineCenter::factory()->create();
        $user = User::factory()->create(['nid' => '1234567890']);
        Vaccination::factory()->create([
            'user_id' => $user->id,
            'vaccine_center_id' => $center->id,
        ]);

        $response = $this->post(route('search'), ['nid' => '1234567890']);

        $response->assertStatus(200)
            ->assertJson([
                'status' => 'Not scheduled',
                'message' => 'You are registered but your vaccination is not scheduled yet. We will notify you via email soon when scheduled.',
            ]);
    }

    /** @test */
    public function it_returns_error_if_nid_is_not_found()
    {
        $response = $this->post(route('search'), ['nid' => '9999999999']);

        $response->assertStatus(200)
            ->assertJson([
                'status' => 'Not registered',
                'message' => 'This NID is not registered for vaccination yet. Please register first.',
            ]);
    }
}

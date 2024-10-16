<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\VaccineCenter;
use Tests\TestCase;

class VaccinationRegistrationTest extends TestCase
{
    /** @test */
    public function it_shows_the_registration_page_and_form()
    {
        $center = VaccineCenter::factory()->create();

        $response = $this->get(route('register'));

        $response->assertStatus(200);
        $response->assertViewIs('pages.register');
        $response->assertViewHas('centers', function ($centers) use ($center) {
            return $centers->contains($center);
        });
    }

    /** @test */
    public function it_registers_a_user_successfully()
    {
        $center = VaccineCenter::factory()->create();

        $response = $this->post(route('register.store'), [
            'nid' => '1234567890',
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'vaccine_center_id' => $center->id,
        ]);

        $response->assertRedirect(route('search.view'));

        $this->assertDatabaseHas('users', [
            'nid' => '1234567890',
            'email' => 'john@example.com',
        ]);

        $this->assertDatabaseHas('vaccinations', [
            'vaccine_center_id' => $center->id,
        ]);
    }

    /** @test */
    public function it_fails_if_nid_is_already_registered()
    {
        User::factory()->create(['nid' => '1234567890']);
        VaccineCenter::factory()->create();

        $response = $this->post(route('register.store'), [
            'nid' => '1234567890',
            'name' => 'Jane Doe',
            'email' => 'jane@example.com',
            'vaccine_center_id' => 1,
        ]);

        $response->assertSessionHasErrors('nid');
    }

    /** @test */
    public function it_fails_if_email_is_already_registered()
    {
        User::factory()->create(['email' => 'john@example.com']);
        VaccineCenter::factory()->create();

        $response = $this->post(route('register.store'), [
            'nid' => '9876543210',
            'name' => 'Jane Doe',
            'email' => 'john@example.com',
            'vaccine_center_id' => 1,
        ]);

        $response->assertSessionHasErrors('email');
    }

    /** @test */
    public function it_fails_if_email_format_is_invalid()
    {
        VaccineCenter::factory()->create();

        $response = $this->post(route('register.store'), [
            'nid' => '1234567890',
            'name' => 'Jane Doe',
            'email' => 'invalid-email-format',
            'vaccine_center_id' => 1,
        ]);

        $response->assertSessionHasErrors('email');
    }

    /** @test */
    public function it_fails_if_nid_is_less_than_10_digits()
    {
        VaccineCenter::factory()->create();

        $response = $this->post(route('register.store'), [
            'nid' => '12345',
            'name' => 'Jane Doe',
            'email' => 'jane@example.com',
            'vaccine_center_id' => 1,
        ]);

        $response->assertSessionHasErrors('nid');
    }

    /** @test */
    public function it_fails_if_nid_contains_non_numeric_characters()
    {
        VaccineCenter::factory()->create();

        $response = $this->post(route('register.store'), [
            'nid' => '12345abcde',
            'name' => 'Jane Doe',
            'email' => 'jane@example.com',
            'vaccine_center_id' => 1,
        ]);

        $response->assertSessionHasErrors('nid');
    }
}

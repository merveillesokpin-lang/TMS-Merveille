<?php

namespace Tests\Feature;

use Tests\TestCase;

class AlerteControllerTest extends TestCase
{
    public function test_store_requires_type_and_vehicle_id(): void
    {
        $response = $this->postJson('/api/alertes', []);

        $response->assertStatus(422)
            ->assertJsonValidationErrors(['TypeAlerte', 'vehicule_id']);
    }
}

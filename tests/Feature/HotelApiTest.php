<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class HotelApiTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        // Desactivar middlewares para simplificar las pruebas (si aplicable)
        $this->withoutMiddleware();
    }

    public function test_create_hotel_success()
    {
        $payload = [
            'name' => 'DECAMERON CARTAGENA',
            'address' => 'CALLE 23 58-25',
            'city' => 'CARTAGENA',
            'nit' => '12345678-9',
            'number_of_rooms' => 42,
            'room_configurations' => [
                [
                    'quantity' => 25,
                    'room_type' => 'Estándar',
                    'accommodation' => 'Sencilla'
                ],
                [
                    'quantity' => 12,
                    'room_type' => 'Junior',
                    'accommodation' => 'Triple'
                ],
                [
                    'quantity' => 5,
                    'room_type' => 'Estándar',
                    'accommodation' => 'Doble'
                ]
            ]
        ];

        $response = $this->postJson('/api/hotels', $payload);

        $response->assertStatus(201)
                 ->assertJsonFragment(['name' => 'DECAMERON CARTAGENA']);

        $this->assertDatabaseHas('hotels', ['name' => 'DECAMERON CARTAGENA']);
    }

    public function test_create_hotel_invalid_accommodation()
    {
        $payload = [
            'name' => 'HOTEL PRUEBA',
            'address' => 'Calle Falsa 123',
            'city' => 'Ciudad X',
            'nit' => '98765432-1',
            'number_of_rooms' => 20,
            'room_configurations' => [
                [
                    'quantity' => 10,
                    'room_type' => 'Junior',
                    'accommodation' => 'Doble'  // Incorrecto: debe ser Triple o Cuádruple
                ]
            ]
        ];

        $response = $this->postJson('/api/hotels', $payload);
        $response->assertStatus(422);
    }
}

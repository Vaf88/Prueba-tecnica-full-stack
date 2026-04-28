<?php

namespace Tests\Feature;

use App\Models\Ticket;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TicketApiTest extends TestCase
{
    use RefreshDatabase;

    public function test_ticket_creation_validation()
    {
        $user = User::factory()->create();
        $token = $user->createToken('test')->plainTextToken;

        $response = $this->postJson('/api/tickets', [], [
            'Authorization' => 'Bearer ' . $token
        ]);

        $response->assertStatus(422)
                 ->assertJsonValidationErrors(['titulo', 'descripcion', 'prioridad', 'cliente_id']);
    }

    public function test_ticket_creation_success()
    {
        $user = User::factory()->create();
        $cliente = User::factory()->create();
        $token = $user->createToken('test')->plainTextToken;

        $data = [
            'titulo' => 'Test Ticket',
            'descripcion' => 'Test description',
            'prioridad' => 'alta',
            'cliente_id' => $cliente->id,
        ];

        $response = $this->postJson('/api/tickets', $data, [
            'Authorization' => 'Bearer ' . $token
        ]);

        $response->assertStatus(201)
                 ->assertJsonStructure([
                     'id',
                     'titulo',
                     'descripcion',
                     'prioridad',
                     'cliente_id',
                     'created_at',
                     'updated_at',
                     'cliente' => ['id', 'name', 'email']
                 ]);

        $this->assertDatabaseHas('tickets', $data);
    }

    public function test_ticket_list_with_filters()
    {
        $user = User::factory()->create();
        $cliente = User::factory()->create();
        $token = $user->createToken('test')->plainTextToken;

        Ticket::factory()->create(['prioridad' => 'alta', 'titulo' => 'Bug fix', 'cliente_id' => $cliente->id]);
        Ticket::factory()->create(['prioridad' => 'baja', 'titulo' => 'Feature request', 'cliente_id' => $cliente->id]);

        $response = $this->getJson('/api/tickets?prioridad=alta', [
            'Authorization' => 'Bearer ' . $token
        ]);

        $response->assertStatus(200)
                 ->assertJsonCount(1, 'data');
    }
}

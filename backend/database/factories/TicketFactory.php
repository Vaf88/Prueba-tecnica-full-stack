<?php

namespace Database\Factories;

use App\Models\Ticket;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Ticket>
 */
class TicketFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'titulo' => $this->faker->sentence(5),
            'descripcion' => $this->faker->paragraph(),
            'prioridad' => $this->faker->randomElement(['baja', 'media', 'alta']),
            'cliente_id' => \App\Models\User::inRandomOrder()->first()->id ?? \App\Models\User::factory(),
        ];
    }
}

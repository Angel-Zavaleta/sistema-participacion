<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\CatTemasDeInteres>
 */
class CatTemasDeInteresFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'tema' => $this->faker->sentence(3, false), // Genera frases cortas como "Medio Ambiente Sostenible"
            'user_id' => User::factory(),
            'activo' => true,
        ];
    }

    /**
     * Estado para temas inactivos.
     */
    public function inactivo(): static
    {
        return $this->state(fn (array $attributes) => [
            'activo' => false,
        ]);
    }

    /**
     * Estado para temas con nombres específicos de prueba.
     */
    public function conTema(string $tema): static
    {
        return $this->state(fn (array $attributes) => [
            'tema' => $tema,
        ]);
    }
}

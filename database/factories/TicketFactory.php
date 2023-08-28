<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Ticket>
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
            'title' => $this->faker->sentence(mt_rand(2,5)),
            'slug' => $this->faker->slug(),
            'excerpt' => $this->faker->paragraph(mt_rand(3,5)),
            'body' => collect($this->faker->paragraphs(mt_rand(5,10)))
            ->map(fn($p) => "<p>$p</p>")
            ->implode(''),
            'user_id' => 11,
            'unit_id' => 1,
            'category_id' => mt_rand(1,3),
        ];
    }
}
<?php

namespace Database\Factories;

use App\Models\CmsKeyHighlight;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<CmsKeyHighlight>
 */
class CmsKeyHighlightFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'placement_target' => 'home_pilar',
            'icon_name' => 'school',
            'metric_value' => fake()->randomElement(['100%', 'Akreditasi A', '24+', '15 Rombel']),
            'title' => fake()->sentence(3),
            'description' => fake()->sentence(6),
            'badge_color' => fake()->randomElement(['primary', 'emerald', 'amber', 'sky', 'violet']),
            'link_url' => null,
            'sort_order' => fake()->numberBetween(1, 4),
            'is_active' => true,
        ];
    }
}

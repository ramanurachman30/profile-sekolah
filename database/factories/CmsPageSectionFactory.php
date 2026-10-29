<?php

namespace Database\Factories;

use App\Models\CmsPageSection;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<CmsPageSection>
 */
class CmsPageSectionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'page_code' => 'home',
            'section_key' => fake()->unique()->slug(2),
            'badge_title' => fake()->words(2, true),
            'title' => fake()->sentence(3),
            'subtitle' => fake()->sentence(6),
            'is_visible' => true,
            'sort_order' => fake()->numberBetween(1, 10),
            'metadata_json' => ['limit' => 3],
        ];
    }
}

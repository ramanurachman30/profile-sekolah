<?php

namespace Database\Factories;

use App\Models\CmsBanner;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<CmsBanner>
 */
class CmsBannerFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'placement' => 'home_hero',
            'badge_text' => fake()->words(3, true),
            'title' => fake()->sentence(4),
            'subtitle' => fake()->sentence(8),
            'cta_primary_text' => 'Daftar Sekarang',
            'cta_primary_url' => '/ppdb',
            'cta_secondary_text' => 'Pelajari Selengkapnya',
            'cta_secondary_url' => '/profil',
            'media_asset_id' => null,
            'start_date' => null,
            'end_date' => null,
            'sort_order' => fake()->numberBetween(1, 5),
            'is_active' => true,
        ];
    }
}

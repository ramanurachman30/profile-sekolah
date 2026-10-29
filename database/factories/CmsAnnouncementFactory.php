<?php

namespace Database\Factories;

use App\Models\CmsAnnouncement;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<CmsAnnouncement>
 */
class CmsAnnouncementFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title' => fake()->sentence(5),
            'content' => fake()->paragraph(),
            'announcement_type' => fake()->randomElement(['info', 'warning', 'success', 'urgent']),
            'placement_target' => 'global_topbar',
            'cta_text' => 'Lihat Detail',
            'cta_url' => '/ppdb',
            'start_date' => now()->subDay(),
            'end_date' => now()->addDays(14),
            'is_active' => true,
        ];
    }
}

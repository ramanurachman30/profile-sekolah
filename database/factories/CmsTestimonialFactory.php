<?php

namespace Database\Factories;

use App\Models\CmsTestimonial;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<CmsTestimonial>
 */
class CmsTestimonialFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'person_name' => fake()->name(),
            'person_category' => fake()->randomElement(['orang_tua', 'alumni', 'komite', 'tokoh_masyarakat', 'siswa']),
            'role_title' => 'Wali Murid Siswa Kelas '.fake()->numberBetween(1, 6),
            'testimonial_text' => fake()->paragraph(),
            'rating' => 5,
            'avatar_asset_id' => null,
            'placement' => 'home',
            'is_featured' => true,
            'sort_order' => fake()->numberBetween(1, 5),
            'is_active' => true,
        ];
    }
}

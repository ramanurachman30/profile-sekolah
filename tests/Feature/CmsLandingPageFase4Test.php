<?php

namespace Tests\Feature;

use App\Filament\Pages\Auth\Login;
use App\Models\CmsAnnouncement;
use App\Models\CmsBanner;
use App\Models\CmsKeyHighlight;
use App\Models\CmsPageSection;
use App\Models\CmsTestimonial;
use App\Models\SchoolProfile;
use Livewire\Livewire;
use Tests\TestCase;

class CmsLandingPageFase4Test extends TestCase
{
    /**
     * Uji 1: HomeController memuat seluruh variabel CMS reusable ke view frontend.home.
     */
    public function test_home_controller_passes_all_reusable_cms_variables_to_view(): void
    {
        $response = $this->get(route('home'));

        $response->assertStatus(200);
        $response->assertViewIs('frontend.home');
        $response->assertViewHas([
            'sections',
            'profile',
            'heroBanners',
            'highlights',
            'facilities',
            'featuredAchievements',
            'latestNews',
            'galleryItems',
            'testimonials',
            'activeAnnouncement',
            'activePeriod',
            'activePpdbPeriod',
            'phases',
        ]);
    }

    /**
     * Uji 2: Hero slider banner dinamis merender data dari CmsBanner dan CTA fleksibel.
     */
    public function test_home_page_renders_hero_banners_and_cta_dynamically(): void
    {
        $banner = CmsBanner::activeFor('home_hero')->first();
        $this->assertNotNull($banner, 'Harus ada banner aktif untuk home_hero');

        $response = $this->get(route('home'));
        $response->assertStatus(200);

        $response->assertSee($banner->title);
        if ($banner->badge_text) {
            $response->assertSee($banner->badge_text);
        }
        if ($banner->cta_primary_text) {
            $response->assertSee($banner->cta_primary_text);
        }
    }

    /**
     * Uji 3: Sambutan Kepala Sekolah dinamis dari profil sekolah (foto, kutipan, naskah).
     */
    public function test_home_page_renders_headmaster_welcome_dynamically(): void
    {
        $profile = SchoolProfile::first();
        $this->assertNotNull($profile, 'SchoolProfile harus ada');

        $response = $this->get(route('home'));
        $response->assertStatus(200);

        if (! empty($profile->headmaster_name)) {
            $response->assertSee($profile->headmaster_name);
        }
        if (! empty($profile->headmaster_welcome_quote)) {
            $response->assertSee($profile->headmaster_welcome_quote);
        }
    }

    /**
     * Uji 4: Kartu keunggulan pilar dan testimoni multi-kategori terbit di beranda.
     */
    public function test_home_page_renders_key_highlights_and_testimonials(): void
    {
        $highlight = CmsKeyHighlight::forTarget('home_pilar')->first();
        $testimonial = CmsTestimonial::forPlacement('home')->first();

        $response = $this->get(route('home'));
        $response->assertStatus(200);

        if ($highlight) {
            $response->assertSee($highlight->title);
            if ($highlight->metric_value) {
                $response->assertSee($highlight->metric_value);
            }
        }

        if ($testimonial) {
            $response->assertSee($testimonial->person_name);
            $response->assertSee(e($testimonial->testimonial_text));
        }
    }

    /**
     * Uji 5: Running ticker / alert bar pengumuman darurat tampil ketika aktif.
     */
    public function test_emergency_announcement_renders_when_active(): void
    {
        $activeAnnouncement = CmsAnnouncement::where('is_active', true)
            ->where('start_date', '<=', now())
            ->where('end_date', '>=', now())
            ->whereIn('placement_target', ['home_banner', 'global_topbar'])
            ->latest('created_at')
            ->first();

        if ($activeAnnouncement) {
            $response = $this->get(route('home'));
            $response->assertStatus(200);
            $response->assertSee($activeAnnouncement->title);
        } else {
            $this->markTestSkipped('Tidak ada pengumuman aktif untuk diuji.');
        }
    }

    /**
     * Uji 6: Pengecekan visibilitas section (is_visible toggle) berhasil menyembunyikan section di beranda.
     */
    public function test_section_visibility_toggle_hides_content_on_landing_page(): void
    {
        $section = CmsPageSection::where('page_code', 'home')
            ->where('section_key', 'testimonials')
            ->first();

        $this->assertNotNull($section, 'Section testimonials harus ada di cms_page_sections');

        // Pastikan awal terlihat
        $section->update(['is_visible' => true]);
        $response = $this->get(route('home'));
        $response->assertStatus(200);
        $response->assertSee($section->title ?: 'Kata Mereka Tentang Kami');

        // Sembunyikan section
        $section->update(['is_visible' => false]);
        $responseHidden = $this->get(route('home'));
        $responseHidden->assertStatus(200);
        $responseHidden->assertDontSee($section->title ?: 'Kata Mereka Tentang Kami');

        // Kembalikan ke true agar tidak mengganggu data
        $section->update(['is_visible' => true]);
    }

    /**
     * Uji 7: Halaman Login Filament kustom tampil dengan branding sekolah dan fitur isi cepat peran.
     */
    public function test_custom_filament_login_page_renders_and_supports_quick_role_autofill(): void
    {
        $response = $this->get('/admin/login');

        $response->assertStatus(200);
        $response->assertSee('Masuk ke Portal Manajemen');
        $response->assertSee('Portal Manajemen & CMS Terpadu Sekolah Dasar');
        $response->assertSee('Lihat Website Publik');

        Livewire::test(Login::class)
            ->call('fillRoleAccount', 'superadmin')
            ->assertSet('data.login', 'superadmin')
            ->assertSet('data.password', 'password123');
    }
}

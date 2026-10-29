<?php

namespace Tests\Feature;

use App\Filament\Resources\CmsAnnouncements\CmsAnnouncementResource;
use App\Filament\Resources\CmsBanners\CmsBannerResource;
use App\Filament\Resources\CmsKeyHighlights\CmsKeyHighlightResource;
use App\Filament\Resources\CmsPageSections\CmsPageSectionResource;
use App\Filament\Resources\CmsTestimonials\CmsTestimonialResource;
use App\Filament\Resources\SchoolProfiles\SchoolProfileResource;
use App\Models\CmsAnnouncement;
use App\Models\CmsBanner;
use App\Models\CmsKeyHighlight;
use App\Models\CmsPageSection;
use App\Models\CmsTestimonial;
use App\Models\SchoolProfile;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Tests\TestCase;

class CmsReusableFase1And2Test extends TestCase
{
    /**
     * Uji 1: Seluruh tabel CMS reusable dan data seeder Fase 1 tersimpan di database.
     */
    public function test_cms_database_tables_and_seeders_exist(): void
    {
        $this->assertGreaterThanOrEqual(10, CmsPageSection::count(), 'cms_page_sections harus memuat seeder section halaman');
        $this->assertGreaterThanOrEqual(3, CmsBanner::count(), 'cms_banners harus memuat seeder hero banner');
        $this->assertGreaterThanOrEqual(4, CmsKeyHighlight::count(), 'cms_key_highlights harus memuat seeder highlight');
        $this->assertGreaterThanOrEqual(3, CmsTestimonial::count(), 'cms_testimonials harus memuat seeder testimoni');
        $this->assertGreaterThanOrEqual(1, CmsAnnouncement::count(), 'cms_announcements harus memuat seeder pengumuman');

        $schoolProfile = SchoolProfile::first();
        $this->assertNotNull($schoolProfile, 'Profil sekolah harus ada di database');
        $this->assertNotEmpty($schoolProfile->headmaster_name, 'Kolom sambutan kepala sekolah harus terisi');
        $this->assertNotEmpty($schoolProfile->social_youtube, 'Kolom sosmed youtube harus terisi');
    }

    /**
     * Uji 2: Model Scopes dan Relasi CMS Reusable berfungsi sesuai spesifikasi.
     */
    public function test_cms_models_scopes_and_relationships(): void
    {
        // 1. CmsPageSection scope & helper
        $homeSections = CmsPageSection::getSectionsForPage('home');
        $this->assertIsArray($homeSections);
        $this->assertArrayHasKey('hero_slider', $homeSections);
        $this->assertArrayHasKey('highlights_metrics', $homeSections);
        $this->assertArrayHasKey('headmaster_welcome', $homeSections);

        // 2. CmsBanner scope
        $homeBanners = CmsBanner::activeFor('home_hero')->get();
        $this->assertNotEmpty($homeBanners, 'Scope activeFor(home_hero) harus mengembalikan banner hero');

        // 3. CmsKeyHighlight scope
        $highlights = CmsKeyHighlight::forPlacement('home_pilar')->get();
        $this->assertNotEmpty($highlights, 'Scope forPlacement(home_pilar) harus mengembalikan highlights');

        // 4. CmsTestimonial scope
        $testimonials = CmsTestimonial::forPlacement('home')->get();
        $this->assertNotEmpty($testimonials, 'Scope forPlacement(home) harus mengembalikan testimoni');

        // 5. CmsAnnouncement scope
        $announcements = CmsAnnouncement::forPlacement('home_banner')->get();
        $this->assertNotEmpty($announcements, 'Scope forPlacement(home_banner) harus mengembalikan pengumuman');

        // 6. SchoolProfile relation
        $schoolProfile = SchoolProfile::first();
        $this->assertTrue(method_exists($schoolProfile, 'headmasterPhoto'));
    }

    /**
     * Uji 3: RBAC Authorization pada 6 Filament CMS Resources (Fase 2).
     */
    public function test_filament_cms_resources_rbac(): void
    {
        $superadmin = User::where('role', 'superadmin')->first();
        $this->assertNotNull($superadmin);

        Auth::login($superadmin);

        // SchoolProfile: Singleton (tidak boleh create baru)
        $this->assertTrue(SchoolProfileResource::canViewAny());
        $this->assertFalse(SchoolProfileResource::canCreate(), 'SchoolProfileResource tidak boleh mengizinkan create (singleton)');
        $this->assertTrue(SchoolProfileResource::canEdit(SchoolProfile::first()));

        // CMS Resources dapat diakses superadmin
        $this->assertTrue(CmsPageSectionResource::canViewAny());
        $this->assertTrue(CmsPageSectionResource::canCreate());
        $this->assertTrue(CmsBannerResource::canViewAny());
        $this->assertTrue(CmsBannerResource::canCreate());
        $this->assertTrue(CmsKeyHighlightResource::canViewAny());
        $this->assertTrue(CmsKeyHighlightResource::canCreate());
        $this->assertTrue(CmsTestimonialResource::canViewAny());
        $this->assertTrue(CmsTestimonialResource::canCreate());
        $this->assertTrue(CmsAnnouncementResource::canViewAny());
        $this->assertTrue(CmsAnnouncementResource::canCreate());
    }

    /**
     * Uji 4: Akses HTTP ke seluruh index list resource CMS di panel admin Filament.
     */
    public function test_filament_cms_admin_pages_render_successfully(): void
    {
        $superadmin = User::where('role', 'superadmin')->first();
        $this->assertNotNull($superadmin);

        $responseProfiles = $this->actingAs($superadmin)->get('/admin/school-profiles');
        $responseProfiles->assertStatus(200);

        $responseSections = $this->actingAs($superadmin)->get('/admin/cms-page-sections');
        $responseSections->assertStatus(200);

        $responseBanners = $this->actingAs($superadmin)->get('/admin/cms-banners');
        $responseBanners->assertStatus(200);

        $responseHighlights = $this->actingAs($superadmin)->get('/admin/cms-key-highlights');
        $responseHighlights->assertStatus(200);

        $responseTestimonials = $this->actingAs($superadmin)->get('/admin/cms-testimonials');
        $responseTestimonials->assertStatus(200);

        $responseAnnouncements = $this->actingAs($superadmin)->get('/admin/cms-announcements');
        $responseAnnouncements->assertStatus(200);
    }
}

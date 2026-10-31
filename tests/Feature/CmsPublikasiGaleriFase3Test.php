<?php

namespace Tests\Feature;

use App\Filament\Resources\AchievementCategories\AchievementCategoryResource;
use App\Filament\Resources\Achievements\AchievementResource;
use App\Filament\Resources\CharacterHabits\CharacterHabitResource;
use App\Filament\Resources\Extracurriculars\ExtracurricularResource;
use App\Filament\Resources\Facilities\FacilityResource;
use App\Filament\Resources\FacilityCategories\FacilityCategoryResource;
use App\Filament\Resources\GalleryCategories\GalleryCategoryResource;
use App\Filament\Resources\GalleryItems\GalleryItemResource;
use App\Filament\Resources\MediaAssets\MediaAssetResource;
use App\Filament\Resources\NewsArticles\NewsArticleResource;
use App\Filament\Resources\NewsCategories\NewsCategoryResource;
use App\Models\Achievement;
use App\Models\AchievementCategory;
use App\Models\CharacterHabit;
use App\Models\Extracurricular;
use App\Models\Facility;
use App\Models\FacilityCategory;
use App\Models\GalleryCategory;
use App\Models\GalleryItem;
use App\Models\MediaAsset;
use App\Models\NewsArticle;
use App\Models\NewsCategory;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Tests\TestCase;

class CmsPublikasiGaleriFase3Test extends TestCase
{
    /**
     * Uji 1: Seluruh data publikasi, galeri, sarpras, dan kesiswaan ada di database.
     */
    public function test_publikasi_and_galeri_data_exist(): void
    {
        $this->assertGreaterThanOrEqual(1, NewsCategory::count(), 'NewsCategory harus ada');
        $this->assertGreaterThanOrEqual(1, NewsArticle::count(), 'NewsArticle harus ada');
        $this->assertGreaterThanOrEqual(1, AchievementCategory::count(), 'AchievementCategory harus ada');
        $this->assertGreaterThanOrEqual(1, Achievement::count(), 'Achievement harus ada');
        $this->assertGreaterThanOrEqual(1, GalleryCategory::count(), 'GalleryCategory harus ada');
        $this->assertGreaterThanOrEqual(1, GalleryItem::count(), 'GalleryItem harus ada');
        $this->assertGreaterThanOrEqual(1, FacilityCategory::count(), 'FacilityCategory harus ada');
        $this->assertGreaterThanOrEqual(1, Facility::count(), 'Facility harus ada');
        $this->assertGreaterThanOrEqual(1, Extracurricular::count(), 'Extracurricular harus ada');
        $this->assertGreaterThanOrEqual(1, CharacterHabit::count(), 'CharacterHabit harus ada');
        $this->assertGreaterThanOrEqual(1, MediaAsset::count(), 'MediaAsset harus ada');
    }

    /**
     * Uji 2: Hak akses RBAC Superadmin terhadap seluruh resource Publikasi & Galeri.
     */
    public function test_superadmin_has_full_access(): void
    {
        $superadmin = User::where('role', 'superadmin')->first();
        $this->assertNotNull($superadmin);
        Auth::login($superadmin);

        $resources = [
            NewsArticleResource::class,
            NewsCategoryResource::class,
            AchievementResource::class,
            AchievementCategoryResource::class,
            GalleryItemResource::class,
            GalleryCategoryResource::class,
            FacilityResource::class,
            FacilityCategoryResource::class,
            ExtracurricularResource::class,
            CharacterHabitResource::class,
            MediaAssetResource::class,
        ];

        foreach ($resources as $res) {
            $this->assertTrue($res::canViewAny(), "Superadmin harus bisa viewAny {$res}");
            $this->assertTrue($res::canCreate(), "Superadmin harus bisa create {$res}");
            $this->assertTrue($res::canEdit(null), "Superadmin harus bisa edit {$res}");
            $this->assertTrue($res::canDelete(null), "Superadmin harus bisa delete {$res}");
        }
    }

    /**
     * Uji 3: Hak akses RBAC Guru Humas (Pengelola Publikasi & Galeri).
     */
    public function test_guru_humas_rbac_permissions(): void
    {
        $humas = User::where('role', 'guru_humas')->first();
        if (! $humas) {
            $humas = User::create([
                'username' => 'guru_humas_test',
                'password_hash' => bcrypt('password'),
                'full_name' => 'Guru Humas Test',
                'email' => 'humas_test@sdncikereteg01.sch.id',
                'role' => 'guru_humas',
                'is_active' => true,
            ]);
        }

        Auth::login($humas);

        // Pengelola Utama Publikasi & Galeri
        $this->assertTrue(NewsArticleResource::canCreate());
        $this->assertTrue(NewsArticleResource::canEdit(null));
        $this->assertFalse(NewsArticleResource::canDelete(null));

        $this->assertTrue(AchievementResource::canCreate());
        $this->assertTrue(GalleryItemResource::canCreate());
        $this->assertTrue(ExtracurricularResource::canCreate());
        $this->assertTrue(CharacterHabitResource::canCreate());
        $this->assertTrue(MediaAssetResource::canCreate());

        // Sarpras: Hanya Baca Saja untuk Humas
        $this->assertTrue(FacilityResource::canViewAny());
        $this->assertFalse(FacilityResource::canCreate(), 'Guru Humas tidak boleh create fasilitas');
        $this->assertFalse(FacilityResource::canEdit(null), 'Guru Humas tidak boleh edit fasilitas');
    }

    /**
     * Uji 4: Hak akses RBAC Admin TU (Pengelola Utama Sarpras & Baca Saja Publikasi).
     */
    public function test_admin_tu_rbac_permissions(): void
    {
        $adminTu = User::where('role', 'admin_tu')->first();
        if (! $adminTu) {
            $adminTu = User::create([
                'username' => 'admin_tu_test',
                'password_hash' => bcrypt('password'),
                'full_name' => 'Admin TU Test',
                'email' => 'tu_test@sdncikereteg01.sch.id',
                'role' => 'admin_tu',
                'is_active' => true,
            ]);
        }

        Auth::login($adminTu);

        // Sarpras: Pengelola Utama untuk TU
        $this->assertTrue(FacilityResource::canViewAny());
        $this->assertTrue(FacilityResource::canCreate());
        $this->assertTrue(FacilityResource::canEdit(null));
        $this->assertFalse(FacilityResource::canDelete(null));

        // Publikasi: Baca Saja
        $this->assertTrue(NewsArticleResource::canViewAny());
        $this->assertFalse(NewsArticleResource::canCreate(), 'TU tidak boleh create berita');
        $this->assertFalse(NewsArticleResource::canEdit(null), 'TU tidak boleh edit berita');

        $this->assertTrue(AchievementResource::canViewAny());
        $this->assertFalse(AchievementResource::canCreate());

        // Media Asset: TU boleh upload
        $this->assertTrue(MediaAssetResource::canViewAny());
        $this->assertTrue(MediaAssetResource::canCreate());
    }

    /**
     * Uji 5: Hak akses RBAC Panitia PPDB (Hanya Media Asset, tidak ada akses ke Berita/Galeri/Sarpras).
     */
    public function test_panitia_ppdb_rbac_permissions(): void
    {
        $ppdb = User::where('role', 'panitia_ppdb')->first();
        if (! $ppdb) {
            $ppdb = User::create([
                'username' => 'panitia_ppdb_test',
                'password_hash' => bcrypt('password'),
                'full_name' => 'Panitia PPDB Test',
                'email' => 'ppdb_test@sdncikereteg01.sch.id',
                'role' => 'panitia_ppdb',
                'is_active' => true,
            ]);
        }

        Auth::login($ppdb);

        $this->assertFalse(NewsArticleResource::canViewAny());
        $this->assertFalse(AchievementResource::canViewAny());
        $this->assertFalse(GalleryItemResource::canViewAny());
        $this->assertFalse(FacilityResource::canViewAny());
        $this->assertFalse(ExtracurricularResource::canViewAny());
        $this->assertFalse(CharacterHabitResource::canViewAny());

        // PPDB dapat mengunggah berkas di MediaAsset
        $this->assertTrue(MediaAssetResource::canViewAny());
        $this->assertTrue(MediaAssetResource::canCreate());
    }

    /**
     * Uji 6: Akses HTTP ke seluruh daftar list halaman Resource Publikasi & Galeri di Admin Panel.
     */
    public function test_filament_admin_pages_render_successfully(): void
    {
        $superadmin = User::where('role', 'superadmin')->first();
        $this->assertNotNull($superadmin);

        $endpoints = [
            '/admin/news-articles',
            '/admin/news-categories',
            '/admin/achievements',
            '/admin/achievement-categories',
            '/admin/gallery-items',
            '/admin/gallery-categories',
            '/admin/facilities',
            '/admin/facility-categories',
            '/admin/extracurriculars',
            '/admin/character-habits',
            '/admin/media-assets',
        ];

        foreach ($endpoints as $url) {
            $response = $this->actingAs($superadmin)->get($url);
            $response->assertStatus(200);
        }
    }
}

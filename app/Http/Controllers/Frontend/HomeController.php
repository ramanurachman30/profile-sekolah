<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Achievement;
use App\Models\CmsAnnouncement;
use App\Models\CmsBanner;
use App\Models\CmsKeyHighlight;
use App\Models\CmsPageSection;
use App\Models\CmsTestimonial;
use App\Models\CurriculumPhase;
use App\Models\Facility;
use App\Models\GalleryItem;
use App\Models\NewsArticle;
use App\Models\PpdbPeriod;
use App\Models\SchoolProfile;
use App\Models\Teacher;
use Illuminate\View\View;

class HomeController extends Controller
{
    public function index(): View
    {
        // 1. Ambil peta konfigurasi section beranda (tampil/sembunyi & judul dinamis)
        $sections = CmsPageSection::getSectionsForPage('home');

        // 2. Profil Sekolah & Sambutan Kepala Sekolah (Single source of truth)
        $profile = SchoolProfile::with(['logo', 'headmasterPhoto'])->first();

        // 3. Hero Slider Banner Beranda (Reusable scope)
        $heroBanners = CmsBanner::activeFor('home_hero')
            ->with('mediaAsset')
            ->get();

        // 4. Pilar Keunggulan & Metrik
        $highlights = CmsKeyHighlight::forTarget('home_pilar')->get();

        // 5. Fasilitas Fisik Pilihan
        $facilities = Facility::with(['category', 'cover'])
            ->orderBy('sort_order')
            ->take(4)
            ->get();

        // 6. Prestasi Siswa Featured
        $featuredAchievements = Achievement::where('is_featured', true)
            ->latest('competition_date')
            ->take(3)
            ->with(['category', 'photo', 'mentorTeacher'])
            ->get();

        // 7. Warta Berita Terbit
        $latestNews = NewsArticle::published()
            ->take(3)
            ->with(['category', 'author', 'cover'])
            ->get();

        // 8. Dokumentasi Galeri
        $galleryItems = GalleryItem::published()
            ->take(6)
            ->with(['category', 'mediaAsset'])
            ->get();

        // 9. Testimoni Pilihan Beranda
        $testimonials = CmsTestimonial::forPlacement('home')
            ->take(4)
            ->with('avatar')
            ->get();

        // 10. Pengumuman Aktif Beranda / Topbar
        $activeAnnouncement = CmsAnnouncement::where('is_active', true)
            ->where('start_date', '<=', now())
            ->where('end_date', '>=', now())
            ->whereIn('placement_target', ['home_banner', 'global_topbar'])
            ->latest('created_at')
            ->first();

        // 11. Periode PPDB Berjalan
        $activePeriod = PpdbPeriod::with('academicYear')
            ->where('is_open', true)
            ->first();
        $activePpdbPeriod = $activePeriod;

        // 12. Fase Kurikulum & Dewan Guru
        $phases = CurriculumPhase::with('grades')->get();
        $featuredTeachers = Teacher::where('is_active', true)
            ->orderBy('sort_order')
            ->take(4)
            ->get();

        return view('frontend.home', compact(
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
            'featuredTeachers'
        ));
    }
}

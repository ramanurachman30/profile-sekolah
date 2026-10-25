<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Achievement;
use App\Models\CurriculumPhase;
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
        $profile = SchoolProfile::first();
        
        $featuredAchievements = Achievement::with(['category', 'photo', 'mentorTeacher'])
            ->where('is_featured', 1)
            ->latest('competition_date')
            ->take(3)
            ->get();

        $latestNews = NewsArticle::with(['category', 'cover'])
            ->published()
            ->take(3)
            ->get();

        $galleryItems = GalleryItem::with(['category', 'mediaAsset'])
            ->where('is_published', 1)
            ->latest('event_date')
            ->take(6)
            ->get();

        $activePeriod = PpdbPeriod::with('academicYear')
            ->where('is_open', 1)
            ->first();

        $phases = CurriculumPhase::with('grades')->get();
        $featuredTeachers = Teacher::where('is_active', 1)->orderBy('sort_order')->take(4)->get();

        return view('frontend.home', compact(
            'profile',
            'featuredAchievements',
            'latestNews',
            'galleryItems',
            'activePeriod',
            'phases',
            'featuredTeachers'
        ));
    }
}

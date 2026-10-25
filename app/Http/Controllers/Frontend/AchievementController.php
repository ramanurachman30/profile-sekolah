<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Achievement;
use App\Models\AchievementCategory;
use Illuminate\Http\Request;
use Illuminate\View\View;

class AchievementController extends Controller
{
    public function index(Request $request): View
    {
        $categories = AchievementCategory::all();

        $query = Achievement::with(['category', 'photo', 'mentorTeacher']);

        if ($request->filled('category') && $request->category !== 'all') {
            $query->whereHas('category', function ($q) use ($request) {
                $q->where('slug', $request->category);
            });
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('achievement_title', 'like', "%{$search}%")
                  ->orWhere('competition_name', 'like', "%{$search}%")
                  ->orWhere('recipient_summary', 'like', "%{$search}%");
            });
        }

        $achievements = $query->latest('competition_date')->get();

        return view('frontend.achievements', compact('categories', 'achievements'));
    }
}

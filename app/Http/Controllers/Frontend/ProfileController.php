<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\SchoolProfile;
use App\Models\Teacher;
use Illuminate\View\View;

class ProfileController extends Controller
{
    public function index(): View
    {
        $profile = SchoolProfile::first();
        $teachers = Teacher::with('photo')
            ->where('is_active', 1)
            ->orderBy('sort_order')
            ->get();

        return view('frontend.profile', compact('profile', 'teachers'));
    }
}

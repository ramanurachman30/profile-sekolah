<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\CharacterHabit;
use App\Models\Extracurricular;
use Illuminate\View\View;

class StudentAffairController extends Controller
{
    public function index(): View
    {
        $habits = CharacterHabit::with('cover')
            ->where('is_active', 1)
            ->orderBy('sort_order')
            ->get();

        $extracurriculars = Extracurricular::with(['cover', 'instructorTeacher'])
            ->where('is_active', 1)
            ->orderBy('sort_order')
            ->get();

        return view('frontend.student-affairs', compact('habits', 'extracurriculars'));
    }
}

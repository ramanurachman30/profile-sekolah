<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\CurriculumPhase;
use App\Models\Grade;
use App\Models\Subject;
use Illuminate\View\View;

class AcademicController extends Controller
{
    public function index(): View
    {
        $phases = CurriculumPhase::with('grades')->get();
        $grades = Grade::with('phase')->orderBy('grade_level')->get();
        $subjects = Subject::orderBy('category')->orderBy('id')->get();

        return view('frontend.academic', compact('phases', 'grades', 'subjects'));
    }
}

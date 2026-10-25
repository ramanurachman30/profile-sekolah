<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Facility;
use App\Models\FacilityCategory;
use Illuminate\View\View;

class FacilityController extends Controller
{
    public function index(): View
    {
        $categories = FacilityCategory::with(['facilities' => function ($q) {
            $q->orderBy('sort_order')->with('cover');
        }])->get();

        $facilities = Facility::with(['category', 'cover'])
            ->orderBy('sort_order')
            ->get();

        return view('frontend.facilities', compact('categories', 'facilities'));
    }
}

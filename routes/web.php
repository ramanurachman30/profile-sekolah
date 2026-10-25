<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes - Portal Publik SDN Cikereteg 01
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return view('frontend.home');
})->name('home');

Route::get('/profil', function () {
    return view('frontend.profile');
})->name('profile');

Route::get('/akademik', function () {
    return view('frontend.academic');
})->name('academic');

Route::get('/kesiswaan', function () {
    return view('frontend.student-affairs');
})->name('student-affairs');

Route::get('/fasilitas', function () {
    return view('frontend.facilities');
})->name('facilities');

Route::get('/prestasi', function () {
    return view('frontend.achievements');
})->name('achievements');

Route::get('/berita', function () {
    return view('frontend.news.index');
})->name('news.index');

Route::get('/berita/{slug}', function ($slug) {
    return view('frontend.news.show', ['slug' => $slug]);
})->name('news.show');

Route::get('/galeri', function () {
    return view('frontend.gallery');
})->name('gallery');

Route::get('/ppdb', function () {
    return view('frontend.ppdb.index');
})->name('ppdb.index');

Route::get('/kontak', function () {
    return view('frontend.contact');
})->name('contact.index');

<?php

use App\Http\Controllers\Frontend\AcademicController;
use App\Http\Controllers\Frontend\AchievementController;
use App\Http\Controllers\Frontend\ContactController;
use App\Http\Controllers\Frontend\FacilityController;
use App\Http\Controllers\Frontend\GalleryController;
use App\Http\Controllers\Frontend\HomeController;
use App\Http\Controllers\Frontend\NewsController;
use App\Http\Controllers\Frontend\PpdbController;
use App\Http\Controllers\Frontend\ProfileController;
use App\Http\Controllers\Frontend\StudentAffairController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes - Portal Publik SDN Cikereteg 01
|--------------------------------------------------------------------------
*/

// Beranda
Route::get('/', [HomeController::class, 'index'])->name('home');

// Profil Sekolah & Dewan Guru
Route::get('/profil', [ProfileController::class, 'index'])->name('profile');

// Akademik & Kurikulum Merdeka
Route::get('/akademik', [AcademicController::class, 'index'])->name('academic');

// Kesiswaan, 5S & Ekstrakurikuler
Route::get('/kesiswaan', [StudentAffairController::class, 'index'])->name('student-affairs');

// Fasilitas & Sarana Prasarana
Route::get('/fasilitas', [FacilityController::class, 'index'])->name('facilities');

// Prestasi & Showcase Siswa
Route::get('/prestasi', [AchievementController::class, 'index'])->name('achievements');

// Warta Berita & Agenda
Route::get('/berita', [NewsController::class, 'index'])->name('news.index');
Route::get('/berita/{slug}', [NewsController::class, 'show'])->name('news.show');

// Dokumentasi Galeri
Route::get('/galeri', [GalleryController::class, 'index'])->name('gallery');

// PPDB SD Online Terpadu
Route::get('/ppdb', [PpdbController::class, 'index'])->name('ppdb.index');
Route::post('/ppdb/daftar', [PpdbController::class, 'store'])->name('ppdb.store');
Route::get('/ppdb/sukses/{registrationNumber}', [PpdbController::class, 'success'])->name('ppdb.success');

// Kontak, Layanan Pesan & Reservasi Kunjungan
Route::get('/kontak', [ContactController::class, 'index'])->name('contact.index');
Route::post('/kontak/pesan', [ContactController::class, 'storeInquiry'])->name('contact.inquiry.store');
Route::post('/kontak/kunjungan', [ContactController::class, 'storeVisit'])->name('contact.visit.store');

<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Http\Requests\Frontend\StorePpdbRegistrationRequest;
use App\Models\PpdbPeriod;
use App\Models\PpdbRegistration;
use App\Models\SchoolProfile;
use App\Services\MediaAssetService;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;
use Throwable;

class PpdbController extends Controller
{
    public function index(): View
    {
        $activePeriod = PpdbPeriod::with('academicYear')
            ->where('is_open', 1)
            ->first();

        $profile = SchoolProfile::first();

        $numA = random_int(2, 9);
        $numB = random_int(1, 8);
        session(['ppdb_math_answer' => $numA + $numB]);

        $mathQuestion = "Berapa hasil dari {$numA} + {$numB}?";
        $formRenderedAt = Crypt::encryptString((string) now()->timestamp);

        return view('frontend.ppdb.index', compact(
            'activePeriod',
            'profile',
            'mathQuestion',
            'formRenderedAt'
        ));
    }

    public function store(StorePpdbRegistrationRequest $request, MediaAssetService $mediaService): JsonResponse|RedirectResponse
    {
        $validated = $request->validated();

        // Hitung umur anak per 1 Juli tahun berjalan
        $birthDate = Carbon::parse($validated['child_birth_date']);
        $referenceDate = Carbon::create((int) date('Y'), 7, 1);
        $diff = $birthDate->diff($referenceDate);
        $childAgeYears = $diff->y;
        $childAgeMonths = $diff->m;

        // Generate Nomor Registrasi Unik (PPDB-SD-YYYY-XXXX) & Simpan dalam Transaksi Database Atomik
        $uploadedFilePaths = [];

        try {
            $registration = DB::transaction(function () use (
                $request,
                $mediaService,
                $validated,
                $childAgeYears,
                $childAgeMonths,
                &$uploadedFilePaths
            ): PpdbRegistration {
                $year = date('Y');
                $lastRegistration = PpdbRegistration::where('registration_number', 'like', "PPDB-SD-{$year}-%")
                    ->lockForUpdate()
                    ->orderBy('id', 'desc')
                    ->first();

                $nextNumber = 1;
                if ($lastRegistration && preg_match('/-(\d+)$/', $lastRegistration->registration_number, $matches)) {
                    $nextNumber = (int) $matches[1] + 1;
                }
                $regNumber = sprintf('PPDB-SD-%s-%04d', $year, $nextNumber);

                // Upload Berkas via MediaAssetService dengan penamaan UUID acak
                $kkAssetId = null;
                if ($request->hasFile('document_kk')) {
                    $kkAsset = $mediaService->upload(
                        $request->file('document_kk'),
                        'KK - '.$validated['child_full_name'],
                        'public',
                        'ppdb',
                        'ppdb'
                    );
                    $uploadedFilePaths[] = $kkAsset->file_path;
                    $kkAssetId = $kkAsset->id;
                }

                $aktaAssetId = null;
                if ($request->hasFile('document_akta')) {
                    $aktaAsset = $mediaService->upload(
                        $request->file('document_akta'),
                        'Akta - '.$validated['child_full_name'],
                        'public',
                        'ppdb',
                        'ppdb'
                    );
                    $uploadedFilePaths[] = $aktaAsset->file_path;
                    $aktaAssetId = $aktaAsset->id;
                }

                $kiaAssetId = null;
                if ($request->hasFile('document_kia')) {
                    $kiaAsset = $mediaService->upload(
                        $request->file('document_kia'),
                        'KIA - '.$validated['child_full_name'],
                        'public',
                        'ppdb',
                        'ppdb'
                    );
                    $uploadedFilePaths[] = $kiaAsset->file_path;
                    $kiaAssetId = $kiaAsset->id;
                }

                return PpdbRegistration::create([
                    'period_id' => $validated['period_id'],
                    'registration_number' => $regNumber,
                    'track' => $validated['track'],
                    'child_full_name' => $validated['child_full_name'],
                    'child_nik' => $validated['child_nik'],
                    'child_gender' => $validated['child_gender'],
                    'child_birth_place' => $validated['child_birth_place'],
                    'child_birth_date' => $validated['child_birth_date'],
                    'child_age_years' => $childAgeYears,
                    'child_age_months' => $childAgeMonths,
                    'parent_name' => $validated['parent_name'],
                    'parent_nik' => $validated['parent_nik'] ?? $validated['child_nik'],
                    'parent_phone' => $validated['parent_phone'],
                    'parent_email' => $validated['parent_email'] ?? null,
                    'parent_occupation' => $validated['parent_occupation'] ?? null,
                    'home_address' => $validated['home_address'],
                    'distance_meters' => $validated['distance_meters'] ?? null,
                    'document_kk_asset_id' => $kkAssetId,
                    'document_akta_asset_id' => $aktaAssetId,
                    'document_kia_asset_id' => $kiaAssetId,
                    'verification_status' => 'menunggu',
                ]);
            });
        } catch (Throwable $exception) {
            foreach ($uploadedFilePaths as $filePath) {
                if (Storage::disk('public')->exists($filePath)) {
                    Storage::disk('public')->delete($filePath);
                }
            }

            throw $exception;
        }

        $regNumber = $registration->registration_number;

        $profile = SchoolProfile::first();
        $cleanPhone = preg_replace('/[^0-9]/', '', $profile->whatsapp ?? '6281234567890');
        $waMessage = rawurlencode(
            "Halo Panitia PPDB SDN Cikereteg 01, saya ingin konfirmasi pendaftaran calon siswa:\n".
            "No. Registrasi: {$regNumber}\n".
            "Nama Anak: {$validated['child_full_name']}\n".
            'Jalur: '.ucfirst($validated['track'])."\n".
            "Nama Wali: {$validated['parent_name']}\n".
            'Terima kasih.'
        );
        $waUrl = "https://wa.me/{$cleanPhone}?text={$waMessage}";

        if ($request->expectsJson() || $request->ajax()) {
            return response()->json([
                'success' => true,
                'registration_number' => $regNumber,
                'child_name' => $validated['child_full_name'],
                'track' => $registration->track_label,
                'whatsapp_url' => $waUrl,
                'redirect_url' => route('ppdb.success', $regNumber),
            ]);
        }

        return redirect()->route('ppdb.success', $regNumber)->with([
            'success' => 'Pendaftaran online berhasil dikirim.',
            'wa_url' => $waUrl,
        ]);
    }

    public function success(string $registrationNumber): View
    {
        $registration = PpdbRegistration::with(['period.academicYear', 'documentKk', 'documentAkta'])
            ->where('registration_number', $registrationNumber)
            ->firstOrFail();

        $profile = SchoolProfile::first();
        $cleanPhone = preg_replace('/[^0-9]/', '', $profile->whatsapp ?? '6281234567890');
        $waMessage = rawurlencode(
            "Halo Panitia PPDB SDN Cikereteg 01, saya ingin konfirmasi pendaftaran calon siswa:\n".
            "No. Registrasi: {$registration->registration_number}\n".
            "Nama Anak: {$registration->child_full_name}\n".
            'Jalur: '.$registration->track_label."\n".
            "Nama Wali: {$registration->parent_name}\n".
            'Terima kasih.'
        );
        $waUrl = "https://wa.me/{$cleanPhone}?text={$waMessage}";

        return view('frontend.ppdb.success', compact('registration', 'profile', 'waUrl'));
    }
}

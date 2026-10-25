<?php

namespace Tests\Feature;

use App\Models\NewsArticle;
use App\Models\PpdbPeriod;
use App\Models\PpdbRegistration;
use App\Models\Student;
use App\Models\User;
use App\Services\PpdbEnrollmentService;
use Tests\TestCase;

class Phase5And6IntegrationTest extends TestCase
{
    /**
     * Test Fase 5: Semua halaman portal publik sekolah merespons status HTTP 200.
     */
    public function test_all_fase_5_public_pages_return_status_200(): void
    {
        $urls = [
            '/',
            '/profil',
            '/akademik',
            '/kesiswaan',
            '/fasilitas',
            '/prestasi',
            '/berita',
            '/galeri',
            '/ppdb',
            '/kontak',
        ];

        foreach ($urls as $url) {
            $response = $this->get($url);
            $response->assertStatus(200);
        }

        // Test detail artikel berita
        $news = NewsArticle::first();
        if ($news) {
            $detailResponse = $this->get('/berita/' . $news->slug);
            $detailResponse->assertStatus(200);
            $detailResponse->assertSee($news->title);
        }
    }

    /**
     * Test Fase 6: Alur Pendaftaran PPDB Frontoffice ke Database.
     */
    public function test_ppdb_registration_submission_and_success_flow(): void
    {
        $period = PpdbPeriod::first();
        $this->assertNotNull($period, 'PPDB Period must exist');

        $childNik = '320199' . rand(1000000000, 9999999999);
        $payload = [
            'period_id' => $period->id,
            'child_full_name' => 'Ahmad Fathir Al-Ghifari',
            'child_nik' => (string) $childNik,
            'child_gender' => 'L',
            'child_birth_place' => 'Bogor',
            'child_birth_date' => '2019-05-14',
            'track' => 'zonasi',
            'parent_name' => 'Bpk. Ahmad Suherman',
            'parent_nik' => '3201991234567890',
            'parent_phone' => '081298765432',
            'parent_email' => 'ortu.fathir@gmail.com',
            'parent_occupation' => 'Wiraswasta',
            'home_address' => 'Kp. Cikereteg Girang RT 02/03 Desa Cikereteg',
            'distance_meters' => 350,
        ];

        $response = $this->post('/ppdb/daftar', $payload);

        $registration = PpdbRegistration::where('child_nik', $childNik)->first();
        $this->assertNotNull($registration, 'Registration record must be created');
        $this->assertEquals('menunggu', $registration->verification_status);
        $this->assertStringStartsWith('PPDB-SD-', $registration->registration_number);

        // Harus redirect ke halaman sukses dengan nomor registrasi yang sesuai
        $response->assertRedirect(route('ppdb.success', $registration->registration_number));

        // Buka halaman bukti sukses
        $successPage = $this->get(route('ppdb.success', $registration->registration_number));
        $successPage->assertStatus(200);
        $successPage->assertSee($registration->registration_number);
        $successPage->assertSee('Ahmad Fathir Al-Ghifari');
        $successPage->assertSee('Konfirmasi ke WhatsApp Panitia PPDB');
    }

    /**
     * Test Fase 6: Alur Backoffice Persetujuan PPDB & Auto-Enroll ke Master Siswa.
     */
    public function test_ppdb_enrollment_service_accepts_and_creates_student(): void
    {
        $registration = PpdbRegistration::where('verification_status', 'menunggu')->first();
        $this->assertNotNull($registration, 'Pending registration must exist');

        $enrollmentService = app(PpdbEnrollmentService::class);
        $student = $enrollmentService->acceptRegistration($registration, 1);

        $this->assertInstanceOf(Student::class, $student);
        $this->assertEquals('aktif', $student->status);
        $this->assertEquals($registration->child_nik, $student->nik);
        $this->assertEquals($registration->child_full_name, $student->full_name);

        $registration->refresh();
        $this->assertEquals('diterima', $registration->verification_status);
        $this->assertEquals($student->id, $registration->enrolled_student_id);
    }

    /**
     * Test Fase 6: Alur Backoffice Penolakan PPDB dengan Alasan.
     */
    public function test_ppdb_enrollment_service_can_reject_registration(): void
    {
        $period = PpdbPeriod::first();
        $childNik = '320188' . rand(1000000000, 9999999999);

        $registration = PpdbRegistration::create([
            'period_id' => $period->id,
            'registration_number' => 'PPDB-SD-REJECT-' . \Illuminate\Support\Str::random(8),
            'track' => 'zonasi',
            'child_full_name' => 'Calon Siswa Uji Tolak',
            'child_nik' => (string) $childNik,
            'child_gender' => 'P',
            'child_birth_place' => 'Bogor',
            'child_birth_date' => '2021-01-01',
            'child_age_years' => 5,
            'child_age_months' => 6,
            'parent_name' => 'Wali Uji Tolak',
            'parent_nik' => (string) $childNik,
            'parent_phone' => '081234567899',
            'home_address' => 'Jl. Cikereteg',
            'verification_status' => 'menunggu',
        ]);

        $enrollmentService = app(PpdbEnrollmentService::class);
        $enrollmentService->rejectRegistration($registration, 'Usia belum mencapai batas minimal 6 tahun per 1 Juli.', 1);

        $registration->refresh();
        $this->assertEquals('ditolak', $registration->verification_status);
        $this->assertEquals('Usia belum mencapai batas minimal 6 tahun per 1 Juli.', $registration->rejection_reason);
    }

    /**
     * Test Fase 6: Akses Filament Admin Panel untuk Panitia PPDB.
     */
    public function test_panitia_ppdb_can_access_filament_ppdb_resources(): void
    {
        $panitia = User::where('role', 'panitia_ppdb')->first();
        $this->assertNotNull($panitia, 'Panitia PPDB user must exist');

        $response = $this->actingAs($panitia)->get('/admin/ppdb-registrations');
        $response->assertStatus(200);

        $periodResponse = $this->actingAs($panitia)->get('/admin/ppdb-periods');
        $periodResponse->assertStatus(200);
    }
}

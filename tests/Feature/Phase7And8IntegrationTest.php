<?php

namespace Tests\Feature;

use App\Filament\Resources\ClassRooms\ClassRoomResource;
use App\Filament\Resources\ContactInquiries\ContactInquiryResource;
use App\Filament\Resources\SchoolVisits\SchoolVisitResource;
use App\Filament\Resources\Students\StudentResource;
use App\Filament\Resources\Teachers\TeacherResource;
use App\Models\ContactInquiry;
use App\Models\SchoolVisit;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Tests\TestCase;

class Phase7And8IntegrationTest extends TestCase
{
    /**
     * Uji 1: Halaman Kontak Publik merender profil dan kedua form layanan (Pesan & Kunjungan)
     */
    public function test_contact_page_renders_with_profile_and_both_service_forms(): void
    {
        $response = $this->get('/kontak');

        $response->assertStatus(200);
        $response->assertSee('Hubungi SDN Cikereteg 01');
        $response->assertSee('Kirim Pesan');
        $response->assertSee('Reservasi School Visit');
        $response->assertSee('form-pesan');
        $response->assertSee('form-kunjungan');
    }

    /**
     * Uji 2: Pengajuan pesan orang tua berhasil menerbitkan tiket PESAN-SD-YYYY-xxxx
     */
    public function test_inquiry_submission_creates_ticket_and_stores_in_database(): void
    {
        $postData = [
            'sender_name' => 'Bapak Ahmad Fauzi',
            'sender_phone' => '081298765432',
            'sender_email' => 'ahmad.fauzi@gmail.com',
            'category' => 'administrasi',
            'subject' => 'Permohonan Legalisir Ijazah',
            'message' => 'Mohon info syarat dan jadwal legalisir ijazah alumni untuk keperluan pendaftaran SMP.',
            'preferred_channel' => 'whatsapp',
        ];

        $response = $this->post('/kontak/pesan', $postData);

        $response->assertRedirect('/kontak#form-pesan');
        $response->assertSessionHas('inquiry_success');

        $this->assertDatabaseHas('trn_contact_inquiries', [
            'sender_name' => 'Bapak Ahmad Fauzi',
            'sender_phone' => '081298765432',
            'category' => 'administrasi',
            'ticket_status' => 'baru',
        ]);

        $inquiry = ContactInquiry::where('sender_name', 'Bapak Ahmad Fauzi')->latest('id')->first();
        $this->assertNotNull($inquiry);
        $currentYear = Carbon::now()->year;
        $this->assertMatchesRegularExpression("/^PESAN-SD-{$currentYear}-\\d{4}$/", $inquiry->ticket_number);
    }

    /**
     * Uji 3: Reservasi School Visit berhasil menerbitkan kode booking KUNJUNGAN-SD-YYYY-xxxx
     */
    public function test_school_visit_reservation_creates_booking_code_and_stores_in_database(): void
    {
        $tomorrow = Carbon::tomorrow()->format('Y-m-d');
        $postData = [
            'parent_name' => 'Ibu Ratna Dewi',
            'parent_phone' => '085712349988',
            'visit_date' => $tomorrow,
            'visit_session' => 'pagi',
            'attendees_count' => 2,
            'grade_interest' => 'kelas_1',
            'internal_notes' => 'Ingin melihat sarana kelas 1 dan perpustakaan ramah anak.',
        ];

        $response = $this->post('/kontak/kunjungan', $postData);

        $response->assertRedirect('/kontak#form-kunjungan');
        $response->assertSessionHas('visit_success');

        $this->assertDatabaseHas('trn_school_visits', [
            'parent_name' => 'Ibu Ratna Dewi',
            'parent_phone' => '085712349988',
            'visit_session' => 'pagi',
            'visit_status' => 'menunggu',
        ]);

        $visit = SchoolVisit::where('parent_name', 'Ibu Ratna Dewi')->latest('id')->first();
        $this->assertNotNull($visit);
        $currentYear = Carbon::now()->year;
        $this->assertMatchesRegularExpression("/^KUNJUNGAN-SD-{$currentYear}-\\d{4}$/", $visit->booking_code);
    }

    /**
     * Uji 4: Otorisasi RBAC Backoffice Filament untuk Layanan Pesan & Kunjungan (Fase 7)
     */
    public function test_filament_service_resources_rbac_authorization(): void
    {
        $adminTu = User::where('role', 'admin_tu')->first();
        $guruHumas = User::where('role', 'guru_humas')->first();

        // Staf TU memiliki akses ke tiket aduan dan reservasi kunjungan
        Auth::login($adminTu);
        $this->assertTrue(ContactInquiryResource::canViewAny());
        $this->assertTrue(ContactInquiryResource::canEdit(new ContactInquiry()));
        $this->assertTrue(SchoolVisitResource::canViewAny());
        $this->assertTrue(SchoolVisitResource::canEdit(new SchoolVisit()));

        // Guru Humas memiliki akses baca/disposisi tiket pesan, tapi tidak ke reservasi kunjungan
        Auth::login($guruHumas);
        $this->assertTrue(ContactInquiryResource::canViewAny());
        $this->assertFalse(SchoolVisitResource::canViewAny());
    }

    /**
     * Uji 5: Otorisasi RBAC Backoffice Filament untuk Modul Master & Kepegawaian (Fase 8)
     */
    public function test_filament_master_resources_rbac_authorization(): void
    {
        $adminTu = User::where('role', 'admin_tu')->first();
        $guruHumas = User::where('role', 'guru_humas')->first();

        // Staf TU memiliki hak CRUD penuh di Master Guru, Rombel, dan Siswa
        Auth::login($adminTu);
        $this->assertTrue(TeacherResource::canViewAny());
        $this->assertTrue(TeacherResource::canCreate());
        $this->assertTrue(ClassRoomResource::canViewAny());
        $this->assertTrue(ClassRoomResource::canCreate());
        $this->assertTrue(StudentResource::canViewAny());
        $this->assertTrue(StudentResource::canCreate());

        // Guru Humas hanya memiliki hak Baca (Read-only)
        Auth::login($guruHumas);
        $this->assertTrue(TeacherResource::canViewAny());
        $this->assertFalse(TeacherResource::canCreate());
        $this->assertTrue(ClassRoomResource::canViewAny());
        $this->assertFalse(ClassRoomResource::canCreate());
        $this->assertTrue(StudentResource::canViewAny());
        $this->assertFalse(StudentResource::canCreate());
    }
}

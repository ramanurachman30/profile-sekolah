<?php

namespace Tests\Feature;

use App\Models\NewsArticle;
use App\Models\PpdbPeriod;
use App\Models\PpdbRegistration;
use App\Models\Student;
use App\Models\User;
use App\Services\PpdbEnrollmentService;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
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
            $detailResponse = $this->get('/berita/'.$news->slug);
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

        $childNik = '320199'.rand(1000000000, 9999999999);
        $payload = [
            'period_id' => $period->id,
            'form_rendered_at' => Crypt::encryptString((string) (now()->timestamp - 10)),
            'security_answer' => 8,
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

        $response = $this->withSession(['ppdb_math_answer' => 8])->post('/ppdb/daftar', $payload);

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
        $childNik = '320188'.rand(1000000000, 9999999999);

        $registration = PpdbRegistration::create([
            'period_id' => $period->id,
            'registration_number' => 'PPDB-SD-REJECT-'.Str::random(8),
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

    /**
     * Test Keamanan PPDB Fase 3: Upload berkas gambar dan PDF valid disimpan dengan UUID acak & menolak PDF palsu.
     */
    public function test_ppdb_upload_hardening_uuid_and_pdf_magic_bytes(): void
    {
        RateLimiter::clear('ppdb-short:127.0.0.1');
        RateLimiter::clear('ppdb-daily:127.0.0.1');
        Storage::fake('public');

        $period = PpdbPeriod::where('is_open', 1)->first() ?? PpdbPeriod::first();
        $uniqueNik = '320124'.random_int(1000000000, 9999999999);
        $validImage = UploadedFile::fake()->image('kartu_keluarga.jpg', 600, 400);
        $validPdf = UploadedFile::fake()->createWithContent(
            'akta_kelahiran.pdf',
            "%PDF-1.4\n1 0 obj\n<< /Type /Catalog >>\nendobj\n%%EOF"
        );

        $payload = [
            'period_id' => $period->id,
            'website_url' => '',
            'form_rendered_at' => Crypt::encryptString((string) (now()->timestamp - 10)),
            'security_answer' => 9,
            'child_full_name' => 'Ananda Putra Pratama',
            'child_nik' => $uniqueNik,
            'child_gender' => 'L',
            'child_birth_place' => 'Bogor',
            'child_birth_date' => '2019-06-15',
            'track' => 'zonasi',
            'parent_name' => 'Bpk. Hendra Pratama',
            'parent_nik' => '3201241985010002',
            'parent_phone' => '081234567890',
            'parent_email' => 'hendra.wali@example.com',
            'parent_occupation' => 'Karyawan Swasta',
            'home_address' => 'Kp. Cikereteg RT 01/02 Desa Cikereteg, Kec. Caringin',
            'distance_meters' => 300,
            'document_kk' => $validImage,
            'document_akta' => $validPdf,
        ];

        $response = $this->withSession(['ppdb_math_answer' => 9])
            ->postJson(route('ppdb.store'), $payload);

        $response->assertStatus(200);
        $response->assertJsonPath('success', true);

        $registration = PpdbRegistration::with(['documentKk', 'documentAkta'])
            ->where('child_nik', $uniqueNik)
            ->first();

        $this->assertNotNull($registration);
        $this->assertNotNull($registration->documentKk);
        $this->assertNotNull($registration->documentAkta);

        $this->assertMatchesRegularExpression(
            '#^uploads/ppdb/\d{4}/\d{2}/ppdb_[0-9a-f\-]{36}\.webp$#',
            $registration->documentKk->file_path
        );
        $this->assertMatchesRegularExpression(
            '#^uploads/ppdb/\d{4}/\d{2}/ppdb_[0-9a-f\-]{36}\.pdf$#',
            $registration->documentAkta->file_path
        );

        Storage::disk('public')->assertExists($registration->documentKk->file_path);
        Storage::disk('public')->assertExists($registration->documentAkta->file_path);

        // Bersihkan record uji
        $registration->documentKk()->delete();
        $registration->documentAkta()->delete();
        $registration->delete();

        // Uji penolakan file ekstensi .pdf palsu tanpa magic bytes %PDF-
        $spoofedPdf = UploadedFile::fake()->createWithContent(
            'palsu.pdf',
            '<html><script>alert("XSS")</script></html>'
        );
        $payload['child_nik'] = '320124'.random_int(1000000000, 9999999999);
        $payload['document_akta'] = $spoofedPdf;

        $spoofedResponse = $this->withSession(['ppdb_math_answer' => 9])
            ->postJson(route('ppdb.store'), $payload);

        $spoofedResponse->assertStatus(422);
        $spoofedResponse->assertJsonValidationErrors(['document_akta']);
    }

    /**
     * Test Sistem SEO Terpadu: Meta Tags, Open Graph, Twitter Card, JSON-LD, Sitemap XML & Robots.txt.
     */
    public function test_seo_meta_tags_json_ld_sitemap_and_robots_work_properly(): void
    {
        // 1. Uji Beranda memiliki Meta Tags, Open Graph, Twitter Card, Canonical, dan Schema.org ElementarySchool
        $homeResponse = $this->get(route('home'));
        $homeResponse->assertStatus(200);
        $homeResponse->assertSee('<meta property="og:locale" content="id_ID" />', false);
        $homeResponse->assertSee('<meta property="og:type" content="website" />', false);
        $homeResponse->assertSee('<meta name="twitter:card" content="summary_large_image" />', false);
        $homeResponse->assertSee('rel="canonical"', false);
        $homeResponse->assertSee('"@type":"ElementarySchool"', false);

        // 2. Uji Detail Berita memiliki og:type article, NewsArticle JSON-LD, dan BreadcrumbList JSON-LD
        $article = NewsArticle::published()->first() ?? NewsArticle::first();
        if ($article) {
            $articleResponse = $this->get(route('news.show', $article->slug));
            $articleResponse->assertStatus(200);
            $articleResponse->assertSee('<meta property="og:type" content="article" />', false);
            $articleResponse->assertSee('"@type":"NewsArticle"', false);
            $articleResponse->assertSee('"@type":"BreadcrumbList"', false);
        }

        // 3. Uji Sitemap XML (/sitemap.xml) menghasilkan dokumen XML valid dengan daftar URL halaman & artikel
        $sitemapResponse = $this->get(route('seo.sitemap'));
        $sitemapResponse->assertStatus(200);
        $sitemapResponse->assertHeader('Content-Type', 'application/xml; charset=UTF-8');
        $sitemapResponse->assertSee('<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">', false);
        $sitemapResponse->assertSee(route('home'), false);
        $sitemapResponse->assertSee(route('ppdb.index'), false);
        if ($article) {
            $sitemapResponse->assertSee(route('news.show', $article->slug), false);
        }

        // 4. Uji Robots.txt (/robots.txt) memblokir /admin dan /ppdb/sukses/ serta menyertakan Sitemap
        $robotsResponse = $this->get(route('seo.robots'));
        $robotsResponse->assertStatus(200);
        $robotsResponse->assertSee('Disallow: /admin', false);
        $robotsResponse->assertSee('Disallow: /ppdb/sukses/', false);
        $robotsResponse->assertSee('Sitemap: '.route('seo.sitemap'), false);

        // 5. Uji Halaman Bukti Pendaftaran PPDB memiliki meta robots noindex, nofollow
        $registration = PpdbRegistration::first();
        if ($registration) {
            $receiptResponse = $this->get(route('ppdb.success', $registration->registration_number));
            $receiptResponse->assertStatus(200);
            $receiptResponse->assertSee('<meta name="robots" content="noindex, nofollow" />', false);
        }
    }
}

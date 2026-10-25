<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\SchoolProfile;
use App\Services\InquiryTicketService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ContactController extends Controller
{
    public function __construct(
        protected InquiryTicketService $ticketService
    ) {}

    /**
     * Tampilkan halaman kontak, lokasi, dan formulir layanan.
     */
    public function index(): View
    {
        $profile = SchoolProfile::first();

        return view('frontend.contact', compact('profile'));
    }

    /**
     * Simpan pesan/aduan dari orang tua dan terbitkan nomor tiket PESAN-SD-YYYY-xxxx
     */
    public function storeInquiry(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'sender_name' => ['required', 'string', 'max:100'],
            'sender_phone' => ['required', 'string', 'max:20'],
            'sender_email' => ['nullable', 'email', 'max:100'],
            'category' => ['required', 'in:ppdb,administrasi,mutasi,konsultasi,lainnya'],
            'subject' => ['required', 'string', 'max:150'],
            'message' => ['required', 'string', 'max:2000'],
            'preferred_channel' => ['nullable', 'in:whatsapp,email,telepon'],
        ], [
            'sender_name.required' => 'Nama lengkap wajib diisi.',
            'sender_phone.required' => 'Nomor WhatsApp / telepon aktif wajib diisi.',
            'category.required' => 'Pilih kategori pesan yang sesuai.',
            'subject.required' => 'Topik / subjek pesan wajib diisi.',
            'message.required' => 'Isi pesan atau pertanyaan wajib diisi.',
        ]);

        $inquiry = $this->ticketService->createInquiry($validated);

        return redirect()->to(route('contact.index') . '#form-pesan')->with('inquiry_success', [
            'ticket_number' => $inquiry->ticket_number,
            'sender_name' => $inquiry->sender_name,
            'category_label' => $inquiry->category_label,
            'created_at' => $inquiry->created_at->translatedFormat('d F Y H:i'),
        ]);
    }

    /**
     * Simpan reservasi kunjungan sekolah (School Visit) dan terbitkan kode KUNJUNGAN-SD-YYYY-xxxx
     */
    public function storeVisit(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'parent_name' => ['required', 'string', 'max:100'],
            'parent_phone' => ['required', 'string', 'max:20'],
            'visit_date' => ['required', 'date', 'after_or_equal:today'],
            'visit_session' => ['required', 'in:pagi,siang'],
            'attendees_count' => ['required', 'integer', 'min:1', 'max:10'],
            'grade_interest' => ['required', 'in:kelas_1,kelas_2,kelas_3,kelas_4,kelas_5,kelas_6,umum'],
            'internal_notes' => ['nullable', 'string', 'max:500'],
        ], [
            'parent_name.required' => 'Nama calon pengunjung / orang tua wajib diisi.',
            'parent_phone.required' => 'Nomor WhatsApp aktif wajib diisi.',
            'visit_date.required' => 'Pilih tanggal rencana kunjungan.',
            'visit_date.after_or_equal' => 'Tanggal kunjungan tidak boleh di masa lampau.',
            'visit_session.required' => 'Pilih sesi jam kunjungan sekolah.',
            'attendees_count.required' => 'Jumlah rombongan wajib diisi.',
            'grade_interest.required' => 'Pilih peminatan jenjang kelas.',
        ]);

        $visit = $this->ticketService->createSchoolVisit($validated);

        return redirect()->to(route('contact.index') . '#form-kunjungan')->with('visit_success', [
            'booking_code' => $visit->booking_code,
            'parent_name' => $visit->parent_name,
            'visit_date' => $visit->visit_date->translatedFormat('l, d F Y'),
            'session_label' => $visit->visit_session === 'pagi' ? 'Pagi (08.00 - 10.00 WIB)' : 'Siang (10.30 - 12.00 WIB)',
            'attendees_count' => $visit->attendees_count,
        ]);
    }
}

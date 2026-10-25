<?php

namespace App\Services;

use App\Models\ContactInquiry;
use App\Models\SchoolVisit;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class InquiryTicketService
{
    /**
     * Generate format nomor tiket pesan/aduan: PESAN-SD-YYYY-xxxx
     */
    public function generateInquiryTicketCode(?int $year = null): string
    {
        $year = $year ?? Carbon::now()->year;
        $prefix = "PESAN-SD-{$year}-";

        return DB::transaction(function () use ($prefix, $year) {
            $lastTicket = ContactInquiry::where('ticket_number', 'like', "{$prefix}%")
                ->orderByDesc('id')
                ->lockForUpdate()
                ->first();

            if ($lastTicket && preg_match('/-(\d{4})$/', $lastTicket->ticket_number, $matches)) {
                $nextSequence = (int) $matches[1] + 1;
            } else {
                $count = ContactInquiry::where('ticket_number', 'like', "{$prefix}%")->count();
                $nextSequence = $count + 1;
            }

            return sprintf('%s%04d', $prefix, $nextSequence);
        });
    }

    /**
     * Generate format kode reservasi kunjungan: KUNJUNGAN-SD-YYYY-xxxx
     */
    public function generateVisitBookingCode(?int $year = null): string
    {
        $year = $year ?? Carbon::now()->year;
        $prefix = "KUNJUNGAN-SD-{$year}-";

        return DB::transaction(function () use ($prefix, $year) {
            $lastVisit = SchoolVisit::where('booking_code', 'like', "{$prefix}%")
                ->orderByDesc('id')
                ->lockForUpdate()
                ->first();

            if ($lastVisit && preg_match('/-(\d{4})$/', $lastVisit->booking_code, $matches)) {
                $nextSequence = (int) $matches[1] + 1;
            } else {
                $count = SchoolVisit::where('booking_code', 'like', "{$prefix}%")->count();
                $nextSequence = $count + 1;
            }

            return sprintf('%s%04d', $prefix, $nextSequence);
        });
    }

    /**
     * Simpan pengajuan pesan/aduan orang tua ke trn_contact_inquiries
     */
    public function createInquiry(array $data): ContactInquiry
    {
        $ticketCode = $this->generateInquiryTicketCode();

        return ContactInquiry::create([
            'ticket_number' => $ticketCode,
            'sender_name' => $data['sender_name'],
            'sender_phone' => $data['sender_phone'],
            'sender_email' => $data['sender_email'] ?? null,
            'category' => $data['category'] ?? 'ppdb',
            'subject' => $data['subject'] ?? 'Pesan Orang Tua',
            'message' => $data['message'],
            'preferred_channel' => $data['preferred_channel'] ?? 'whatsapp',
            'ticket_status' => 'baru',
            'assigned_to_teacher_id' => $data['assigned_to_teacher_id'] ?? null,
            'created_at' => Carbon::now(),
        ]);
    }

    /**
     * Simpan reservasi kunjungan sekolah calon wali murid ke trn_school_visits
     */
    public function createSchoolVisit(array $data): SchoolVisit
    {
        $bookingCode = $this->generateVisitBookingCode();

        return SchoolVisit::create([
            'booking_code' => $bookingCode,
            'parent_name' => $data['parent_name'],
            'parent_phone' => $data['parent_phone'],
            'visit_date' => $data['visit_date'],
            'visit_session' => $data['visit_session'] ?? 'pagi',
            'attendees_count' => $data['attendees_count'] ?? 1,
            'grade_interest' => $data['grade_interest'] ?? 'kelas_1',
            'visit_status' => 'menunggu',
            'internal_notes' => $data['internal_notes'] ?? null,
            'created_at' => Carbon::now(),
        ]);
    }
}

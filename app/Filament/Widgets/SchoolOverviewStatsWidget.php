<?php

namespace App\Filament\Widgets;

use App\Models\ContactInquiry;
use App\Models\SchoolVisit;
use App\Models\Teacher;
use Filament\Support\Icons\Heroicon;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class SchoolOverviewStatsWidget extends BaseWidget
{
    protected static ?int $sort = 1;

    protected function getStats(): array
    {
        $user = Auth::user();

        // 1. Metrik Siswa Aktif dari View Database v_active_students
        $totalActiveStudents = DB::table('v_active_students')->count();
        $maleStudents = DB::table('v_active_students')->where('gender', 'L')->count();
        $femaleStudents = DB::table('v_active_students')->where('gender', 'P')->count();

        // 2. Metrik Dewan Guru & GTK
        $totalActiveTeachers = Teacher::where('is_active', true)->count();

        // 3. Metrik PPDB dari View Database v_ppdb_dashboard & tabel registrasi
        $totalPpdbRegistrants = DB::table('trn_ppdb_registrations')->count();
        $acceptedPpdb = (int) DB::table('v_ppdb_dashboard')
            ->where('verification_status', 'diterima')
            ->sum('total_registrants');
        $pendingPpdb = (int) DB::table('trn_ppdb_registrations')
            ->where('verification_status', 'menunggu')
            ->count();

        // 4. Metrik Layanan Publik (Tiket Aduan & Reservasi Kunjungan)
        $pendingInquiries = ContactInquiry::where('ticket_status', 'baru')->count();
        $pendingVisits = SchoolVisit::where('visit_status', 'menunggu')->count();

        // Jika Panitia PPDB: Tampilkan fokus PPDB
        if ($user && $user->role === 'panitia_ppdb') {
            $rejectedPpdb = (int) DB::table('v_ppdb_dashboard')
                ->where('verification_status', 'ditolak')
                ->sum('total_registrants');

            return [
                Stat::make('Total Pendaftar PPDB', $totalPpdbRegistrants)
                    ->description('Seluruh berkas calon siswa masuk')
                    ->descriptionIcon(Heroicon::OutlinedUserPlus)
                    ->color('primary')
                    ->chart([5, 8, 12, 15, 18, $totalPpdbRegistrants]),

                Stat::make('Calon Siswa Diterima', $acceptedPpdb)
                    ->description('Resmi terdaftar di database siswa')
                    ->descriptionIcon(Heroicon::OutlinedCheckCircle)
                    ->color('success'),

                Stat::make('Menunggu Verifikasi', $pendingPpdb)
                    ->description('Perlu peninjauan berkas KK & Akta')
                    ->descriptionIcon(Heroicon::OutlinedClock)
                    ->color('warning'),

                Stat::make('Berkas Ditolak', $rejectedPpdb)
                    ->description('Tidak memenuhi syarat umur/zonasi')
                    ->descriptionIcon(Heroicon::OutlinedXCircle)
                    ->color('danger'),
            ];
        }

        // Tampilan Eksekutif untuk Superadmin, Admin TU, dan Guru Humas
        return [
            Stat::make('Total Siswa Aktif', "{$totalActiveStudents} Siswa")
                ->description("{$maleStudents} Laki-laki • {$femaleStudents} Perempuan")
                ->descriptionIcon(Heroicon::OutlinedUsers)
                ->color('success')
                ->chart([10, 14, 18, 22, 25, 28, $totalActiveStudents]),

            Stat::make('Dewan Guru & GTK', "{$totalActiveTeachers} Orang")
                ->description('Pendidik & staf kependidikan aktif')
                ->descriptionIcon(Heroicon::OutlinedAcademicCap)
                ->color('primary'),

            Stat::make('Pendaftar PPDB Online', "{$totalPpdbRegistrants} Calon")
                ->description("{$acceptedPpdb} Diterima • {$pendingPpdb} Menunggu Verifikasi")
                ->descriptionIcon(Heroicon::OutlinedUserPlus)
                ->color('warning')
                ->chart([3, 7, 11, 14, 17, $totalPpdbRegistrants]),

            Stat::make('Tiket Layanan Publik', ($pendingInquiries + $pendingVisits).' Pending')
                ->description("{$pendingInquiries} Tiket Baru • {$pendingVisits} Kunjungan Sekolah")
                ->descriptionIcon(Heroicon::OutlinedChatBubbleLeftRight)
                ->color('info'),
        ];
    }
}

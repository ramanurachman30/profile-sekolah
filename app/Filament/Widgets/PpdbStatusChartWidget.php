<?php

namespace App\Filament\Widgets;

use Filament\Widgets\ChartWidget;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PpdbStatusChartWidget extends ChartWidget
{
    protected static ?int $sort = 2;

    protected ?string $heading = 'Status Verifikasi PPDB Online (v_ppdb_dashboard)';

    protected ?string $description = 'Distribusi status pendaftaran calon peserta didik baru kelas 1';

    protected ?string $maxHeight = '280px';

    public static function canView(): bool
    {
        $user = Auth::user();

        return $user && in_array($user->role, ['superadmin', 'panitia_ppdb', 'admin_tu']);
    }

    protected function getData(): array
    {
        // Ambil data agregasi dari view database v_ppdb_dashboard
        $rows = DB::table('v_ppdb_dashboard')->get();

        $accepted = (int) ($rows->firstWhere('verification_status', 'diterima')->total_registrants ?? 0);
        $rejected = (int) ($rows->firstWhere('verification_status', 'ditolak')->total_registrants ?? 0);

        // Pengecekan status menunggu dan diverifikasi langsung dari tabel transaksi
        $pending = (int) DB::table('trn_ppdb_registrations')->where('verification_status', 'menunggu')->count();
        $inReview = (int) DB::table('trn_ppdb_registrations')->where('verification_status', 'diverifikasi')->count();

        return [
            'datasets' => [
                [
                    'label' => 'Jumlah Calon Siswa',
                    'data' => [$accepted, $pending, $inReview, $rejected],
                    'backgroundColor' => [
                        '#10b981', // Emerald / Success: Diterima
                        '#f59e0b', // Amber / Warning: Menunggu
                        '#0ea5e9', // Sky / Info: Sedang Diverifikasi
                        '#ef4444', // Red / Danger: Ditolak
                    ],
                    'borderWidth' => 2,
                    'borderColor' => '#ffffff',
                ],
            ],
            'labels' => [
                "Diterima ({$accepted})",
                "Menunggu ({$pending})",
                "Diverifikasi ({$inReview})",
                "Ditolak ({$rejected})",
            ],
        ];
    }

    protected function getType(): string
    {
        return 'doughnut';
    }
}

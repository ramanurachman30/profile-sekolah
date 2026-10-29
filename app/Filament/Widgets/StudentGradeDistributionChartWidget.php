<?php

namespace App\Filament\Widgets;

use Filament\Widgets\ChartWidget;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class StudentGradeDistributionChartWidget extends ChartWidget
{
    protected static ?int $sort = 3;

    protected ?string $heading = 'Distribusi Siswa Aktif per Tingkat Kelas (v_active_students)';

    protected ?string $description = 'Komposisi siswa laki-laki dan perempuan di setiap jenjang rombel kelas';

    protected ?string $maxHeight = '280px';

    public static function canView(): bool
    {
        $user = Auth::user();

        return $user && in_array($user->role, ['superadmin', 'admin_tu', 'guru_humas']);
    }

    protected function getData(): array
    {
        // Ambil data distribusi per tingkat kelas dari view database v_active_students
        $stats = DB::table('v_active_students')
            ->selectRaw('grade_level, 
                SUM(CASE WHEN gender = "L" THEN 1 ELSE 0 END) AS male_count, 
                SUM(CASE WHEN gender = "P" THEN 1 ELSE 0 END) AS female_count,
                COUNT(*) AS total_count')
            ->groupBy('grade_level')
            ->orderBy('grade_level')
            ->get()
            ->keyBy('grade_level');

        $labels = ['Kelas 1', 'Kelas 2', 'Kelas 3', 'Kelas 4', 'Kelas 5', 'Kelas 6'];
        $maleData = [];
        $femaleData = [];

        for ($grade = 1; $grade <= 6; $grade++) {
            $row = $stats->get($grade);
            $maleData[] = (int) ($row->male_count ?? 0);
            $femaleData[] = (int) ($row->female_count ?? 0);
        }

        return [
            'datasets' => [
                [
                    'label' => 'Siswa Laki-laki (L)',
                    'data' => $maleData,
                    'backgroundColor' => '#3b82f6', // Biru
                    'borderRadius' => 6,
                ],
                [
                    'label' => 'Siswa Perempuan (P)',
                    'data' => $femaleData,
                    'backgroundColor' => '#ec4899', // Merah Muda
                    'borderRadius' => 6,
                ],
            ],
            'labels' => $labels,
        ];
    }

    protected function getType(): string
    {
        return 'bar';
    }
}

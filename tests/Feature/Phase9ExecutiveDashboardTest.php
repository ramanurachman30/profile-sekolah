<?php

namespace Tests\Feature;

use App\Filament\Widgets\PpdbStatusChartWidget;
use App\Filament\Widgets\RecentInquiriesAndVisitsWidget;
use App\Filament\Widgets\RecentPpdbRegistrationsWidget;
use App\Filament\Widgets\StudentGradeDistributionChartWidget;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class Phase9ExecutiveDashboardTest extends TestCase
{
    /**
     * Uji 1: Database View (v_active_students & v_ppdb_dashboard) aktif dan dapat di-query
     */
    public function test_database_views_exist_and_accessible(): void
    {
        $activeStudentsCount = DB::table('v_active_students')->count();
        $this->assertGreaterThan(0, $activeStudentsCount, 'Database view v_active_students harus memuat data siswa aktif.');

        $ppdbDashboardCount = DB::table('v_ppdb_dashboard')->count();
        $this->assertGreaterThan(0, $ppdbDashboardCount, 'Database view v_ppdb_dashboard harus memuat data agregat status PPDB.');

        $achievementCount = DB::table('v_achievement_showcase')->count();
        $this->assertGreaterThanOrEqual(0, $achievementCount, 'Database view v_achievement_showcase dapat di-query.');
    }

    /**
     * Uji 2: Superadmin dapat mengakses panel admin dan merender metrik dashboard
     */
    public function test_superadmin_can_access_dashboard_and_widgets(): void
    {
        $superadmin = User::where('role', 'superadmin')->first();
        Auth::login($superadmin);

        $response = $this->actingAs($superadmin)->get('/admin');
        $response->assertStatus(200);

        // Verifikasi semua widget dapat dilihat oleh Superadmin
        $this->assertTrue(PpdbStatusChartWidget::canView());
        $this->assertTrue(StudentGradeDistributionChartWidget::canView());
        $this->assertTrue(RecentPpdbRegistrationsWidget::canView());
        $this->assertTrue(RecentInquiriesAndVisitsWidget::canView());
    }

    /**
     * Uji 3: Panitia PPDB mendapatkan widget yang dipersonalisasi khusus PPDB
     */
    public function test_panitia_ppdb_sees_tailored_ppdb_widgets(): void
    {
        $panitia = User::where('role', 'panitia_ppdb')->first();
        Auth::login($panitia);

        $response = $this->actingAs($panitia)->get('/admin');
        $response->assertStatus(200);

        // Widget khusus PPDB aktif
        $this->assertTrue(PpdbStatusChartWidget::canView());
        $this->assertTrue(RecentPpdbRegistrationsWidget::canView());

        // Widget distribusi kelas siswa non-PPDB tidak ditampilkan untuk panitia PPDB
        $this->assertFalse(StudentGradeDistributionChartWidget::canView());
    }

    /**
     * Uji 4: Staf Tata Usaha (Admin TU) dapat melihat widget operasional sekolah
     */
    public function test_admin_tu_sees_tailored_widgets(): void
    {
        $adminTu = User::where('role', 'admin_tu')->first();
        Auth::login($adminTu);

        $response = $this->actingAs($adminTu)->get('/admin');
        $response->assertStatus(200);

        $this->assertTrue(StudentGradeDistributionChartWidget::canView());
        $this->assertTrue(RecentInquiriesAndVisitsWidget::canView());
        $this->assertTrue(PpdbStatusChartWidget::canView());
    }
}

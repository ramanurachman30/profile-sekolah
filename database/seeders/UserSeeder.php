<?php

namespace Database\Seeders;

use App\Models\Teacher;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     * Membuat 4 akun pengguna untuk 4 role operasional sekolah dasar:
     * 1. superadmin   : Kepala Sekolah / Penanggung Jawab IT (Akses penuh)
     * 2. admin_tu     : Staf Tata Usaha (Administrasi, inventaris, pesan, kunjungan)
     * 3. guru_humas   : Guru & Tim Publikasi Web (Berita, galeri, prestasi)
     * 4. panitia_ppdb : Tim Panitia PPDB (Verifikasi berkas calon siswa baru)
     */
    public function run(): void
    {
        $kepsek = Teacher::where('full_name', 'like', '%Siti Rohmah%')->first();
        $guruHumas = Teacher::where('full_name', 'like', '%Hendra Gunawan%')->first();
        $panitiaPpdb = Teacher::where('full_name', 'like', '%Nurhasanah%')->first();

        $defaultPassword = Hash::make('password123');

        $users = [
            [
                'username' => 'superadmin',
                'full_name' => 'Dra. Hj. Siti Rohmah, M.Pd.',
                'email' => 'kepsek@sdncikereteg01.sch.id',
                'password_hash' => $defaultPassword,
                'role' => 'superadmin',
                'teacher_id' => $kepsek?->id ?? 1,
                'is_active' => true,
            ],
            [
                'username' => 'admin_tu',
                'full_name' => 'Staf Tata Usaha SDN Cikereteg 01',
                'email' => 'tu@sdncikereteg01.sch.id',
                'password_hash' => $defaultPassword,
                'role' => 'admin_tu',
                'teacher_id' => null,
                'is_active' => true,
            ],
            [
                'username' => 'guru_humas',
                'full_name' => 'Bpk. Hendra Gunawan, S.Pd.',
                'email' => 'humas@sdncikereteg01.sch.id',
                'password_hash' => $defaultPassword,
                'role' => 'guru_humas',
                'teacher_id' => $guruHumas?->id ?? 3,
                'is_active' => true,
            ],
            [
                'username' => 'panitia_ppdb',
                'full_name' => 'Ibu Nurhasanah, S.Pd.SD.',
                'email' => 'ppdb@sdncikereteg01.sch.id',
                'password_hash' => $defaultPassword,
                'role' => 'panitia_ppdb',
                'teacher_id' => $panitiaPpdb?->id ?? 2,
                'is_active' => true,
            ],
        ];

        foreach ($users as $userData) {
            User::updateOrCreate(
                ['username' => $userData['username']],
                $userData
            );
        }

        $this->command?->info('User seeder berhasil: 4 akun untuk 4 role telah siap (Password default: password123).');
    }
}

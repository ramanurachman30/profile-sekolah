<?php

namespace Database\Seeders;

use App\Models\AcademicYear;
use App\Models\Achievement;
use App\Models\CharacterHabit;
use App\Models\ClassRoom;
use App\Models\Extracurricular;
use App\Models\Facility;
use App\Models\FacilityCategory;
use App\Models\GalleryItem;
use App\Models\Grade;
use App\Models\MediaAsset;
use App\Models\NewsArticle;
use App\Models\Student;
use App\Models\Subject;
use App\Models\Teacher;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ContentSeeder extends Seeder
{
    public function run(): void
    {
        $academicYear = AcademicYear::first();
        $headmaster = Teacher::find(1);
        $teacherNur = Teacher::find(2);
        $teacherHendra = Teacher::find(3);
        $teacherDewi = Teacher::find(4);
        $teacherRizki = Teacher::find(5);
        $authorUser = User::first();

        // 1. Helper function to create MediaAsset
        $getMedia = function ($name, $url, $alt, $type = 'image') {
            return MediaAsset::firstOrCreate(
                ['file_path' => $url],
                [
                    'file_name' => $name,
                    'file_type' => $type,
                    'mime_type' => $type === 'video' ? 'video/mp4' : 'image/jpeg',
                    'file_size_kb' => 120,
                    'alt_text' => $alt,
                ]
            );
        };

        // 2. Mapel SD (Kurikulum Merdeka)
        $subjects = [
            ['subject_code' => 'PAI', 'subject_name' => 'Pendidikan Agama Islam & Budi Pekerti', 'category' => 'wajib'],
            ['subject_code' => 'PANCASILA', 'subject_name' => 'Pendidikan Pancasila', 'category' => 'wajib'],
            ['subject_code' => 'BINDO', 'subject_name' => 'Bahasa Indonesia', 'category' => 'wajib'],
            ['subject_code' => 'MAT', 'subject_name' => 'Matematika', 'category' => 'wajib'],
            ['subject_code' => 'IPAS', 'subject_name' => 'Ilmu Pengetahuan Alam dan Sosial (IPAS)', 'category' => 'wajib'],
            ['subject_code' => 'PJOK', 'subject_name' => 'Pendidikan Jasmani, Olahraga, dan Kesehatan', 'category' => 'wajib'],
            ['subject_code' => 'SENI', 'subject_name' => 'Seni Rupa dan Musik', 'category' => 'wajib'],
            ['subject_code' => 'BSUNDA', 'subject_name' => 'Bahasa dan Sastra Sunda', 'category' => 'muatan_lokal'],
            ['subject_code' => 'BING', 'subject_name' => 'Bahasa Inggris Dasar', 'category' => 'pilihan'],
        ];
        foreach ($subjects as $s) {
            Subject::firstOrCreate(['subject_code' => $s['subject_code']], $s);
        }

        // 3. Rombel / Classes (rel_classes)
        if ($academicYear && ClassRoom::count() === 0) {
            $grades = Grade::all();
            foreach ($grades as $grade) {
                ClassRoom::firstOrCreate(
                    [
                        'academic_year_id' => $academicYear->id,
                        'class_name' => $grade->grade_level.'A',
                    ],
                    [
                        'grade_id' => $grade->id,
                        'homeroom_teacher_id' => $grade->grade_level === 1 ? ($teacherNur->id ?? null) : ($teacherDewi->id ?? null),
                        'room_name' => 'Ruang Kelas '.$grade->grade_level,
                        'capacity' => 28,
                    ]
                );
            }
        }

        // 3b. Sample Siswa Aktif per Tingkat Kelas untuk v_active_students
        $classRooms = ClassRoom::all();
        if ($classRooms->isNotEmpty()) {
            Student::whereNull('current_class_id')->update(['current_class_id' => $classRooms->first()->id]);
        }

        if (Student::whereNotNull('current_class_id')->count() < 15) {
            $sampleStudents = [
                // Kelas 1
                ['Ahmad Fauzan', 'L', '2019-03-15', 'Budi Santoso', '08123456701'],
                ['Siti Aisyah', 'P', '2019-05-20', 'Rahmat Hidayat', '08123456702'],
                ['Muhammad Rizky', 'L', '2019-02-10', 'Dedi Mulyadi', '08123456703'],
                ['Nayla Putri', 'P', '2019-07-04', 'Agus Setiawan', '08123456704'],
                // Kelas 2
                ['Alif Pratama', 'L', '2018-04-12', 'Bambang Irawan', '08123456705'],
                ['Zahra Amelia', 'P', '2018-08-18', 'Heri Susanto', '08123456706'],
                ['Dimas Setiawan', 'L', '2018-01-25', 'Iwan Fals', '08123456707'],
                // Kelas 3
                ['Fathan Al Farisi', 'L', '2017-06-11', 'Joko Widodo', '08123456708'],
                ['Kirana Larasati', 'P', '2017-09-30', 'Kurniawan', '08123456709'],
                ['Raffi Ahmad', 'L', '2017-03-22', 'Lukman Hakim', '08123456710'],
                // Kelas 4
                ['Danendra Arya', 'L', '2016-11-05', 'Maman Suratman', '08123456711'],
                ['Anindya Shafa', 'P', '2016-02-14', 'Nanang Kosim', '08123456712'],
                ['Fikri Haikal', 'L', '2016-07-19', 'Oding Nasrudin', '08123456713'],
                // Kelas 5
                ['Bilal Ramadhan', 'L', '2015-10-08', 'Panji Wibowo', '08123456714'],
                ['Cantika Meilani', 'P', '2015-05-16', 'Qomarudin', '08123456715'],
                ['Zidan Arkan', 'L', '2015-12-01', 'Rian D Academy', '08123456716'],
                // Kelas 6
                ['Rian Pratama', 'L', '2014-08-14', 'Surya Saputra', '08123456717'],
                ['Aulia Rahmawati', 'P', '2014-04-25', 'Taufik Hidayat', '08123456718'],
                ['Gilang Ramadhan', 'L', '2014-01-17', 'Ujang Koswara', '08123456719'],
                ['Salma Nabilla', 'P', '2014-09-09', 'Wahyu Wibisono', '08123456720'],
            ];

            foreach ($sampleStudents as $idx => $s) {
                $classIdx = min((int) floor($idx / 3.4), $classRooms->count() - 1);
                $class = $classRooms[$classIdx] ?? $classRooms->first();
                $nisn = '00'.str_pad((string) (12345678 + $idx), 8, '0', STR_PAD_LEFT);
                $nis = '2026'.str_pad((string) (101 + $idx), 4, '0', STR_PAD_LEFT);

                Student::firstOrCreate(
                    ['nisn' => $nisn],
                    [
                        'nis' => $nis,
                        'nik' => '320101'.str_pad((string) (100000 + $idx), 10, '0', STR_PAD_LEFT),
                        'full_name' => $s[0],
                        'nickname' => explode(' ', $s[0])[0],
                        'gender' => $s[1],
                        'birth_place' => 'Bogor',
                        'birth_date' => $s[2],
                        'parent_guardian_name' => $s[3],
                        'parent_phone' => $s[4],
                        'address' => 'Kp. Cikereteg RT 02 / RW 04, Caringin, Kab. Bogor',
                        'rt_rw' => 'RT 02 / RW 04',
                        'current_class_id' => $class?->id,
                        'status' => 'aktif',
                    ]
                );
            }
        }

        // 4. Pembiasaan Karakter (mst_character_habits)
        $habits = [
            [
                'title' => 'Budaya 5S di Gerbang',
                'badge_label' => 'Pagi Hari',
                'routine_schedule' => '06.45 - 07.00 WIB',
                'description' => 'Senyum, Salam, Sapa, Sopan, dan Santun saat bersalaman dengan guru piket dan menyapa teman sebelum masuk gerbang sekolah.',
                'image' => 'https://images.unsplash.com/photo-1577896851231-70ef18881754?q=80&w=600&auto=format&fit=crop',
                'sort_order' => 1,
            ],
            [
                'title' => 'Literasi Pagi 15 Menit',
                'badge_label' => 'Literasi Dasar',
                'routine_schedule' => '07.00 - 07.15 WIB',
                'description' => 'Membiasakan anak membaca buku cerita dongeng, ensiklopedia bergambar, atau buku fabel di Pojok Baca kelas yang nyaman.',
                'image' => 'https://images.unsplash.com/photo-1509062522246-3755977927d7?q=80&w=600&auto=format&fit=crop',
                'sort_order' => 2,
            ],
            [
                'title' => 'Doa & Sholat Dhuha',
                'badge_label' => 'Spiritual & Moral',
                'routine_schedule' => 'Setiap Pagi Sebelum Bel',
                'description' => 'Sholat Dhuha berjamaah di Musholla Al-Ikhlas bagi siswa muslim, serta doa pagi bersama di kelas dengan bimbingan wali kelas.',
                'image' => 'https://images.unsplash.com/photo-1544717305-2782549b5136?q=80&w=600&auto=format&fit=crop',
                'sort_order' => 3,
            ],
            [
                'title' => 'Jumat Bersih & Sehat',
                'badge_label' => 'Adiwiyata',
                'routine_schedule' => 'Setiap Hari Jumat',
                'description' => 'Senam irama anak gembira di lapangan dilanjutkan kerja bakti menyiram tanaman kebun sekolah dan operasi semut memilah sampah.',
                'image' => 'https://images.unsplash.com/photo-1544717302-de2939b7ef71?q=80&w=600&auto=format&fit=crop',
                'sort_order' => 4,
            ],
        ];

        foreach ($habits as $h) {
            $media = $getMedia(Str::slug($h['title']).'.jpg', $h['image'], $h['title']);
            CharacterHabit::firstOrCreate(
                ['title' => $h['title']],
                [
                    'badge_label' => $h['badge_label'],
                    'routine_schedule' => $h['routine_schedule'],
                    'description' => $h['description'],
                    'cover_asset_id' => $media->id,
                    'sort_order' => $h['sort_order'],
                    'is_active' => 1,
                ]
            );
        }

        // 5. Ekstrakurikuler (mst_extracurriculars)
        $ekskuls = [
            [
                'name' => 'Pramuka Siaga & Penggalang',
                'slug' => 'pramuka',
                'category' => 'wajib',
                'badge_text' => 'Wajib Nasional',
                'schedule_info' => 'Sabtu, 08.00 - 10.00 WIB',
                'instructor_teacher_id' => $teacherHendra->id ?? null,
                'description' => 'Membentuk kemandirian, kedisiplinan, kecintaan alam, tali-temali, semaphore gembira, serta kepemimpinan regu Siaga & Penggalang.',
                'image' => 'https://images.unsplash.com/photo-1509062522246-3755977927d7?q=80&w=600&auto=format&fit=crop',
                'sort_order' => 1,
            ],
            [
                'name' => 'Futsal Mini SD',
                'slug' => 'futsal-mini',
                'category' => 'olahraga',
                'badge_text' => 'Olahraga Prestasi',
                'schedule_info' => 'Selasa & Kamis, 14.30 - 16.00 WIB',
                'instructor_teacher_id' => $teacherRizki->id ?? null,
                'description' => 'Melatih teknik dasar dribbling, passing, kerjasama tim, serta kebugaran jasmani anak di lapangan serbaguna sekolah.',
                'image' => 'https://images.unsplash.com/photo-1517649763962-0c623266ddc0?q=80&w=600&auto=format&fit=crop',
                'sort_order' => 2,
            ],
            [
                'name' => 'Seni Tari Tradisional Sunda',
                'slug' => 'tari-tradisional',
                'category' => 'seni_budaya',
                'badge_text' => 'Seni Budaya',
                'schedule_info' => 'Rabu, 13.00 - 14.30 WIB',
                'instructor_teacher_id' => $teacherDewi->id ?? null,
                'description' => 'Mengenalkan kelenturan gerak tari Jaipong, tari Saman, dan kreasi nusantara untuk mengasah kepercayaan diri tampil di panggung.',
                'image' => 'https://images.unsplash.com/photo-1544717302-de2939b7ef71?q=80&w=600&auto=format&fit=crop',
                'sort_order' => 3,
            ],
            [
                'name' => 'Dokter Cilik (Dokcil & UKS)',
                'slug' => 'dokter-cilik',
                'category' => 'kesehatan',
                'badge_text' => 'Kesehatan Siswa',
                'schedule_info' => 'Jumat, 13.00 - 14.00 WIB',
                'instructor_teacher_id' => $teacherNur->id ?? null,
                'description' => 'Kader kesehatan sekolah belajar pertolongan pertama (P3K), gizi seimbang, kebersihan kuku dan gigi, serta UKS sehat.',
                'image' => 'https://images.unsplash.com/photo-1584515979956-d9f6e5d09982?q=80&w=600&auto=format&fit=crop',
                'sort_order' => 4,
            ],
            [
                'name' => 'Pencak Silat Tradisional',
                'slug' => 'pencak-silat',
                'category' => 'bela_diri',
                'badge_text' => 'Bela Diri Tradisi',
                'schedule_info' => 'Sabtu, 10.00 - 11.30 WIB',
                'instructor_teacher_id' => $teacherRizki->id ?? null,
                'description' => 'Melatih ketahanan fisik, konsentrasi, seni jurus bela diri warisan leluhur, dan adab sopan santun ksatria.',
                'image' => 'https://images.unsplash.com/photo-1544717305-2782549b5136?q=80&w=600&auto=format&fit=crop',
                'sort_order' => 5,
            ],
            [
                'name' => 'Marawis & Hadroh Santri',
                'slug' => 'marawis-hadroh',
                'category' => 'keagamaan',
                'badge_text' => 'Seni Religi',
                'schedule_info' => 'Kamis, 13.00 - 14.30 WIB',
                'instructor_teacher_id' => $teacherHendra->id ?? null,
                'description' => 'Mempelajari tabuhan rebana, shalawat nabi, dan kesenian musik Islami untuk mengisi peringatan hari besar Islam (PHBI).',
                'image' => 'https://images.unsplash.com/photo-1542838132-92c53300491e?q=80&w=600&auto=format&fit=crop',
                'sort_order' => 6,
            ],
            [
                'name' => 'Seni Lukis & Kriya Anak',
                'slug' => 'seni-lukis',
                'category' => 'seni_budaya',
                'badge_text' => 'Kreativitas Seni',
                'schedule_info' => 'Senin, 13.00 - 14.30 WIB',
                'instructor_teacher_id' => $teacherDewi->id ?? null,
                'description' => 'Mengekspresikan imajinasi melalui cat air, krayon, origami, dan hasta karya daur ulang ramah lingkungan.',
                'image' => 'https://images.unsplash.com/photo-1516321318423-f06f85e504b3?q=80&w=600&auto=format&fit=crop',
                'sort_order' => 7,
            ],
            [
                'name' => 'Catur & Asah Otak',
                'slug' => 'catur-mini',
                'category' => 'keterampilan',
                'badge_text' => 'Asah Logika',
                'schedule_info' => 'Rabu, 13.00 - 14.30 WIB',
                'instructor_teacher_id' => $teacherRizki->id ?? null,
                'description' => 'Melatih daya pikir strategis, ketenangan, kesabaran mengambil keputusan, dan sportivitas diatas papan catur 64 kotak.',
                'image' => 'https://images.unsplash.com/photo-1580894732444-8ecded7900cd?q=80&w=600&auto=format&fit=crop',
                'sort_order' => 8,
            ],
        ];

        foreach ($ekskuls as $e) {
            $media = $getMedia(Str::slug($e['name']).'.jpg', $e['image'], $e['name']);
            Extracurricular::firstOrCreate(
                ['slug' => $e['slug']],
                [
                    'name' => $e['name'],
                    'category' => $e['category'],
                    'badge_text' => $e['badge_text'],
                    'schedule_info' => $e['schedule_info'],
                    'instructor_teacher_id' => $e['instructor_teacher_id'],
                    'description' => $e['description'],
                    'cover_asset_id' => $media->id,
                    'sort_order' => $e['sort_order'],
                    'is_active' => 1,
                ]
            );
        }

        // 6. Fasilitas & Sarpras (mst_facility_categories & mst_facilities)
        $facilityCats = [
            1 => 'Ruang Belajar & Pembelajaran',
            2 => 'Sarana Ibadah & Olahraga',
            3 => 'Layanan Kesehatan & Kantin',
            4 => 'Lingkungan & Adiwiyata',
        ];
        foreach ($facilityCats as $id => $catName) {
            FacilityCategory::firstOrCreate(['id' => $id], ['name' => $catName]);
        }

        $facilities = [
            [
                'category_id' => 1,
                'facility_code' => 'KELAS-01',
                'name' => 'Ruang Kelas Berventilasi & Sejuk',
                'capacity' => 168,
                'condition_status' => 'sangat_baik',
                'description' => 'Pencahayaan alami dan sirkulasi udara sejuk, papan tulis bersih, serta meja kursi ergonomis ramah anak untuk 6 rombongan belajar.',
                'image' => 'https://images.unsplash.com/photo-1580582932707-520aed937b7b?q=80&w=500&auto=format&fit=crop',
                'sort_order' => 1,
            ],
            [
                'category_id' => 1,
                'facility_code' => 'PERPUS-01',
                'name' => 'Perpustakaan & Pojok Baca Lesehan',
                'capacity' => 35,
                'condition_status' => 'sangat_baik',
                'description' => 'Koleksi buku cerita bergambar, ensiklopedia sains anak, fabel nusantara, serta karpet baca lesehan yang nyaman untuk gerakan literasi 15 menit.',
                'image' => 'https://images.unsplash.com/photo-1521587760476-6c12a4b040da?q=80&w=500&auto=format&fit=crop',
                'sort_order' => 2,
            ],
            [
                'category_id' => 1,
                'facility_code' => 'TIK-01',
                'name' => 'Ruang Komputer TIK & Chromebook',
                'capacity' => 25,
                'condition_status' => 'baik',
                'description' => 'Unit perangkat Chromebook bantuan pemerintah untuk literasi digital dasar siswa dan pelaksanaan ujian ANBK tertib dan aman.',
                'image' => 'https://images.unsplash.com/photo-1516321318423-f06f85e504b3?q=80&w=500&auto=format&fit=crop',
                'sort_order' => 3,
            ],
            [
                'category_id' => 2,
                'facility_code' => 'LAP-01',
                'name' => 'Lapangan Olahraga & Upacara Serbaguna',
                'capacity' => 300,
                'condition_status' => 'sangat_baik',
                'description' => 'Area terbuka serbaguna beralas aspal halus untuk apel bendera hari Senin, senam gembira hari Jumat, futsal mini, dan kepramukaan.',
                'image' => 'https://images.unsplash.com/photo-1574629810360-7efbbe195018?q=80&w=500&auto=format&fit=crop',
                'sort_order' => 4,
            ],
            [
                'category_id' => 3,
                'facility_code' => 'UKS-01',
                'name' => 'Ruang Kesehatan Siswa (UKS)',
                'capacity' => 10,
                'condition_status' => 'sangat_baik',
                'description' => 'Tempat istirahat bagi siswa yang sakit, ranjang periksa, timbangan berat badan, kotak P3K lengkap, serta pos binaan Puskesmas Caringin.',
                'image' => 'https://images.unsplash.com/photo-1584515979956-d9f6e5d09982?q=80&w=500&auto=format&fit=crop',
                'sort_order' => 5,
            ],
            [
                'category_id' => 2,
                'facility_code' => 'MUSH-01',
                'name' => 'Musholla Al-Ikhlas & Tempat Wudhu',
                'capacity' => 60,
                'condition_status' => 'sangat_baik',
                'description' => 'Sarana ibadah sholat dhuha dan sholat dzuhur berjamaah dengan tempat wudhu bersih terpisah antara putra dan putri.',
                'image' => 'https://images.unsplash.com/photo-1542838132-92c53300491e?q=80&w=500&auto=format&fit=crop',
                'sort_order' => 6,
            ],
            [
                'category_id' => 3,
                'facility_code' => 'KANTIN-01',
                'name' => 'Kantin Sehat Higienis Ramah Anak',
                'capacity' => 40,
                'condition_status' => 'baik',
                'description' => 'Menyediakan jajanan dan makanan bernutrisi yang diawasi pihak sekolah bebas dari pengawet dan pewarna berbahaya.',
                'image' => 'https://images.unsplash.com/photo-1567521464027-f127ff144326?q=80&w=500&auto=format&fit=crop',
                'sort_order' => 7,
            ],
            [
                'category_id' => 4,
                'facility_code' => 'KEBUN-01',
                'name' => 'Kebun Toga & Taman Adiwiyata Asri',
                'capacity' => 50,
                'condition_status' => 'sangat_baik',
                'description' => 'Wahana edukasi alam terbuka tempat anak belajar menyiram tanaman toga, mengenal bunga nusantara, dan memilah sampah kompos.',
                'image' => 'https://images.unsplash.com/photo-1585320806297-9794b3e4eeae?q=80&w=500&auto=format&fit=crop',
                'sort_order' => 8,
            ],
        ];

        foreach ($facilities as $f) {
            $media = $getMedia(Str::slug($f['name']).'.jpg', $f['image'], $f['name']);
            Facility::firstOrCreate(
                ['facility_code' => $f['facility_code']],
                [
                    'category_id' => $f['category_id'],
                    'name' => $f['name'],
                    'capacity' => $f['capacity'],
                    'condition_status' => $f['condition_status'],
                    'description' => $f['description'],
                    'cover_asset_id' => $media->id,
                    'sort_order' => $f['sort_order'],
                ]
            );
        }

        // 7. Prestasi Siswa (trn_achievements)
        $achievements = [
            [
                'category_id' => 1, // Seni FLS2N
                'academic_year_id' => $academicYear->id ?? 1,
                'achievement_title' => 'Juara 1 Tari Kreasi Daerah Sunda FLS2N',
                'competition_name' => 'Festival dan Lomba Seni Siswa Nasional (FLS2N) Tingkat Kabupaten Bogor 2026',
                'level' => 'kabupaten',
                'ranking_position' => 'Juara 1',
                'competition_date' => '2026-08-15',
                'mentor_teacher_id' => $teacherDewi->id ?? null,
                'parent_rep_name' => 'Ibu Dewi Sartika & Wali Murid Paguyuban',
                'recipient_summary' => 'Siti Aisyah & Tim Tari Siswi (Kelas 4-5)',
                'description' => 'Peraih piala utama FLS2N Tingkat Kecamatan Caringin & Lolos ke Tingkat Kabupaten Bogor. Tim siswi kelas 4 & 5 berfoto penghargaan bersama Kepala Sekolah Dra. Hj. Siti Rohmah, M.Pd., guru pembina seni, serta orang tua pendamping.',
                'image' => 'https://images.unsplash.com/photo-1544717302-de2939b7ef71?q=80&w=700&auto=format&fit=crop',
                'is_featured' => 1,
            ],
            [
                'category_id' => 2, // Olahraga O2SN
                'academic_year_id' => $academicYear->id ?? 1,
                'achievement_title' => 'Juara 1 Turnamen Futsal Mini O2SN',
                'competition_name' => 'Olimpiade Olahraga Siswa Nasional (O2SN) Tingkat Kecamatan Caringin 2026',
                'level' => 'kecamatan',
                'ranking_position' => 'Juara 1',
                'competition_date' => '2026-09-02',
                'mentor_teacher_id' => $teacherRizki->id ?? null,
                'parent_rep_name' => 'Guru PJOK & Paguyuban Wali Murid',
                'recipient_summary' => 'Tim Futsal Putra (Kelas 5 & 6)',
                'description' => 'Tim Futsal Putra SDN Cikereteg 01 mengalungi medali emas dan mengangkat trofi juara bersama guru olahraga Bpk. Rizki Ramadhan, S.Pd. serta ayah-bunda wali murid yang setia menyemangati di tribun lapangan.',
                'image' => 'https://images.unsplash.com/photo-1517649763962-0c623266ddc0?q=80&w=700&auto=format&fit=crop',
                'is_featured' => 1,
            ],
            [
                'category_id' => 3, // Sains OSN
                'academic_year_id' => $academicYear->id ?? 1,
                'achievement_title' => 'Medali Perak Olimpiade Sains Nasional (OSN) IPA',
                'competition_name' => 'Olimpiade Sains Nasional (OSN) SD Wilayah II Kabupaten Bogor 2026',
                'level' => 'kabupaten',
                'ranking_position' => 'Medali Perak',
                'competition_date' => '2026-07-28',
                'mentor_teacher_id' => $teacherNur->id ?? null,
                'parent_rep_name' => 'Ibu Nurhasanah, S.Pd.SD. & Ibu Kandung Siswa',
                'recipient_summary' => 'Rizky Aditya Pratama (Kelas 5)',
                'description' => 'Keberhasilan gemilang ananda Rizky Aditya Pratama meraih Medali Perak bidang IPA Terpadu. Menunjukkan kemampuan eksplorasi sains, eksperimen sederhana, serta penalaran kritis sejak tingkat sekolah dasar.',
                'image' => 'https://images.unsplash.com/photo-1577896851231-70ef18881754?q=80&w=700&auto=format&fit=crop',
                'is_featured' => 1,
            ],
            [
                'category_id' => 1, // Seni FLS2N
                'academic_year_id' => $academicYear->id ?? 1,
                'achievement_title' => 'Juara 2 Lomba Menggambar & Mewarnai FLS2N',
                'competition_name' => 'FLS2N SD Kecamatan Caringin 2026',
                'level' => 'kecamatan',
                'ranking_position' => 'Juara 2',
                'competition_date' => '2026-08-12',
                'mentor_teacher_id' => $teacherDewi->id ?? null,
                'parent_rep_name' => 'Dewan Guru Kelas Rendah',
                'recipient_summary' => 'Annisa Zahra Khairunnisa (Kelas 3)',
                'description' => 'Karya lukis bertema Adiwiyata Sekolah Hijau Asri karya Annisa Zahra berhasil memikat dewan juri dengan komposisi warna cerah dan pesan pelestarian alam.',
                'image' => 'https://images.unsplash.com/photo-1509062522246-3755977927d7?q=80&w=700&auto=format&fit=crop',
                'is_featured' => 0,
            ],
            [
                'category_id' => 4, // Pramuka
                'academic_year_id' => $academicYear->id ?? 1,
                'achievement_title' => 'Juara Harapan 1 Lomba Ketangkasan Baris Berbaris Pramuka',
                'competition_name' => 'Jambore Ranting Gerakan Pramuka Kwartir Ranting Caringin 2026',
                'level' => 'kecamatan',
                'ranking_position' => 'Juara Harapan 1',
                'competition_date' => '2026-08-20',
                'mentor_teacher_id' => $teacherHendra->id ?? null,
                'parent_rep_name' => 'Pembina Pramuka Siaga',
                'recipient_summary' => 'Regu Rajawali & Regu Melati (Kelas 5-6)',
                'description' => 'Kedisiplinan baris-berbaris dan kekompakan yel-yel Pramuka Penggalang SDN Cikereteg 01 mengantarkan regu meraih penghargaan dalam perkemahan satu hari.',
                'image' => 'https://images.unsplash.com/photo-1544717305-2782549b5136?q=80&w=700&auto=format&fit=crop',
                'is_featured' => 0,
            ],
        ];

        foreach ($achievements as $ach) {
            $media = $getMedia(Str::slug($ach['achievement_title']).'.jpg', $ach['image'], $ach['achievement_title']);
            Achievement::firstOrCreate(
                ['achievement_title' => $ach['achievement_title']],
                [
                    'category_id' => $ach['category_id'],
                    'academic_year_id' => $ach['academic_year_id'],
                    'competition_name' => $ach['competition_name'],
                    'level' => $ach['level'],
                    'ranking_position' => $ach['ranking_position'],
                    'competition_date' => $ach['competition_date'],
                    'mentor_teacher_id' => $ach['mentor_teacher_id'],
                    'parent_rep_name' => $ach['parent_rep_name'],
                    'recipient_summary' => $ach['recipient_summary'],
                    'description' => $ach['description'],
                    'photo_asset_id' => $media->id,
                    'is_featured' => $ach['is_featured'],
                ]
            );
        }

        // 8. Berita & Artikel (trn_news_articles)
        $articles = [
            [
                'category_id' => 1,
                'title' => 'Gelar Karya P5: Siswa Tampilkan Kreativitas Daur Ulang & Tari Tradisional',
                'slug' => 'gelar-karya-p5-kreativitas-daur-ulang',
                'summary' => 'Siswa-siswi kelas 1 sampai kelas 6 antusias memamerkan hasil karya proyek profil pelajar Pancasila di hadapan wali murid dan dewan guru.',
                'content' => "<p>Suasana semarak menyelimuti halaman utama SDN Cikereteg 01 dalam acara Gelar Karya Projek Penguatan Profil Pelajar Pancasila (P5). Kegiatan yang berlangsung meriah ini dihadiri oleh para wali murid, dewan guru, serta komite sekolah.</p><p>Para peserta didik dari Fase A, B, dan C memamerkan aneka hasil karya kreatif mereka. Mulai dari pot tanaman estetik dari limbah botol plastik, kerajinan anyaman bambu sederhana, hingga olahan pangan tradisional dari singkong dan ubi hasil panen kebun sekolah Adiwiyata.</p><p>Kepala SDN Cikereteg 01, Dra. Hj. Siti Rohmah, M.Pd., menyampaikan apresiasi setinggi-tingginya kepada para siswa dan guru pendamping. 'P5 bukan sekadar pameran produk, melainkan proses menumbuhkan jiwa gotong royong, kemandirian, dan kepedulian lingkungan sejak usia dini,' ungkap beliau dalam sambutannya.</p>",
                'image' => 'https://images.unsplash.com/photo-1577896851231-70ef18881754?q=80&w=700&auto=format&fit=crop',
                'published_at' => '2026-10-18 08:30:00',
            ],
            [
                'category_id' => 1,
                'title' => 'Peringatan Hari Guru: Apel Khidmat & Persembahan Puisi Siswa',
                'slug' => 'peringatan-hari-guru-apel-khidmat',
                'summary' => 'Seluruh warga SDN Cikereteg 01 melaksanakan apel bendera penuh khidmat diselingi pembacaan puisi dari perwakilan murid untuk bapak/ibu guru.',
                'content' => "<p>Dalam rangka memperingati Hari Guru Nasional, keluarga besar SDN Cikereteg 01 menggelar apel bendera penuh rasa syukur dan kekeluargaan. Petugas upacara kali ini seluruhnya dibawakan langsung oleh dewan guru sekolah.</p><p>Momen haru terjadi saat perwakilan siswa kelas 3 membacakan puisi bertajuk 'Pelita Hatiku' yang dipersembahkan untuk seluruh guru yang telah dengan sabar mendidik mereka membaca, menulis, dan berbudi pekerti luhur. Acara ditutup dengan pemotongan tumpeng bersama pengurus paguyuban wali murid.</p>",
                'image' => 'https://images.unsplash.com/photo-1509062522246-3755977927d7?q=80&w=700&auto=format&fit=crop',
                'published_at' => '2026-10-05 09:00:00',
            ],
            [
                'category_id' => 4,
                'title' => 'Pemeriksaan Gigi & Imunisasi Berkala oleh Puskesmas Caringin',
                'slug' => 'pemeriksaan-gigi-dan-imunisasi-puskesmas',
                'summary' => 'Puskesmas Caringin bekerjasama dengan UKS sekolah mengadakan penyuluhan cara menyikat gigi yang benar serta imunisasi rutin bagi siswa kelas 1 dan 2.',
                'content' => '<p>Menjaga kesehatan fisik siswa sejak usia dini merupakan prioritas penting di SDN Cikereteg 01. Bersama tim medis dari Puskesmas Caringin, sekolah menyelenggarakan program pemeriksaan gigi berkala dan Bulan Imunisasi Anak Sekolah (BIAS).</p><p>Siswa kelas 1 dan 2 diajarkan teknik menggosok gigi yang baik menggunakan model gigi peraga. Berkat pendekatan ramah dan ceria dari para dokter dan pembina UKS, Ibu Nurhasanah, S.Pd.SD., anak-anak mengikuti seluruh rangkaian tanpa rasa takut.</p>',
                'image' => 'https://images.unsplash.com/photo-1544717305-2782549b5136?q=80&w=700&auto=format&fit=crop',
                'published_at' => '2026-09-22 10:15:00',
            ],
            [
                'category_id' => 1,
                'title' => 'Simulasi ANBK Kelas 5: Siswa Terbiasa Menggunakan Chromebook',
                'slug' => 'simulasi-anbk-kelas-5-chromebook',
                'summary' => 'Pelaksanaan simulasi Asesmen Nasional Berbasis Komputer berjalan tertib dan lancar di bawah bimbingan proktor dan teknisi sekolah.',
                'content' => '<p>Sebagai persiapan menjelang Asesmen Nasional Berbasis Komputer (ANBK), para siswa kelas 5 SDN Cikereteg 01 mengikuti gladi resik dan simulasi ujian daring di ruang TIK sekolah.</p><p>Dengan ketersediaan unit Chromebook bantuan Kemendikbudristek dan koneksi internet stabil, peserta didik tampak terbiasa mengoperasikan mouse dan keyboard untuk menjawab instrumen literasi membaca dan numerasi bernalar.</p>',
                'image' => 'https://images.unsplash.com/photo-1516321318423-f06f85e504b3?q=80&w=700&auto=format&fit=crop',
                'published_at' => '2026-09-10 11:00:00',
            ],
            [
                'category_id' => 1,
                'title' => 'Semarak Hari Pramuka: Perkemahan Satu Hari Pangkalan Cikereteg 01',
                'slug' => 'semarak-hari-pramuka-perkemahan-satu-hari',
                'summary' => 'Ratusan anggota pramuka Siaga dan Penggalang merayakan hari jadi Pramuka dengan aneka perlombaan ketangkasan dan api unggun gembira.',
                'content' => '<p>Pangkalan Pramuka SDN Cikereteg 01 menyelenggarakan Perkemahan Satu Hari (Persari) dalam rangka menyambut Hari Pramuka. Kegiatan ini diikuti oleh seluruh siswa anggota Siaga dan Penggalang dengan penuh semangat patriotisme.</p><p>Aneka pos ketangkasan digelar di lapangan sekolah, mulai dari semaphore sandi gembira, tali temali pioneering tiang bendera, hingga lomba cerdas cermat Dwi Darma dan Dasa Darma.</p>',
                'image' => 'https://images.unsplash.com/photo-1574629810360-7efbbe195018?q=80&w=700&auto=format&fit=crop',
                'published_at' => '2026-08-14 14:00:00',
            ],
            [
                'category_id' => 3,
                'title' => 'Sosialisasi PPDB Online SDN Cikereteg 01: Bebas Pungutan & Ramah Anak',
                'slug' => 'sosialisasi-ppdb-online-bebas-pungutan',
                'summary' => 'Pihak sekolah mengumumkan pembukaan gelombang pendaftaran peserta didik baru kelas 1 tanpa tes calistung dan bebas biaya.',
                'content' => '<p>SDN Cikereteg 01 mengumumkan kesiapan pelaksanaan Penerimaan Peserta Didik Baru (PPDB) untuk jenjang kelas 1 Sekolah Dasar. Pendaftaran dibuka melalui kanal formulir mandiri online maupun pelayanan langsung di sekretariat sekolah.</p><p>Kepala sekolah menegaskan bahwa sesuai regulasi pemerintah, penerimaan siswa baru jenjang SD tidak memberlakukan tes baca, tulis, dan hitung (calistung). Seluruh biaya operasional sekolah 100% didanai oleh Bantuan Operasional Sekolah (BOS) sehingga bebas dari segala bentuk pungutan.</p>',
                'image' => 'https://images.unsplash.com/photo-1580582932707-520aed937b7b?q=80&w=700&auto=format&fit=crop',
                'published_at' => '2026-08-01 09:30:00',
            ],
        ];

        foreach ($articles as $art) {
            $media = $getMedia(Str::slug($art['title']).'.jpg', $art['image'], $art['title']);
            NewsArticle::firstOrCreate(
                ['slug' => $art['slug']],
                [
                    'category_id' => $art['category_id'],
                    'title' => $art['title'],
                    'summary' => $art['summary'],
                    'content' => $art['content'],
                    'cover_asset_id' => $media->id,
                    'author_user_id' => $authorUser->id ?? 1,
                    'author_name' => 'Tim Humas SDN Cikereteg 01',
                    'status' => 'published',
                    'views_count' => rand(45, 230),
                    'published_at' => $art['published_at'],
                ]
            );
        }

        // 9. Galeri Kegiatan (trn_gallery_items)
        $galleryItems = [
            [
                'category_id' => 5, // P5
                'media_type' => 'foto',
                'title' => 'Pameran Gelar Karya P5 Daur Ulang & Makanan Sehat',
                'event_date' => '2026-10-20',
                'description' => 'Pameran hasil karya siswa SD dalam projek penguatan profil pelajar pancasila. Menampilkan kerajinan tangan dari tutup botol dan olahan umbi lokal.',
                'tags' => 'p5 daur ulang karya pameran merdeka adiwiyata',
                'image' => 'https://images.unsplash.com/photo-1544717302-de2939b7ef71?q=80&w=700&auto=format&fit=crop',
            ],
            [
                'category_id' => 3, // Seni
                'media_type' => 'foto',
                'title' => 'Pentas Tari Jaipong Siswi SD di Panggung Budaya',
                'event_date' => '2026-09-14',
                'description' => 'Penampilan memukau siswi kelas 4 & 5 SDN Cikereteg 01 dalam balutan busana adat Jawa Barat saat seleksi FLS2N tingkat kecamatan.',
                'tags' => 'tari sunda jaipong seni fls2n budaya panggung',
                'image' => 'https://images.unsplash.com/photo-1544717305-2782549b5136?q=80&w=700&auto=format&fit=crop',
            ],
            [
                'category_id' => 2, // Pramuka
                'media_type' => 'foto',
                'title' => 'Apel Upacara Hari Senin & Pelantikan Pramuka Siaga Garuda',
                'event_date' => '2026-09-08',
                'description' => 'Upacara bendera khidmat di lapangan sekolah dilanjutkan penyematan lencana kehormatan Siaga Garuda bagi ananda teladan.',
                'tags' => 'upacara bendera pramuka siaga garuda lapangan',
                'image' => 'https://images.unsplash.com/photo-1509062522246-3755977927d7?q=80&w=700&auto=format&fit=crop',
            ],
            [
                'category_id' => 1, // Belajar
                'media_type' => 'foto',
                'title' => 'Pembelajaran IPA Praktik Menanam Biji Kacang Hijau',
                'event_date' => '2026-08-25',
                'description' => 'Anak-anak kelas 3 belajar mengamati pertumbuhan kecambah dan mencatat hasil pertumbuhan setiap hari di lembar observasi.',
                'tags' => 'sains ipas biologi tanaman belajar merdeka',
                'image' => 'https://images.unsplash.com/photo-1577896851231-70ef18881754?q=80&w=700&auto=format&fit=crop',
            ],
            [
                'category_id' => 4, // Olahraga
                'media_type' => 'foto',
                'title' => 'Turnamen Futsal Antar SD Sekecamatan Caringin',
                'event_date' => '2026-08-18',
                'description' => 'Aksi lincah tim futsal putra SDN Cikereteg 01 menggocek bola hingga berhasil melaju ke babak final turnamen O2SN.',
                'tags' => 'futsal olahraga o2sn juara bola tim',
                'image' => 'https://images.unsplash.com/photo-1517649763962-0c623266ddc0?q=80&w=700&auto=format&fit=crop',
            ],
            [
                'category_id' => 5, // P5
                'media_type' => 'foto',
                'title' => 'Gerakan Bersih Selokan & Memilah Sampah Adiwiyata',
                'event_date' => '2026-08-04',
                'description' => 'Kerja bakti rutin Jumat pagi membiasakan siswa memilah sampah organik dan non-organik untuk menjaga keasrian lingkungan sekolah.',
                'tags' => 'adiwiyata jumat bersih lingkungan sampah kebersihan',
                'image' => 'https://images.unsplash.com/photo-1585320806297-9794b3e4eeae?q=80&w=700&auto=format&fit=crop',
            ],
            [
                'category_id' => 3, // Seni
                'media_type' => 'video',
                'title' => 'Video Dokumentasi: Tari Rampak Kendang Cilik Siswi SD',
                'event_date' => '2026-07-20',
                'description' => 'Rekaman penampilan tim tari SDN Cikereteg 01 saat mengisi pentas seni perpisahan kelas 6 dan sambutan tahun ajaran baru.',
                'tags' => 'video tari jaipong seni pentas perpisahan',
                'image' => 'https://images.unsplash.com/photo-1544717302-de2939b7ef71?q=80&w=700&auto=format&fit=crop',
                'video_embed_url' => 'https://www.youtube.com/embed/dQw4w9WgXcQ',
            ],
            [
                'category_id' => 1, // Belajar
                'media_type' => 'video',
                'title' => 'Video Profil & Tur Fasilitas Ramah Anak SDN Cikereteg 01',
                'event_date' => '2026-07-15',
                'description' => 'Jelajah singkat mengenal ruang kelas sejuk, perpustakaan lesehan, musholla, dan kebun toga bersama pengurus OSIS cilik sekolah.',
                'tags' => 'video tur profil sekolah fasilitas lingkungan',
                'image' => 'https://images.unsplash.com/photo-1580582932707-520aed937b7b?q=80&w=700&auto=format&fit=crop',
                'video_embed_url' => 'https://www.youtube.com/embed/dQw4w9WgXcQ',
            ],
        ];

        foreach ($galleryItems as $gal) {
            $mediaAssetType = $gal['media_type'] === 'video' ? 'video' : 'image';
            $media = $getMedia(Str::slug($gal['title']).'.jpg', $gal['image'], $gal['title'], $mediaAssetType);
            GalleryItem::firstOrCreate(
                ['title' => $gal['title']],
                [
                    'category_id' => $gal['category_id'],
                    'media_type' => $gal['media_type'],
                    'event_date' => $gal['event_date'],
                    'description' => $gal['description'],
                    'media_asset_id' => $media->id,
                    'video_embed_url' => $gal['video_embed_url'] ?? null,
                    'tags' => $gal['tags'] ?? null,
                    'is_published' => 1,
                ]
            );
        }
    }
}

<?php

namespace Database\Seeders;

use App\Models\CmsAnnouncement;
use App\Models\CmsBanner;
use App\Models\CmsKeyHighlight;
use App\Models\CmsPageSection;
use App\Models\CmsTestimonial;
use App\Models\MediaAsset;
use App\Models\SchoolProfile;
use Illuminate\Database\Seeder;

class CmsReusableSeeder extends Seeder
{
    public function run(): void
    {
        // Helper untuk membuat/mengambil MediaAsset demo
        $getMedia = function (string $name, string $url, string $alt): MediaAsset {
            return MediaAsset::firstOrCreate(
                ['file_path' => $url],
                [
                    'file_name' => $name,
                    'file_type' => 'image',
                    'mime_type' => 'image/jpeg',
                    'file_size_kb' => 150,
                    'alt_text' => $alt,
                ]
            );
        };

        $bannerHero1 = $getMedia(
            'hero_banner_upacara.jpg',
            'https://images.unsplash.com/photo-1577896851231-70ef18881754?q=80&w=1200&auto=format&fit=crop',
            'Upacara Bendera Siswa SDN Cikereteg 01'
        );

        $bannerHero2 = $getMedia(
            'hero_banner_belajar.jpg',
            'https://images.unsplash.com/photo-1509062522246-3755977927d7?q=80&w=1200&auto=format&fit=crop',
            'Kegiatan Belajar Kurikulum Merdeka di Kelas'
        );

        $avatarWali = $getMedia(
            'avatar_wali_rahmawati.jpg',
            'https://images.unsplash.com/photo-1544005313-94ddf0286df2?q=80&w=300&auto=format&fit=crop',
            'Ibu Rahmawati Wali Murid Kelas 3A'
        );

        $avatarKomite = $getMedia(
            'avatar_komite_mulyadi.jpg',
            'https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?q=80&w=300&auto=format&fit=crop',
            'Bpk H Mulyadi Ketua Komite Sekolah'
        );

        $avatarAlumni = $getMedia(
            'avatar_alumni_fajar.jpg',
            'https://images.unsplash.com/photo-1500648767791-00dcc994a43e?q=80&w=300&auto=format&fit=crop',
            'dr Fajar Pratama Alumni SDN Cikereteg 01'
        );

        // 1. Inisialisasi Sections Dinamis Beranda (cms_page_sections)
        $sections = [
            [
                'page_code' => 'home',
                'section_key' => 'hero_slider',
                'badge_title' => 'SELAMAT DATANG',
                'title' => 'SDN Cikereteg 01 Caringin',
                'subtitle' => 'Mewujudkan Generasi Beriman, Cerdas Bernalar & Berwawasan Lingkungan',
                'is_visible' => true,
                'sort_order' => 1,
                'metadata_json' => ['autoplay' => true, 'interval_sec' => 5],
            ],
            [
                'page_code' => 'home',
                'section_key' => 'headmaster_welcome',
                'badge_title' => 'SAMBUTAN PIMPINAN',
                'title' => 'Sambutan Kepala Sekolah',
                'subtitle' => 'Mendidik dengan kasih sayang, keteladanan, dan komitmen keunggulan',
                'is_visible' => true,
                'sort_order' => 2,
                'metadata_json' => ['layout' => 'split_photo_text'],
            ],
            [
                'page_code' => 'home',
                'section_key' => 'highlights_metrics',
                'badge_title' => 'KEUNGGULAN UTAMA',
                'title' => 'Pilar Keunggulan Sekolah',
                'subtitle' => 'Komitmen mutu pendidikan dasar terakreditasi A BAN-S/M',
                'is_visible' => true,
                'sort_order' => 3,
                'metadata_json' => ['columns' => 4],
            ],
            [
                'page_code' => 'home',
                'section_key' => 'facilities_preview',
                'badge_title' => 'FASILITAS SEKOLAH',
                'title' => 'Sarana & Prasarana Unggulan',
                'subtitle' => 'Ruang belajar ramah anak, nyaman, dan mendukung minat bakat siswa',
                'is_visible' => true,
                'sort_order' => 4,
                'metadata_json' => ['limit' => 4],
            ],
            [
                'page_code' => 'home',
                'section_key' => 'achievements_preview',
                'badge_title' => 'PRESTASI SISWA',
                'title' => 'Prestasi & Kebanggaan Sekolah',
                'subtitle' => 'Raihan tropi dan medali kejuaraan seni, olahraga, dan sains',
                'is_visible' => true,
                'sort_order' => 5,
                'metadata_json' => ['limit' => 3],
            ],
            [
                'page_code' => 'home',
                'section_key' => 'latest_news',
                'badge_title' => 'KABAR TERKINI',
                'title' => 'Warta & Berita Kegiatan',
                'subtitle' => 'Informasi resmi seputar agenda, pengumuman, dan aktivitas belajar',
                'is_visible' => true,
                'sort_order' => 6,
                'metadata_json' => ['limit' => 3],
            ],
            [
                'page_code' => 'home',
                'section_key' => 'gallery_preview',
                'badge_title' => 'DOKUMENTASI KAMI',
                'title' => 'Galeri Foto & Video Kegiatan',
                'subtitle' => 'Momen kebersamaan, belajar aktif, dan pembiasaan karakter budi pekerti',
                'is_visible' => true,
                'sort_order' => 7,
                'metadata_json' => ['limit' => 6],
            ],
            [
                'page_code' => 'home',
                'section_key' => 'testimonials',
                'badge_title' => 'TESTIMONI',
                'title' => 'Kata Mereka Tentang Kami',
                'subtitle' => 'Apresiasi dan pengalaman nyata dari para wali murid dan alumni',
                'is_visible' => true,
                'sort_order' => 8,
                'metadata_json' => ['columns' => 3],
            ],
            [
                'page_code' => 'home',
                'section_key' => 'ppdb_cta',
                'badge_title' => 'PPDB ONLINE 2026/2027',
                'title' => 'Penerimaan Peserta Didik Baru',
                'subtitle' => 'Mari bergabung dan bertumbuh bersama keluarga besar SDN Cikereteg 01',
                'is_visible' => true,
                'sort_order' => 9,
                'metadata_json' => ['bg_theme' => 'primary_gradient'],
            ],
            [
                'page_code' => 'home',
                'section_key' => 'contact_info',
                'badge_title' => 'KONTAK KAMI',
                'title' => 'Layanan Informasi & Konsultasi',
                'subtitle' => 'Pintu komunikasi terbuka setiap hari kerja bagi orang tua murid',
                'is_visible' => true,
                'sort_order' => 10,
                'metadata_json' => ['show_map' => true],
            ],
        ];

        foreach ($sections as $sec) {
            CmsPageSection::updateOrCreate(
                ['page_code' => $sec['page_code'], 'section_key' => $sec['section_key']],
                $sec
            );
        }

        // 2. Banner Slider & Hero Multi-Halaman (cms_banners)
        $banners = [
            [
                'placement' => 'home_hero',
                'badge_text' => 'SEKOLAH DASAR RUJUKAN RAMAH ANAK',
                'title' => 'Mewujudkan Generasi Beriman, Cerdas Bernalar & Berakhlak Luhur',
                'subtitle' => 'Pendidikan dasar berkualitas berbasis Profil Pelajar Pancasila di Desa Cikereteg, Kec. Caringin, Kabupaten Bogor.',
                'cta_primary_text' => 'Daftar PPDB Online',
                'cta_primary_url' => '/ppdb',
                'cta_secondary_text' => 'Profil Sekolah',
                'cta_secondary_url' => '/profil',
                'media_asset_id' => $bannerHero1->id,
                'sort_order' => 1,
                'is_active' => true,
            ],
            [
                'placement' => 'home_hero',
                'badge_text' => 'KURIKULUM MERDEKA BERBAGI',
                'title' => 'Lingkungan Belajar Interaktif, Asri, dan Berwawasan Lingkungan',
                'subtitle' => 'Didukung dewan guru berkompeten, ruang kelas representatif, dan pembiasaan budaya 5S sejak pagi hari.',
                'cta_primary_text' => 'Fasilitas Belajar',
                'cta_primary_url' => '/fasilitas',
                'cta_secondary_text' => 'Prestasi Siswa',
                'cta_secondary_url' => '/prestasi',
                'media_asset_id' => $bannerHero2->id,
                'sort_order' => 2,
                'is_active' => true,
            ],
            [
                'placement' => 'ppdb_hero',
                'badge_text' => 'TAHUN AJARAN 2026/2027',
                'title' => 'Penerimaan Peserta Didik Baru (PPDB) Kelas 1 SD',
                'subtitle' => 'Proses seleksi transparan melalui jalur Zonasi, Afirmasi, Mutasi Orang Tua, dan Reguler dengan kuota 84 siswa.',
                'cta_primary_text' => 'Isi Formulir Online',
                'cta_primary_url' => '#formulir-pendaftaran',
                'cta_secondary_text' => 'Alur & Persyaratan',
                'cta_secondary_url' => '#alur-ppdb',
                'media_asset_id' => $bannerHero1->id,
                'sort_order' => 1,
                'is_active' => true,
            ],
        ];

        foreach ($banners as $b) {
            CmsBanner::updateOrCreate(
                ['placement' => $b['placement'], 'title' => $b['title']],
                $b
            );
        }

        // 3. Fakta Cepat, Metrik & Keunggulan (cms_key_highlights)
        $highlights = [
            [
                'placement_target' => 'home_pilar',
                'icon_name' => 'verified',
                'metric_value' => 'Akreditasi A',
                'title' => 'Standar Mutu BAN-S/M',
                'description' => 'Tata kelola sekolah, kurikulum, dan sarana terakreditasi unggul secara konsisten.',
                'badge_color' => 'emerald',
                'link_url' => '/profil',
                'sort_order' => 1,
                'is_active' => true,
            ],
            [
                'placement_target' => 'home_pilar',
                'icon_name' => 'menu_book',
                'metric_value' => 'Kurikulum Merdeka',
                'title' => 'Belajar Terdiferensiasi',
                'description' => 'Pendekatan Fase A-C yang menyenangkan, kontekstual, dan menumbuhkan nalar kritis anak.',
                'badge_color' => 'primary',
                'link_url' => '/akademik',
                'sort_order' => 2,
                'is_active' => true,
            ],
            [
                'placement_target' => 'home_pilar',
                'icon_name' => 'emoji_events',
                'metric_value' => '24+ Tropi Juara',
                'title' => 'Prestasi Kejuaraan',
                'description' => 'Raihan prestasi seni tari FLS2N, olahraga O2SN, dan olimpiade sains di tingkat kabupaten.',
                'badge_color' => 'amber',
                'link_url' => '/prestasi',
                'sort_order' => 3,
                'is_active' => true,
            ],
            [
                'placement_target' => 'home_pilar',
                'icon_name' => 'volunteer_activism',
                'metric_value' => 'Budaya 5S & P5',
                'title' => 'Karakter Budi Pekerti',
                'description' => 'Senyum, Salam, Sapa, Sopan, Santun serta pembiasaan sholat dhuha dan cinta lingkungan hidup.',
                'badge_color' => 'sky',
                'link_url' => '/kesiswaan',
                'sort_order' => 4,
                'is_active' => true,
            ],
        ];

        foreach ($highlights as $hl) {
            CmsKeyHighlight::updateOrCreate(
                ['placement_target' => $hl['placement_target'], 'title' => $hl['title']],
                $hl
            );
        }

        // 4. Testimoni Multi-Kategori (cms_testimonials)
        $testimonials = [
            [
                'person_name' => 'Ibu Rahmawati, S.E.',
                'person_category' => 'orang_tua',
                'role_title' => 'Wali Murid Siswa Kelas 3A',
                'testimonial_text' => 'Sangat bersyukur menyekolahkan ananda di SDN Cikereteg 01. Guru-gurunya sangat sabar, penuh perhatian, dan fasilitas belajarnya semakin lengkap. Program pembiasaan 5S di pagi hari benar-benar membentuk sopan santun anak di rumah.',
                'rating' => 5,
                'avatar_asset_id' => $avatarWali->id,
                'placement' => 'home',
                'is_featured' => true,
                'sort_order' => 1,
                'is_active' => true,
            ],
            [
                'person_name' => 'Bpk. H. Mulyadi',
                'person_category' => 'komite',
                'role_title' => 'Ketua Komite SDN Cikereteg 01',
                'testimonial_text' => 'Kerja sama antara pihak sekolah, guru, dan para wali murid terjalin sangat harmonis. Transparansi manajemen sekolah dan dedikasi Ibu Kepala Sekolah patut diacungi jempol demi kemajuan pendidikan anak-anak kita.',
                'rating' => 5,
                'avatar_asset_id' => $avatarKomite->id,
                'placement' => 'home',
                'is_featured' => true,
                'sort_order' => 2,
                'is_active' => true,
            ],
            [
                'person_name' => 'dr. Fajar Pratama',
                'person_category' => 'alumni',
                'role_title' => 'Alumni Angkatan 2008 / Dokter RSUD Ciawi',
                'testimonial_text' => 'Fondasi kedisiplinan dan rasa ingin tahu saya berawal dari bimbingan guru-guru hebat di SDN Cikereteg 01. Sangat bangga melihat almamater tercinta terus berprestasi dan kini memiliki sarana digital yang modern.',
                'rating' => 5,
                'avatar_asset_id' => $avatarAlumni->id,
                'placement' => 'home',
                'is_featured' => true,
                'sort_order' => 3,
                'is_active' => true,
            ],
        ];

        foreach ($testimonials as $t) {
            CmsTestimonial::updateOrCreate(
                ['person_name' => $t['person_name']],
                $t
            );
        }

        // 5. Pengumuman Terjadwal (cms_announcements)
        CmsAnnouncement::updateOrCreate(
            ['title' => 'Pendaftaran PPDB Tahun Ajaran 2026/2027 Resmi Dibuka Daring'],
            [
                'content' => 'Penerimaan Peserta Didik Baru Gelombang 1 dibuka untuk calon siswa kelas 1 SD. Siapkan berkas Kartu Keluarga, Akta Kelahiran, dan Kartu Identitas Anak (KIA). Kuota terbatas untuk 3 rombel belajar.',
                'announcement_type' => 'info',
                'placement_target' => 'global_topbar',
                'cta_text' => 'Daftar PPDB',
                'cta_url' => '/ppdb',
                'start_date' => now()->subDays(2),
                'end_date' => now()->addDays(60),
                'is_active' => true,
            ]
        );

        // 6. Update Perluasan Profil Sekolah (mst_school_profile)
        $profile = SchoolProfile::first();
        if ($profile) {
            $kepsekPhoto = $getMedia(
                'foto_kepsek_resmi.jpg',
                'https://images.unsplash.com/photo-1573496359142-b8d87734a5a2?q=80&w=400&auto=format&fit=crop',
                'Dra. Hj. Siti Rohmah, M.Pd. Kepala Sekolah SDN Cikereteg 01'
            );

            $profile->update([
                'headmaster_welcome_quote' => 'Mendidik dengan kasih sayang, menumbuhkan karakter luhur dan kecerdasan bernalar anak sejak usia dasar.',
                'headmaster_welcome_text' => "Assalamu’alaikum Warahmatullahi Wabarakatuh.\n\nSelamat datang di portal resmi SDN Cikereteg 01 Kecamatan Caringin, Kabupaten Bogor. Puji syukur kita panjatkan ke hadirat Allah SWT atas rahmat dan karunia-Nya, kami dapat menghadirkan media informasi digital ini sebagai jembatan silaturahmi, transparansi, dan layanan publik bagi seluruh warga sekolah, orang tua murid, dan masyarakat luas.\n\nSebagai lembaga pendidikan dasar, kami berkomitmen untuk menciptakan ekosistem belajar yang ramah anak, aman, inklusif, dan menyenangkan. Melalui implementasi Kurikulum Merdeka, pembiasaan karakter budi pekerti 5S, serta pengembangan bakat minat non-akademik, kami berikhtiar mengantarkan peserta didik menjadi generasi yang beriman, bertakwa, berakhlak mulia, cerdas bernalar kritis, dan berwawasan lingkungan hidup.\n\nTerima kasih atas kepercayaan dan sinergi yang luar biasa dari para orang tua murid, komite sekolah, dan dewan guru. Mari bersama-sama kita wujudkan masa depan terbaik bagi putra-putri tercinta.\n\nWassalamu’alaikum Warahmatullahi Wabarakatuh.",
                'headmaster_photo_asset_id' => $kepsekPhoto->id,
                'social_facebook' => 'https://facebook.com/sdncikereteg01',
                'social_instagram' => 'https://instagram.com/sdncikereteg01_official',
                'social_youtube' => 'https://youtube.com/@sdncikereteg01',
                'maps_embed_url' => 'https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3962.883713606771!2d106.8456!3d-6.6912!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0x0!2zNsKwNDEnMjguMyJTIDEwNsKwNTAnNDQuMiJF!5e0!3m2!1sid!2sid!4v1680000000000!5m2!1sid!2sid',
                'operating_hours' => 'Senin - Jumat: 07.00 - 14.30 WIB, Sabtu: 07.30 - 11.30 WIB (Ekskul)',
            ]);
        }
    }
}

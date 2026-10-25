@extends('layouts.frontend')

@section('title', 'Akademik & Kurikulum SD - SDN Cikereteg 01')
@section('meta_description', 'Penerapan Kurikulum Merdeka Fase A, B, dan C di SDN Cikereteg 01. Pembelajaran menyenangkan, berdiferensiasi, dan mengedepankan karakter anak.')

@section('content')
<!-- BREADCRUMB -->
<div class="w-full bg-surface-container-low border-b border-surface-container/60 py-3">
  <div class="max-w-7xl mx-auto px-margin-mobile lg:px-margin">
    <nav aria-label="Breadcrumb" class="flex items-center gap-2 font-label-md text-label-md text-on-surface-variant">
      <a class="hover:text-primary transition-colors flex items-center gap-1" href="{{ route('home') }}">
        <span class="material-symbols-outlined text-[16px]">home</span>
        <span>Beranda</span>
      </a>
      <span class="material-symbols-outlined text-[14px] text-outline">chevron_right</span>
      <span class="text-primary font-semibold">Akademik & Kurikulum SD</span>
    </nav>
  </div>
</div>

<!-- HERO HEADER -->
<section class="w-full py-10 bg-gradient-to-b from-primary/5 via-surface to-surface">
  <div class="max-w-7xl mx-auto px-margin-mobile lg:px-margin">
    <div class="max-w-3xl space-y-3">
      <span class="font-label-sm text-label-sm text-secondary font-bold uppercase tracking-wider">Kurikulum Merdeka SD</span>
      <h1 class="font-headline-xl text-headline-xl text-primary font-extrabold tracking-tight">
        Pembelajaran Menyenangkan & Bermakna di SD
      </h1>
      <p class="font-body-lg text-body-lg text-on-surface-variant leading-relaxed">
        SDN Cikereteg 01 menerapkan <strong>Kurikulum Merdeka</strong> yang berpusat pada minat dan kesiapan belajar anak: Fase A (Kelas 1-2), Fase B (Kelas 3-4), dan Fase C (Kelas 5-6), memperkuat budi pekerti Pancasila dan menumbuhkan kecintaan literasi sejak dini.
      </p>
    </div>
  </div>
</section>

<!-- 3 PILAR PEMBELAJARAN SD -->
<section class="w-full py-10 bg-surface">
  <div class="max-w-7xl mx-auto px-margin-mobile lg:px-margin">
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
      
      <div class="bg-surface-container-lowest p-6 rounded-3xl border border-surface-container shadow-sm space-y-3 card-hover">
        <div class="w-12 h-12 rounded-2xl bg-primary-fixed text-primary flex items-center justify-center font-bold">
          <span class="material-symbols-outlined text-[24px]">diversity_1</span>
        </div>
        <h3 class="font-title-md text-title-md text-primary font-bold">Pembelajaran Berdiferensiasi</h3>
        <p class="font-body-sm text-body-sm text-on-surface-variant leading-relaxed">
          Guru menyesuaikan metode ajar dengan kesiapan belajar setiap anak. Siswa yang butuh bimbingan lebih didampingi dengan sabar, sementara yang sudah mandiri diberi tantangan eksplorasi kreatif.
        </p>
      </div>

      <div class="bg-surface-container-lowest p-6 rounded-3xl border border-surface-container shadow-sm space-y-3 card-hover">
        <div class="w-12 h-12 rounded-2xl bg-secondary-fixed text-secondary flex items-center justify-center font-bold">
          <span class="material-symbols-outlined text-[24px]">psychology_alt</span>
        </div>
        <h3 class="font-title-md text-title-md text-primary font-bold">Projek Karakter (P5)</h3>
        <p class="font-body-sm text-body-sm text-on-surface-variant leading-relaxed">
          Belajar kontekstual di luar kelas! Siswa diajak berkebun sayur hidroponik di taman sekolah Adiwiyata, memilah sampah daur ulang, dan mementaskan kesenian kearifan lokal Sunda.
        </p>
      </div>

      <div class="bg-surface-container-lowest p-6 rounded-3xl border border-surface-container shadow-sm space-y-3 card-hover">
        <div class="w-12 h-12 rounded-2xl bg-tertiary-fixed text-tertiary-container flex items-center justify-center font-bold">
          <span class="material-symbols-outlined text-[24px]">menu_book</span>
        </div>
        <h3 class="font-title-md text-title-md text-primary font-bold">Literasi & Numerasi Gembira</h3>
        <p class="font-body-sm text-body-sm text-on-surface-variant leading-relaxed">
          Membiasakan membaca 15 menit setiap pagi di Pojok Baca kelas dan mengenalkan konsep hitung dasar melalui benda konkrit sehari-hari tanpa beban hafalan rumus yang membingungkan anak.
        </p>
      </div>

    </div>
  </div>
</section>

<!-- FASE PERKEMBANGAN BELAJAR SD -->
<section class="w-full py-12 bg-surface-container-low" id="fase">
  <div class="max-w-7xl mx-auto px-margin-mobile lg:px-margin">
    <div class="text-center max-w-2xl mx-auto mb-10">
      <span class="font-label-sm text-label-sm text-secondary font-bold uppercase tracking-wider">Tingkatan Belajar</span>
      <h2 class="font-headline-md text-headline-md text-primary font-extrabold mt-1">Struktur Tiga Fase Belajar Siswa SD</h2>
      <p class="font-body-md text-body-md text-on-surface-variant mt-2">
        Materi ajar berjenjang mengikuti daya tangkap, motorik, dan emosi anak Sekolah Dasar.
      </p>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
      @foreach($phases as $phase)
        <div id="fase-{{ strtolower(str_replace(' ', '-', $phase->phase_code)) }}" class="bg-surface-container-lowest rounded-3xl p-6 border border-surface-container shadow-sm space-y-4 card-hover">
          <div class="flex items-center justify-between pb-2 border-b border-surface-container">
            <div>
              <span class="text-xs font-bold uppercase text-primary">{{ $phase->phase_code }}</span>
              <h3 class="font-title-lg text-title-lg text-primary font-bold">{{ $phase->grades_coverage }}</h3>
            </div>
            <span class="text-xs px-2.5 py-1 rounded-full bg-primary-fixed text-primary font-bold">
              @if($phase->phase_code === 'Fase A') Usia 6 - 8 Th @elseif($phase->phase_code === 'Fase B') Usia 8 - 10 Th @else Usia 10 - 12 Th @endif
            </span>
          </div>
          <p class="font-body-sm text-sm text-on-surface-variant leading-relaxed">
            {{ $phase->focus_description }}
          </p>
          <div class="space-y-2 text-xs text-on-surface">
            <div class="font-bold text-primary">Capaian Pembelajaran:</div>
            <ul class="space-y-1.5 list-disc list-inside text-on-surface-variant">
              @if($phase->phase_code === 'Fase A')
                <li>Mengenal huruf, membaca cerita bergambar fabel tanpa tes calistung</li>
                <li>Mengenal angka, berhitung konkret penjumlahan & pengurangan dasar</li>
                <li>Pendidikan Agama Islam, budi pekerti, dan hafalan doa harian</li>
                <li>Pendidikan Pancasila: saling berbagi, tolong-menolong & antri tertib</li>
              @elseif($phase->phase_code === 'Fase B')
                <li>Bahasa Indonesia: karangan narasi pendek & presentasi percaya diri</li>
                <li>Matematika: perkalian, pembagian, pengukuran jam, dan mata uang</li>
                <li>IPAS: ekosistem alam, tumbuhan, dan lingkungan sekitar Caringin</li>
                <li>Kearifan lokal Sunda, tari kreasi & proyek P5 daur ulang sampah</li>
              @else
                <li>Matematika aplikatif: pecahan, luas bangun datar & logika data</li>
                <li>Simulasi ANBK resmi Kemendikbudristek di ruang komputer TIK</li>
                <li>Praktik sains sederhana & eksperimen lingkungan Adiwiyata</li>
                <li>Pengembangan karakter kepemimpinan siswa & persiapan jenjang SMP</li>
              @endif
            </ul>
          </div>
        </div>
      @endforeach
    </div>
  </div>
</section>

<!-- JADWAL HARIAN & WAKTU KEPULANGAN BERTAHAP -->
<section class="w-full py-12 bg-surface">
  <div class="max-w-7xl mx-auto px-margin-mobile lg:px-margin">
    <div class="bg-surface-container-lowest rounded-3xl p-6 sm:p-8 border border-surface-container shadow-sm">
      <div class="max-w-2xl mb-6">
        <span class="font-label-sm text-label-sm text-secondary font-bold uppercase tracking-wider">Kedisiplinan Sekolah</span>
        <h2 class="font-headline-sm text-headline-sm text-primary font-extrabold mt-1">Jadwal Harian & Waktu Kepulangan Bertahap</h2>
        <p class="font-body-sm text-on-surface-variant mt-1">Siswa hadir pukul 06.45 WIB untuk mengikuti penyambutan 5S dan literasi pagi sebelum bel masuk kelas.</p>
      </div>

      <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <div class="p-5 rounded-2xl bg-surface-container-low border border-surface-container">
          <div class="flex items-center gap-2 text-primary font-bold text-base mb-3">
            <span class="material-symbols-outlined text-[20px]">wb_sunny</span>
            <span>Rutinitas Pagi (Senin - Jumat)</span>
          </div>
          <ul class="space-y-2 text-xs sm:text-sm text-on-surface">
            <li class="flex justify-between py-1.5 border-b border-surface-container/60">
              <span class="font-mono text-outline">06.45 - 07.00 WIB</span>
              <span class="font-semibold text-primary">Penyambutan 5S di Gerbang Sekolah</span>
            </li>
            <li class="flex justify-between py-1.5 border-b border-surface-container/60">
              <span class="font-mono text-outline">07.00 - 07.15 WIB</span>
              <span>Doa Pagi Bersama & Literasi Pojok Baca</span>
            </li>
            <li class="flex justify-between py-1.5 border-b border-surface-container/60">
              <span class="font-mono text-outline">07.15 - 09.30 WIB</span>
              <span>Kegiatan Belajar Sesi I</span>
            </li>
            <li class="flex justify-between py-1.5 border-b border-surface-container/60">
              <span class="font-mono text-outline">09.30 - 10.00 WIB</span>
              <span class="font-semibold text-secondary">Istirahat & Kudapan Sehat</span>
            </li>
            <li class="flex justify-between py-1.5 text-xs text-on-surface-variant">
              <span class="font-mono text-outline">10.00 - Selesai</span>
              <span>Kegiatan Belajar Sesi II & Pembelajaran Proyek</span>
            </li>
          </ul>
        </div>

        <div class="p-5 rounded-2xl bg-surface-container-low border border-surface-container">
          <div class="flex items-center gap-2 text-primary font-bold text-base mb-3">
            <span class="material-symbols-outlined text-[20px]">schedule</span>
            <span>Waktu Kepulangan Bertahap Siswa</span>
          </div>
          <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
            @foreach($grades as $grade)
              <div class="p-3 rounded-xl bg-surface-container-lowest border border-surface-container flex items-center justify-between">
                <div>
                  <div class="font-bold text-primary text-sm">Kelas {{ $grade->grade_level }} SD</div>
                  <div class="text-[11px] text-on-surface-variant">{{ $grade->phase?->phase_code }}</div>
                </div>
                <div class="text-right">
                  <span class="font-mono font-bold text-secondary text-sm">{{ substr($grade->dismissal_time, 0, 5) }}</span>
                  <span class="text-[10px] text-outline block">WIB</span>
                </div>
              </div>
            @endforeach
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- DAFTAR MATA PELAJARAN SD -->
<section class="w-full py-12 bg-surface-container-low" id="mapel">
  <div class="max-w-7xl mx-auto px-margin-mobile lg:px-margin">
    <div class="text-center max-w-2xl mx-auto mb-10">
      <span class="font-label-sm text-label-sm text-secondary font-bold uppercase tracking-wider">Kurikulum Dasar</span>
      <h2 class="font-headline-md text-headline-md text-primary font-extrabold mt-1">Mata Pelajaran Kurikulum Merdeka</h2>
      <p class="font-body-md text-body-md text-on-surface-variant mt-2">
        Mata pelajaran dirancang proporsional dan kontekstual, mendukung kecakapan abad-21 dan kecintaan budaya Sunda.
      </p>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
      @foreach($subjects as $subj)
        <div class="bg-surface-container-lowest p-4 rounded-2xl border border-surface-container shadow-sm flex items-center gap-3">
          <div class="w-10 h-10 rounded-xl bg-primary-fixed text-primary flex items-center justify-center font-bold text-xs shrink-0">
            {{ $subj->subject_code }}
          </div>
          <div>
            <h4 class="font-bold text-primary text-sm">{{ $subj->subject_name }}</h4>
            <span class="text-[11px] text-on-surface-variant capitalize">{{ str_replace('_', ' ', $subj->category) }}</span>
          </div>
        </div>
      @endforeach
    </div>
  </div>
</section>
@endsection

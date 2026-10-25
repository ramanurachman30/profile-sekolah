@extends('layouts.frontend')

@section('title', 'Profil Sekolah - SDN Cikereteg 01')
@section('meta_description', 'Mengenal sejarah, visi, misi, dan susunan dewan guru profesional di SDN Cikereteg 01, Kec. Caringin, Kab. Bogor.')

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
      <span class="text-primary font-semibold">Profil Sekolah</span>
    </nav>
  </div>
</div>

<!-- HERO HEADER -->
<section class="w-full py-10 bg-gradient-to-b from-primary/5 via-surface to-surface">
  <div class="max-w-7xl mx-auto px-margin-mobile lg:px-margin">
    <div class="max-w-3xl space-y-3">
      <span class="font-label-sm text-label-sm text-secondary font-bold uppercase tracking-wider">Identitas & Kelembagaan</span>
      <h1 class="font-headline-xl text-headline-xl text-primary font-extrabold tracking-tight">
        Profil Resmi {{ $profile->school_name ?? 'SDN Cikereteg 01' }}
      </h1>
      <p class="font-body-lg text-body-lg text-on-surface-variant leading-relaxed">
        Mengenal lebih dekat visi, misi, sejarah pengabdian, serta susunan dewan guru yang membimbing setiap langkah belajar putra-putri tercinta di {{ $profile->school_name ?? 'SDN Cikereteg 01' }}, {{ $profile->sub_district ?? 'Kecamatan Caringin' }}, {{ $profile->district ?? 'Kabupaten Bogor' }}.
      </p>
    </div>
  </div>
</section>

<!-- IDENTITAS FORMAL SEKOLAH -->
<section class="w-full py-8 bg-surface">
  <div class="max-w-7xl mx-auto px-margin-mobile lg:px-margin">
    <div class="grid grid-cols-2 sm:grid-cols-4 gap-4">
      <div class="bg-surface-container-lowest p-5 rounded-2xl border border-surface-container shadow-sm">
        <span class="text-xs text-on-surface-variant font-semibold block">Nama Sekolah</span>
        <span class="font-bold text-primary text-base sm:text-lg mt-0.5 block">{{ $profile->school_name ?? 'SDN Cikereteg 01' }}</span>
      </div>
      <div class="bg-surface-container-lowest p-5 rounded-2xl border border-surface-container shadow-sm">
        <span class="text-xs text-on-surface-variant font-semibold block">Nomor Pokok (NPSN)</span>
        <span class="font-bold text-primary text-base sm:text-lg mt-0.5 block">{{ $profile->npsn ?? '20200845' }}</span>
      </div>
      <div class="bg-surface-container-lowest p-5 rounded-2xl border border-surface-container shadow-sm">
        <span class="text-xs text-on-surface-variant font-semibold block">Status Sekolah</span>
        <span class="font-bold text-primary text-base sm:text-lg mt-0.5 block">{{ $profile->school_level ?? 'Sekolah Dasar (Negeri)' }}</span>
      </div>
      <div class="bg-surface-container-lowest p-5 rounded-2xl border border-surface-container shadow-sm">
        <span class="text-xs text-on-surface-variant font-semibold block">Nilai Akreditasi</span>
        <span class="font-bold text-tertiary-container text-base sm:text-lg mt-0.5 block">Akreditasi {{ $profile->accreditation ?? 'A' }} (Unggul)</span>
      </div>
    </div>
  </div>
</section>

<!-- VISI & MISI SEKOLAH -->
<section class="w-full py-12 bg-surface-container-low" id="visi-misi">
  <div class="max-w-7xl mx-auto px-margin-mobile lg:px-margin">
    <div class="text-center max-w-2xl mx-auto mb-10">
      <span class="font-label-sm text-label-sm text-secondary font-bold uppercase tracking-wider">Arah & Landasan</span>
      <h2 class="font-headline-md text-headline-md text-primary font-extrabold mt-1">Visi & Misi {{ $profile->school_name ?? 'SDN Cikereteg 01' }}</h2>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start">
      
      <!-- Visi Card -->
      <div class="lg:col-span-5 bg-surface-container-lowest p-6 sm:p-8 rounded-3xl border border-surface-container shadow-sm space-y-4">
        <div class="w-12 h-12 rounded-2xl bg-primary-fixed text-primary flex items-center justify-center">
          <span class="material-symbols-outlined text-[26px]">visibility</span>
        </div>
        <h3 class="font-title-lg text-title-lg text-primary font-extrabold">Visi Sekolah</h3>
        <blockquote class="p-4 rounded-2xl bg-surface-container-low border-l-4 border-primary text-primary font-bold text-base leading-relaxed">
          "{{ $profile->vision ?? 'Terwujudnya Peserta Didik yang Beriman, Bertaqwa, Berakhlak Mulia, Cerdas Bernalar, Terampil, Mandiri, dan Berwawasan Lingkungan Berdasarkan Profil Pelajar Pancasila.' }}"
        </blockquote>
        <p class="font-body-sm text-sm text-on-surface-variant leading-relaxed">
          Visi ini menjadi penuntun seluruh kegiatan kurikuler, pembiasaan karakter 5S, kesiswaan, dan tata kelola lingkungan hijau Adiwiyata di {{ $profile->school_name ?? 'SDN Cikereteg 01' }}.
        </p>
      </div>

      <!-- Misi Card -->
      <div class="lg:col-span-7 bg-surface-container-lowest p-6 sm:p-8 rounded-3xl border border-surface-container shadow-sm space-y-4">
        <div class="w-12 h-12 rounded-2xl bg-secondary-fixed text-secondary flex items-center justify-center">
          <span class="material-symbols-outlined text-[26px]">task_alt</span>
        </div>
        <h3 class="font-title-lg text-title-lg text-primary font-extrabold">Misi Sekolah</h3>
        @php
            $missions = explode("\n", $profile->mission ?? '');
        @endphp
        <ul class="space-y-3 font-body-sm text-sm text-on-surface">
          @foreach($missions as $index => $mission)
            @if(trim($mission))
              <li class="flex items-start gap-3">
                <span class="w-6 h-6 rounded-full bg-primary-fixed text-primary font-bold flex items-center justify-center shrink-0 text-xs mt-0.5">{{ $index + 1 }}</span>
                <span>{{ preg_replace('/^\d+\.\s*/', '', trim($mission)) }}</span>
              </li>
            @endif
          @endforeach
        </ul>
      </div>

    </div>
  </div>
</section>

<!-- SEJARAH RINGKAS -->
<section class="w-full py-12 bg-surface" id="sejarah">
  <div class="max-w-7xl mx-auto px-margin-mobile lg:px-margin">
    <div class="bg-surface-container-lowest p-6 sm:p-8 rounded-3xl border border-surface-container shadow-sm space-y-4">
      <span class="font-label-sm text-label-sm text-secondary font-bold uppercase tracking-wider">Perjalanan Pengabdian</span>
      <h2 class="font-headline-sm text-headline-sm text-primary font-extrabold">Sejarah Singkat {{ $profile->school_name ?? 'SDN Cikereteg 01' }}</h2>
      <div class="prose max-w-none text-on-surface-variant font-body-md text-sm sm:text-base leading-relaxed space-y-3">
        <p>
          {{ $profile->history_summary ?? 'SDN Cikereteg 01 resmi didirikan pada tahun 1985 untuk melayani kebutuhan pendidikan dasar masyarakat Desa Cikereteg, Caringin, Kab. Bogor.' }}
        </p>
        <p>
          Bermula dari bangunan bersahaja dengan 3 ruang kelas dasar, sekolah terus bertumbuh dan berbenah sarana prasarananya. Kini sekolah memiliki rombongan belajar lengkap (Kelas 1 sampai Kelas 6), ruang perpustakaan sekolah yang nyaman, ruang komputer TIK untuk ANBK, ruang UKS, musholla, kantin sehat, serta lapangan olahraga yang asri.
        </p>
        <p>
          Dengan predikat <strong>Akreditasi A</strong> dan implementasi <strong>Kurikulum Merdeka</strong>, sekolah terus berkomitmen menjadi rumah kedua yang hangat bagi para siswa untuk bertumbuh cerdas dan berkarakter mulia.
        </p>
      </div>
    </div>
  </div>
</section>

<!-- DEWAN GURU & TENAGA KEPENDIDIKAN SD -->
<section class="w-full py-12 bg-surface-container-low" id="guru">
  <div class="max-w-7xl mx-auto px-margin-mobile lg:px-margin">
    <div class="text-center max-w-2xl mx-auto mb-10">
      <span class="font-label-sm text-label-sm text-secondary font-bold uppercase tracking-wider">Pendidik Berdedikasi</span>
      <h2 class="font-headline-md text-headline-md text-primary font-extrabold mt-1">Kepala Sekolah & Dewan Guru</h2>
      <p class="font-body-md text-body-md text-on-surface-variant mt-2">
        Pendidik profesional yang sabar dan penuh kasih sayang membimbing langkah belajar putra-putri Anda di Sekolah Dasar.
      </p>
    </div>

    <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 gap-6">
      @forelse($teachers as $teacher)
        <div class="bg-surface-container-lowest rounded-2xl overflow-hidden border border-surface-container shadow-sm text-center card-hover flex flex-col justify-between">
          <div>
            <div class="w-full h-44 overflow-hidden relative">
              <img src="{{ $teacher->photo?->url ?? 'https://images.unsplash.com/photo-1544717305-2782549b5136?q=80&w=400&auto=format&fit=crop' }}" alt="{{ $teacher->full_name }}" class="w-full h-full object-cover" />
            </div>
            <div class="p-4 space-y-1">
              <h4 class="font-bold text-primary text-sm">{{ $teacher->full_name }}</h4>
              <span class="text-xs text-secondary font-bold block">{{ $teacher->role_title }}</span>
              <span class="text-[11px] text-on-surface-variant block">{{ $teacher->education }}</span>
              @if($teacher->consultation_hours)
                <span class="text-[10px] text-outline block pt-1">Konsultasi: {{ $teacher->consultation_hours }}</span>
              @endif
            </div>
          </div>
          @if($teacher->motto)
            <div class="px-4 pb-4 text-[10px] italic text-on-surface-variant border-t border-surface-container pt-2">
              "{{ Str::limit($teacher->motto, 60) }}"
            </div>
          @endif
        </div>
      @empty
        <div class="col-span-4 text-center py-8 text-on-surface-variant">Belum ada data dewan guru terdaftar.</div>
      @endforelse
    </div>
  </div>
</section>
@endsection

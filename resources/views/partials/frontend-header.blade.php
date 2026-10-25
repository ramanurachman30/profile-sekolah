@php
    $profile = \App\Models\SchoolProfile::first();
    $activePeriod = \App\Models\PpdbPeriod::open()->first();
@endphp

<!-- HEADER NAVIGATION -->
<header class="fixed top-0 left-0 right-0 z-50 w-full shadow-[0_1px_8px_rgba(0,0,0,0.04)]">
  <!-- Top info bar -->
  <div class="w-full bg-primary text-on-primary">
    <div class="max-w-7xl mx-auto px-margin-mobile lg:px-margin h-10 flex items-center justify-between font-label-sm text-label-sm">
      <div class="flex items-center gap-space-md overflow-x-auto py-1">
        <div class="flex items-center gap-1.5 whitespace-nowrap">
          <span class="material-symbols-outlined text-[15px] text-secondary-fixed">location_on</span>
          <span>{{ $profile->address ?? 'Jl. Raya Cikereteg No. 12, Kec. Caringin, Kab. Bogor' }}</span>
        </div>
        <span class="opacity-40 hidden sm:inline">•</span>
        <a class="hidden sm:flex items-center gap-1 hover:text-secondary-fixed transition-colors whitespace-nowrap" href="tel:{{ preg_replace('/[^0-9]/', '', $profile->phone ?? '02518241234') }}">
          <span class="material-symbols-outlined text-[15px]">call</span>
          <span>{{ $profile->phone ?? '(0251) 824-1234' }}</span>
        </a>
        <span class="opacity-40 hidden md:inline">•</span>
        <div class="hidden md:flex items-center gap-1 opacity-90 whitespace-nowrap">
          <span class="material-symbols-outlined text-[15px]">schedule</span>
          <span>Senin - Jumat: 07.00 - 14.30 WIB</span>
        </div>
      </div>
      <div class="flex items-center gap-2 whitespace-nowrap">
        <span class="inline-flex items-center px-2 py-0.5 rounded bg-primary-container text-on-primary font-bold text-xs">
          NPSN: {{ $profile->npsn ?? '20200845' }}
        </span>
        <span class="inline-flex items-center px-2 py-0.5 rounded bg-tertiary-fixed text-on-tertiary-fixed font-bold text-xs">
          Akreditasi {{ $profile->accreditation ?? 'A' }}
        </span>
      </div>
    </div>
  </div>

  <!-- Main Navigation Bar -->
  <div class="h-20 bg-surface-container-lowest/95 backdrop-blur-md">
    <div class="max-w-7xl mx-auto px-margin-mobile lg:px-margin h-full flex items-center justify-between gap-space-md">
      <!-- Logo & Title -->
      <a class="flex items-center gap-3" href="{{ route('home') }}">
        <div class="w-11 h-11 rounded-2xl bg-primary text-on-primary flex items-center justify-center font-extrabold text-xl shadow-sm">
          <span class="material-symbols-outlined text-[26px] text-secondary-fixed">school</span>
        </div>
        <div class="flex flex-col">
          <span class="font-headline-sm text-headline-sm text-primary tracking-tight font-extrabold leading-none">{{ $profile->school_name ?? 'SDN CIKERETEG 01' }}</span>
          <span class="font-label-sm text-label-sm text-on-surface-variant uppercase tracking-wider font-semibold">{{ $profile->sub_district ?? 'Caringin' }}, {{ $profile->district ?? 'Kab. Bogor' }}</span>
        </div>
      </a>

      <!-- Desktop Navigation Links -->
      <nav class="hidden xl:flex items-center gap-1 font-label-lg text-label-lg">
        <a class="px-2.5 py-1.5 rounded-lg transition-colors {{ request()->routeIs('home') ? 'text-primary font-bold bg-primary-fixed/30' : 'text-on-surface-variant hover:text-on-surface' }}" href="{{ route('home') }}">Beranda</a>
        <a class="px-2.5 py-1.5 rounded-lg transition-colors {{ request()->routeIs('profile') ? 'text-primary font-bold bg-primary-fixed/30' : 'text-on-surface-variant hover:text-on-surface' }}" href="{{ route('profile') }}">Profil</a>
        <a class="px-2.5 py-1.5 rounded-lg transition-colors {{ request()->routeIs('academic') ? 'text-primary font-bold bg-primary-fixed/30' : 'text-on-surface-variant hover:text-on-surface' }}" href="{{ route('academic') }}">Akademik</a>
        <a class="px-2.5 py-1.5 rounded-lg transition-colors {{ request()->routeIs('student-affairs') ? 'text-primary font-bold bg-primary-fixed/30' : 'text-on-surface-variant hover:text-on-surface' }}" href="{{ route('student-affairs') }}">Kesiswaan</a>
        <a class="px-2.5 py-1.5 rounded-lg transition-colors {{ request()->routeIs('facilities') ? 'text-primary font-bold bg-primary-fixed/30' : 'text-on-surface-variant hover:text-on-surface' }}" href="{{ route('facilities') }}">Fasilitas</a>
        <a class="px-2.5 py-1.5 rounded-lg transition-colors {{ request()->routeIs('achievements') ? 'text-primary font-bold bg-primary-fixed/30' : 'text-on-surface-variant hover:text-on-surface' }}" href="{{ route('achievements') }}">Prestasi</a>
        <a class="px-2.5 py-1.5 rounded-lg transition-colors {{ request()->routeIs('news.*') ? 'text-primary font-bold bg-primary-fixed/30' : 'text-on-surface-variant hover:text-on-surface' }}" href="{{ route('news.index') }}">Berita</a>
        <a class="px-2.5 py-1.5 rounded-lg transition-colors {{ request()->routeIs('gallery') ? 'text-primary font-bold bg-primary-fixed/30' : 'text-on-surface-variant hover:text-on-surface' }}" href="{{ route('gallery') }}">Galeri</a>
        <a class="px-2.5 py-1.5 rounded-lg transition-colors {{ request()->routeIs('ppdb.*') ? 'text-primary font-bold bg-primary-fixed/30' : 'text-on-surface-variant hover:text-on-surface' }}" href="{{ route('ppdb.index') }}">PPDB</a>
        <a class="px-2.5 py-1.5 rounded-lg transition-colors {{ request()->routeIs('contact.*') ? 'text-primary font-bold bg-primary-fixed/30' : 'text-on-surface-variant hover:text-on-surface' }}" href="{{ route('contact.index') }}">Kontak</a>
      </nav>

      <!-- Right CTA & Mobile Toggle Button -->
      <div class="flex items-center gap-space-sm">
        <a class="relative inline-flex items-center gap-2 bg-primary-container hover:bg-primary text-on-primary font-label-lg text-label-lg px-4 py-2.5 rounded-xl transition-all shadow-[0_2px_8px_rgba(30,58,138,0.18)]" href="{{ route('ppdb.index') }}">
          <span class="material-symbols-outlined text-[18px]">how_to_reg</span>
          <span>PPDB SD</span>
        </a>

        <button id="mobileMenuBtn" aria-label="Buka menu navigasi" class="xl:hidden w-11 h-11 flex items-center justify-center rounded-xl bg-surface-container-high text-on-surface hover:bg-surface-container-highest transition-colors">
          <span id="mobileMenuIcon" class="material-symbols-outlined text-[24px]">menu</span>
        </button>
      </div>
    </div>
  </div>

  <!-- Mobile Drawer -->
  <div id="mobileDrawer" class="hidden xl:hidden bg-surface-container-lowest border-b border-outline-variant/30 px-margin-mobile py-4 shadow-xl">
    <nav class="flex flex-col gap-1 font-label-lg text-label-lg">
      <a class="py-2.5 px-3 rounded-lg {{ request()->routeIs('home') ? 'bg-primary-fixed/30 text-primary font-bold' : 'text-on-surface-variant hover:bg-surface-container' }}" href="{{ route('home') }}">Beranda</a>
      <a class="py-2.5 px-3 rounded-lg {{ request()->routeIs('profile') ? 'bg-primary-fixed/30 text-primary font-bold' : 'text-on-surface-variant hover:bg-surface-container' }}" href="{{ route('profile') }}">Profil Sekolah</a>
      <a class="py-2.5 px-3 rounded-lg {{ request()->routeIs('academic') ? 'bg-primary-fixed/30 text-primary font-bold' : 'text-on-surface-variant hover:bg-surface-container' }}" href="{{ route('academic') }}">Akademik & Kurikulum</a>
      <a class="py-2.5 px-3 rounded-lg {{ request()->routeIs('student-affairs') ? 'bg-primary-fixed/30 text-primary font-bold' : 'text-on-surface-variant hover:bg-surface-container' }}" href="{{ route('student-affairs') }}">Kesiswaan & Ekskul</a>
      <a class="py-2.5 px-3 rounded-lg {{ request()->routeIs('facilities') ? 'bg-primary-fixed/30 text-primary font-bold' : 'text-on-surface-variant hover:bg-surface-container' }}" href="{{ route('facilities') }}">Fasilitas Sekolah</a>
      <a class="py-2.5 px-3 rounded-lg {{ request()->routeIs('achievements') ? 'bg-primary-fixed/30 text-primary font-bold' : 'text-on-surface-variant hover:bg-surface-container' }}" href="{{ route('achievements') }}">Prestasi Siswa</a>
      <a class="py-2.5 px-3 rounded-lg {{ request()->routeIs('news.*') ? 'bg-primary-fixed/30 text-primary font-bold' : 'text-on-surface-variant hover:bg-surface-container' }}" href="{{ route('news.index') }}">Berita & Agenda</a>
      <a class="py-2.5 px-3 rounded-lg {{ request()->routeIs('gallery') ? 'bg-primary-fixed/30 text-primary font-bold' : 'text-on-surface-variant hover:bg-surface-container' }}" href="{{ route('gallery') }}">Galeri</a>
      <a class="py-2.5 px-3 rounded-lg {{ request()->routeIs('ppdb.*') ? 'bg-primary-fixed/30 text-primary font-bold' : 'text-on-surface-variant hover:bg-surface-container' }}" href="{{ route('ppdb.index') }}">Info PPDB SD</a>
      <a class="py-2.5 px-3 rounded-lg {{ request()->routeIs('contact.*') ? 'bg-primary-fixed/30 text-primary font-bold' : 'text-on-surface-variant hover:bg-surface-container' }}" href="{{ route('contact.index') }}">Kontak & Lokasi</a>
    </nav>
  </div>
</header>

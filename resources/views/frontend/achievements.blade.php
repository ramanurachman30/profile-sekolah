@extends('layouts.frontend')

@section('title', 'Prestasi Siswa - SDN Cikereteg 01')
@section('meta_description', 'Showcase prestasi dan kejuaraan siswa SDN Cikereteg 01 dalam bidang sains OSN, olahraga O2SN, seni tari FLS2N, dan pramuka bersama dewan guru.')

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
      <span class="text-primary font-semibold">Prestasi Siswa</span>
    </nav>
  </div>
</div>

<!-- HERO HEADER -->
<section class="w-full py-10 bg-gradient-to-b from-primary/5 via-surface to-surface">
  <div class="max-w-7xl mx-auto px-margin-mobile lg:px-margin">
    <div class="max-w-3xl space-y-3">
      <span class="font-label-sm text-label-sm text-secondary font-bold uppercase tracking-wider">Showcase Kejuaraan</span>
      <h1 class="font-headline-xl text-headline-xl text-primary font-extrabold tracking-tight">
        Prestasi Gemilang Siswa SDN Cikereteg 01
      </h1>
      <p class="font-body-lg text-body-lg text-on-surface-variant leading-relaxed">
        Dokumentasi kejuaraan resmi yang diraih oleh putra-putri berprestasi bersama guru pembimbing dan paguyuban orang tua murid dalam ajang OSN, O2SN, FLS2N, serta kepramukaan.
      </p>
    </div>
  </div>
</section>

<!-- FILTER & PENCARIAN PRESTASI -->
<section class="w-full py-6 bg-surface">
  <div class="max-w-7xl mx-auto px-margin-mobile lg:px-margin">
    <div class="bg-surface-container-lowest p-6 rounded-3xl border border-surface-container shadow-sm space-y-4">
      <form method="GET" action="{{ route('achievements') }}" class="flex flex-col md:flex-row md:items-center justify-between gap-4">
        
        <!-- Category Filter Buttons -->
        <div class="flex flex-wrap items-center gap-2">
          <a href="{{ route('achievements') }}" class="px-4 py-2 rounded-xl font-label-md text-xs font-bold transition-all shadow-sm {{ !request('category') || request('category') === 'all' ? 'bg-primary text-on-primary' : 'bg-surface-container-high text-on-surface-variant hover:text-primary' }}">
            Semua Prestasi
          </a>
          @foreach($categories as $cat)
            <a href="{{ route('achievements', ['category' => $cat->slug, 'search' => request('search')]) }}" class="px-4 py-2 rounded-xl font-label-md text-xs font-bold transition-all {{ request('category') === $cat->slug ? 'bg-primary text-on-primary' : 'bg-surface-container-high text-on-surface-variant hover:text-primary' }}">
              {{ $cat->category_name }}
            </a>
          @endforeach
        </div>

        <!-- Search input -->
        <div class="relative w-full md:w-72">
          <span class="material-symbols-outlined absolute left-3.5 top-1/2 -translate-y-1/2 text-outline text-[18px]">search</span>
          <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama siswa / kejuaraan..." class="w-full pl-10 pr-4 py-2.5 rounded-xl border border-outline-variant bg-surface-container-low text-xs focus:border-primary focus:ring-1 focus:ring-primary outline-none transition-all" />
        </div>

      </form>
    </div>
  </div>
</section>

<!-- GRID DAFTAR PRESTASI -->
<section class="w-full py-8 bg-surface">
  <div class="max-w-7xl mx-auto px-margin-mobile lg:px-margin">
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
      @forelse($achievements as $ach)
        <div class="achievement-card bg-surface-container-lowest rounded-3xl border border-surface-container shadow-sm overflow-hidden card-hover flex flex-col justify-between">
          <div>
            <div class="w-full h-52 overflow-hidden relative">
              <img src="{{ $ach->photo?->url ?? 'https://images.unsplash.com/photo-1544717302-de2939b7ef71?q=80&w=700&auto=format&fit=crop' }}" alt="{{ $ach->achievement_title }}" class="w-full h-full object-cover" />
              <span class="absolute top-3 left-3 bg-secondary text-white font-bold text-[11px] px-3 py-1 rounded-full shadow-sm">{{ $ach->ranking_position }}</span>
              <span class="absolute top-3 right-3 bg-black/60 text-white font-semibold text-[11px] px-2.5 py-1 rounded-full backdrop-blur-sm">{{ $ach->competition_date?->format('Y') ?? '2026' }}</span>
            </div>
            <div class="p-5 space-y-2">
              <h3 class="font-title-md text-title-md text-primary font-bold">{{ $ach->achievement_title }}</h3>
              <p class="font-body-sm text-xs text-on-surface-variant leading-relaxed">
                {{ $ach->description }}
              </p>
              <div class="bg-surface-container-low p-2.5 rounded-xl text-[11px] text-on-surface space-y-0.5 mt-2">
                <div class="flex justify-between"><span class="text-outline">Penerima:</span> <span class="font-bold text-primary">{{ $ach->recipient_summary }}</span></div>
                @if($ach->parent_rep_name)
                  <div class="flex justify-between"><span class="text-outline">Pendamping:</span> <span>{{ $ach->parent_rep_name }}</span></div>
                @endif
                @if($ach->mentorTeacher)
                  <div class="flex justify-between"><span class="text-outline">Pembina:</span> <span>{{ $ach->mentorTeacher->full_name }}</span></div>
                @endif
              </div>
            </div>
          </div>
          <div class="px-5 pb-5 pt-2 border-t border-surface-container text-xs text-primary font-semibold flex items-center justify-between">
            <span class="capitalize">Tingkat {{ $ach->level }}</span>
            <span class="material-symbols-outlined text-[16px] text-secondary">emoji_events</span>
          </div>
        </div>
      @empty
        <div class="col-span-3 text-center py-12 text-on-surface-variant bg-surface-container-low rounded-3xl">
          <span class="material-symbols-outlined text-4xl text-outline mb-2">search_off</span>
          <p class="font-bold text-base">Tidak ada prestasi yang cocok dengan kriteria pencarian.</p>
          <a href="{{ route('achievements') }}" class="text-primary text-xs font-bold underline mt-2 inline-block">Reset Filter</a>
        </div>
      @endforelse
    </div>
  </div>
</section>
@endsection

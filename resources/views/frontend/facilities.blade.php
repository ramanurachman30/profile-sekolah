@extends('layouts.frontend')

@section('title', 'Fasilitas & Sarana Prasarana - SDN Cikereteg 01')
@section('meta_description', 'Sarana dan prasarana belajar ramah anak di SDN Cikereteg 01: ruang kelas sejuk, perpustakaan lesehan, lab Chromebook TIK, UKS, dan musholla.')

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
      <span class="text-primary font-semibold">Fasilitas Sekolah</span>
    </nav>
  </div>
</div>

<!-- HERO HEADER -->
<section class="w-full py-10 bg-gradient-to-b from-primary/5 via-surface to-surface">
  <div class="max-w-7xl mx-auto px-margin-mobile lg:px-margin">
    <div class="max-w-3xl space-y-3">
      <span class="font-label-sm text-label-sm text-secondary font-bold uppercase tracking-wider">Sarana & Prasarana</span>
      <h1 class="font-headline-xl text-headline-xl text-primary font-extrabold tracking-tight">
        Lingkungan Belajar Asri, Nyaman & Ramah Anak
      </h1>
      <p class="font-body-lg text-body-lg text-on-surface-variant leading-relaxed">
        SDN Cikereteg 01 senantiasa merawat dan memperbarui fasilitas sekolah demi menciptakan suasana belajar yang aman, nyaman, dan mendukung tumbuh kembang anak usia Sekolah Dasar.
      </p>
    </div>
  </div>
</section>

<!-- GRID FASILITAS SEKOLAH -->
<section class="w-full py-10 bg-surface">
  <div class="max-w-7xl mx-auto px-margin-mobile lg:px-margin">
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
      @forelse($facilities as $facility)
        <div class="bg-surface-container-lowest rounded-3xl overflow-hidden border border-surface-container shadow-sm card-hover flex flex-col justify-between">
          <div>
            <div class="w-full h-44 overflow-hidden relative">
              <img src="{{ $facility->cover?->url ?? 'https://images.unsplash.com/photo-1580582932707-520aed937b7b?q=80&w=500&auto=format&fit=crop' }}" alt="{{ $facility->name }}" class="w-full h-full object-cover" />
              <span class="absolute top-3 left-3 bg-primary text-white font-bold text-[11px] px-2.5 py-1 rounded-full shadow-sm">{{ $facility->category?->name ?? 'Fasilitas' }}</span>
            </div>
            <div class="p-5 space-y-2">
              <h3 class="font-title-md text-title-md text-primary font-bold">{{ $facility->name }}</h3>
              <p class="font-body-sm text-xs text-on-surface-variant leading-relaxed">
                {{ $facility->description }}
              </p>
            </div>
          </div>
          <div class="px-5 pb-5 pt-2 border-t border-surface-container flex items-center justify-between text-xs">
            <span class="font-bold text-primary">{{ $facility->facility_code }}</span>
            <span class="text-on-surface-variant capitalize">Kondisi: <strong class="text-secondary">{{ str_replace('_', ' ', $facility->condition_status) }}</strong></span>
          </div>
        </div>
      @empty
        <div class="col-span-4 text-center py-8 text-on-surface-variant">Belum ada fasilitas terdaftar.</div>
      @endforelse
    </div>
  </div>
</section>

<!-- KEAMANAN & KEBERSIHAN LINGKUNGAN -->
<section class="w-full py-12 bg-surface-container-low">
  <div class="max-w-7xl mx-auto px-margin-mobile lg:px-margin">
    <div class="bg-surface-container-lowest p-6 sm:p-8 rounded-3xl border border-surface-container shadow-sm">
      <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <div class="flex items-start gap-4">
          <div class="w-12 h-12 rounded-2xl bg-primary-fixed text-primary flex items-center justify-center shrink-0">
            <span class="material-symbols-outlined text-[24px]">verified_user</span>
          </div>
          <div>
            <h4 class="font-bold text-primary text-base">Sekolah Ramah Anak</h4>
            <p class="text-xs text-on-surface-variant mt-1 leading-relaxed">Seluruh sudut sekolah dirancang aman dari benda tajam, pagar pembatas kokoh, serta pengawasan guru piket harian.</p>
          </div>
        </div>
        <div class="flex items-start gap-4">
          <div class="w-12 h-12 rounded-2xl bg-secondary-fixed text-secondary flex items-center justify-center shrink-0">
            <span class="material-symbols-outlined text-[24px]">recycling</span>
          </div>
          <div>
            <h4 class="font-bold text-primary text-base">Program Adiwiyata</h4>
            <p class="text-xs text-on-surface-variant mt-1 leading-relaxed">Penyediaan tempat sampah terpilah (organik dan anorganik) di depan setiap kelas untuk mendidik kebiasaan peduli lingkungan.</p>
          </div>
        </div>
        <div class="flex items-start gap-4">
          <div class="w-12 h-12 rounded-2xl bg-tertiary-fixed text-tertiary-container flex items-center justify-center shrink-0">
            <span class="material-symbols-outlined text-[24px]">sanitizer</span>
          </div>
          <div>
            <h4 class="font-bold text-primary text-base">Sanitasi & Air Bersih</h4>
            <p class="text-xs text-on-surface-variant mt-1 leading-relaxed">Toilet terpisah antara siswa putra, putri, dan guru dengan ketersediaan air bersih melimpah dari mata air pegunungan.</p>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
@endsection

@extends('layouts.frontend')

@section('title', 'Kesiswaan & Ekstrakurikuler - SDN Cikereteg 01')
@section('meta_description', 'Katalog kegiatan ekstrakurikuler SD dan pembiasaan karakter budi pekerti 5S di SDN Cikereteg 01, Kec. Caringin, Kab. Bogor.')

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
      <span class="text-primary font-semibold">Kesiswaan & Ekstrakurikuler</span>
    </nav>
  </div>
</div>

<!-- HERO HEADER -->
<section class="w-full py-10 bg-gradient-to-b from-primary/5 via-surface to-surface">
  <div class="max-w-7xl mx-auto px-margin-mobile lg:px-margin">
    <div class="max-w-3xl space-y-3">
      <span class="font-label-sm text-label-sm text-secondary font-bold uppercase tracking-wider">Kesiswaan & Karakter</span>
      <h1 class="font-headline-xl text-headline-xl text-primary font-extrabold tracking-tight">
        Membentuk Karakter Luhur, Ceria & Berprestasi
      </h1>
      <p class="font-body-lg text-body-lg text-on-surface-variant leading-relaxed">
        Pendidikan kesiswaan di SDN Cikereteg 01 memadukan penanaman budi pekerti 5S setiap pagi, kegiatan keagamaan, serta 8 pilihan ekstrakurikuler menyenangkan untuk menyalurkan bakat alami siswa Sekolah Dasar.
      </p>
    </div>
  </div>
</section>

<!-- PEMBIASAAN KARAKTER 5S & HARIAN -->
<section class="w-full py-10 bg-surface" id="pembiasaan">
  <div class="max-w-7xl mx-auto px-margin-mobile lg:px-margin">
    <div class="text-center max-w-2xl mx-auto mb-10">
      <span class="font-label-sm text-label-sm text-secondary font-bold uppercase tracking-wider">Nilai Budi Pekerti</span>
      <h2 class="font-headline-md text-headline-md text-primary font-extrabold mt-1">Pembiasaan Positif Setiap Hari</h2>
      <p class="font-body-md text-body-md text-on-surface-variant mt-2">
        Membangun karakter anak sejak usia dini melalui keteladanan nyata di sekolah.
      </p>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
      @forelse($habits as $habit)
        <div class="bg-surface-container-lowest rounded-3xl border border-surface-container shadow-sm overflow-hidden card-hover flex flex-col justify-between">
          <div>
            <div class="w-full h-44 overflow-hidden relative">
              <img src="{{ $habit->cover?->url ?? 'https://images.unsplash.com/photo-1577896851231-70ef18881754?q=80&w=600&auto=format&fit=crop' }}" alt="{{ $habit->title }}" class="w-full h-full object-cover" />
              <span class="absolute top-3 left-3 bg-primary/90 text-white font-bold text-[11px] px-2.5 py-1 rounded-full shadow-sm">{{ $habit->badge_label }}</span>
            </div>
            <div class="p-5 space-y-2">
              <h3 class="font-title-md text-title-md text-primary font-bold">{{ $habit->title }}</h3>
              <p class="font-body-sm text-xs text-on-surface-variant leading-relaxed">
                {{ $habit->description }}
              </p>
            </div>
          </div>
          <div class="px-5 pb-5 text-[11px] text-primary font-semibold">
            Rutin: {{ $habit->routine_schedule }}
          </div>
        </div>
      @empty
        <div class="col-span-4 text-center py-8 text-on-surface-variant">Belum ada pembiasaan tercatat.</div>
      @endforelse
    </div>
  </div>
</section>

<!-- KATALOG EKSTRAKURIKULER SD -->
<section class="w-full py-12 bg-surface-container-low" id="ekskul">
  <div class="max-w-7xl mx-auto px-margin-mobile lg:px-margin">
    <div class="text-center max-w-2xl mx-auto mb-10">
      <span class="font-label-sm text-label-sm text-secondary font-bold uppercase tracking-wider">Minat & Bakat Anak SD</span>
      <h2 class="font-headline-md text-headline-md text-primary font-extrabold mt-1">Ekstrakurikuler Pilihan Siswa</h2>
      <p class="font-body-md text-body-md text-on-surface-variant mt-2">
        Seluruh kegiatan didampingi oleh guru pembina yang penuh kesabaran, melatih bakat tanpa mengorbankan waktu istirahat anak.
      </p>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
      @forelse($extracurriculars as $ekskul)
        <div class="bg-surface-container-lowest rounded-3xl border border-surface-container shadow-sm overflow-hidden card-hover flex flex-col justify-between">
          <div>
            <div class="w-full h-44 overflow-hidden relative">
              <img src="{{ $ekskul->cover?->url ?? 'https://images.unsplash.com/photo-1509062522246-3755977927d7?q=80&w=600&auto=format&fit=crop' }}" alt="{{ $ekskul->name }}" class="w-full h-full object-cover" />
              <span class="absolute top-3 left-3 bg-secondary text-white font-bold text-[11px] px-2.5 py-1 rounded-full shadow-sm">{{ $ekskul->badge_text }}</span>
            </div>
            <div class="p-5 space-y-2">
              <h3 class="font-title-md text-title-md text-primary font-bold">{{ $ekskul->name }}</h3>
              <p class="font-body-sm text-xs text-on-surface-variant leading-relaxed">
                {{ $ekskul->description }}
              </p>
              @if($ekskul->instructorTeacher)
                <div class="text-[11px] text-on-surface-variant pt-1">
                  <span class="text-outline">Pembina:</span> <strong>{{ $ekskul->instructorTeacher->full_name }}</strong>
                </div>
              @endif
            </div>
          </div>
          <div class="px-5 pb-5 pt-2 border-t border-surface-container text-xs text-primary font-semibold flex items-center justify-between">
            <span>{{ $ekskul->schedule_info }}</span>
            <span class="material-symbols-outlined text-[16px] text-secondary">verified</span>
          </div>
        </div>
      @empty
        <div class="col-span-4 text-center py-8 text-on-surface-variant">Belum ada ekstrakurikuler terdaftar.</div>
      @endforelse
    </div>
  </div>
</section>
@endsection

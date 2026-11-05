@extends('layouts.frontend')

@section('title', ($profile->school_name ?? 'SDN Cikereteg 01') . ' - Cerdas, Berakhlak Mulia & Berkarakter | Kurikulum Merdeka SD')
@section('meta_description', 'Website resmi ' . ($profile->school_name ?? 'SDN Cikereteg 01') . ', ' . ($profile->sub_district ?? 'Kec. Caringin') . ', ' . ($profile->district ?? 'Kab. Bogor') . '. Sekolah Dasar Negeri ramah anak dengan Kurikulum Merdeka, pembiasaan karakter luhur 5S, dan lingkungan belajar asri.')

@section('content')

{{-- 0. RUNNING TICKER / EMERGENCY ANNOUNCEMENT BAR --}}
@if($activeAnnouncement && ($sections['announcement_bar']->is_visible ?? true))
  @php
    $alertStyle = match($activeAnnouncement->announcement_type) {
        'urgent', 'danger' => 'bg-red-600 text-white',
        'warning' => 'bg-amber-500 text-slate-900',
        default => 'bg-primary-container text-white',
    };
    $badgeStyle = match($activeAnnouncement->announcement_type) {
        'urgent', 'danger' => 'bg-red-800 text-red-100',
        'warning' => 'bg-amber-700 text-white',
        default => 'bg-white/20 text-white',
    };
  @endphp
  <div class="announcement-bar w-full {{ $alertStyle }} py-2.5 px-margin-mobile lg:px-margin shadow-sm transition-all" role="alert">
    <div class="max-w-7xl mx-auto flex flex-col sm:flex-row items-center justify-between gap-3 text-xs sm:text-sm">
      <div class="flex items-center gap-2.5 text-center sm:text-left">
        <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full font-bold text-[11px] uppercase tracking-wider {{ $badgeStyle }}">
          <span class="inline-block w-2 h-2 rounded-full bg-white animate-pulse"></span>
          {{ $activeAnnouncement->announcement_type === 'urgent' ? 'Penting' : ($activeAnnouncement->announcement_type === 'warning' ? 'Perhatian' : 'Pengumuman') }}
        </span>
        <p class="font-medium leading-snug">
          <strong>{{ $activeAnnouncement->title }}:</strong>
          <span class="opacity-95">{{ Str::limit($activeAnnouncement->content, 120) }}</span>
        </p>
      </div>
      <div class="flex items-center gap-2 shrink-0">
        @if(!empty($activeAnnouncement->cta_text) && !empty($activeAnnouncement->cta_url))
          <a href="{{ $activeAnnouncement->cta_url }}" class="px-3.5 py-1 rounded-lg bg-white text-primary font-bold text-xs hover:bg-white/90 transition-all shadow-sm">
            {{ $activeAnnouncement->cta_text }}
          </a>
        @endif
        <button type="button" onclick="this.closest('.announcement-bar').remove()" aria-label="Tutup pengumuman" class="p-1 rounded-md hover:bg-black/10 transition-colors">
          <span class="material-symbols-outlined text-[18px]">close</span>
        </button>
      </div>
    </div>
  </div>
@endif

{{-- 1. HERO SLIDER SECTION --}}
@if(($sections['hero_slider']->is_visible ?? true))
<section class="relative w-full py-10 lg:py-16 bg-gradient-to-b from-primary/5 via-surface to-surface overflow-hidden">
  <div class="max-w-7xl mx-auto px-margin-mobile lg:px-margin">
    @if($heroBanners->isNotEmpty())
      <div id="heroSlider" class="relative">
        <div class="hero-slides-wrapper">
          @foreach($heroBanners as $index => $banner)
            <div class="hero-slide transition-opacity duration-700 {{ $index === 0 ? 'block opacity-100' : 'hidden opacity-0' }}" data-index="{{ $index }}">
              <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 lg:gap-12 items-center">
                
                {{-- Banner Text & CTA --}}
                <div class="lg:col-span-7 space-y-6">
                  <div class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full bg-surface-container-high text-primary font-label-md text-label-md font-bold">
                    <span class="flex h-2.5 w-2.5 rounded-full bg-secondary-container"></span>
                    <span>{{ $banner->badge_text ?? ($sections['hero_slider']->badge_title ?? 'Sekolah Ramah Anak & Kurikulum Merdeka') }}</span>
                  </div>
                  
                  <h1 class="font-headline-xl text-headline-xl text-primary font-extrabold tracking-tight leading-tight">
                    {{ $banner->title ?? ($sections['hero_slider']->title ?? 'Mendidik Generasi Cerdas, Berakhlak Mulia & Berkarakter') }}
                  </h1>
                  
                  <p class="font-body-lg text-body-lg text-on-surface-variant leading-relaxed">
                    {{ $banner->subtitle ?? ($sections['hero_slider']->subtitle ?? ('Selamat datang di portal resmi ' . ($profile->school_name ?? 'SDN Cikereteg 01') . '. Kami menyelenggarakan pendidikan dasar ramah anak yang ramah, asri, dan berprestasi.')) }}
                  </p>

                  <div class="flex flex-wrap items-center gap-4 pt-2">
                    @if(!empty($banner->cta_primary_text))
                      <a class="px-6 py-3.5 rounded-xl bg-primary hover:bg-primary-container text-on-primary font-label-lg text-label-lg font-bold flex items-center gap-2 transition-all shadow-md" href="{{ $banner->cta_primary_url ?: route('ppdb.index') }}">
                        <span class="material-symbols-outlined text-[20px]">how_to_reg</span>
                        <span>{{ $banner->cta_primary_text }}</span>
                      </a>
                    @else
                      <a class="px-6 py-3.5 rounded-xl bg-primary hover:bg-primary-container text-on-primary font-label-lg text-label-lg font-bold flex items-center gap-2 transition-all shadow-md" href="{{ route('ppdb.index') }}">
                        <span class="material-symbols-outlined text-[20px]">how_to_reg</span>
                        <span>Pendaftaran PPDB Online</span>
                      </a>
                    @endif

                    @if(!empty($banner->cta_secondary_text))
                      <a class="px-6 py-3.5 rounded-xl bg-surface-container hover:bg-surface-container-high text-primary font-label-lg text-label-lg font-bold flex items-center gap-2 transition-all" href="{{ $banner->cta_secondary_url ?: route('profile') }}">
                        <span class="material-symbols-outlined text-[20px]">info</span>
                        <span>{{ $banner->cta_secondary_text }}</span>
                      </a>
                    @else
                      <a class="px-6 py-3.5 rounded-xl bg-surface-container hover:bg-surface-container-high text-primary font-label-lg text-label-lg font-bold flex items-center gap-2 transition-all" href="{{ route('profile') }}">
                        <span class="material-symbols-outlined text-[20px]">info</span>
                        <span>Tentang Sekolah Kami</span>
                      </a>
                    @endif
                  </div>

                  {{-- Quick Badges Identitas --}}
                  <div class="grid grid-cols-2 sm:grid-cols-4 gap-3 pt-4 border-t border-surface-container">
                    <div class="bg-surface-container-lowest p-3 rounded-xl border border-surface-container">
                      <div class="font-bold text-primary text-sm flex items-center gap-1">
                        <span class="material-symbols-outlined text-[16px] text-tertiary-container">verified</span>
                        <span>Akreditasi {{ $profile->accreditation ?? 'A' }}</span>
                      </div>
                      <div class="text-xs text-on-surface-variant mt-0.5">BAN-S/M Unggul</div>
                    </div>
                    <div class="bg-surface-container-lowest p-3 rounded-xl border border-surface-container">
                      <div class="font-bold text-primary text-sm flex items-center gap-1">
                        <span class="material-symbols-outlined text-[16px] text-secondary">eco</span>
                        <span>Adiwiyata</span>
                      </div>
                      <div class="text-xs text-on-surface-variant mt-0.5">Sekolah Hijau Asri</div>
                    </div>
                    <div class="bg-surface-container-lowest p-3 rounded-xl border border-surface-container">
                      <div class="font-bold text-primary text-sm flex items-center gap-1">
                        <span class="material-symbols-outlined text-[16px] text-primary">diversity_3</span>
                        <span>Ramah Anak</span>
                      </div>
                      <div class="text-xs text-on-surface-variant mt-0.5">Bebas Perundungan</div>
                    </div>
                    <div class="bg-surface-container-lowest p-3 rounded-xl border border-surface-container">
                      <div class="font-bold text-primary text-sm flex items-center gap-1">
                        <span class="material-symbols-outlined text-[16px] text-tertiary-container">money_off</span>
                        <span>Gratis 100%</span>
                      </div>
                      <div class="text-xs text-on-surface-variant mt-0.5">Didanai Dana BOS</div>
                    </div>
                  </div>
                </div>

                {{-- Banner Media / Photo --}}
                <div class="lg:col-span-5">
                  <div class="relative rounded-3xl overflow-hidden shadow-lg border border-surface-container bg-surface-container">
                    <img src="{{ $banner->mediaAsset?->url ?? 'https://images.unsplash.com/photo-1580582932707-520aed937b7b?q=80&w=800&auto=format&fit=crop' }}" alt="{{ $banner->title }}" class="w-full h-[380px] sm:h-[420px] object-cover" />
                    <div class="absolute inset-0 bg-gradient-to-t from-primary/90 via-primary/20 to-transparent flex items-end p-6">
                      <div class="text-on-primary">
                        <span class="font-label-xs text-xs uppercase tracking-wider text-secondary-fixed font-bold">{{ $profile->sub_district ?? 'Kec. Caringin' }}, {{ $profile->district ?? 'Kab. Bogor' }}</span>
                        <h3 class="font-title-lg text-title-lg font-bold leading-snug">{{ $banner->title ?? ($profile->school_name ?? 'SDN Cikereteg 01') }}</h3>
                        <p class="font-body-sm text-xs text-on-primary/90 mt-1 line-clamp-2">{{ $banner->subtitle ?? 'Membina generasi berkarakter sejak usia dini melalui pembiasaan positif setiap hari.' }}</p>
                      </div>
                    </div>
                  </div>
                </div>

              </div>
            </div>
          @endforeach
        </div>

        {{-- Carousel Navigation (Jika Lebih dari 1 Banner) --}}
        @if($heroBanners->count() > 1)
          <div class="flex items-center justify-between pt-6">
            <div class="flex items-center gap-2">
              @foreach($heroBanners as $i => $b)
                <button type="button" class="hero-dot h-2.5 rounded-full transition-all duration-300 {{ $i === 0 ? 'bg-primary w-8' : 'bg-outline-variant/50 w-2.5 hover:bg-primary/50' }}" data-slide="{{ $i }}" aria-label="Lihat slide {{ $i + 1 }}"></button>
              @endforeach
            </div>
            <div class="flex items-center gap-2">
              <button type="button" class="hero-prev w-9 h-9 rounded-xl bg-surface-container-high hover:bg-primary hover:text-white text-primary flex items-center justify-center transition-all" aria-label="Slide sebelumnya">
                <span class="material-symbols-outlined text-[20px]">chevron_left</span>
              </button>
              <button type="button" class="hero-next w-9 h-9 rounded-xl bg-surface-container-high hover:bg-primary hover:text-white text-primary flex items-center justify-center transition-all" aria-label="Slide berikutnya">
                <span class="material-symbols-outlined text-[20px]">chevron_right</span>
              </button>
            </div>
          </div>
        @endif
      </div>
    @else
      {{-- Fallback jika belum ada data banner di database --}}
      <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 lg:gap-12 items-center">
        <div class="lg:col-span-7 space-y-6">
          <div class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full bg-surface-container-high text-primary font-label-md text-label-md font-bold">
            <span class="flex h-2.5 w-2.5 rounded-full bg-secondary-container"></span>
            <span>{{ $sections['hero_slider']->badge_title ?? 'Sekolah Ramah Anak & Kurikulum Merdeka' }}</span>
          </div>
          <h1 class="font-headline-xl text-headline-xl text-primary font-extrabold tracking-tight leading-tight">
            {{ $sections['hero_slider']->title ?? 'Mendidik Generasi Cerdas, Berakhlak Mulia & Berkarakter Luhur' }}
          </h1>
          <p class="font-body-lg text-body-lg text-on-surface-variant leading-relaxed">
            Selamat datang di portal resmi <strong>{{ $profile->school_name ?? 'SDN Cikereteg 01' }}</strong>, {{ $profile->sub_district ?? 'Kec. Caringin' }}, {{ $profile->district ?? 'Kab. Bogor' }}. Kami menyelenggarakan pendidikan dasar ramah anak yang menyenangkan, bebas pungutan biaya (100% Gratis Dana BOS), serta mengedepankan budi pekerti luhur.
          </p>
          <div class="flex flex-wrap items-center gap-4 pt-2">
            <a class="px-6 py-3.5 rounded-xl bg-primary hover:bg-primary-container text-on-primary font-label-lg text-label-lg font-bold flex items-center gap-2 transition-all shadow-md" href="{{ route('ppdb.index') }}">
              <span class="material-symbols-outlined text-[20px]">how_to_reg</span>
              <span>Pendaftaran PPDB Siswa Baru</span>
            </a>
            <a class="px-6 py-3.5 rounded-xl bg-surface-container hover:bg-surface-container-high text-primary font-label-lg text-label-lg font-bold flex items-center gap-2 transition-all" href="{{ route('profile') }}">
              <span class="material-symbols-outlined text-[20px]">info</span>
              <span>Tentang Sekolah Kami</span>
            </a>
          </div>
        </div>
        <div class="lg:col-span-5">
          <div class="relative rounded-3xl overflow-hidden shadow-lg border border-surface-container">
            <img src="https://images.unsplash.com/photo-1580582932707-520aed937b7b?q=80&w=800&auto=format&fit=crop" alt="SDN Cikereteg 01" class="w-full h-[400px] object-cover" />
          </div>
        </div>
      </div>
    @endif
  </div>
</section>
@endif

{{-- 2. SAMBUTAN KEPALA SEKOLAH --}}
@if(($sections['headmaster_welcome']->is_visible ?? true))
<section id="sambutan-kepsek" class="w-full py-12 lg:py-16 bg-surface-container-low">
  <div class="max-w-7xl mx-auto px-margin-mobile lg:px-margin">
    <div class="bg-surface-container-lowest rounded-3xl p-6 sm:p-10 border border-surface-container shadow-sm">
      <div class="grid grid-cols-1 md:grid-cols-12 gap-8 items-center">
        
        {{-- Foto & Identitas Pimpinan --}}
        <div class="md:col-span-4 flex flex-col items-center text-center">
          <div class="w-40 h-40 sm:w-44 sm:h-44 rounded-full overflow-hidden border-4 border-primary-fixed shadow-md mb-4 bg-surface-container">
            <img src="{{ $profile->headmasterPhoto?->url ?? 'https://images.unsplash.com/photo-1573496359142-b8d87734a5a2?q=80&w=400&auto=format&fit=crop' }}" alt="{{ $profile->headmaster_name ?? 'Kepala Sekolah SDN Cikereteg 01' }}" class="w-full h-full object-cover" />
          </div>
          <h3 class="font-title-md text-title-md text-primary font-bold">{{ $profile->headmaster_name ?? 'Dra. Hj. Siti Rohmah, M.Pd.' }}</h3>
          <span class="font-label-sm text-label-sm text-on-surface-variant mt-0.5">Kepala {{ $profile->school_name ?? 'SDN Cikereteg 01' }}</span>
          @if(!empty($profile->headmaster_nip))
            <span class="text-xs text-outline mt-1 font-mono">NIP. {{ $profile->headmaster_nip }}</span>
          @endif
        </div>

        {{-- Naskah Sambutan & Kutipan --}}
        <div class="md:col-span-8 space-y-4">
          <div class="flex items-center gap-2">
            <span class="font-label-sm text-label-sm text-secondary font-bold uppercase tracking-wider bg-secondary-fixed/50 px-3 py-1 rounded-full">
              {{ $sections['headmaster_welcome']->badge_title ?? 'SAMBUTAN PIMPINAN' }}
            </span>
          </div>

          <h2 class="font-headline-sm text-headline-sm text-primary font-extrabold leading-snug">
            {{ $profile->headmaster_welcome_quote ? '“' . $profile->headmaster_welcome_quote . '”' : ($sections['headmaster_welcome']->title ?? 'Pendidikan Dasar Adalah Fondasi Pembentukan Budi Pekerti Anak') }}
          </h2>

          <div class="font-body-md text-body-md text-on-surface-variant leading-relaxed space-y-3">
            @if(!empty($profile->headmaster_welcome_text))
              @foreach(array_slice(explode("\n\n", $profile->headmaster_welcome_text), 0, 2) as $paragraph)
                <p>{!! nl2br(e($paragraph)) !!}</p>
              @endforeach
            @else
              <p><em>Assalamu’alaikum Warahmatullahi Wabarakatuh, Sampurasun.</em></p>
              <p>Selamat datang di portal resmi SDN Cikereteg 01. Kami meyakini bahwa setiap anak memiliki keunikan dan potensi istimewa yang harus ditumbuhkan dengan penuh kasih sayang, rasa aman, dan keteladanan. Bersama dewan guru yang berdedikasi dan dukungan komite sekolah, kami berkomitmen mewujudkan lulusan yang beriman, cerdas bernalar, bergotong-royong, serta cinta lingkungan hidup.</p>
            @endif
          </div>

          <div class="pt-3 flex flex-wrap items-center gap-4">
            <a href="{{ route('profile') }}" class="inline-flex items-center gap-2 px-5 py-2.5 rounded-xl bg-primary text-white font-bold text-sm hover:bg-primary-container transition-all shadow-sm">
              <span>Pelajari Profil & Visi Misi Lengkap</span>
              <span class="material-symbols-outlined text-[16px]">arrow_forward</span>
            </a>
          </div>
        </div>

      </div>
    </div>
  </div>
</section>
@endif

{{-- 3. PILAR KEUNGGULAN & METRIK --}}
@if(($sections['highlights_metrics']->is_visible ?? true) && $highlights->isNotEmpty())
<section class="w-full py-12 lg:py-16 bg-surface">
  <div class="max-w-7xl mx-auto px-margin-mobile lg:px-margin">
    <div class="text-center max-w-2xl mx-auto mb-10">
      <span class="text-xs font-bold text-primary bg-primary-fixed/40 px-3 py-1 rounded-full uppercase tracking-wider">
        {{ $sections['highlights_metrics']->badge_title ?? 'KEUNGGULAN UTAMA' }}
      </span>
      <h2 class="font-headline-md text-headline-md font-extrabold text-primary mt-2">
        {{ $sections['highlights_metrics']->title ?? 'Pilar Keunggulan Sekolah' }}
      </h2>
      <p class="font-body-md text-body-md text-on-surface-variant mt-2">
        {{ $sections['highlights_metrics']->subtitle ?? 'Komitmen mutu pendidikan dasar terakreditasi A BAN-S/M dengan lingkungan belajar asri dan menyenangkan.' }}
      </p>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
      @foreach($highlights as $hl)
        @php
          $colorConfig = match($hl->badge_color) {
            'emerald' => ['bg' => 'bg-emerald-50', 'text' => 'text-emerald-700', 'border' => 'border-emerald-100', 'icon_bg' => 'bg-emerald-100 text-emerald-800'],
            'amber' => ['bg' => 'bg-amber-50', 'text' => 'text-amber-800', 'border' => 'border-amber-100', 'icon_bg' => 'bg-amber-100 text-amber-900'],
            'sky' => ['bg' => 'bg-sky-50', 'text' => 'text-sky-700', 'border' => 'border-sky-100', 'icon_bg' => 'bg-sky-100 text-sky-800'],
            'violet' => ['bg' => 'bg-violet-50', 'text' => 'text-violet-700', 'border' => 'border-violet-100', 'icon_bg' => 'bg-violet-100 text-violet-800'],
            default => ['bg' => 'bg-primary/5', 'text' => 'text-primary', 'border' => 'border-primary/10', 'icon_bg' => 'bg-primary/10 text-primary'],
          };
        @endphp
        <div class="bg-surface-container-lowest rounded-3xl p-6 border border-surface-container shadow-sm card-hover flex flex-col justify-between">
          <div>
            <div class="flex items-center justify-between mb-4">
              <div class="w-12 h-12 rounded-2xl {{ $colorConfig['icon_bg'] }} flex items-center justify-center font-bold">
                <span class="material-symbols-outlined text-[26px]">{{ $hl->icon_name ?: 'star' }}</span>
              </div>
              @if(!empty($hl->metric_value))
                <span class="px-3 py-1 rounded-full text-xs font-bold {{ $colorConfig['bg'] }} {{ $colorConfig['text'] }} border {{ $colorConfig['border'] }}">
                  {{ $hl->metric_value }}
                </span>
              @endif
            </div>
            <h3 class="font-title-md text-title-md text-primary font-bold mb-2">{{ $hl->title }}</h3>
            <p class="font-body-sm text-xs text-on-surface-variant leading-relaxed">
              {{ $hl->description }}
            </p>
          </div>
          @if(!empty($hl->link_url))
            <a href="{{ $hl->link_url }}" class="inline-flex items-center gap-1 text-xs font-bold text-primary hover:underline pt-4 mt-2 border-t border-surface-container">
              <span>Pelajari Detail</span>
              <span class="material-symbols-outlined text-[14px]">arrow_forward</span>
            </a>
          @endif
        </div>
      @endforeach
    </div>
  </div>
</section>
@endif

{{-- 4. FASILITAS FISIK PILIHAN --}}
@if(($sections['facilities_preview']->is_visible ?? true) && $facilities->isNotEmpty())
<section class="w-full py-12 lg:py-16 bg-surface-container-low">
  <div class="max-w-7xl mx-auto px-margin-mobile lg:px-margin">
    <div class="flex flex-col md:flex-row md:items-end justify-between gap-4 mb-8">
      <div>
        <span class="font-label-sm text-label-sm text-secondary font-bold uppercase tracking-wider">
          {{ $sections['facilities_preview']->badge_title ?? 'FASILITAS SEKOLAH' }}
        </span>
        <h2 class="font-headline-sm text-headline-sm text-primary font-extrabold mt-1">
          {{ $sections['facilities_preview']->title ?? 'Sarana & Prasarana Unggulan' }}
        </h2>
        <p class="font-body-sm text-xs text-on-surface-variant mt-1">
          {{ $sections['facilities_preview']->subtitle ?? 'Ruang belajar ramah anak, nyaman, dan mendukung minat bakat siswa.' }}
        </p>
      </div>
      <a href="{{ route('facilities') }}" class="inline-flex items-center gap-1 text-primary font-bold text-sm hover:underline">
        <span>Lihat Semua Fasilitas</span>
        <span class="material-symbols-outlined text-[16px]">arrow_forward</span>
      </a>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
      @foreach($facilities as $facility)
        <div class="bg-surface-container-lowest rounded-3xl border border-surface-container shadow-sm overflow-hidden card-hover flex flex-col justify-between">
          <div>
            <div class="w-full h-44 overflow-hidden relative bg-surface-container">
              <img src="{{ $facility->cover?->url ?? 'https://images.unsplash.com/photo-1580582932707-520aed937b7b?q=80&w=500&auto=format&fit=crop' }}" alt="{{ $facility->name }}" class="w-full h-full object-cover" />
              @if($facility->category)
                <span class="absolute top-3 left-3 bg-primary/85 text-white font-bold text-[11px] px-2.5 py-1 rounded-full shadow-sm backdrop-blur-xs">
                  {{ $facility->category->name }}
                </span>
              @endif
              <span class="absolute top-3 right-3 bg-emerald-600/90 text-white font-bold text-[10px] px-2 py-0.5 rounded-full shadow-sm backdrop-blur-xs">
                {{ $facility->condition_label }}
              </span>
            </div>
            <div class="p-5 space-y-2">
              <h3 class="font-title-md text-title-md text-primary font-bold line-clamp-2">{{ $facility->name }}</h3>
              <p class="font-body-sm text-xs text-on-surface-variant line-clamp-3 leading-relaxed">
                {{ $facility->description }}
              </p>
            </div>
          </div>
          <div class="px-5 pb-5 pt-2 border-t border-surface-container text-xs text-on-surface-variant flex items-center justify-between">
            <span class="font-semibold text-primary">Kapasitas: {{ $facility->capacity ? $facility->capacity . ' Siswa' : 'Representatif' }}</span>
            <span class="material-symbols-outlined text-[18px] text-primary">apartment</span>
          </div>
        </div>
      @endforeach
    </div>
  </div>
</section>
@endif

{{-- 5. STRUKTUR 3 FASE KURIKULUM MERDEKA SD --}}
@if(($sections['curriculum_phases']->is_visible ?? true) && $phases->isNotEmpty())
<section class="w-full py-12 lg:py-16 bg-surface">
  <div class="max-w-7xl mx-auto px-margin-mobile lg:px-margin">
    <div class="text-center max-w-2xl mx-auto mb-10">
      <span class="text-xs font-bold text-primary bg-primary-fixed/40 px-3 py-1 rounded-full uppercase tracking-wider">Kurikulum Merdeka SD</span>
      <h2 class="font-headline-md text-headline-md font-extrabold text-primary mt-2">Tiga Fase Perkembangan Belajar Siswa</h2>
      <p class="font-body-md text-body-md text-on-surface-variant mt-2">
        Materi dan metode ajar disesuaikan secara bertahap sesuai usia dan kesiapan belajar anak di Sekolah Dasar.
      </p>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
      @foreach($phases as $phase)
        <div class="bg-surface-container-lowest rounded-3xl p-6 border border-outline-variant/30 card-hover flex flex-col justify-between">
          <div>
            <div class="flex items-center justify-between mb-3">
              <span class="px-3 py-1 rounded-full bg-primary-fixed text-primary font-bold text-xs">{{ $phase->phase_code }}</span>
              <span class="text-xs font-semibold text-outline">{{ $phase->grades_coverage }}</span>
            </div>
            <h3 class="font-title-lg text-title-lg font-bold text-primary mb-2">
              @if($phase->phase_code === 'Fase A')
                Transisi PAUD - SD Ramah Anak
              @elseif($phase->phase_code === 'Fase B')
                Penguatan Numerasi & IPAS
              @else
                Penalaran Kritis & Karakter
              @endif
            </h3>
            <p class="text-xs text-on-surface-variant leading-relaxed mb-4">
              {{ $phase->focus_description }}
            </p>
          </div>
          <a href="{{ route('academic') }}#fase-{{ strtolower(str_replace(' ', '-', $phase->phase_code)) }}" class="text-xs font-bold text-primary hover:underline inline-flex items-center gap-1 pt-3 border-t border-surface-container">
            <span>Rincian Kurikulum {{ $phase->phase_code }}</span>
            <span class="material-symbols-outlined text-[14px]">arrow_forward</span>
          </a>
        </div>
      @endforeach
    </div>
  </div>
</section>
@endif

{{-- 6. PRESTASI SISWA UNGGULAN --}}
@if(($sections['achievements_preview']->is_visible ?? true))
<section class="w-full py-12 lg:py-16 bg-surface-container-low">
  <div class="max-w-7xl mx-auto px-margin-mobile lg:px-margin">
    <div class="flex flex-col md:flex-row md:items-end justify-between gap-4 mb-8">
      <div>
        <span class="font-label-sm text-label-sm text-secondary font-bold uppercase tracking-wider">
          {{ $sections['achievements_preview']->badge_title ?? 'PRESTASI SISWA' }}
        </span>
        <h2 class="font-headline-sm text-headline-sm text-primary font-extrabold mt-1">
          {{ $sections['achievements_preview']->title ?? 'Kebanggaan Sekolah Bersama Guru & Ortu' }}
        </h2>
        <p class="font-body-sm text-xs text-on-surface-variant mt-1">
          {{ $sections['achievements_preview']->subtitle ?? 'Raihan tropi dan medali kejuaraan seni, olahraga, dan sains.' }}
        </p>
      </div>
      <a href="{{ route('achievements') }}" class="inline-flex items-center gap-1 text-primary font-bold text-sm hover:underline">
        <span>Lihat Semua Prestasi</span>
        <span class="material-symbols-outlined text-[16px]">arrow_forward</span>
      </a>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
      @forelse($featuredAchievements as $ach)
        <div class="bg-surface-container-lowest rounded-3xl border border-surface-container shadow-sm overflow-hidden card-hover flex flex-col justify-between">
          <div>
            <div class="w-full h-48 overflow-hidden relative bg-surface-container">
              <img src="{{ $ach->photo?->url ?? 'https://images.unsplash.com/photo-1544717302-de2939b7ef71?q=80&w=700&auto=format&fit=crop' }}" alt="{{ $ach->achievement_title }}" class="w-full h-full object-cover" />
              <span class="absolute top-3 left-3 bg-secondary text-white font-bold text-[11px] px-3 py-1 rounded-full shadow-sm">{{ $ach->ranking_position }}</span>
              <span class="absolute top-3 right-3 bg-black/60 text-white font-semibold text-[11px] px-2.5 py-1 rounded-full backdrop-blur-sm">{{ $ach->competition_date?->format('Y') ?? date('Y') }}</span>
            </div>
            <div class="p-5 space-y-2">
              <h3 class="font-title-md text-title-md text-primary font-bold line-clamp-2">{{ $ach->achievement_title }}</h3>
              <p class="font-body-sm text-xs text-on-surface-variant line-clamp-3 leading-relaxed">
                {{ $ach->description }}
              </p>
              <div class="bg-surface-container-low p-2.5 rounded-xl text-[11px] text-on-surface space-y-0.5 mt-2">
                <div class="flex justify-between"><span class="text-outline">Penerima:</span> <span class="font-bold text-primary">{{ $ach->recipient_summary }}</span></div>
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
        <div class="col-span-3 text-center py-8 text-on-surface-variant">Belum ada data prestasi unggulan ditampilkan.</div>
      @endforelse
    </div>
  </div>
</section>
@endif

{{-- 7. WARTA BERITA & AGENDA SEKOLAH --}}
@if(($sections['latest_news']->is_visible ?? true))
<section class="w-full py-12 lg:py-16 bg-surface">
  <div class="max-w-7xl mx-auto px-margin-mobile lg:px-margin">
    <div class="flex flex-col md:flex-row md:items-end justify-between gap-4 mb-8">
      <div>
        <span class="font-label-sm text-label-sm text-secondary font-bold uppercase tracking-wider">
          {{ $sections['latest_news']->badge_title ?? 'WARTA SEKOLAH' }}
        </span>
        <h2 class="font-headline-sm text-headline-sm text-primary font-extrabold mt-1">
          {{ $sections['latest_news']->title ?? 'Kabar & Dokumentasi Terkini' }}
        </h2>
        <p class="font-body-sm text-xs text-on-surface-variant mt-1">
          {{ $sections['latest_news']->subtitle ?? 'Informasi resmi seputar agenda, pengumuman, dan aktivitas belajar.' }}
        </p>
      </div>
      <a href="{{ route('news.index') }}" class="inline-flex items-center gap-1 text-primary font-bold text-sm hover:underline">
        <span>Arsip Berita Lengkap</span>
        <span class="material-symbols-outlined text-[16px]">arrow_forward</span>
      </a>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
      @forelse($latestNews as $news)
        <article class="bg-surface-container-lowest rounded-3xl overflow-hidden border border-surface-container shadow-sm card-hover flex flex-col justify-between">
          <div>
            <div class="w-full h-44 overflow-hidden relative bg-surface-container">
              <img src="{{ $news->cover?->url ?? 'https://images.unsplash.com/photo-1577896851231-70ef18881754?q=80&w=600&auto=format&fit=crop' }}" alt="{{ $news->title }}" class="w-full h-full object-cover" />
              <span class="absolute top-3 left-3 bg-primary/90 text-white font-bold text-[11px] px-2.5 py-1 rounded-full shadow-sm">{{ $news->category?->name ?? 'Kegiatan' }}</span>
            </div>
            <div class="p-5 space-y-2">
              <span class="text-xs text-on-surface-variant font-medium">{{ $news->published_at?->translatedFormat('d F Y') ?? date('d M Y') }}</span>
              <h3 class="font-title-md text-title-md text-primary font-bold line-clamp-2 hover:text-primary-container transition-colors">
                <a href="{{ route('news.show', $news->slug) }}">{{ $news->title }}</a>
              </h3>
              <p class="font-body-sm text-xs text-on-surface-variant line-clamp-2 leading-relaxed">
                {{ $news->summary }}
              </p>
            </div>
          </div>
          <div class="p-5 pt-0">
            <a href="{{ route('news.show', $news->slug) }}" class="text-xs font-bold text-primary hover:underline inline-flex items-center gap-1">
              <span>Baca Selengkapnya</span>
              <span class="material-symbols-outlined text-[14px]">arrow_forward</span>
            </a>
          </div>
        </article>
      @empty
        <div class="col-span-3 text-center py-8 text-on-surface-variant">Belum ada berita terbit.</div>
      @endforelse
    </div>
  </div>
</section>
@endif

{{-- 8. DOKUMENTASI GALERI --}}
@if(($sections['gallery_preview']->is_visible ?? true))
<section class="w-full py-12 lg:py-16 bg-surface-container-low">
  <div class="max-w-7xl mx-auto px-margin-mobile lg:px-margin">
    <div class="flex flex-col md:flex-row md:items-end justify-between gap-4 mb-8">
      <div>
        <span class="font-label-sm text-label-sm text-secondary font-bold uppercase tracking-wider">
          {{ $sections['gallery_preview']->badge_title ?? 'DOKUMENTASI' }}
        </span>
        <h2 class="font-headline-sm text-headline-sm text-primary font-extrabold mt-1">
          {{ $sections['gallery_preview']->title ?? 'Galeri Foto Kegiatan Siswa' }}
        </h2>
        <p class="font-body-sm text-xs text-on-surface-variant mt-1">
          {{ $sections['gallery_preview']->subtitle ?? 'Momen kebersamaan, belajar aktif, dan pembiasaan karakter budi pekerti.' }}
        </p>
      </div>
      <a href="{{ route('gallery') }}" class="inline-flex items-center gap-1 text-primary font-bold text-sm hover:underline">
        <span>Lihat Semua Galeri</span>
        <span class="material-symbols-outlined text-[16px]">arrow_forward</span>
      </a>
    </div>

    <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-6 gap-3">
      @forelse($galleryItems as $item)
        <a href="{{ route('gallery') }}" class="group relative rounded-2xl overflow-hidden aspect-square border border-surface-container shadow-sm card-hover block bg-surface-container">
          <img src="{{ $item->mediaAsset?->url ?? 'https://images.unsplash.com/photo-1544717302-de2939b7ef71?q=80&w=700&auto=format&fit=crop' }}" alt="{{ $item->title }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-300" />
          <div class="absolute inset-0 bg-primary/60 opacity-0 group-hover:opacity-100 transition-opacity flex flex-col items-center justify-center p-2 text-center text-white">
            <span class="material-symbols-outlined text-[20px] mb-1">
              {{ $item->media_type === 'video' ? 'play_circle' : 'photo_camera' }}
            </span>
            <span class="text-[11px] font-bold line-clamp-2">{{ $item->title }}</span>
          </div>
        </a>
      @empty
        <div class="col-span-6 text-center py-8 text-on-surface-variant">Belum ada dokumentasi galeri.</div>
      @endforelse
    </div>
  </div>
</section>
@endif

{{-- 9. TESTIMONI WALI MURID & ALUMNI --}}
@if(($sections['testimonials']->is_visible ?? true) && $testimonials->isNotEmpty())
<section class="w-full py-12 lg:py-16 bg-surface">
  <div class="max-w-7xl mx-auto px-margin-mobile lg:px-margin">
    <div class="text-center max-w-2xl mx-auto mb-10">
      <span class="text-xs font-bold text-primary bg-primary-fixed/40 px-3 py-1 rounded-full uppercase tracking-wider">
        {{ $sections['testimonials']->badge_title ?? 'TESTIMONI' }}
      </span>
      <h2 class="font-headline-md text-headline-md font-extrabold text-primary mt-2">
        {{ $sections['testimonials']->title ?? 'Kata Mereka Tentang Kami' }}
      </h2>
      <p class="font-body-md text-body-md text-on-surface-variant mt-2">
        {{ $sections['testimonials']->subtitle ?? 'Apresiasi dan pengalaman nyata dari para orang tua murid, komite, dan alumni SDN Cikereteg 01.' }}
      </p>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
      @foreach($testimonials as $t)
        @php
          $categoryLabel = match($t->person_category) {
            'orang_tua' => 'Wali Murid',
            'komite' => 'Komite Sekolah',
            'alumni' => 'Alumni',
            'guru' => 'Dewan Guru',
            'mitra' => 'Mitra Sekolah',
            default => ucfirst(str_replace('_', ' ', $t->person_category)),
          };
        @endphp
        <div class="bg-surface-container-lowest rounded-3xl p-6 sm:p-7 border border-surface-container shadow-sm card-hover flex flex-col justify-between">
          <div class="space-y-4">
            {{-- Rating Stars --}}
            <div class="flex items-center gap-1 text-secondary-container">
              @for($star = 1; $star <= 5; $star++)
                <span class="material-symbols-outlined text-[18px] {{ $star <= ($t->rating ?? 5) ? 'text-secondary-container fill-current' : 'text-outline-variant/50' }}">
                  star
                </span>
              @endfor
            </div>

            {{-- Kutipan Testimoni --}}
            <blockquote class="font-body-sm text-sm text-on-surface leading-relaxed italic">
              “{{ $t->testimonial_text }}”
            </blockquote>
          </div>

          {{-- Profil Pemberi Ulasan --}}
          <div class="pt-5 mt-4 border-t border-surface-container flex items-center gap-3">
            <div class="w-12 h-12 rounded-full overflow-hidden bg-primary/10 border-2 border-primary-fixed shrink-0">
              <img src="{{ $t->avatar?->url ?? 'https://images.unsplash.com/photo-1544005313-94ddf0286df2?q=80&w=200&auto=format&fit=crop' }}" alt="{{ $t->person_name }}" class="w-full h-full object-cover" />
            </div>
            <div class="min-w-0">
              <h4 class="font-bold text-primary text-sm truncate">{{ $t->person_name }}</h4>
              <p class="text-xs text-on-surface-variant truncate">{{ $t->role_title }}</p>
              <span class="inline-block mt-0.5 px-2 py-0.5 rounded text-[10px] font-bold bg-primary-fixed/40 text-primary">
                {{ $categoryLabel }}
              </span>
            </div>
          </div>
        </div>
      @endforeach
    </div>
  </div>
</section>
@endif

{{-- 10. PPDB STATUS & CTA BANNER --}}
@if(($sections['ppdb_cta']->is_visible ?? true) && $activePeriod)
<section class="w-full py-14 bg-gradient-to-r from-primary via-primary-container to-primary text-on-primary shadow-inner">
  <div class="max-w-7xl mx-auto px-margin-mobile lg:px-margin text-center max-w-3xl space-y-4">
    <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-secondary-fixed text-secondary font-bold text-xs uppercase tracking-wider">
      <span class="material-symbols-outlined text-[15px]">campaign</span>
      <span>{{ $sections['ppdb_cta']->badge_title ?? 'Penerimaan Siswa Baru Dibuka' }}</span>
    </span>
    <h2 class="font-headline-lg text-headline-lg font-extrabold text-white">
      {{ $sections['ppdb_cta']->title ?? $activePeriod->wave_name }}
    </h2>
    <p class="font-body-md text-white/90 leading-relaxed max-w-2xl mx-auto text-sm sm:text-base">
      {{ $sections['ppdb_cta']->subtitle ?? ('Pendaftaran calon peserta didik baru kelas 1 Sekolah Dasar SDN Cikereteg 01 tahun ajaran ' . ($activePeriod->academicYear?->year_code ?? '2026/2027') . '. Tanpa tes calistung, bebas biaya pungutan (100% Gratis Dana BOS).') }}
    </p>
    <div class="flex flex-wrap items-center justify-center gap-4 pt-2">
      <a href="{{ route('ppdb.index') }}" class="px-6 py-3.5 rounded-xl bg-secondary hover:bg-secondary-container text-on-secondary font-bold text-sm flex items-center gap-2 transition-all shadow-lg">
        <span class="material-symbols-outlined text-[18px]">how_to_reg</span>
        <span>Isi Formulir Online Sekarang</span>
      </a>
      <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $profile->whatsapp ?? '6281234567890') }}" target="_blank" class="px-6 py-3.5 rounded-xl bg-white/10 hover:bg-white/20 text-white font-bold text-sm flex items-center gap-2 transition-all border border-white/20">
        <span class="material-symbols-outlined text-[18px]">chat</span>
        <span>Tanya Panitia via WA</span>
      </a>
    </div>
  </div>
</section>
@endif

{{-- 11. KONTAK KAMI & PETA MINI --}}
@if(($sections['contact_info']->is_visible ?? true))
<section class="w-full py-12 lg:py-16 bg-surface-container-low border-t border-surface-container">
  <div class="max-w-7xl mx-auto px-margin-mobile lg:px-margin">
    <div class="text-center max-w-2xl mx-auto mb-10">
      <span class="text-xs font-bold text-primary bg-primary-fixed/40 px-3 py-1 rounded-full uppercase tracking-wider">
        {{ $sections['contact_info']->badge_title ?? 'KONTAK KAMI' }}
      </span>
      <h2 class="font-headline-md text-headline-md font-extrabold text-primary mt-2">
        {{ $sections['contact_info']->title ?? 'Layanan Informasi & Konsultasi' }}
      </h2>
      <p class="font-body-md text-body-md text-on-surface-variant mt-2">
        {{ $sections['contact_info']->subtitle ?? 'Pintu komunikasi terbuka setiap hari kerja bagi orang tua murid dan masyarakat.' }}
      </p>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start">
      {{-- Detail Kontak --}}
      <div class="lg:col-span-5 space-y-4">
        <div class="bg-surface-container-lowest p-6 rounded-3xl border border-surface-container shadow-sm space-y-4">
          <div class="flex items-start gap-3">
            <div class="w-10 h-10 rounded-xl bg-primary/10 text-primary flex items-center justify-center shrink-0 mt-0.5">
              <span class="material-symbols-outlined text-[20px]">location_on</span>
            </div>
            <div>
              <h4 class="font-bold text-primary text-sm">Alamat Sekolah</h4>
              <p class="text-xs text-on-surface-variant leading-relaxed mt-0.5">{{ $profile->address ?? 'Jl. Raya Cikereteg No. 12, Kec. Caringin, Kab. Bogor' }}</p>
            </div>
          </div>

          <div class="flex items-start gap-3">
            <div class="w-10 h-10 rounded-xl bg-primary/10 text-primary flex items-center justify-center shrink-0 mt-0.5">
              <span class="material-symbols-outlined text-[20px]">call</span>
            </div>
            <div>
              <h4 class="font-bold text-primary text-sm">Telepon & WhatsApp</h4>
              <p class="text-xs text-on-surface-variant mt-0.5">{{ $profile->phone ?? '(0251) 824-1234' }}</p>
              @if(!empty($profile->whatsapp))
                <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $profile->whatsapp) }}" target="_blank" class="text-xs text-secondary font-bold hover:underline inline-flex items-center gap-1 mt-0.5">
                  <span>Chat WhatsApp TU (+{{ $profile->whatsapp }})</span>
                </a>
              @endif
            </div>
          </div>

          <div class="flex items-start gap-3">
            <div class="w-10 h-10 rounded-xl bg-primary/10 text-primary flex items-center justify-center shrink-0 mt-0.5">
              <span class="material-symbols-outlined text-[20px]">schedule</span>
            </div>
            <div>
              <h4 class="font-bold text-primary text-sm">Jam Operasional Layanan</h4>
              <p class="text-xs text-on-surface-variant mt-0.5">{{ $profile->operating_hours ?? 'Senin - Jumat: 07.00 - 14.30 WIB' }}</p>
            </div>
          </div>
        </div>

        <div class="text-center sm:text-left">
          <a href="{{ route('contact.index') }}" class="inline-flex items-center gap-2 px-5 py-3 rounded-xl bg-surface-container-high hover:bg-primary hover:text-white text-primary font-bold text-sm transition-all shadow-sm">
            <span>Kirim Pesan / Formulir Kontak Online</span>
            <span class="material-symbols-outlined text-[16px]">arrow_forward</span>
          </a>
        </div>
      </div>

      {{-- Peta Google Maps --}}
      <div class="lg:col-span-7">
        <div class="bg-surface-container-lowest rounded-3xl overflow-hidden border border-surface-container shadow-sm h-[320px] relative">
          @if(!empty($profile->maps_embed_url))
            <iframe src="{{ $profile->maps_embed_url }}" width="100%" height="100%" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade" title="Peta Lokasi {{ $profile->school_name ?? 'SDN Cikereteg 01' }}"></iframe>
          @else
            <div class="w-full h-full flex flex-col items-center justify-center p-6 text-center bg-surface-container">
              <span class="material-symbols-outlined text-4xl text-primary mb-2">map</span>
              <p class="font-bold text-primary text-sm">{{ $profile->school_name ?? 'SDN Cikereteg 01' }}</p>
              <p class="text-xs text-on-surface-variant max-w-sm mt-1">{{ $profile->address ?? 'Kecamatan Caringin, Kabupaten Bogor' }}</p>
            </div>
          @endif
        </div>
      </div>
    </div>
  </div>
</section>
@endif

@endsection

@push('scripts')
<script>
  document.addEventListener('DOMContentLoaded', function () {
    const slider = document.getElementById('heroSlider');
    if (!slider) return;

    const slides = slider.querySelectorAll('.hero-slide');
    const dots = slider.querySelectorAll('.hero-dot');
    const prevBtn = slider.querySelector('.hero-prev');
    const nextBtn = slider.querySelector('.hero-next');

    if (slides.length <= 1) return;

    let currentIndex = 0;
    let timer = null;

    function showSlide(index) {
      if (index < 0) index = slides.length - 1;
      if (index >= slides.length) index = 0;
      currentIndex = index;

      slides.forEach(function (slide, i) {
        if (i === currentIndex) {
          slide.classList.remove('hidden', 'opacity-0');
          slide.classList.add('block', 'opacity-100');
        } else {
          slide.classList.add('hidden', 'opacity-0');
          slide.classList.remove('block', 'opacity-100');
        }
      });

      dots.forEach(function (dot, i) {
        if (i === currentIndex) {
          dot.classList.add('bg-primary', 'w-8');
          dot.classList.remove('bg-outline-variant/50', 'w-2.5');
        } else {
          dot.classList.remove('bg-primary', 'w-8');
          dot.classList.add('bg-outline-variant/50', 'w-2.5');
        }
      });
    }

    function nextSlide() {
      showSlide(currentIndex + 1);
    }

    function prevSlide() {
      showSlide(currentIndex - 1);
    }

    if (nextBtn) {
      nextBtn.addEventListener('click', function () {
        nextSlide();
        resetTimer();
      });
    }

    if (prevBtn) {
      prevBtn.addEventListener('click', function () {
        prevSlide();
        resetTimer();
      });
    }

    dots.forEach(function (dot, i) {
      dot.addEventListener('click', function () {
        showSlide(i);
        resetTimer();
      });
    });

    function startTimer() {
      timer = setInterval(nextSlide, 5000);
    }

    function resetTimer() {
      if (timer) clearInterval(timer);
      startTimer();
    }

    startTimer();
  });
</script>
@endpush

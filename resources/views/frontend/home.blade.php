@extends('layouts.frontend')

@section('title', 'SDN Cikereteg 01 - Cerdas, Berakhlak Mulia & Berkarakter | Kurikulum Merdeka SD')
@section('meta_description', 'Website resmi SDN Cikereteg 01, Kec. Caringin, Kab. Bogor. Sekolah Dasar Negeri ramah anak dengan Kurikulum Merdeka, pembiasaan karakter luhur 5S, dan lingkungan belajar asri.')

@section('content')
<!-- 1. HERO SECTION -->
<section class="relative w-full py-12 lg:py-16 bg-gradient-to-b from-primary/5 via-surface to-surface overflow-hidden">
  <div class="max-w-7xl mx-auto px-margin-mobile lg:px-margin">
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 lg:gap-12 items-center">
      
      <!-- Hero Text -->
      <div class="lg:col-span-7 space-y-6">
        <div class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full bg-surface-container-high text-primary font-label-md text-label-md font-bold">
          <span class="flex h-2.5 w-2.5 rounded-full bg-secondary-container"></span>
          <span>Sekolah Ramah Anak & Kurikulum Merdeka</span>
        </div>
        
        <h1 class="font-headline-xl text-headline-xl text-primary font-extrabold tracking-tight leading-tight">
          Mendidik Generasi Cerdas, Berakhlak Mulia & Berkarakter Luhur
        </h1>
        
        <p class="font-body-lg text-body-lg text-on-surface-variant leading-relaxed">
          Selamat datang di portal resmi <strong>{{ $profile->school_name ?? 'SDN Cikereteg 01' }}</strong>, {{ $profile->sub_district ?? 'Kec. Caringin' }}, {{ $profile->district ?? 'Kab. Bogor' }}. Kami menyelenggarakan pendidikan dasar ramah anak yang menyenangkan, bebas pungutan biaya (100% Gratis Dana BOS), serta mengedepankan pembentukan budi pekerti Pancasila.
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

        <!-- Quick badges -->
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

      <!-- Hero Image -->
      <div class="lg:col-span-5">
        <div class="relative rounded-3xl overflow-hidden shadow-lg border border-surface-container">
          <img src="https://images.unsplash.com/photo-1580582932707-520aed937b7b?q=80&w=800&auto=format&fit=crop" alt="Suasana Belajar SDN Cikereteg 01" class="w-full h-[400px] object-cover" />
          <div class="absolute inset-0 bg-gradient-to-t from-primary/85 via-transparent to-transparent flex items-end p-6">
            <div class="text-on-primary">
              <span class="font-label-xs text-xs uppercase tracking-wider text-secondary-fixed font-bold">{{ $profile->sub_district ?? 'Kec. Caringin' }}, {{ $profile->district ?? 'Kab. Bogor' }}</span>
              <h3 class="font-title-lg text-title-lg font-bold">{{ $profile->school_name ?? 'SDN Cikereteg 01' }}</h3>
              <p class="font-body-sm text-xs text-on-primary/90 mt-1">Membina generasi berkarakter sejak usia dini melalui pembiasaan positif setiap hari.</p>
            </div>
          </div>
        </div>
      </div>

    </div>
  </div>
</section>

<!-- 2. SAMBUTAN KEPALA SEKOLAH -->
<section class="w-full py-12 bg-surface-container-low">
  <div class="max-w-7xl mx-auto px-margin-mobile lg:px-margin">
    <div class="bg-surface-container-lowest rounded-3xl p-6 sm:p-8 border border-surface-container shadow-sm">
      <div class="grid grid-cols-1 md:grid-cols-12 gap-8 items-center">
        
        <div class="md:col-span-4 flex flex-col items-center text-center">
          <div class="w-36 h-36 rounded-full overflow-hidden border-4 border-primary-fixed shadow-md mb-3">
            <img src="https://images.unsplash.com/photo-1544717305-2782549b5136?q=80&w=400&auto=format&fit=crop" alt="Kepala Sekolah SDN Cikereteg 01" class="w-full h-full object-cover" />
          </div>
          <h3 class="font-title-md text-title-md text-primary font-bold">{{ $profile->headmaster_name ?? 'Dra. Hj. Siti Rohmah, M.Pd.' }}</h3>
          <span class="font-label-sm text-label-sm text-on-surface-variant">Kepala {{ $profile->school_name ?? 'SDN Cikereteg 01' }}</span>
          @if(!empty($profile->headmaster_nip))
            <span class="text-xs text-outline mt-0.5">NIP: {{ $profile->headmaster_nip }}</span>
          @endif
        </div>

        <div class="md:col-span-8 space-y-3">
          <span class="font-label-sm text-label-sm text-secondary font-bold uppercase tracking-wider">Sambutan Kepala Sekolah</span>
          <h2 class="font-headline-sm text-headline-sm text-primary font-extrabold">
            "Pendidikan Dasar Adalah Fondasi Pembentukan Budi Pekerti Anak"
          </h2>
          <p class="font-body-md text-body-md text-on-surface-variant leading-relaxed">
            <em>Assalamu’alaikum Warahmatullahi Wabarakatuh, Sampurasun.</em><br />
            Selamat datang di website resmi SDN Cikereteg 01. Kami meyakini bahwa setiap anak memiliki keunikan dan potensi istimewa yang harus ditumbuhkan dengan penuh kasih sayang, rasa aman, dan keteladanan. Bersama dewan guru yang berdedikasi dan dukungan komite sekolah, kami berkomitmen mewujudkan lulusan yang beriman, cerdas bernalar, bergotong-royong, serta cinta tanah air.
          </p>
          <div class="pt-2 flex items-center gap-3">
            <a href="{{ route('profile') }}" class="inline-flex items-center gap-1.5 text-primary font-bold text-sm hover:underline">
              <span>Pelajari Profil & Dewan Guru Sekolah</span>
              <span class="material-symbols-outlined text-[16px]">arrow_forward</span>
            </a>
          </div>
        </div>

      </div>
    </div>
  </div>
</section>

<!-- 3. STRUKTUR 3 FASE KURIKULUM MERDEKA SD -->
<section class="w-full py-14 bg-surface">
  <div class="max-w-7xl mx-auto px-margin-mobile lg:px-margin">
    <div class="text-center max-w-2xl mx-auto mb-12">
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
            <span>Rincian {{ $phase->phase_code }}</span>
            <span class="material-symbols-outlined text-[14px]">arrow_forward</span>
          </a>
        </div>
      @endforeach
    </div>
  </div>
</section>

<!-- 4. PRESTASI SISWA UNGGULAN -->
<section class="w-full py-12 bg-surface-container-low">
  <div class="max-w-7xl mx-auto px-margin-mobile lg:px-margin">
    <div class="flex flex-col md:flex-row md:items-end justify-between gap-4 mb-8">
      <div>
        <span class="font-label-sm text-label-sm text-secondary font-bold uppercase tracking-wider">Showcase Prestasi</span>
        <h2 class="font-headline-sm text-headline-sm text-primary font-extrabold mt-1">Kebanggaan Sekolah Bersama Guru & Ortu</h2>
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
            <div class="w-full h-48 overflow-hidden relative">
              <img src="{{ $ach->photo?->url ?? 'https://images.unsplash.com/photo-1544717302-de2939b7ef71?q=80&w=700&auto=format&fit=crop' }}" alt="{{ $ach->achievement_title }}" class="w-full h-full object-cover" />
              <span class="absolute top-3 left-3 bg-secondary text-white font-bold text-[11px] px-3 py-1 rounded-full shadow-sm">{{ $ach->ranking_position }}</span>
              <span class="absolute top-3 right-3 bg-black/60 text-white font-semibold text-[11px] px-2.5 py-1 rounded-full backdrop-blur-sm">{{ $ach->competition_date?->format('Y') ?? '2026' }}</span>
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
        <div class="col-span-3 text-center py-8 text-on-surface-variant">Belum ada data prestasi ditampilkan.</div>
      @endforelse
    </div>
  </div>
</section>

<!-- 5. WARTA BERITA & AGENDA SEKOLAH -->
<section class="w-full py-14 bg-surface">
  <div class="max-w-7xl mx-auto px-margin-mobile lg:px-margin">
    <div class="flex flex-col md:flex-row md:items-end justify-between gap-4 mb-8">
      <div>
        <span class="font-label-sm text-label-sm text-secondary font-bold uppercase tracking-wider">Warta Sekolah</span>
        <h2 class="font-headline-sm text-headline-sm text-primary font-extrabold mt-1">Kabar & Dokumentasi Terkini</h2>
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
            <div class="w-full h-44 overflow-hidden relative">
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

<!-- 6. CUPLIKAN GALERI -->
<section class="w-full py-12 bg-surface-container-low">
  <div class="max-w-7xl mx-auto px-margin-mobile lg:px-margin">
    <div class="flex flex-col md:flex-row md:items-end justify-between gap-4 mb-8">
      <div>
        <span class="font-label-sm text-label-sm text-secondary font-bold uppercase tracking-wider">Dokumentasi</span>
        <h2 class="font-headline-sm text-headline-sm text-primary font-extrabold mt-1">Galeri Foto Kegiatan Siswa</h2>
      </div>
      <a href="{{ route('gallery') }}" class="inline-flex items-center gap-1 text-primary font-bold text-sm hover:underline">
        <span>Lihat Semua Galeri</span>
        <span class="material-symbols-outlined text-[16px]">arrow_forward</span>
      </a>
    </div>

    <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-6 gap-3">
      @forelse($galleryItems as $item)
        <a href="{{ route('gallery') }}" class="group relative rounded-2xl overflow-hidden aspect-square border border-surface-container shadow-sm card-hover block">
          <img src="{{ $item->mediaAsset?->url ?? 'https://images.unsplash.com/photo-1544717302-de2939b7ef71?q=80&w=700&auto=format&fit=crop' }}" alt="{{ $item->title }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-300" />
          <div class="absolute inset-0 bg-primary/40 opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center p-2 text-center">
            <span class="text-white text-[11px] font-bold line-clamp-2">{{ $item->title }}</span>
          </div>
        </a>
      @empty
        <div class="col-span-6 text-center py-8 text-on-surface-variant">Belum ada dokumentasi galeri.</div>
      @endforelse
    </div>
  </div>
</section>

<!-- 7. STATUS PPDB AKTIF BANNER -->
@if($activePeriod)
<section class="w-full py-14 bg-gradient-to-r from-primary via-primary-container to-primary text-on-primary">
  <div class="max-w-7xl mx-auto px-margin-mobile lg:px-margin text-center max-w-3xl space-y-4">
    <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-secondary-fixed text-secondary font-bold text-xs uppercase tracking-wider">
      <span class="material-symbols-outlined text-[15px]">campaign</span>
      <span>Penerimaan Siswa Baru Dibuka</span>
    </span>
    <h2 class="font-headline-lg text-headline-lg font-extrabold text-white">
      {{ $activePeriod->wave_name }}
    </h2>
    <p class="font-body-md text-white/90 leading-relaxed max-w-2xl mx-auto text-sm sm:text-base">
      Pendaftaran calon peserta didik baru kelas 1 Sekolah Dasar SDN Cikereteg 01 tahun ajaran {{ $activePeriod->academicYear?->year_code ?? '2026/2027' }}. Tanpa tes calistung, bebas biaya pungutan (100% Gratis Dana BOS).
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
@endsection

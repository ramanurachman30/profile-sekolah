@extends('layouts.frontend')

@section('title', 'Dokumentasi Galeri - SDN Cikereteg 01')
@section('meta_description', 'Dokumentasi foto dan video kegiatan belajar mengajar, gelar karya P5, ekstrakurikuler, dan pentas seni di SDN Cikereteg 01.')

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
      <span class="text-primary font-semibold">Galeri Dokumentasi</span>
    </nav>
  </div>
</div>

<!-- HERO HEADER -->
<section class="w-full py-10 bg-gradient-to-b from-primary/5 via-surface to-surface">
  <div class="max-w-7xl mx-auto px-margin-mobile lg:px-margin">
    <div class="max-w-3xl space-y-3">
      <span class="font-label-sm text-label-sm text-secondary font-bold uppercase tracking-wider">Momen Berharga</span>
      <h1 class="font-headline-xl text-headline-xl text-primary font-extrabold tracking-tight">
        Dokumentasi Kegiatan Siswa SDN Cikereteg 01
      </h1>
      <p class="font-body-lg text-body-lg text-on-surface-variant leading-relaxed">
        Kumpulan foto dan video keceriaan belajar, gelar karya projek P5, perkemahan Pramuka, pentas tari tradisional, dan aktivitas anak-anak setiap hari.
      </p>
    </div>
  </div>
</section>

<!-- FILTER & SEARCH BAR -->
<section class="w-full py-6 bg-surface">
  <div class="max-w-7xl mx-auto px-margin-mobile lg:px-margin">
    <div class="bg-surface-container-lowest p-6 rounded-3xl border border-surface-container shadow-sm space-y-5">
      
      <form method="GET" action="{{ route('gallery') }}" class="space-y-4">
        <!-- Baris 1: Pencarian & Type Toggle -->
        <div class="flex flex-col sm:flex-row items-center justify-between gap-4">
          <div class="relative w-full sm:w-80">
            <span class="material-symbols-outlined absolute left-3.5 top-1/2 -translate-y-1/2 text-outline text-[18px]">search</span>
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari kegiatan (tari, pramuka, p5)..." class="w-full pl-10 pr-4 py-2.5 rounded-xl border border-outline-variant bg-surface-container-low text-xs focus:border-primary focus:ring-1 focus:ring-primary outline-none transition-all" />
          </div>

          <div class="flex items-center gap-3 w-full sm:w-auto justify-between sm:justify-end">
            <!-- Type Filters -->
            <div class="flex items-center gap-1.5 bg-surface-container-low p-1 rounded-xl">
              <a href="{{ route('gallery', ['category' => request('category'), 'search' => request('search')]) }}" class="px-3 py-1.5 rounded-lg font-label-sm text-xs font-bold transition-all {{ !request('type') ? 'bg-primary text-on-primary' : 'bg-surface-container text-on-surface-variant hover:text-primary' }}">
                Semua Media
              </a>
              <a href="{{ route('gallery', ['type' => 'foto', 'category' => request('category'), 'search' => request('search')]) }}" class="px-3 py-1.5 rounded-lg font-label-sm text-xs font-semibold transition-all {{ request('type') === 'foto' ? 'bg-primary text-on-primary' : 'bg-surface-container text-on-surface-variant hover:text-primary' }}">
                Foto
              </a>
              <a href="{{ route('gallery', ['type' => 'video', 'category' => request('category'), 'search' => request('search')]) }}" class="px-3 py-1.5 rounded-lg font-label-sm text-xs font-semibold transition-all {{ request('type') === 'video' ? 'bg-primary text-on-primary' : 'bg-surface-container text-on-surface-variant hover:text-primary' }}">
                Video
              </a>
            </div>

            <a href="{{ route('gallery') }}" title="Reset Filter" class="p-2 rounded-xl bg-surface-container text-on-surface-variant hover:text-primary hover:bg-surface-container-high transition-colors flex items-center justify-center">
              <span class="material-symbols-outlined text-[20px]">refresh</span>
            </a>
          </div>
        </div>

        <!-- Baris 2: Tombol Kategori -->
        <div class="flex flex-wrap items-center gap-2 pt-2 border-t border-surface-container">
          <a href="{{ route('gallery', ['type' => request('type'), 'search' => request('search')]) }}" class="px-4 py-2 rounded-xl font-label-md text-xs font-bold transition-all shadow-sm {{ !request('category') || request('category') === 'all' ? 'bg-primary text-on-primary' : 'bg-surface-container-high text-on-surface-variant hover:text-primary' }}">
            Semua Album
          </a>
          @foreach($categories as $cat)
            <a href="{{ route('gallery', ['category' => $cat->slug, 'type' => request('type'), 'search' => request('search')]) }}" class="px-4 py-2 rounded-xl font-label-md text-xs font-bold transition-all {{ request('category') === $cat->slug ? 'bg-primary text-on-primary' : 'bg-surface-container-high text-on-surface-variant hover:text-primary' }}">
              {{ $cat->category_name }}
            </a>
          @endforeach
        </div>
      </form>

      <div class="flex items-center justify-between text-xs text-outline pt-1">
        <span>Menampilkan {{ $items->count() }} dokumentasi kegiatan</span>
        <span class="text-[11px] text-primary">Klik untuk melihat ukuran penuh / video</span>
      </div>

    </div>
  </div>
</section>

<!-- GRID FOTO & VIDEO -->
<section class="w-full py-8 bg-surface">
  <div class="max-w-7xl mx-auto px-margin-mobile lg:px-margin">
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
      @forelse($items as $item)
        <div class="gallery-item-card bg-surface-container-lowest rounded-3xl border border-surface-container shadow-sm overflow-hidden card-hover cursor-pointer flex flex-col justify-between"
             onclick="openLightbox('{{ $item->media_type }}', '{{ $item->mediaAsset?->url }}', '{{ addslashes($item->title) }}', '{{ addslashes($item->description) }}', '{{ $item->video_embed_url }}', '{{ $item->event_date?->format('d M Y') }}')">
          <div>
            <div class="w-full h-52 overflow-hidden relative group">
              <img src="{{ $item->mediaAsset?->url ?? 'https://images.unsplash.com/photo-1544717302-de2939b7ef71?q=80&w=700&auto=format&fit=crop' }}" alt="{{ $item->title }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300" />
              <span class="absolute top-3 left-3 bg-secondary text-white font-bold text-[11px] px-2.5 py-1 rounded-full shadow-sm">{{ $item->category?->category_name ?? 'Kegiatan' }}</span>
              @if($item->media_type === 'video')
                <div class="absolute inset-0 bg-black/40 flex items-center justify-center">
                  <span class="w-12 h-12 rounded-full bg-primary text-white flex items-center justify-center shadow-lg material-symbols-outlined text-[28px]">play_arrow</span>
                </div>
              @else
                <div class="absolute inset-0 bg-primary/20 opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center">
                  <span class="w-10 h-10 rounded-full bg-white/90 text-primary flex items-center justify-center material-symbols-outlined text-[20px]">zoom_in</span>
                </div>
              @endif
            </div>
            <div class="p-4 space-y-1">
              <span class="text-[11px] text-outline font-semibold">{{ $item->event_date?->translatedFormat('d F Y') ?? '' }}</span>
              <h3 class="font-title-sm text-sm font-bold text-primary leading-snug line-clamp-2">{{ $item->title }}</h3>
              <p class="text-xs text-on-surface-variant line-clamp-2">{{ $item->description }}</p>
            </div>
          </div>
        </div>
      @empty
        <div class="col-span-4 text-center py-12 text-on-surface-variant bg-surface-container-low rounded-3xl">
          <span class="material-symbols-outlined text-4xl text-outline mb-2">image_not_supported</span>
          <p class="font-bold text-base">Tidak ada dokumentasi yang sesuai.</p>
          <a href="{{ route('gallery') }}" class="text-primary text-xs font-bold underline mt-2 inline-block">Reset Filter</a>
        </div>
      @endforelse
    </div>
  </div>
</section>

<!-- LIGHTBOX MODAL -->
<div id="galleryModal" class="hidden fixed inset-0 z-50 items-center justify-center p-4">
  <div id="galleryBackdrop" onclick="closeLightbox()" class="fixed inset-0 bg-black/80 backdrop-blur-sm"></div>
  <div class="relative bg-surface-container-lowest rounded-3xl max-w-3xl w-full overflow-hidden shadow-2xl border border-surface-container z-10 space-y-3 p-6">
    <div class="flex items-center justify-between pb-2 border-b border-surface-container">
      <div>
        <span id="modalDate" class="text-[11px] text-outline font-semibold"></span>
        <h3 id="modalTitle" class="font-title-lg text-title-lg text-primary font-bold"></h3>
      </div>
      <button onclick="closeLightbox()" class="w-9 h-9 rounded-full bg-surface-container hover:bg-surface-container-high text-on-surface flex items-center justify-center transition-colors">
        <span class="material-symbols-outlined text-[20px]">close</span>
      </button>
    </div>

    <!-- Media Container -->
    <div id="mediaBox" class="w-full rounded-2xl overflow-hidden bg-black flex items-center justify-center max-h-[480px]">
      <img id="modalImg" src="" alt="" class="w-full h-auto max-h-[480px] object-contain hidden" />
      <div id="modalVideoWrap" class="w-full aspect-video hidden">
        <iframe id="modalIframe" src="" class="w-full h-full" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
      </div>
    </div>

    <p id="modalDesc" class="text-xs text-on-surface-variant leading-relaxed pt-2"></p>
  </div>
</div>

@push('scripts')
<script>
function openLightbox(type, imgUrl, title, desc, videoUrl, dateStr) {
  const modal = document.getElementById('galleryModal');
  const modalTitle = document.getElementById('modalTitle');
  const modalDesc = document.getElementById('modalDesc');
  const modalDate = document.getElementById('modalDate');
  const modalImg = document.getElementById('modalImg');
  const modalVideoWrap = document.getElementById('modalVideoWrap');
  const modalIframe = document.getElementById('modalIframe');

  modalTitle.textContent = title;
  modalDesc.textContent = desc;
  modalDate.textContent = dateStr;

  if (type === 'video' && videoUrl) {
    modalImg.classList.add('hidden');
    modalVideoWrap.classList.remove('hidden');
    modalIframe.src = videoUrl;
  } else {
    modalVideoWrap.classList.add('hidden');
    modalIframe.src = '';
    modalImg.src = imgUrl;
    modalImg.classList.remove('hidden');
  }

  modal.classList.remove('hidden');
  modal.classList.add('flex');
}

function closeLightbox() {
  const modal = document.getElementById('galleryModal');
  const modalIframe = document.getElementById('modalIframe');
  modalIframe.src = '';
  modal.classList.add('hidden');
  modal.classList.remove('flex');
}
</script>
@endpush
@endsection

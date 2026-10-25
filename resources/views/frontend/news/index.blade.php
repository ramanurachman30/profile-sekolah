@extends('layouts.frontend')

@section('title', 'Warta & Berita - SDN Cikereteg 01')
@section('meta_description', 'Kabar terkini seputar kegiatan sekolah, pengumuman Kurikulum Merdeka, prestasi siswa, dan agenda resmi SDN Cikereteg 01.')

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
      <span class="text-primary font-semibold">Warta & Berita</span>
    </nav>
  </div>
</div>

<!-- HERO HEADER -->
<section class="w-full py-10 bg-gradient-to-b from-primary/5 via-surface to-surface">
  <div class="max-w-7xl mx-auto px-margin-mobile lg:px-margin">
    <div class="max-w-3xl space-y-3">
      <span class="font-label-sm text-label-sm text-secondary font-bold uppercase tracking-wider">Informasi Terpadu</span>
      <h1 class="font-headline-xl text-headline-xl text-primary font-extrabold tracking-tight">
        Kabar & Pengumuman SDN Cikereteg 01
      </h1>
      <p class="font-body-lg text-body-lg text-on-surface-variant leading-relaxed">
        Pusat publikasi resmi kegiatan belajar mengajar, program Adiwiyata, agenda upacara, dan informasi penting bagi seluruh orang tua murid.
      </p>
    </div>
  </div>
</section>

<!-- FILTER & SEARCH BAR -->
<section class="w-full py-6 bg-surface">
  <div class="max-w-7xl mx-auto px-margin-mobile lg:px-margin">
    <div class="bg-surface-container-lowest p-6 rounded-3xl border border-surface-container shadow-sm space-y-4">
      <form method="GET" action="{{ route('news.index') }}" class="flex flex-col md:flex-row md:items-center justify-between gap-4">
        
        <!-- Category Buttons -->
        <div class="flex flex-wrap items-center gap-2">
          <a href="{{ route('news.index') }}" class="px-4 py-2 rounded-xl font-label-md text-xs font-bold transition-all shadow-sm {{ !request('category') || request('category') === 'all' ? 'bg-primary text-on-primary' : 'bg-surface-container-high text-on-surface-variant hover:text-primary' }}">
            Semua Berita
          </a>
          @foreach($categories as $cat)
            <a href="{{ route('news.index', ['category' => $cat->slug, 'search' => request('search')]) }}" class="px-4 py-2 rounded-xl font-label-md text-xs font-bold transition-all {{ request('category') === $cat->slug ? 'bg-primary text-on-primary' : 'bg-surface-container-high text-on-surface-variant hover:text-primary' }}">
              {{ $cat->name }} ({{ $cat->articles_count }})
            </a>
          @endforeach
        </div>

        <!-- Search input -->
        <div class="relative w-full md:w-72">
          <span class="material-symbols-outlined absolute left-3.5 top-1/2 -translate-y-1/2 text-outline text-[18px]">search</span>
          <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari artikel berita..." class="w-full pl-10 pr-4 py-2.5 rounded-xl border border-outline-variant bg-surface-container-low text-xs focus:border-primary focus:ring-1 focus:ring-primary outline-none transition-all" />
        </div>

      </form>
    </div>
  </div>
</section>

<!-- GRID BERITA -->
<section class="w-full py-8 bg-surface">
  <div class="max-w-7xl mx-auto px-margin-mobile lg:px-margin">
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
      @forelse($articles as $article)
        <article class="bg-surface-container-lowest rounded-3xl overflow-hidden border border-surface-container shadow-sm card-hover flex flex-col justify-between">
          <div>
            <div class="w-full h-48 overflow-hidden relative">
              <img src="{{ $article->cover?->url ?? 'https://images.unsplash.com/photo-1577896851231-70ef18881754?q=80&w=600&auto=format&fit=crop' }}" alt="{{ $article->title }}" class="w-full h-full object-cover" />
              <span class="absolute top-3 left-3 bg-primary/90 text-white font-bold text-[11px] px-2.5 py-1 rounded-full shadow-sm">{{ $article->category?->name ?? 'Warta' }}</span>
            </div>
            <div class="p-5 space-y-2">
              <div class="flex items-center justify-between text-xs text-on-surface-variant font-medium">
                <span>{{ $article->published_at?->translatedFormat('d F Y') ?? date('d M Y') }}</span>
                <span class="flex items-center gap-1 text-[11px]"><span class="material-symbols-outlined text-[14px]">visibility</span> {{ $article->views_count }}</span>
              </div>
              <h3 class="font-title-md text-title-md text-primary font-bold line-clamp-2 hover:text-primary-container transition-colors">
                <a href="{{ route('news.show', $article->slug) }}">{{ $article->title }}</a>
              </h3>
              <p class="font-body-sm text-xs text-on-surface-variant line-clamp-3 leading-relaxed">
                {{ $article->summary }}
              </p>
            </div>
          </div>
          <div class="p-5 pt-0 border-t border-surface-container mt-2 flex items-center justify-between">
            <span class="text-[11px] text-outline">{{ $article->author_name }}</span>
            <a href="{{ route('news.show', $article->slug) }}" class="text-xs font-bold text-primary hover:underline inline-flex items-center gap-1">
              <span>Baca Selengkapnya</span>
              <span class="material-symbols-outlined text-[14px]">arrow_forward</span>
            </a>
          </div>
        </article>
      @empty
        <div class="col-span-3 text-center py-12 text-on-surface-variant bg-surface-container-low rounded-3xl">
          <span class="material-symbols-outlined text-4xl text-outline mb-2">article</span>
          <p class="font-bold text-base">Tidak ada artikel berita yang sesuai.</p>
          <a href="{{ route('news.index') }}" class="text-primary text-xs font-bold underline mt-2 inline-block">Reset Filter</a>
        </div>
      @endforelse
    </div>

    <!-- Pagination -->
    <div class="mt-8">
      {{ $articles->links() }}
    </div>
  </div>
</section>
@endsection

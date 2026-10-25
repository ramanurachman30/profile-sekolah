@extends('layouts.frontend')

@section('title', $article->title . ' - SDN Cikereteg 01')
@section('meta_description', Str::limit($article->summary, 160))

@section('content')
<!-- BREADCRUMB -->
<div class="w-full bg-surface-container-low border-b border-surface-container/60 py-3">
  <div class="max-w-7xl mx-auto px-margin-mobile lg:px-margin">
    <nav aria-label="Breadcrumb" class="flex items-center gap-2 font-label-md text-label-md text-on-surface-variant flex-wrap">
      <a class="hover:text-primary transition-colors flex items-center gap-1" href="{{ route('home') }}">
        <span class="material-symbols-outlined text-[16px]">home</span>
        <span>Beranda</span>
      </a>
      <span class="material-symbols-outlined text-[14px] text-outline">chevron_right</span>
      <a class="hover:text-primary transition-colors" href="{{ route('news.index') }}">Berita</a>
      <span class="material-symbols-outlined text-[14px] text-outline">chevron_right</span>
      <span class="text-primary font-semibold truncate max-w-xs">{{ Str::limit($article->title, 40) }}</span>
    </nav>
  </div>
</div>

<!-- ARTICLE DETAIL SECTION -->
<section class="w-full py-10 bg-surface">
  <div class="max-w-7xl mx-auto px-margin-mobile lg:px-margin">
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start">
      
      <!-- Main Article Column -->
      <article class="lg:col-span-8 bg-surface-container-lowest p-6 sm:p-8 rounded-3xl border border-surface-container shadow-sm space-y-6">
        
        <!-- Header & Meta -->
        <div class="space-y-3">
          <div class="flex flex-wrap items-center gap-2">
            <span class="px-3 py-1 rounded-full bg-primary-fixed text-primary font-bold text-xs uppercase tracking-wider">
              {{ $article->category?->name ?? 'Kegiatan' }}
            </span>
            <span class="text-xs text-outline">•</span>
            <span class="text-xs text-on-surface-variant font-medium">
              {{ $article->published_at?->translatedFormat('l, d F Y') ?? date('d M Y') }}
            </span>
            <span class="text-xs text-outline">•</span>
            <span class="flex items-center gap-1 text-xs text-on-surface-variant">
              <span class="material-symbols-outlined text-[15px]">visibility</span>
              {{ $article->views_count }} dilihat
            </span>
          </div>

          <h1 class="font-headline-lg text-headline-lg text-primary font-extrabold tracking-tight leading-snug">
            {{ $article->title }}
          </h1>

          <div class="flex items-center gap-3 pt-2 border-t border-surface-container">
            <div class="w-9 h-9 rounded-full bg-primary/10 text-primary flex items-center justify-center font-bold text-sm">
              <span class="material-symbols-outlined text-[20px]">person</span>
            </div>
            <div>
              <span class="text-xs font-bold text-primary block">{{ $article->author_name }}</span>
              <span class="text-[11px] text-outline block">Publikasi Resmi SDN Cikereteg 01</span>
            </div>
          </div>
        </div>

        <!-- Cover Image -->
        @if($article->cover)
          <div class="rounded-2xl overflow-hidden shadow-sm border border-surface-container">
            <img src="{{ $article->cover->url }}" alt="{{ $article->title }}" class="w-full h-auto max-h-[450px] object-cover" />
            @if($article->cover->alt_text)
              <div class="p-2.5 bg-surface-container-low text-[11px] text-on-surface-variant text-center italic">
                {{ $article->cover->alt_text }}
              </div>
            @endif
          </div>
        @endif

        <!-- Summary Lead -->
        <div class="p-4 rounded-2xl bg-surface-container-low border-l-4 border-primary text-primary font-semibold text-sm leading-relaxed">
          {{ $article->summary }}
        </div>

        <!-- Article Content -->
        <div class="prose max-w-none text-on-surface text-sm sm:text-base leading-relaxed space-y-4">
          {!! $article->content !!}
        </div>

        <!-- Social Share & Navigation -->
        <div class="pt-6 border-t border-surface-container flex flex-col sm:flex-row sm:items-center justify-between gap-4">
          <div class="flex items-center gap-2">
            <span class="text-xs font-bold text-on-surface">Bagikan:</span>
            <a href="https://api.whatsapp.com/send?text={{ rawurlencode($article->title . ' ' . url()->current()) }}" target="_blank" class="w-8 h-8 rounded-full bg-tertiary-container text-white flex items-center justify-center hover:opacity-90 transition-opacity" title="WhatsApp">
              <span class="material-symbols-outlined text-[16px]">chat</span>
            </a>
            <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(url()->current()) }}" target="_blank" class="w-8 h-8 rounded-full bg-primary text-white flex items-center justify-center hover:opacity-90 transition-opacity" title="Facebook">
              <span class="material-symbols-outlined text-[16px]">share</span>
            </a>
          </div>
          <a href="{{ route('news.index') }}" class="inline-flex items-center gap-1.5 text-xs font-bold text-primary hover:underline">
            <span class="material-symbols-outlined text-[16px]">arrow_back</span>
            <span>Kembali ke Warta Berita</span>
          </a>
        </div>

      </article>

      <!-- Sidebar Column -->
      <aside class="lg:col-span-4 space-y-6">
        
        <!-- Recent News Widget -->
        <div class="bg-surface-container-lowest p-6 rounded-3xl border border-surface-container shadow-sm space-y-4">
          <h3 class="font-title-md text-title-md text-primary font-bold flex items-center gap-2 pb-2 border-b border-surface-container">
            <span class="material-symbols-outlined text-secondary">newspaper</span>
            <span>Berita Terkini Lainnya</span>
          </h3>
          <div class="space-y-4">
            @foreach($recentNews as $recent)
              <a href="{{ route('news.show', $recent->slug) }}" class="flex gap-3 group">
                <img src="{{ $recent->cover?->url ?? 'https://images.unsplash.com/photo-1577896851231-70ef18881754?q=80&w=300&auto=format&fit=crop' }}" alt="{{ $recent->title }}" class="w-20 h-16 rounded-xl object-cover shrink-0 group-hover:opacity-90 transition-opacity" />
                <div class="space-y-1">
                  <span class="text-[10px] text-outline font-semibold block">{{ $recent->published_at?->format('d M Y') }}</span>
                  <h4 class="text-xs font-bold text-primary group-hover:text-primary-container transition-colors line-clamp-2">
                    {{ $recent->title }}
                  </h4>
                </div>
              </a>
            @endforeach
          </div>
        </div>

        <!-- Categories Widget -->
        <div class="bg-surface-container-lowest p-6 rounded-3xl border border-surface-container shadow-sm space-y-3">
          <h3 class="font-title-md text-title-md text-primary font-bold pb-2 border-b border-surface-container">
            Kategori Berita
          </h3>
          <ul class="space-y-1.5 text-xs text-on-surface">
            @foreach($categories as $cat)
              <li>
                <a href="{{ route('news.index', ['category' => $cat->slug]) }}" class="flex items-center justify-between p-2 rounded-xl hover:bg-surface-container transition-colors">
                  <span>{{ $cat->name }}</span>
                  <span class="font-bold text-outline bg-surface-container-low px-2 py-0.5 rounded-full text-[10px]">{{ $cat->articles_count }}</span>
                </a>
              </li>
            @endforeach
          </ul>
        </div>

      </aside>

    </div>
  </div>
</section>
@endsection

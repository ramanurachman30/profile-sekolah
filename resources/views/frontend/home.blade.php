@extends('layouts.frontend')

@section('title', 'Beranda - SDN Cikereteg 01')

@section('content')
<section class="py-16 text-center max-w-4xl mx-auto px-4">
    <div class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-primary/10 text-primary font-bold text-sm mb-4">
        <span>Portal Resmi SDN Cikereteg 01</span>
    </div>
    <h1 class="text-3xl lg:text-5xl font-extrabold text-primary mb-6">Mendidik Generasi Cerdas & Berkarakter</h1>
    <p class="text-on-surface-variant leading-relaxed mb-8">Kurikulum Merdeka jenjang Sekolah Dasar ramah anak di Kecamatan Caringin, Kabupaten Bogor.</p>
    <a href="{{ route('ppdb.index') }}" class="inline-flex items-center gap-2 bg-primary text-white font-bold px-6 py-3 rounded-xl shadow-lg hover:bg-primary-container transition-all">
        <span class="material-symbols-outlined">how_to_reg</span>
        <span>Informasi PPDB Online</span>
    </a>
</section>
@endsection

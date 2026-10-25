@extends('layouts.frontend')

@section('title', 'Pendaftaran PPDB Berhasil - ' . $registration->registration_number)

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
      <a class="hover:text-primary transition-colors" href="{{ route('ppdb.index') }}">PPDB Online</a>
      <span class="material-symbols-outlined text-[14px] text-outline">chevron_right</span>
      <span class="text-primary font-semibold">Bukti Pendaftaran</span>
    </nav>
  </div>
</div>

<section class="w-full py-14 bg-surface">
  <div class="max-w-2xl mx-auto px-margin-mobile lg:px-margin">
    <div class="bg-surface-container-lowest rounded-3xl p-6 sm:p-10 border border-surface-container shadow-xl text-center space-y-6">
      
      <!-- Icon Success -->
      <div class="w-20 h-20 rounded-full bg-emerald-100 text-emerald-600 flex items-center justify-center mx-auto shadow-inner">
        <span class="material-symbols-outlined text-[44px]">check_circle</span>
      </div>

      <div class="space-y-2">
        <span class="px-3.5 py-1 rounded-full bg-emerald-50 text-emerald-700 font-bold text-xs uppercase tracking-wider">
          Pendaftaran Berhasil Terkirim
        </span>
        <h1 class="font-headline-md text-headline-md text-primary font-extrabold">
          Bukti Pendaftaran PPDB SD
        </h1>
        <p class="font-body-sm text-xs text-on-surface-variant max-w-md mx-auto">
          Formulir pendaftaran calon peserta didik baru telah tersimpan di sistem SDN Cikereteg 01 dan sedang menunggu verifikasi panitia.
        </p>
      </div>

      <!-- Detail Card -->
      <div class="bg-surface-container-low p-6 rounded-2xl border border-surface-container text-left space-y-3">
        <div class="flex items-center justify-between pb-3 border-b border-surface-container">
          <span class="text-xs text-outline font-semibold">Nomor Registrasi:</span>
          <span class="font-mono font-extrabold text-primary text-base">{{ $registration->registration_number }}</span>
        </div>

        <div class="grid grid-cols-2 gap-2 text-xs py-1 border-b border-surface-container/60">
          <span class="text-on-surface-variant">Nama Calon Siswa:</span>
          <span class="font-bold text-on-surface text-right">{{ $registration->child_full_name }}</span>
        </div>

        <div class="grid grid-cols-2 gap-2 text-xs py-1 border-b border-surface-container/60">
          <span class="text-on-surface-variant">NIK Anak:</span>
          <span class="font-mono font-semibold text-right">{{ $registration->child_nik }}</span>
        </div>

        <div class="grid grid-cols-2 gap-2 text-xs py-1 border-b border-surface-container/60">
          <span class="text-on-surface-variant">Jalur Pendaftaran:</span>
          <span class="font-bold text-secondary text-right">{{ $registration->track_label }}</span>
        </div>

        <div class="grid grid-cols-2 gap-2 text-xs py-1 border-b border-surface-container/60">
          <span class="text-on-surface-variant">Nama Orang Tua/Wali:</span>
          <span class="font-semibold text-right">{{ $registration->parent_name }}</span>
        </div>

        <div class="grid grid-cols-2 gap-2 text-xs py-1 border-b border-surface-container/60">
          <span class="text-on-surface-variant">Nomor WhatsApp:</span>
          <span class="font-mono font-semibold text-right">{{ $registration->parent_phone }}</span>
        </div>

        <div class="grid grid-cols-2 gap-2 text-xs pt-1 items-center">
          <span class="text-on-surface-variant">Status Saat Ini:</span>
          <div class="text-right">
            <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full bg-amber-100 text-amber-800 font-bold text-[11px]">
              <span class="h-1.5 w-1.5 rounded-full bg-amber-500"></span>
              <span>{{ $registration->verification_status_label }}</span>
            </span>
          </div>
        </div>
      </div>

      <!-- Action Buttons -->
      <div class="space-y-3 pt-2">
        <a href="{{ $waUrl }}" target="_blank" class="w-full py-4 px-6 rounded-2xl bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-sm flex items-center justify-center gap-2 transition-all shadow-lg">
          <span class="material-symbols-outlined text-[20px]">chat</span>
          <span>Konfirmasi ke WhatsApp Panitia PPDB</span>
        </a>

        <div class="flex items-center gap-3">
          <button onclick="window.print()" class="w-1/2 py-3 px-4 rounded-xl bg-surface-container hover:bg-surface-container-high text-primary font-bold text-xs flex items-center justify-center gap-1.5 transition-colors">
            <span class="material-symbols-outlined text-[18px]">print</span>
            <span>Cetak Bukti</span>
          </button>

          <a href="{{ route('home') }}" class="w-1/2 py-3 px-4 rounded-xl bg-surface-container hover:bg-surface-container-high text-on-surface font-semibold text-xs flex items-center justify-center gap-1.5 transition-colors">
            <span class="material-symbols-outlined text-[18px]">home</span>
            <span>Kembali ke Beranda</span>
          </a>
        </div>
      </div>

      <div class="p-4 rounded-2xl bg-primary-fixed/20 text-primary text-xs leading-relaxed text-left flex items-start gap-3">
        <span class="material-symbols-outlined text-primary text-[20px] shrink-0 mt-0.5">info</span>
        <span>Simpan nomor registrasi <strong>{{ $registration->registration_number }}</strong>. Panitia PPDB SDN Cikereteg 01 akan menghubungi via WhatsApp untuk verifikasi berkas fisik saat awal tahun ajaran.</span>
      </div>

    </div>
  </div>
</section>
@endsection

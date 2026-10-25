@extends('layouts.frontend')

@section('title', 'PPDB Online - SDN Cikereteg 01')
@section('meta_description', 'Pendaftaran Peserta Didik Baru (PPDB) SDN Cikereteg 01 Kelas 1 SD. Tanpa tes calistung, bebas biaya pendidikan (100% Gratis Dana BOS).')

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
      <span class="text-primary font-semibold">PPDB SD Online</span>
    </nav>
  </div>
</div>

<!-- HERO HEADER & STATUS KUOTA -->
<section class="w-full py-10 bg-gradient-to-b from-primary/5 via-surface to-surface">
  <div class="max-w-7xl mx-auto px-margin-mobile lg:px-margin">
    <div class="max-w-3xl space-y-3">
      <span class="font-label-sm text-label-sm text-secondary font-bold uppercase tracking-wider">Tahun Ajaran {{ $activePeriod->academicYear?->year_code ?? '2026/2027' }}</span>
      <h1 class="font-headline-xl text-headline-xl text-primary font-extrabold tracking-tight">
        Penerimaan Peserta Didik Baru (PPDB SD)
      </h1>
      <p class="font-body-lg text-body-lg text-on-surface-variant leading-relaxed">
        Selamat datang di portal PPDB online <strong>{{ $profile->school_name ?? 'SDN Cikereteg 01' }}</strong>. Kami menyambut putra-putri tercinta untuk memulai petualangan belajar yang menyenangkan, tanpa tes calistung, dan bebas pungutan biaya (100% Gratis Dana BOS).
      </p>
    </div>

    <!-- Banner Info Periode & Kuota -->
    @if($activePeriod)
      <div class="mt-8 bg-surface-container-lowest p-6 rounded-3xl border-2 border-primary/20 shadow-md">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4 items-center">
          <div class="md:col-span-2">
            <span class="inline-flex items-center gap-1 px-3 py-1 rounded-full bg-primary/10 text-primary font-bold text-xs uppercase">
              <span class="h-2 w-2 rounded-full bg-emerald-500 animate-pulse"></span>
              <span>Pendaftaran Sedang Dibuka</span>
            </span>
            <h3 class="font-title-lg text-primary font-extrabold mt-1.5">{{ $activePeriod->wave_name }}</h3>
            <p class="text-xs text-on-surface-variant mt-0.5">
              Jadwal: {{ $activePeriod->start_date?->format('d M Y') }} s/d {{ $activePeriod->end_date?->format('d M Y') }}
            </p>
          </div>
          <div class="bg-surface-container-low p-4 rounded-2xl text-center border border-surface-container">
            <span class="text-xs text-outline font-semibold block">Target Daya Tampung</span>
            <span class="font-headline-sm font-extrabold text-primary">{{ $activePeriod->target_quota }} Siswa</span>
            <span class="text-[11px] text-on-surface-variant block">3 Rombongan Belajar</span>
          </div>
          <div class="bg-surface-container-low p-4 rounded-2xl text-center border border-surface-container">
            <span class="text-xs text-outline font-semibold block">Sisa Kuota Tersedia</span>
            <span class="font-headline-sm font-extrabold text-secondary">{{ $activePeriod->remaining_quota }} Kursi</span>
            <span class="text-[11px] text-emerald-600 font-semibold block">{{ $activePeriod->accepted_count }} Sudah Diterima</span>
          </div>
        </div>
      </div>
    @else
      <div class="mt-8 p-6 rounded-3xl bg-surface-container text-center text-on-surface-variant">
        <span class="material-symbols-outlined text-4xl text-outline mb-2">event_busy</span>
        <h3 class="font-bold text-base text-primary">Periode PPDB Belum Dibuka</h3>
        <p class="text-xs mt-1">Silakan pantau berkala pengumuman di website ini atau hubungi tata usaha sekolah.</p>
      </div>
    @endif

    <!-- 3 Poin Utama PPDB SD -->
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 mt-8">
      <div class="bg-surface-container-lowest p-5 rounded-2xl border border-surface-container shadow-sm flex items-start gap-3">
        <div class="w-10 h-10 rounded-xl bg-primary-fixed text-primary flex items-center justify-center shrink-0">
          <span class="material-symbols-outlined text-[22px]">cake</span>
        </div>
        <div>
          <h4 class="font-title-sm text-sm font-bold text-primary">Usia Calon Siswa</h4>
          <p class="font-body-xs text-xs text-on-surface-variant mt-0.5">Prioritas usia 7 tahun atau minimal 6 tahun per 1 Juli tahun berjalan.</p>
        </div>
      </div>

      <div class="bg-surface-container-lowest p-5 rounded-2xl border border-surface-container shadow-sm flex items-start gap-3">
        <div class="w-10 h-10 rounded-xl bg-secondary-fixed text-secondary flex items-center justify-center shrink-0">
          <span class="material-symbols-outlined text-[22px]">description</span>
        </div>
        <div>
          <h4 class="font-title-sm text-sm font-bold text-primary">Dokumen Utama</h4>
          <p class="font-body-xs text-xs text-on-surface-variant mt-0.5">Akta Kelahiran anak dan Kartu Keluarga (KK), opsional KIA bila ada.</p>
        </div>
      </div>

      <div class="bg-surface-container-lowest p-5 rounded-2xl border border-surface-container shadow-sm flex items-start gap-3">
        <div class="w-10 h-10 rounded-xl bg-tertiary-fixed text-tertiary-container flex items-center justify-center shrink-0">
          <span class="material-symbols-outlined text-[22px]">sentiment_very_satisfied</span>
        </div>
        <div>
          <h4 class="font-title-sm text-sm font-bold text-primary">Tanpa Tes Calistung</h4>
          <p class="font-body-xs text-xs text-on-surface-variant mt-0.5">Tidak diperkenankan adanya tes baca, tulis, atau hitung bagi calon siswa SD.</p>
        </div>
      </div>
    </div>

  </div>
</section>

<!-- JALUR PENDAFTARAN -->
<section class="w-full py-10 bg-surface">
  <div class="max-w-7xl mx-auto px-margin-mobile lg:px-margin">
    <div class="text-center max-w-2xl mx-auto mb-10">
      <span class="font-label-sm text-label-sm text-secondary font-bold uppercase tracking-wider">Ketentuan PPDB</span>
      <h2 class="font-headline-md text-headline-md text-primary font-extrabold mt-1">4 Jalur Pendaftaran Siswa</h2>
      <p class="font-body-md text-body-md text-on-surface-variant mt-2">
        Pilihlah jalur pendaftaran yang sesuai dengan kondisi keluarga Anda:
      </p>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-4 gap-6">

      <!-- Jalur Zonasi -->
      <div class="bg-surface-container-lowest p-6 rounded-3xl border-2 border-primary shadow-sm space-y-3 card-hover flex flex-col justify-between">
        <div class="space-y-3">
          <div class="flex items-center justify-between">
            <span class="text-xs font-bold uppercase px-2.5 py-1 rounded-full bg-primary text-on-primary">Kuota 70%</span>
            <span class="material-symbols-outlined text-[24px] text-primary">pin_drop</span>
          </div>
          <h3 class="font-title-md text-title-md text-primary font-bold">1. Jalur Zonasi</h3>
          <p class="font-body-sm text-xs text-on-surface-variant leading-relaxed">
            Diperuntukkan bagi anak yang berdomisili di dalam wilayah zonasi Desa Cikereteg dan sekitarnya berdasarkan radius jarak tempat tinggal.
          </p>
          <ul class="text-xs space-y-1 text-on-surface pt-2 border-t border-surface-container">
            <li class="flex items-center gap-1.5"><span class="material-symbols-outlined text-[15px] text-tertiary-container">check</span>KK diterbitkan minimal 1 tahun</li>
            <li class="flex items-center gap-1.5"><span class="material-symbols-outlined text-[15px] text-tertiary-container">check</span>Prioritas usia tertua (7 tahun)</li>
          </ul>
        </div>
        <div class="pt-3 border-t border-surface-container">
          <span class="text-xs font-bold text-primary">Gratis Tanpa Biaya</span>
        </div>
      </div>

      <!-- Jalur Afirmasi -->
      <div class="bg-surface-container-lowest p-6 rounded-3xl border border-surface-container shadow-sm space-y-3 card-hover flex flex-col justify-between">
        <div class="space-y-3">
          <div class="flex items-center justify-between">
            <span class="text-xs font-bold uppercase px-2.5 py-1 rounded-full bg-secondary-fixed text-secondary">Kuota 15%</span>
            <span class="material-symbols-outlined text-[24px] text-secondary">favorite</span>
          </div>
          <h3 class="font-title-md text-title-md text-primary font-bold">2. Jalur Afirmasi</h3>
          <p class="font-body-sm text-xs text-on-surface-variant leading-relaxed">
            Bagi calon siswa dari keluarga prasejahtera penerima bantuan KIP/PKH/KKS dan penyandang disabilitas ramah anak.
          </p>
          <ul class="text-xs space-y-1 text-on-surface pt-2 border-t border-surface-container">
            <li class="flex items-center gap-1.5"><span class="material-symbols-outlined text-[15px] text-tertiary-container">check</span>Bukti kepemilikan KIP / PKH</li>
            <li class="flex items-center gap-1.5"><span class="material-symbols-outlined text-[15px] text-tertiary-container">check</span>Pendampingan belajar guru kelas</li>
          </ul>
        </div>
        <div class="pt-3 border-t border-surface-container">
          <span class="text-xs font-bold text-primary">Bantuan Perlengkapan</span>
        </div>
      </div>

      <!-- Jalur Perpindahan Tugas -->
      <div class="bg-surface-container-lowest p-6 rounded-3xl border border-surface-container shadow-sm space-y-3 card-hover flex flex-col justify-between">
        <div class="space-y-3">
          <div class="flex items-center justify-between">
            <span class="text-xs font-bold uppercase px-2.5 py-1 rounded-full bg-surface-container-high text-primary">Kuota 5%</span>
            <span class="material-symbols-outlined text-[24px] text-primary">commute</span>
          </div>
          <h3 class="font-title-md text-title-md text-primary font-bold">3. Mutasi Orang Tua</h3>
          <p class="font-body-sm text-xs text-on-surface-variant leading-relaxed">
            Bagi anak yang orang tuanya pindah tugas kerja resmi (ASN, TNI, Polri, BUMN, atau swasta) ke wilayah Caringin/Bogor.
          </p>
          <ul class="text-xs space-y-1 text-on-surface pt-2 border-t border-surface-container">
            <li class="flex items-center gap-1.5"><span class="material-symbols-outlined text-[15px] text-tertiary-container">check</span>Surat penugasan resmi ortu</li>
            <li class="flex items-center gap-1.5"><span class="material-symbols-outlined text-[15px] text-tertiary-container">check</span>Surat keterangan domisili</li>
          </ul>
        </div>
        <div class="pt-3 border-t border-surface-container">
          <span class="text-xs font-bold text-primary">Pelayanan Cepat TU</span>
        </div>
      </div>

      <!-- Jalur Reguler -->
      <div class="bg-surface-container-lowest p-6 rounded-3xl border border-surface-container shadow-sm space-y-3 card-hover flex flex-col justify-between">
        <div class="space-y-3">
          <div class="flex items-center justify-between">
            <span class="text-xs font-bold uppercase px-2.5 py-1 rounded-full bg-surface-container text-on-surface">Kuota 10%</span>
            <span class="material-symbols-outlined text-[24px] text-outline">group</span>
          </div>
          <h3 class="font-title-md text-title-md text-primary font-bold">4. Jalur Reguler</h3>
          <p class="font-body-sm text-xs text-on-surface-variant leading-relaxed">
            Bagi pendaftar umum yang berdomisili di luar batas zonasi utama apabila kuota zonasi telah terpenuhi dan masih terdapat sisa kursi.
          </p>
          <ul class="text-xs space-y-1 text-on-surface pt-2 border-t border-surface-container">
            <li class="flex items-center gap-1.5"><span class="material-symbols-outlined text-[15px] text-tertiary-container">check</span>Akta Kelahiran & KK resmi</li>
            <li class="flex items-center gap-1.5"><span class="material-symbols-outlined text-[15px] text-tertiary-container">check</span>Seleksi berdasarkan usia anak</li>
          </ul>
        </div>
        <div class="pt-3 border-t border-surface-container">
          <span class="text-xs font-bold text-primary">Bebas Pungutan Biaya</span>
        </div>
      </div>

    </div>
  </div>
</section>

<!-- FORMULIR PENDAFTARAN ONLINE -->
<section class="w-full py-12 bg-surface-container-low" id="formulir-daftar">
  <div class="max-w-4xl mx-auto px-margin-mobile lg:px-margin">
    <div class="bg-surface-container-lowest rounded-3xl p-6 sm:p-10 border border-surface-container shadow-md space-y-6">
      
      <div class="text-center max-w-xl mx-auto space-y-2">
        <span class="text-xs font-bold uppercase px-3 py-1 rounded-full bg-primary/10 text-primary">Formulir Mandiri Online</span>
        <h2 class="font-headline-sm text-headline-sm text-primary font-extrabold">Formulir Pendaftaran Calon Siswa Baru</h2>
        <p class="font-body-sm text-xs text-on-surface-variant">
          Silakan lengkapi data calon siswa dan orang tua dengan teliti. Lampirkan foto/scan Kartu Keluarga dan Akta Kelahiran.
        </p>
      </div>

      @if($errors->any())
        <div class="p-4 rounded-2xl bg-red-50 border border-red-200 text-red-700 text-xs space-y-1">
          <strong class="font-bold block">Mohon perbaiki isian formulir:</strong>
          <ul class="list-disc list-inside">
            @foreach($errors->all() as $err)
              <li>{{ $err }}</li>
            @endforeach
          </ul>
        </div>
      @endif

      @if($activePeriod)
        <form action="{{ route('ppdb.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
          @csrf
          <input type="hidden" name="period_id" value="{{ $activePeriod->id }}" />

          <!-- Bagian 1: Data Calon Siswa -->
          <div class="space-y-4">
            <h3 class="font-title-md text-primary font-bold flex items-center gap-2 pb-2 border-b border-surface-container">
              <span class="material-symbols-outlined text-secondary">child_care</span>
              <span>1. Data Calon Siswa Baru</span>
            </h3>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
              <div>
                <label class="block text-xs font-bold text-on-surface mb-1">
                  Nama Lengkap Anak (Sesuai Akta) <span class="text-red-500">*</span>
                </label>
                <input type="text" name="child_full_name" value="{{ old('child_full_name') }}" required placeholder="Contoh: Muhammad Rizki Pratama" class="w-full px-3.5 py-2.5 rounded-xl border border-surface-container-high bg-surface focus:bg-surface-container-lowest focus:border-primary outline-none text-sm transition-all" />
              </div>

              <div>
                <label class="block text-xs font-bold text-on-surface mb-1">
                  NIK Anak (16 Digit di KK) <span class="text-red-500">*</span>
                </label>
                <input type="text" name="child_nik" value="{{ old('child_nik') }}" required maxlength="16" placeholder="16 Digit NIK Anak" class="w-full px-3.5 py-2.5 rounded-xl border border-surface-container-high bg-surface focus:bg-surface-container-lowest focus:border-primary outline-none text-sm transition-all" />
              </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
              <div>
                <label class="block text-xs font-bold text-on-surface mb-1">
                  Jenis Kelamin <span class="text-red-500">*</span>
                </label>
                <select name="child_gender" required class="w-full px-3.5 py-2.5 rounded-xl border border-surface-container-high bg-surface focus:bg-surface-container-lowest focus:border-primary outline-none text-sm transition-all">
                  <option value="L" {{ old('child_gender') === 'L' ? 'selected' : '' }}>Laki-laki</option>
                  <option value="P" {{ old('child_gender') === 'P' ? 'selected' : '' }}>Perempuan</option>
                </select>
              </div>

              <div>
                <label class="block text-xs font-bold text-on-surface mb-1">
                  Tempat Lahir <span class="text-red-500">*</span>
                </label>
                <input type="text" name="child_birth_place" value="{{ old('child_birth_place', 'Bogor') }}" required placeholder="Kota / Kabupaten Lahir" class="w-full px-3.5 py-2.5 rounded-xl border border-surface-container-high bg-surface focus:bg-surface-container-lowest focus:border-primary outline-none text-sm transition-all" />
              </div>

              <div>
                <label class="block text-xs font-bold text-on-surface mb-1">
                  Tanggal Lahir Anak <span class="text-red-500">*</span>
                </label>
                <input type="date" name="child_birth_date" value="{{ old('child_birth_date') }}" required class="w-full px-3.5 py-2.5 rounded-xl border border-surface-container-high bg-surface focus:bg-surface-container-lowest focus:border-primary outline-none text-sm transition-all" />
              </div>
            </div>

            <div>
              <label class="block text-xs font-bold text-on-surface mb-1">
                Pilihan Jalur Pendaftaran <span class="text-red-500">*</span>
              </label>
              <select name="track" required class="w-full px-3.5 py-2.5 rounded-xl border border-surface-container-high bg-surface focus:bg-surface-container-lowest focus:border-primary outline-none text-sm transition-all">
                <option value="zonasi" {{ old('track') === 'zonasi' ? 'selected' : '' }}>Jalur Zonasi (Desa Cikereteg & Sekitarnya)</option>
                <option value="afirmasi" {{ old('track') === 'afirmasi' ? 'selected' : '' }}>Jalur Afirmasi (Keluarga Prasejahtera KIP/PKH)</option>
                <option value="perpindahan_ortu" {{ old('track') === 'perpindahan_ortu' ? 'selected' : '' }}>Jalur Perpindahan Tugas Orang Tua (Mutasi)</option>
                <option value="reguler" {{ old('track') === 'reguler' ? 'selected' : '' }}>Jalur Reguler / Umum</option>
              </select>
            </div>
          </div>

          <!-- Bagian 2: Data Orang Tua / Wali -->
          <div class="space-y-4 pt-4 border-t border-surface-container">
            <h3 class="font-title-md text-primary font-bold flex items-center gap-2 pb-2 border-b border-surface-container">
              <span class="material-symbols-outlined text-secondary">family_restroom</span>
              <span>2. Data Orang Tua / Wali Murid</span>
            </h3>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
              <div>
                <label class="block text-xs font-bold text-on-surface mb-1">
                  Nama Ayah / Ibu / Wali <span class="text-red-500">*</span>
                </label>
                <input type="text" name="parent_name" value="{{ old('parent_name') }}" required placeholder="Contoh: Bpk. Supriyadi" class="w-full px-3.5 py-2.5 rounded-xl border border-surface-container-high bg-surface focus:bg-surface-container-lowest focus:border-primary outline-none text-sm transition-all" />
              </div>

              <div>
                <label class="block text-xs font-bold text-on-surface mb-1">
                  Nomor WhatsApp Aktif <span class="text-red-500">*</span>
                </label>
                <input type="tel" name="parent_phone" value="{{ old('parent_phone') }}" required placeholder="08xxxxxxxxxx" class="w-full px-3.5 py-2.5 rounded-xl border border-surface-container-high bg-surface focus:bg-surface-container-lowest focus:border-primary outline-none text-sm transition-all" />
              </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
              <div>
                <label class="block text-xs font-bold text-on-surface mb-1">
                  NIK Orang Tua / Wali
                </label>
                <input type="text" name="parent_nik" value="{{ old('parent_nik') }}" maxlength="16" placeholder="16 Digit NIK Wali" class="w-full px-3.5 py-2.5 rounded-xl border border-surface-container-high bg-surface focus:bg-surface-container-lowest focus:border-primary outline-none text-sm transition-all" />
              </div>

              <div>
                <label class="block text-xs font-bold text-on-surface mb-1">
                  Pekerjaan Orang Tua
                </label>
                <input type="text" name="parent_occupation" value="{{ old('parent_occupation') }}" placeholder="Petani, Karyawan, Wiraswasta, dll" class="w-full px-3.5 py-2.5 rounded-xl border border-surface-container-high bg-surface focus:bg-surface-container-lowest focus:border-primary outline-none text-sm transition-all" />
              </div>

              <div>
                <label class="block text-xs font-bold text-on-surface mb-1">
                  Perkiraan Jarak ke Sekolah (Meter)
                </label>
                <input type="number" name="distance_meters" value="{{ old('distance_meters') }}" placeholder="Contoh: 450" class="w-full px-3.5 py-2.5 rounded-xl border border-surface-container-high bg-surface focus:bg-surface-container-lowest focus:border-primary outline-none text-sm transition-all" />
              </div>
            </div>

            <div>
              <label class="block text-xs font-bold text-on-surface mb-1">
                Alamat Domisili Tempat Tinggal <span class="text-red-500">*</span>
              </label>
              <textarea name="home_address" required rows="2" placeholder="Nama kampung, RT/RW, Desa Cikereteg, Kec. Caringin, Kab. Bogor" class="w-full p-3 rounded-xl border border-surface-container-high bg-surface focus:bg-surface-container-lowest focus:border-primary outline-none text-sm transition-all">{{ old('home_address') }}</textarea>
            </div>
          </div>

          <!-- Bagian 3: Unggah Dokumen Pendukung -->
          <div class="space-y-4 pt-4 border-t border-surface-container">
            <h3 class="font-title-md text-primary font-bold flex items-center gap-2 pb-2 border-b border-surface-container">
              <span class="material-symbols-outlined text-secondary">upload_file</span>
              <span>3. Unggah Berkas Dokumen (Foto / Scan PDF)</span>
            </h3>

            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
              <div class="p-4 rounded-2xl bg-surface-container-low border border-surface-container space-y-2">
                <label class="block text-xs font-bold text-primary">
                  1. Foto/Scan Kartu Keluarga (KK)
                </label>
                <input type="file" name="document_kk" accept="image/*,application/pdf" class="w-full text-xs text-on-surface-variant file:mr-2 file:py-1.5 file:px-3 file:rounded-lg file:border-0 file:text-xs file:font-bold file:bg-primary file:text-white hover:file:bg-primary-container" />
                <span class="text-[10px] text-outline block">Maks. 3 MB (JPG, PNG, PDF)</span>
              </div>

              <div class="p-4 rounded-2xl bg-surface-container-low border border-surface-container space-y-2">
                <label class="block text-xs font-bold text-primary">
                  2. Foto/Scan Akta Kelahiran
                </label>
                <input type="file" name="document_akta" accept="image/*,application/pdf" class="w-full text-xs text-on-surface-variant file:mr-2 file:py-1.5 file:px-3 file:rounded-lg file:border-0 file:text-xs file:font-bold file:bg-primary file:text-white hover:file:bg-primary-container" />
                <span class="text-[10px] text-outline block">Maks. 3 MB (JPG, PNG, PDF)</span>
              </div>

              <div class="p-4 rounded-2xl bg-surface-container-low border border-surface-container space-y-2">
                <label class="block text-xs font-bold text-primary">
                  3. KIA / Bukti Afirmasi (Opsional)
                </label>
                <input type="file" name="document_kia" accept="image/*,application/pdf" class="w-full text-xs text-on-surface-variant file:mr-2 file:py-1.5 file:px-3 file:rounded-lg file:border-0 file:text-xs file:font-bold file:bg-secondary file:text-white hover:file:bg-secondary-container" />
                <span class="text-[10px] text-outline block">Kartu Identitas Anak / KIP / Mutasi</span>
              </div>
            </div>
          </div>

          <div class="pt-4 border-t border-surface-container">
            <button type="submit" class="w-full py-4 px-6 rounded-2xl bg-primary hover:bg-primary-container text-on-primary font-bold text-base flex items-center justify-center gap-2 transition-all shadow-lg cursor-pointer">
              <span class="material-symbols-outlined text-[22px]">how_to_reg</span>
              <span>Kirim Formulir Pendaftaran Siswa Baru</span>
            </button>
            <p class="text-[11px] text-on-surface-variant text-center mt-2.5">
              Seluruh proses pendaftaran di {{ $profile->school_name ?? 'SDN Cikereteg 01' }} tidak dipungut biaya apapun (Gratis).
            </p>
          </div>

        </form>
      @endif

    </div>
  </div>
</section>

<!-- FAQ PPDB -->
<section class="w-full py-12 bg-surface">
  <div class="max-w-4xl mx-auto px-margin-mobile lg:px-margin">
    <div class="text-center mb-8">
      <span class="font-label-sm text-label-sm text-secondary font-bold uppercase tracking-wider">Tanya Jawab</span>
      <h2 class="font-headline-sm text-headline-sm text-primary font-extrabold mt-1">FAQ Pendaftaran Calon Siswa</h2>
    </div>

    <div class="space-y-3">
      <details class="group bg-surface-container-lowest rounded-2xl p-4 border border-surface-container shadow-sm" open>
        <summary class="flex items-center justify-between cursor-pointer font-bold text-sm text-primary list-none">
          <span>Apakah anak yang belum lancar membaca boleh mendaftar?</span>
          <span class="material-symbols-outlined text-primary group-open:rotate-180 transition-transform">expand_more</span>
        </summary>
        <p class="text-xs text-on-surface-variant mt-2 border-t border-surface-container pt-2 leading-relaxed">
          Tentu saja sangat boleh! Sesuai aturan resmi Kurikulum Merdeka Kemendikbudristek, masuk SD <strong>tidak boleh ada tes calistung</strong>. Di kelas 1 guru akan membimbing proses membaca dan berhitung secara bertahap dan menyenangkan.
        </p>
      </details>

      <details class="group bg-surface-container-lowest rounded-2xl p-4 border border-surface-container shadow-sm">
        <summary class="flex items-center justify-between cursor-pointer font-bold text-sm text-primary list-none">
          <span>Apakah harus memiliki ijazah TK atau PAUD?</span>
          <span class="material-symbols-outlined text-primary group-open:rotate-180 transition-transform">expand_more</span>
        </summary>
        <p class="text-xs text-on-surface-variant mt-2 border-t border-surface-container pt-2 leading-relaxed">
          Ijazah TK/PAUD bukan syarat mutlak. Jika anak tidak sempat menempuh pendidikan TK, ananda tetap berhak mendaftar selama telah memenuhi syarat usia minimal.
        </p>
      </details>

      <details class="group bg-surface-container-lowest rounded-2xl p-4 border border-surface-container shadow-sm">
        <summary class="flex items-center justify-between cursor-pointer font-bold text-sm text-primary list-none">
          <span>Bagaimana jika orang tua kesulitan mengisi formulir secara online?</span>
          <span class="material-symbols-outlined text-primary group-open:rotate-180 transition-transform">expand_more</span>
        </summary>
        <p class="text-xs text-on-surface-variant mt-2 border-t border-surface-container pt-2 leading-relaxed">
          Bapak/Ibu wali murid dipersilakan datang langsung ke sekretariat SDN Cikereteg 01 pada jam kerja (Senin - Jumat 07.30 - 14.30 WIB). Panitia PPDB kami siap membantu mengisi dan memeriksa berkas secara langsung.
        </p>
      </details>
    </div>
  </div>
</section>
@endsection

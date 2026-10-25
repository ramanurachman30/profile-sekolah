@php
    $profile = \App\Models\SchoolProfile::first();
@endphp

<!-- FOOTER -->
<footer class="bg-primary text-on-primary pt-12 pb-8 border-t border-primary-container">
  <div class="max-w-7xl mx-auto px-margin-mobile lg:px-margin">
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8 mb-12">
      <div class="space-y-4">
        <div class="flex items-center gap-3">
          <div class="w-10 h-10 rounded-xl bg-surface-container-lowest text-primary flex items-center justify-center font-bold text-xl">
            <span class="material-symbols-outlined text-[24px] text-primary">school</span>
          </div>
          <div class="flex flex-col">
            <span class="font-bold text-base tracking-tight leading-none">{{ $profile->school_name ?? 'SDN CIKERETEG 01' }}</span>
            <span class="text-[11px] text-secondary-fixed font-medium">Sekolah Dasar Negeri • {{ $profile->sub_district ?? 'Caringin' }} {{ $profile->district ?? 'Bogor' }}</span>
          </div>
        </div>
        <p class="font-body-md text-body-md text-on-primary/80 leading-relaxed text-xs">
          {{ $profile->history_summary ? Str::limit($profile->history_summary, 140) : 'Sekolah Dasar Negeri ramah anak yang menanamkan budi pekerti luhur, kecintaan belajar, dan wawasan lingkungan hidup Adiwiyata.' }}
        </p>
        <div class="flex items-center gap-2 text-xs text-on-primary/80">
          <span class="px-2 py-0.5 rounded bg-white/10">NPSN: {{ $profile->npsn ?? '20200845' }}</span>
          <span class="px-2 py-0.5 rounded bg-white/10">Akreditasi {{ $profile->accreditation ?? 'A' }} BAN-S/M</span>
        </div>
      </div>

      <div>
        <h4 class="font-title-sm text-title-sm font-bold text-secondary-fixed mb-4">Navigasi Halaman</h4>
        <ul class="space-y-2 text-xs text-on-primary/80">
          <li><a class="hover:text-secondary-fixed transition-colors" href="{{ route('home') }}">Beranda</a></li>
          <li><a class="hover:text-secondary-fixed transition-colors" href="{{ route('profile') }}">Profil & Dewan Guru</a></li>
          <li><a class="hover:text-secondary-fixed transition-colors" href="{{ route('academic') }}">Kurikulum Merdeka SD</a></li>
          <li><a class="hover:text-secondary-fixed transition-colors" href="{{ route('student-affairs') }}">Kesiswaan & Ekskul</a></li>
          <li><a class="hover:text-secondary-fixed transition-colors" href="{{ route('facilities') }}">Fasilitas Sekolah</a></li>
        </ul>
      </div>

      <div>
        <h4 class="font-title-sm text-title-sm font-bold text-secondary-fixed mb-4">Layanan & Informasi</h4>
        <ul class="space-y-2 text-xs text-on-primary/80">
          <li><a class="hover:text-secondary-fixed transition-colors" href="{{ route('ppdb.index') }}">Penerimaan Siswa Baru (PPDB SD)</a></li>
          <li><a class="hover:text-secondary-fixed transition-colors" href="{{ route('achievements') }}">Prestasi Siswa SD</a></li>
          <li><a class="hover:text-secondary-fixed transition-colors" href="{{ route('news.index') }}">Berita & Kegiatan Sekolah</a></li>
          <li><a class="hover:text-secondary-fixed transition-colors" href="{{ route('gallery') }}">Galeri Foto Kegiatan</a></li>
          <li><a class="hover:text-secondary-fixed transition-colors" href="{{ route('contact.index') }}">Kontak & Lokasi</a></li>
        </ul>
      </div>

      <div class="space-y-3">
        <h4 class="font-title-sm text-title-sm font-bold text-secondary-fixed mb-4">Alamat & Kontak</h4>
        <div class="flex items-start gap-2 text-xs text-on-primary/80">
          <span class="material-symbols-outlined text-[16px] text-secondary-fixed shrink-0 mt-0.5">location_on</span>
          <span>{{ $profile->address ?? 'Jl. Raya Cikereteg No. 12, Desa Cikereteg, Kec. Caringin, Kab. Bogor 16730' }}</span>
        </div>
        <div class="flex items-center gap-2 text-xs text-on-primary/80">
          <span class="material-symbols-outlined text-[16px] text-secondary-fixed shrink-0">call</span>
          <span>{{ $profile->phone ?? '(0251) 824-1234' }}</span>
        </div>
        <div class="flex items-center gap-2 text-xs text-on-primary/80">
          <span class="material-symbols-outlined text-[16px] text-secondary-fixed shrink-0">chat</span>
          <span>+{{ $profile->whatsapp ?? '6281234567890' }} (WhatsApp TU)</span>
        </div>
        <div class="flex items-center gap-2 text-xs text-on-primary/80">
          <span class="material-symbols-outlined text-[16px] text-secondary-fixed shrink-0">schedule</span>
          <span>Senin - Jumat: 07.00 - 14.30 WIB</span>
        </div>
      </div>
    </div>

    <div class="pt-6 border-t border-white/10 flex flex-col sm:flex-row items-center justify-between gap-4 text-xs text-on-primary/60">
      <p>© {{ date('Y') }} {{ $profile->school_name ?? 'SDN Cikereteg 01' }}. Hak Cipta Dilindungi Undang-Undang.</p>
      <p>{{ $profile->sub_district ?? 'Kecamatan Caringin' }}, {{ $profile->district ?? 'Kabupaten Bogor' }}, Jawa Barat</p>
    </div>
  </div>
</footer>

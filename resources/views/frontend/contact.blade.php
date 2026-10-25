@extends('layouts.frontend')

@section('title', 'Kontak, Pesan Aduan & Kunjungan Sekolah - SDN Cikereteg 01')
@section('meta_description', 'Alamat resmi, peta lokasi, nomor telepon, WhatsApp, formulir tiket pesan orang tua, serta reservasi kunjungan sekolah SDN Cikereteg 01 Caringin Bogor.')

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
      <span class="text-primary font-semibold">Kontak & Layanan</span>
    </nav>
  </div>
</div>

<!-- HERO HEADER -->
<section class="w-full py-10 bg-gradient-to-b from-primary/5 via-surface to-surface">
  <div class="max-w-7xl mx-auto px-margin-mobile lg:px-margin">
    <div class="max-w-3xl space-y-3">
      <span class="font-label-sm text-label-sm text-secondary font-bold uppercase tracking-wider">Layanan Komunikasi Terpadu</span>
      <h1 class="font-headline-xl text-headline-xl text-primary font-extrabold tracking-tight">
        Hubungi SDN Cikereteg 01
      </h1>
      <p class="font-body-lg text-body-lg text-on-surface-variant leading-relaxed">
        Pintu komunikasi kami senantiasa terbuka untuk seluruh orang tua murid, calon wali murid, dan masyarakat. Sampaikan pertanyaan, konsultasi, pengaduan, atau jadwalkan kunjungan langsung ke sekolah kami.
      </p>
    </div>
  </div>
</section>

<!-- INFO KONTAK & KARTU UTAMA -->
<section class="w-full py-6 bg-surface">
  <div class="max-w-7xl mx-auto px-margin-mobile lg:px-margin">
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
      
      <div class="bg-surface-container-lowest p-6 rounded-3xl border border-surface-container shadow-sm space-y-2 card-hover">
        <div class="w-10 h-10 rounded-xl bg-primary-fixed text-primary flex items-center justify-center">
          <span class="material-symbols-outlined text-[20px]">location_on</span>
        </div>
        <h4 class="font-bold text-primary text-sm">Alamat Sekolah</h4>
        <p class="text-xs text-on-surface-variant leading-relaxed">
          {{ $profile->address ?? 'Jl. Raya Cikereteg No. 12' }}, {{ $profile->sub_district ?? 'Kec. Caringin' }}, {{ $profile->district ?? 'Kab. Bogor' }}, Jawa Barat {{ $profile->postal_code ?? '16730' }}
        </p>
      </div>

      <div class="bg-surface-container-lowest p-6 rounded-3xl border border-surface-container shadow-sm space-y-2 card-hover">
        <div class="w-10 h-10 rounded-xl bg-secondary-fixed text-secondary flex items-center justify-center">
          <span class="material-symbols-outlined text-[20px]">call</span>
        </div>
        <h4 class="font-bold text-primary text-sm">Telepon & Jam Kerja</h4>
        <p class="text-xs text-on-surface-variant leading-relaxed">
          {{ $profile->phone ?? '(0251) 824-1234' }}<br />
          <span class="text-outline text-[11px]">Senin - Jumat: 07.00 - 14.30 WIB</span>
        </p>
      </div>

      <div class="bg-surface-container-lowest p-6 rounded-3xl border border-surface-container shadow-sm space-y-2 card-hover">
        <div class="w-10 h-10 rounded-xl bg-tertiary-fixed text-tertiary-container flex items-center justify-center">
          <span class="material-symbols-outlined text-[20px]">chat</span>
        </div>
        <h4 class="font-bold text-primary text-sm">WhatsApp Resmi</h4>
        <p class="text-xs text-on-surface-variant leading-relaxed">
          +{{ $profile->whatsapp ?? '6281234567890' }}<br />
          <span class="text-outline text-[11px]">Respon staf TU & panitia PPDB</span>
        </p>
      </div>

      <div class="bg-surface-container-lowest p-6 rounded-3xl border border-surface-container shadow-sm space-y-2 card-hover">
        <div class="w-10 h-10 rounded-xl bg-primary-fixed text-primary flex items-center justify-center">
          <span class="material-symbols-outlined text-[20px]">mail</span>
        </div>
        <h4 class="font-bold text-primary text-sm">Email Sekolah</h4>
        <p class="text-xs text-on-surface-variant leading-relaxed">
          {{ $profile->email ?? 'sdncikereteg01@bogorkab.sch.id' }}<br />
          <span class="text-outline text-[11px]">Korespondensi kedinasan & surat</span>
        </p>
      </div>

    </div>
  </div>
</section>

<!-- FORMULIR LAYANAN TERPADU: PESAN/ADUAN & KUNJUNGAN SEKOLAH -->
<section class="w-full py-10 bg-surface-container-low">
  <div class="max-w-7xl mx-auto px-margin-mobile lg:px-margin">
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
      
      <!-- FORM A: KIRIM PESAN & TIKET ADUAN -->
      <div id="form-pesan" class="bg-surface-container-lowest p-6 sm:p-8 rounded-3xl border border-surface-container shadow-sm flex flex-col justify-between">
        <div>
          <div class="flex items-center gap-2 mb-2">
            <span class="material-symbols-outlined text-secondary text-[24px]">chat_bubble</span>
            <span class="font-label-sm text-label-sm text-secondary font-bold uppercase tracking-wider">Tiket Layanan Digital</span>
          </div>
          <h2 class="font-headline-sm text-headline-sm text-primary font-extrabold">Kirim Pesan & Konsultasi</h2>
          <p class="text-xs text-on-surface-variant mt-1 leading-relaxed">
            Sampaikan pertanyaan, masukan, atau permohonan informasi kepada pihak sekolah. Sistem akan otomatis menerbitkan nomor tiket aduan resmi.
          </p>

          {{-- NOTIFIKASI SUKSES PESAN --}}
          @if(session('inquiry_success'))
            <div class="mt-5 p-5 rounded-2xl bg-success-container/20 border border-success text-on-surface space-y-3">
              <div class="flex items-start gap-3">
                <span class="material-symbols-outlined text-success text-[24px]">check_circle</span>
                <div>
                  <h4 class="font-bold text-sm text-primary">Tiket Pesan Berhasil Diterbitkan!</h4>
                  <p class="text-xs text-on-surface-variant mt-0.5">
                    Terima kasih <strong>{{ session('inquiry_success')['sender_name'] }}</strong>. Pesan Anda telah tercatat pada sistem Tata Usaha SDN Cikereteg 01.
                  </p>
                </div>
              </div>
              <div class="bg-surface-container-lowest p-3 rounded-xl border border-surface-container flex items-center justify-between text-xs">
                <span class="text-on-surface-variant">Nomor Tiket:</span>
                <span class="font-mono font-bold text-primary text-sm">{{ session('inquiry_success')['ticket_number'] }}</span>
              </div>
              <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $profile->whatsapp ?? '6281234567890') }}?text={{ urlencode('Halo Staf TU SDN Cikereteg 01, saya ingin konfirmasi tiket aduan/pesan: ' . session('inquiry_success')['ticket_number']) }}" target="_blank" class="w-full py-2.5 rounded-xl bg-success text-white font-bold text-xs flex items-center justify-center gap-1.5 hover:bg-success/90 transition-colors">
                <span class="material-symbols-outlined text-[16px]">chat</span>
                <span>Konfirmasi via WhatsApp Staf TU</span>
              </a>
            </div>
          @endif

          <form action="{{ route('contact.inquiry.store') }}" method="POST" class="mt-6 space-y-4">
            @csrf

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
              <div class="space-y-1">
                <label class="block text-xs font-bold text-on-surface">Nama Lengkap <span class="text-error">*</span></label>
                <input type="text" name="sender_name" value="{{ old('sender_name') }}" required placeholder="Contoh: Ayah Budi Santoso" class="w-full px-4 py-2.5 rounded-xl border border-surface-container bg-surface text-xs focus:outline-none focus:border-primary @error('sender_name') border-error @enderror" />
                @error('sender_name') <span class="text-[11px] text-error">{{ $message }}</span> @enderror
              </div>

              <div class="space-y-1">
                <label class="block text-xs font-bold text-on-surface">No. WhatsApp / HP <span class="text-error">*</span></label>
                <input type="tel" name="sender_phone" value="{{ old('sender_phone') }}" required placeholder="08xxxxxxxxxx" class="w-full px-4 py-2.5 rounded-xl border border-surface-container bg-surface text-xs focus:outline-none focus:border-primary @error('sender_phone') border-error @enderror" />
                @error('sender_phone') <span class="text-[11px] text-error">{{ $message }}</span> @enderror
              </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
              <div class="space-y-1">
                <label class="block text-xs font-bold text-on-surface">Email (Opsional)</label>
                <input type="email" name="sender_email" value="{{ old('sender_email') }}" placeholder="alamat@email.com" class="w-full px-4 py-2.5 rounded-xl border border-surface-container bg-surface text-xs focus:outline-none focus:border-primary @error('sender_email') border-error @enderror" />
                @error('sender_email') <span class="text-[11px] text-error">{{ $message }}</span> @enderror
              </div>

              <div class="space-y-1">
                <label class="block text-xs font-bold text-on-surface">Kategori Pesan <span class="text-error">*</span></label>
                <select name="category" required class="w-full px-3 py-2.5 rounded-xl border border-surface-container bg-surface text-xs focus:outline-none focus:border-primary">
                  <option value="ppdb" {{ old('category') == 'ppdb' ? 'selected' : '' }}>Informasi PPDB Online</option>
                  <option value="administrasi" {{ old('category') == 'administrasi' ? 'selected' : '' }}>Administrasi & Surat Sekolah</option>
                  <option value="mutasi" {{ old('category') == 'mutasi' ? 'selected' : '' }}>Mutasi & Pindah Masuk/Keluar</option>
                  <option value="konsultasi" {{ old('category') == 'konsultasi' ? 'selected' : '' }}>Konsultasi Belajar Siswa</option>
                  <option value="lainnya" {{ old('category') == 'lainnya' ? 'selected' : '' }}>Saran / Lainnya</option>
                </select>
              </div>
            </div>

            <div class="space-y-1">
              <label class="block text-xs font-bold text-on-surface">Topik / Subjek Pesan <span class="text-error">*</span></label>
              <input type="text" name="subject" value="{{ old('subject') }}" required placeholder="Contoh: Tanya legalisir raport atau syarat zonasi" class="w-full px-4 py-2.5 rounded-xl border border-surface-container bg-surface text-xs focus:outline-none focus:border-primary @error('subject') border-error @enderror" />
              @error('subject') <span class="text-[11px] text-error">{{ $message }}</span> @enderror
            </div>

            <div class="space-y-1">
              <label class="block text-xs font-bold text-on-surface">Isi Pesan / Pertanyaan <span class="text-error">*</span></label>
              <textarea name="message" rows="4" required placeholder="Tuliskan uraian pesan atau pertanyaan Anda secara lengkap..." class="w-full px-4 py-2.5 rounded-xl border border-surface-container bg-surface text-xs focus:outline-none focus:border-primary @error('message') border-error @enderror">{{ old('message') }}</textarea>
              @error('message') <span class="text-[11px] text-error">{{ $message }}</span> @enderror
            </div>

            <div class="space-y-1">
              <label class="block text-xs font-bold text-on-surface">Saluran Balasan yang Diinginkan</label>
              <div class="flex items-center gap-4 text-xs pt-1">
                <label class="inline-flex items-center gap-1.5 cursor-pointer">
                  <input type="radio" name="preferred_channel" value="whatsapp" checked class="text-primary focus:ring-primary" />
                  <span>WhatsApp</span>
                </label>
                <label class="inline-flex items-center gap-1.5 cursor-pointer">
                  <input type="radio" name="preferred_channel" value="email" {{ old('preferred_channel') == 'email' ? 'selected' : '' }} class="text-primary focus:ring-primary" />
                  <span>Email</span>
                </label>
                <label class="inline-flex items-center gap-1.5 cursor-pointer">
                  <input type="radio" name="preferred_channel" value="telepon" {{ old('preferred_channel') == 'telepon' ? 'selected' : '' }} class="text-primary focus:ring-primary" />
                  <span>Telepon Langsung</span>
                </label>
              </div>
            </div>

            <div class="pt-2">
              <button type="submit" class="w-full py-3.5 rounded-xl bg-primary hover:bg-primary-container text-white font-bold text-xs flex items-center justify-center gap-2 transition-all shadow-md">
                <span class="material-symbols-outlined text-[18px]">send</span>
                <span>Kirim Pesan & Terbitkan Tiket</span>
              </button>
            </div>
          </form>
        </div>
      </div>

      <!-- FORM B: RESERVASI KUNJUNGAN SEKOLAH (SCHOOL VISIT) -->
      <div id="form-kunjungan" class="bg-surface-container-lowest p-6 sm:p-8 rounded-3xl border border-surface-container shadow-sm flex flex-col justify-between">
        <div>
          <div class="flex items-center gap-2 mb-2">
            <span class="material-symbols-outlined text-tertiary-container text-[24px]">school</span>
            <span class="font-label-sm text-label-sm text-tertiary-container font-bold uppercase tracking-wider">Jadwalkan Kunjungan</span>
          </div>
          <h2 class="font-headline-sm text-headline-sm text-primary font-extrabold">Reservasi School Visit</h2>
          <p class="text-xs text-on-surface-variant mt-1 leading-relaxed">
            Ingin melihat fasilitas, ruang kelas, dan suasana belajar di SDN Cikereteg 01? Daftarkan jadwal kunjungan Anda bersama putra-putri tercinta.
          </p>

          {{-- NOTIFIKASI SUKSES KUNJUNGAN --}}
          @if(session('visit_success'))
            <div class="mt-5 p-5 rounded-2xl bg-info-container/20 border border-primary text-on-surface space-y-3">
              <div class="flex items-start gap-3">
                <span class="material-symbols-outlined text-primary text-[24px]">event_available</span>
                <div>
                  <h4 class="font-bold text-sm text-primary">Reservasi Kunjungan Berhasil Dibuat!</h4>
                  <p class="text-xs text-on-surface-variant mt-0.5">
                    Permohonan kunjungan atas nama <strong>{{ session('visit_success')['parent_name'] }}</strong> telah tercatat pada agenda sekolah.
                  </p>
                </div>
              </div>
              <div class="bg-surface-container-lowest p-3 rounded-xl border border-surface-container space-y-1 text-xs">
                <div class="flex items-center justify-between">
                  <span class="text-on-surface-variant">Kode Booking:</span>
                  <span class="font-mono font-bold text-primary text-sm">{{ session('visit_success')['booking_code'] }}</span>
                </div>
                <div class="flex items-center justify-between text-[11px] text-on-surface-variant">
                  <span>Jadwal:</span>
                  <span class="font-medium text-on-surface">{{ session('visit_success')['visit_date'] }} ({{ session('visit_success')['session_label'] }})</span>
                </div>
              </div>
              <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $profile->whatsapp ?? '6281234567890') }}?text={{ urlencode('Halo SDN Cikereteg 01, saya ingin konfirmasi jadwal kunjungan dengan kode booking: ' . session('visit_success')['booking_code']) }}" target="_blank" class="w-full py-2.5 rounded-xl bg-primary text-white font-bold text-xs flex items-center justify-center gap-1.5 hover:bg-primary-container transition-colors">
                <span class="material-symbols-outlined text-[16px]">chat</span>
                <span>Konfirmasi Jadwal via WhatsApp</span>
              </a>
            </div>
          @endif

          <form action="{{ route('contact.visit.store') }}" method="POST" class="mt-6 space-y-4">
            @csrf

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
              <div class="space-y-1">
                <label class="block text-xs font-bold text-on-surface">Nama Orang Tua / Calon Wali <span class="text-error">*</span></label>
                <input type="text" name="parent_name" value="{{ old('parent_name') }}" required placeholder="Contoh: Ibu Rina Marlina" class="w-full px-4 py-2.5 rounded-xl border border-surface-container bg-surface text-xs focus:outline-none focus:border-primary @error('parent_name') border-error @enderror" />
                @error('parent_name') <span class="text-[11px] text-error">{{ $message }}</span> @enderror
              </div>

              <div class="space-y-1">
                <label class="block text-xs font-bold text-on-surface">No. WhatsApp Aktif <span class="text-error">*</span></label>
                <input type="tel" name="parent_phone" value="{{ old('parent_phone') }}" required placeholder="08xxxxxxxxxx" class="w-full px-4 py-2.5 rounded-xl border border-surface-container bg-surface text-xs focus:outline-none focus:border-primary @error('parent_phone') border-error @enderror" />
                @error('parent_phone') <span class="text-[11px] text-error">{{ $message }}</span> @enderror
              </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
              <div class="space-y-1">
                <label class="block text-xs font-bold text-on-surface">Rencana Tanggal Kunjungan <span class="text-error">*</span></label>
                <input type="date" name="visit_date" value="{{ old('visit_date', date('Y-m-d', strtotime('+1 day'))) }}" min="{{ date('Y-m-d') }}" required class="w-full px-4 py-2.5 rounded-xl border border-surface-container bg-surface text-xs focus:outline-none focus:border-primary @error('visit_date') border-error @enderror" />
                @error('visit_date') <span class="text-[11px] text-error">{{ $message }}</span> @enderror
              </div>

              <div class="space-y-1">
                <label class="block text-xs font-bold text-on-surface">Pilihan Sesi Jam <span class="text-error">*</span></label>
                <select name="visit_session" required class="w-full px-3 py-2.5 rounded-xl border border-surface-container bg-surface text-xs focus:outline-none focus:border-primary">
                  <option value="pagi" {{ old('visit_session') == 'pagi' ? 'selected' : '' }}>Sesi Pagi (08.00 - 10.00 WIB)</option>
                  <option value="siang" {{ old('visit_session') == 'siang' ? 'selected' : '' }}>Sesi Siang (10.30 - 12.00 WIB)</option>
                </select>
              </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
              <div class="space-y-1">
                <label class="block text-xs font-bold text-on-surface">Jumlah Peserta Hadir <span class="text-error">*</span></label>
                <input type="number" name="attendees_count" value="{{ old('attendees_count', 2) }}" min="1" max="10" required class="w-full px-4 py-2.5 rounded-xl border border-surface-container bg-surface text-xs focus:outline-none focus:border-primary @error('attendees_count') border-error @enderror" />
                @error('attendees_count') <span class="text-[11px] text-error">{{ $message }}</span> @enderror
              </div>

              <div class="space-y-1">
                <label class="block text-xs font-bold text-on-surface">Peminatan Jenjang Kelas <span class="text-error">*</span></label>
                <select name="grade_interest" required class="w-full px-3 py-2.5 rounded-xl border border-surface-container bg-surface text-xs focus:outline-none focus:border-primary">
                  <option value="kelas_1" {{ old('grade_interest') == 'kelas_1' ? 'selected' : '' }}>Calon Peserta Didik Kelas 1</option>
                  <option value="kelas_2" {{ old('grade_interest') == 'kelas_2' ? 'selected' : '' }}>Pindahan Kelas 2</option>
                  <option value="kelas_3" {{ old('grade_interest') == 'kelas_3' ? 'selected' : '' }}>Pindahan Kelas 3</option>
                  <option value="kelas_4" {{ old('grade_interest') == 'kelas_4' ? 'selected' : '' }}>Pindahan Kelas 4</option>
                  <option value="kelas_5" {{ old('grade_interest') == 'kelas_5' ? 'selected' : '' }}>Pindahan Kelas 5</option>
                  <option value="kelas_6" {{ old('grade_interest') == 'kelas_6' ? 'selected' : '' }}>Pindahan Kelas 6</option>
                  <option value="umum" {{ old('grade_interest') == 'umum' ? 'selected' : '' }}>Kunjungan Umum / Lembaga</option>
                </select>
              </div>
            </div>

            <div class="space-y-1">
              <label class="block text-xs font-bold text-on-surface">Catatan Khusus / Keperluan Kunjungan</label>
              <textarea name="internal_notes" rows="3" placeholder="Contoh: Ingin konsultasi program inklusi atau melihat sarana laboratorium komputer..." class="w-full px-4 py-2.5 rounded-xl border border-surface-container bg-surface text-xs focus:outline-none focus:border-primary @error('internal_notes') border-error @enderror">{{ old('internal_notes') }}</textarea>
              @error('internal_notes') <span class="text-[11px] text-error">{{ $message }}</span> @enderror
            </div>

            <div class="pt-2">
              <button type="submit" class="w-full py-3.5 rounded-xl bg-secondary hover:bg-secondary-container text-on-secondary font-bold text-xs flex items-center justify-center gap-2 transition-all shadow-md">
                <span class="material-symbols-outlined text-[18px]">calendar_add_on</span>
                <span>Booking Jadwal Kunjungan</span>
              </button>
            </div>
          </form>
        </div>
      </div>

    </div>
  </div>
</section>

<!-- PETA & PETUNJUK LOKASI -->
<section class="w-full py-12 bg-surface">
  <div class="max-w-7xl mx-auto px-margin-mobile lg:px-margin">
    <div class="bg-surface-container-lowest p-6 sm:p-8 rounded-3xl border border-surface-container shadow-sm space-y-4">
      <div class="flex items-center gap-2 text-primary font-bold text-base">
        <span class="material-symbols-outlined text-[24px]">map</span>
        <span>Peta Lokasi & Akses SDN Cikereteg 01</span>
      </div>
      <p class="text-xs text-on-surface-variant">
        Terletak di lokasi strategis pinggir jalan utama Cikereteg Caringin, mudah diakses kendaraan umum maupun pribadi dengan fasilitas parkir sekolah yang memadai.
      </p>
      <div class="w-full h-80 rounded-2xl overflow-hidden border border-surface-container shadow-inner">
        <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d15850.569470942095!2d106.84561845!3d-6.69179835!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e69c8bfbe01c80f%3A0x6b10eb8b38749a2a!2sCikereteg%2C%20Caringin%2C%20Bogor%20Regency%2C%20West%20Java!5e0!3m2!1sen!2sid!4v1700000000000!5m2!1sen!2sid" class="w-full h-full" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
      </div>
    </div>
  </div>
</section>
@endsection

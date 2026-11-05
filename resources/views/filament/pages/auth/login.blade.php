@php
    use Filament\Support\Facades\FilamentView;
    use Filament\View\PanelsRenderHook;

    $profile = $this->schoolProfile;
    $schoolName = $profile?->school_name ?? 'SDN Cikereteg 01';
    $npsn = $profile?->npsn ?? '20200845';
    $accreditation = $profile?->accreditation ?? 'A';
    $subDistrict = $profile?->sub_district ?? 'Kec. Caringin';
    $district = $profile?->district ?? 'Kab. Bogor';
@endphp

<div class="sdn-login-root">
    <style>
        /* Background & Container Layout Override for Login Page */
        .fi-simple-layout {
            background:
                radial-gradient(circle at 12% 18%, rgba(254, 166, 25, 0.14), transparent 36%),
                radial-gradient(circle at 88% 82%, rgba(30, 58, 138, 0.22), transparent 42%),
                linear-gradient(135deg, #eef2ff 0%, #f8fafc 50%, #e0e7ff 100%) !important;
            min-height: 100dvh;
            justify-content: center;
            padding: 1.25rem;
        }

        html.dark .fi-simple-layout {
            background:
                radial-gradient(circle at 15% 20%, rgba(254, 166, 25, 0.10), transparent 35%),
                radial-gradient(circle at 85% 80%, rgba(59, 130, 246, 0.15), transparent 40%),
                linear-gradient(135deg, #090d16 0%, #0f172a 55%, #111827 100%) !important;
        }

        .fi-simple-main-ctn {
            width: 100%;
            max-width: 68rem;
            margin: 0 auto;
        }

        .fi-simple-main {
            margin: 1rem auto !important;
            padding: 0 !important;
            max-width: 68rem !important;
            width: 100% !important;
            border-radius: 1.75rem !important;
            overflow: hidden;
            box-shadow:
                0 25px 50px -12px rgba(0, 35, 111, 0.16),
                0 0 0 1px rgba(15, 23, 42, 0.06) !important;
            background: #ffffff !important;
        }

        html.dark .fi-simple-main {
            background: #0f172a !important;
            box-shadow:
                0 25px 50px -12px rgba(0, 0, 0, 0.65),
                0 0 0 1px rgba(255, 255, 255, 0.08) !important;
        }

        /* Split Grid Layout */
        .sdn-login-grid {
            display: grid;
            grid-template-columns: 1fr;
            min-height: 620px;
        }

        @media (min-width: 1024px) {
            .sdn-login-grid {
                grid-template-columns: 46% 54%;
            }
        }

        /* Left Branding Showcase Panel */
        .sdn-login-aside {
            position: relative;
            background: linear-gradient(155deg, #00236f 0%, #1e3a8a 52%, #0f172a 100%);
            color: #ffffff;
            padding: 2.25rem;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            overflow: hidden;
        }

        @media (min-width: 640px) {
            .sdn-login-aside {
                padding: 2.75rem;
            }
        }

        .sdn-login-aside::before {
            content: '';
            position: absolute;
            top: -110px;
            right: -110px;
            width: 320px;
            height: 320px;
            border-radius: 9999px;
            background: radial-gradient(circle, rgba(254, 166, 25, 0.28) 0%, rgba(254, 166, 25, 0) 70%);
            pointer-events: none;
        }

        .sdn-login-aside::after {
            content: '';
            position: absolute;
            bottom: -120px;
            left: -90px;
            width: 300px;
            height: 300px;
            border-radius: 9999px;
            background: radial-gradient(circle, rgba(96, 165, 250, 0.24) 0%, rgba(96, 165, 250, 0) 70%);
            pointer-events: none;
        }

        .sdn-aside-content {
            position: relative;
            z-index: 2;
        }

        .sdn-badge-row {
            display: flex;
            flex-wrap: wrap;
            align-items: center;
            gap: 0.5rem;
            margin-bottom: 1.5rem;
        }

        .sdn-pill-gold {
            display: inline-flex;
            align-items: center;
            gap: 0.375rem;
            padding: 0.35rem 0.75rem;
            border-radius: 9999px;
            background: rgba(254, 166, 25, 0.18);
            border: 1px solid rgba(254, 166, 25, 0.45);
            color: #ffddb8;
            font-size: 0.7rem;
            font-weight: 700;
            letter-spacing: 0.05em;
            text-transform: uppercase;
        }

        .sdn-pill-glass {
            display: inline-flex;
            align-items: center;
            gap: 0.35rem;
            padding: 0.35rem 0.75rem;
            border-radius: 9999px;
            background: rgba(255, 255, 255, 0.1);
            border: 1px solid rgba(255, 255, 255, 0.16);
            color: #e2e8f0;
            font-size: 0.7rem;
            font-weight: 600;
        }

        .sdn-brand-box {
            display: flex;
            align-items: center;
            gap: 0.9rem;
            margin-bottom: 1.5rem;
        }

        .sdn-brand-logo {
            width: 3.25rem;
            height: 3.25rem;
            border-radius: 1rem;
            background: linear-gradient(135deg, #fea619 0%, #f59e0b 100%);
            color: #00164e;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 10px 20px -5px rgba(254, 166, 25, 0.4);
            flex-shrink: 0;
        }

        .sdn-brand-title {
            font-size: 1.25rem;
            font-weight: 800;
            letter-spacing: -0.02em;
            line-height: 1.2;
            color: #ffffff;
        }

        .sdn-brand-subtitle {
            font-size: 0.75rem;
            color: #cbd5e1;
            font-weight: 500;
            margin-top: 0.15rem;
        }

        .sdn-hero-heading {
            font-size: 1.5rem;
            font-weight: 800;
            line-height: 1.3;
            color: #ffffff;
            margin-bottom: 0.75rem;
            letter-spacing: -0.02em;
        }

        .sdn-hero-desc {
            font-size: 0.85rem;
            line-height: 1.65;
            color: rgba(226, 232, 240, 0.9);
            margin-bottom: 1.75rem;
        }

        /* Role Feature Cards on Left Panel */
        .sdn-role-features {
            display: grid;
            grid-template-columns: 1fr;
            gap: 0.65rem;
            margin-bottom: 1.75rem;
        }

        .sdn-role-feature-item {
            display: flex;
            align-items: flex-start;
            gap: 0.75rem;
            padding: 0.75rem 0.9rem;
            border-radius: 0.9rem;
            background: rgba(255, 255, 255, 0.07);
            border: 1px solid rgba(255, 255, 255, 0.11);
            backdrop-filter: blur(8px);
            transition: transform 0.2s ease, background 0.2s ease;
        }

        .sdn-role-feature-item:hover {
            background: rgba(255, 255, 255, 0.12);
            transform: translateX(3px);
        }

        .sdn-role-icon {
            width: 2rem;
            height: 2rem;
            border-radius: 0.6rem;
            background: rgba(254, 166, 25, 0.2);
            color: #ffddb8;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
            margin-top: 0.1rem;
        }

        .sdn-role-item-title {
            font-size: 0.8rem;
            font-weight: 700;
            color: #ffffff;
            line-height: 1.25;
        }

        .sdn-role-item-desc {
            font-size: 0.72rem;
            color: #cbd5e1;
            margin-top: 0.15rem;
            line-height: 1.4;
        }

        .sdn-aside-footer {
            position: relative;
            z-index: 2;
            padding-top: 1.25rem;
            border-top: 1px solid rgba(255, 255, 255, 0.12);
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 0.75rem;
            flex-wrap: wrap;
        }

        .sdn-back-link {
            display: inline-flex;
            align-items: center;
            gap: 0.45rem;
            font-size: 0.78rem;
            font-weight: 700;
            color: #ffddb8;
            text-decoration: none;
            padding: 0.45rem 0.85rem;
            border-radius: 0.65rem;
            background: rgba(255, 255, 255, 0.08);
            border: 1px solid rgba(255, 255, 255, 0.15);
            transition: all 0.2s ease;
        }

        .sdn-back-link:hover {
            background: rgba(254, 166, 25, 0.22);
            border-color: rgba(254, 166, 25, 0.5);
            color: #ffffff;
        }

        /* Right Form Section */
        .sdn-login-form-panel {
            padding: 2.25rem 1.75rem;
            display: flex;
            flex-direction: column;
            justify-content: center;
            background: #ffffff;
        }

        @media (min-width: 640px) {
            .sdn-login-form-panel {
                padding: 2.75rem 3rem;
            }
        }

        html.dark .sdn-login-form-panel {
            background: #0f172a;
        }

        .sdn-form-header {
            margin-bottom: 1.75rem;
        }

        .sdn-form-kicker {
            display: inline-flex;
            align-items: center;
            gap: 0.4rem;
            padding: 0.3rem 0.75rem;
            border-radius: 9999px;
            background: #eef2ff;
            color: #1e3a8a;
            font-size: 0.7rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            margin-bottom: 0.85rem;
        }

        html.dark .sdn-form-kicker {
            background: rgba(59, 130, 246, 0.15);
            color: #93c5fd;
        }

        .sdn-form-title {
            font-size: 1.65rem;
            font-weight: 800;
            color: #0f172a;
            letter-spacing: -0.025em;
            line-height: 1.25;
        }

        html.dark .sdn-form-title {
            color: #f8fafc;
        }

        .sdn-form-subtitle {
            font-size: 0.875rem;
            color: #64748b;
            margin-top: 0.4rem;
            line-height: 1.5;
        }

        html.dark .sdn-form-subtitle {
            color: #94a3b8;
        }

        /* Filament Form Button & Input Enhancements */
        .sdn-login-form-panel .fi-btn-color-primary,
        .sdn-login-form-panel button[type="submit"] {
            background: linear-gradient(135deg, #00236f 0%, #1e3a8a 100%) !important;
            border-radius: 0.85rem !important;
            padding-top: 0.75rem !important;
            padding-bottom: 0.75rem !important;
            font-weight: 700 !important;
            font-size: 0.925rem !important;
            box-shadow: 0 10px 20px -6px rgba(0, 35, 111, 0.35) !important;
            transition: transform 0.15s ease, box-shadow 0.15s ease !important;
        }

        .sdn-login-form-panel .fi-btn-color-primary:hover,
        .sdn-login-form-panel button[type="submit"]:hover {
            transform: translateY(-1px);
            box-shadow: 0 14px 24px -6px rgba(0, 35, 111, 0.45) !important;
        }

        .sdn-login-form-panel .fi-input-wrp {
            border-radius: 0.85rem !important;
            transition: box-shadow 0.2s ease, border-color 0.2s ease;
        }

        /* Quick Role Selector Box */
        .sdn-quick-roles {
            margin-top: 1.75rem;
            padding-top: 1.25rem;
            border-top: 1px dashed #e2e8f0;
        }

        html.dark .sdn-quick-roles {
            border-top-color: #1e293b;
        }

        .sdn-quick-roles-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 0.65rem;
        }

        .sdn-quick-roles-label {
            font-size: 0.72rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            color: #64748b;
        }

        html.dark .sdn-quick-roles-label {
            color: #94a3b8;
        }

        .sdn-quick-roles-hint {
            font-size: 0.7rem;
            color: #94a3b8;
        }

        .sdn-quick-roles-grid {
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 0.5rem;
        }

        @media (min-width: 480px) {
            .sdn-quick-roles-grid {
                grid-template-columns: repeat(4, minmax(0, 1fr));
            }
        }

        .sdn-role-chip {
            display: flex;
            flex-direction: column;
            align-items: flex-start;
            padding: 0.55rem 0.65rem;
            border-radius: 0.75rem;
            background: #f8fafc;
            border: 1px solid #e2e8f0;
            cursor: pointer;
            text-align: left;
            transition: all 0.15s ease;
        }

        .sdn-role-chip:hover {
            background: #eef2ff;
            border-color: #6366f1;
            transform: translateY(-1px);
        }

        html.dark .sdn-role-chip {
            background: #1e293b;
            border-color: #334155;
        }

        html.dark .sdn-role-chip:hover {
            background: rgba(79, 70, 229, 0.2);
            border-color: #818cf8;
        }

        .sdn-role-chip-name {
            font-size: 0.73rem;
            font-weight: 700;
            color: #1e293b;
            line-height: 1.2;
        }

        html.dark .sdn-role-chip-name {
            color: #f1f5f9;
        }

        .sdn-role-chip-user {
            font-size: 0.65rem;
            color: #6366f1;
            font-family: ui-monospace, SFMono-Regular, Menlo, Monaco, Consolas, monospace;
            margin-top: 0.15rem;
        }

        html.dark .sdn-role-chip-user {
            color: #a5b4fc;
        }

        .sdn-form-footer-note {
            margin-top: 1.5rem;
            display: flex;
            align-items: center;
            justify-content: space-between;
            flex-wrap: wrap;
            gap: 0.5rem;
            font-size: 0.72rem;
            color: #94a3b8;
        }
    </style>

    {{ FilamentView::renderHook(PanelsRenderHook::SIMPLE_PAGE_START, scopes: $this->getRenderHookScopes()) }}

    <div class="sdn-login-grid">
        {{-- KOLOM KIRI: BRANDING & IDENTITAS SEKOLAH --}}
        <aside class="sdn-login-aside">
            <div class="sdn-aside-content">
                <div class="sdn-badge-row">
                    <span class="sdn-pill-gold">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" style="width: 13px; height: 13px;">
                            <path fill-rule="evenodd" d="M16.403 12.652a3 3 0 0 0 0-5.304 3 3 0 0 0-3.75-3.751 3 3 0 0 0-5.305 0 3 3 0 0 0-3.751 3.75 3 3 0 0 0 0 5.305 3 3 0 0 0 3.75 3.751 3 3 0 0 0 5.305 0 3 3 0 0 0 3.751-3.75Zm-2.546-4.46a.75.75 0 0 0-1.214-.883l-3.483 4.79-1.88-1.88a.75.75 0 1 0-1.06 1.061l2.5 2.5a.75.75 0 0 0 1.137-.089l4-5.5Z" clip-rule="evenodd" />
                        </svg>
                        <span>Akreditasi {{ $accreditation }} BAN-S/M</span>
                    </span>
                    <span class="sdn-pill-glass">NPSN: {{ $npsn }}</span>
                </div>

                <div class="sdn-brand-box">
                    <div class="sdn-brand-logo">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" style="width: 28px; height: 28px;">
                            <path d="M11.7 2.805a.75.75 0 0 1 .6 0A60.65 60.65 0 0 1 22.83 8.72a.75.75 0 0 1-.231 1.337 49.948 49.948 0 0 0-9.902 3.912l-.003.002c-.114.06-.227.119-.34.18a.75.75 0 0 1-.707 0A50.88 50.88 0 0 0 7.5 12.173v-.224c0-.131.067-.248.172-.311a54.615 54.615 0 0 1 4.653-2.52.75.75 0 0 0-.65-1.352 56.123 56.123 0 0 0-4.78 2.589 1.858 1.858 0 0 0-.859 1.228 49.803 49.803 0 0 0-4.634-1.527.75.75 0 0 1-.231-1.337A60.653 60.653 0 0 1 11.7 2.805Z" />
                            <path d="M13.06 15.473a48.45 48.45 0 0 1 7.666-3.282c.134 1.414.22 2.843.255 4.284a.75.75 0 0 1-.46.711 47.87 47.87 0 0 0-8.105 4.342.75.75 0 0 1-.832 0 47.87 47.87 0 0 0-8.104-4.342.75.75 0 0 1-.461-.71c.035-1.442.121-2.87.255-4.286.921.304 1.83.634 2.726.99v1.27a1.5 1.5 0 0 0-.14 2.508c-.09.38-.222.753-.397 1.11.452.213.901.434 1.346.66a6.727 6.727 0 0 0 .551-1.607 1.5 1.5 0 0 0 .14-2.67v-.645a48.549 48.549 0 0 1 3.44 1.667 2.25 2.25 0 0 0 2.12 0Z" />
                        </svg>
                    </div>
                    <div>
                        <div class="sdn-brand-title">{{ strtoupper($schoolName) }}</div>
                        <div class="sdn-brand-subtitle">{{ $subDistrict }}, {{ $district }} • Jawa Barat</div>
                    </div>
                </div>

                <h1 class="sdn-hero-heading">
                    Portal Manajemen &amp; CMS Terpadu Sekolah Dasar
                </h1>
                <p class="sdn-hero-desc">
                    Ruang kendali digital untuk mengelola tampilan landing page, publikasi berita kegiatan, galeri dokumentasi, data akademik, hingga verifikasi PPDB secara aman dan terukur.
                </p>

                <div class="sdn-role-features">
                    <div class="sdn-role-feature-item">
                        <div class="sdn-role-icon">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" style="width: 16px; height: 16px;">
                                <path fill-rule="evenodd" d="M9.661 2.237a.531.531 0 0 1 .678 0 11.947 11.947 0 0 0 7.078 2.749.5.5 0 0 1 .479.425c.069.52.104 1.05.104 1.59 0 5.162-3.26 9.563-7.834 11.256a.48.48 0 0 1-.332 0C5.26 16.564 2 12.163 2 7c0-.538.035-1.069.104-1.589a.5.5 0 0 1 .48-.425 11.947 11.947 0 0 0 7.077-2.75Z" clip-rule="evenodd" />
                            </svg>
                        </div>
                        <div>
                            <div class="sdn-role-item-title">Kepala Sekolah &amp; Superadmin</div>
                            <div class="sdn-role-item-desc">Otoritas penuh profil sekolah, sambutan, konfigurasi CMS, &amp; dasbor eksekutif.</div>
                        </div>
                    </div>

                    <div class="sdn-role-feature-item">
                        <div class="sdn-role-icon">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" style="width: 16px; height: 16px;">
                                <path d="M10 9a3 3 0 1 0 0-6 3 3 0 0 0 0 6ZM6 8a2 2 0 1 1-4 0 2 2 0 0 1 4 0ZM1.49 15.326a.78.78 0 0 1-.358-.442 3 3 0 0 1 4.308-3.516 6.484 6.484 0 0 0-1.905 3.959c-.023.222-.014.442.025.654a4.97 4.97 0 0 1-2.07-.655ZM16.44 15.98a4.97 4.97 0 0 0 2.07-.654.78.78 0 0 0 .357-.442 3 3 0 0 0-4.308-3.517 6.484 6.484 0 0 1 1.907 3.96 2.32 2.32 0 0 1-.026.654ZM18 8a2 2 0 1 1-4 0 2 2 0 0 1 4 0ZM5.304 16.19a.844.844 0 0 1-.277-.71 5 5 0 0 1 9.947 0 .843.843 0 0 1-.277.71A6.975 6.975 0 0 1 10 18a6.974 6.974 0 0 1-4.696-1.81Z" />
                            </svg>
                        </div>
                        <div>
                            <div class="sdn-role-item-title">Tata Usaha (Admin TU) &amp; Guru Humas</div>
                            <div class="sdn-role-item-desc">Pengelolaan direktori guru, rombel, sarpras, warta berita, prestasi, &amp; galeri.</div>
                        </div>
                    </div>

                    <div class="sdn-role-feature-item">
                        <div class="sdn-role-icon">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" style="width: 16px; height: 16px;">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 1 0 0-16 8 8 0 0 0 0 16Zm3.857-9.809a.75.75 0 0 0-1.214-.882l-3.483 4.79-1.88-1.88a.75.75 0 1 0-1.06 1.061l2.5 2.5a.75.75 0 0 0 1.137-.089l4-5.5Z" clip-rule="evenodd" />
                            </svg>
                        </div>
                        <div>
                            <div class="sdn-role-item-title">Panitia Seleksi PPDB SD</div>
                            <div class="sdn-role-item-desc">Verifikasi berkas pendaftar jalur Zonasi, Afirmasi, &amp; pengumuman kelulusan.</div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="sdn-aside-footer">
                <a href="{{ route('home') }}" class="sdn-back-link">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" style="width: 15px; height: 15px;">
                        <path fill-rule="evenodd" d="M17 10a.75.75 0 0 1-.75.75H5.612l4.158 3.96a.75.75 0 1 1-1.04 1.08l-5.5-5.25a.75.75 0 0 1 0-1.08l5.5-5.25a.75.75 0 1 1 1.04 1.08L5.612 9.25H16.25A.75.75 0 0 1 17 10Z" clip-rule="evenodd" />
                    </svg>
                    <span>Lihat Website Publik</span>
                </a>
                <span style="font-size: 0.72rem; color: rgba(203, 213, 225, 0.75);">
                    Kurikulum Merdeka • Budaya 5S
                </span>
            </div>
        </aside>

        {{-- KOLOM KANAN: FORMULIR LOGIN FILAMENT --}}
        <section class="sdn-login-form-panel">
            <div class="sdn-form-header">
                <div class="sdn-form-kicker">
                    <span style="width: 7px; height: 7px; border-radius: 9999px; background: #10b981; display: inline-block;"></span>
                    <span>Otentikasi Petugas Resmi</span>
                </div>
                <h2 class="sdn-form-title">{{ $this->getHeading() }}</h2>
                <p class="sdn-form-subtitle">{{ $this->getSubheading() }}</p>
            </div>

            {{-- Form Bawaan Filament (Input Login, Password, Remember, Tombol Submit) --}}
            {{ $this->content }}

            {{-- Panel Bantu: Isi Cepat Akun Peran (1-Klik) --}}
            <div class="sdn-quick-roles">
                <div class="sdn-quick-roles-header">
                    <span class="sdn-quick-roles-label">Akses Cepat Peran (Klik untuk Isi)</span>
                    <span class="sdn-quick-roles-hint">Sandi: <code>password123</code></span>
                </div>
                <div class="sdn-quick-roles-grid">
                    <button type="button" wire:click="fillRoleAccount('superadmin')" class="sdn-role-chip" title="Isi akun Kepala Sekolah / Superadmin">
                        <span class="sdn-role-chip-name">Kepala Sekolah</span>
                        <span class="sdn-role-chip-user">superadmin</span>
                    </button>
                    <button type="button" wire:click="fillRoleAccount('admin_tu')" class="sdn-role-chip" title="Isi akun Staf Tata Usaha">
                        <span class="sdn-role-chip-name">Tata Usaha</span>
                        <span class="sdn-role-chip-user">admin_tu</span>
                    </button>
                    <button type="button" wire:click="fillRoleAccount('guru_humas')" class="sdn-role-chip" title="Isi akun Tim Humas & Publikasi">
                        <span class="sdn-role-chip-name">Guru Humas</span>
                        <span class="sdn-role-chip-user">guru_humas</span>
                    </button>
                    <button type="button" wire:click="fillRoleAccount('panitia_ppdb')" class="sdn-role-chip" title="Isi akun Panitia PPDB">
                        <span class="sdn-role-chip-name">Panitia PPDB</span>
                        <span class="sdn-role-chip-user">panitia_ppdb</span>
                    </button>
                </div>
            </div>

            <div class="sdn-form-footer-note">
                <span>&copy; {{ date('Y') }} {{ $schoolName }}</span>
                <span>Dinas Pendidikan {{ $district }}</span>
            </div>
        </section>
    </div>

    <x-filament-actions::modals />

    {{ FilamentView::renderHook(PanelsRenderHook::SIMPLE_PAGE_END, scopes: $this->getRenderHookScopes()) }}
</div>


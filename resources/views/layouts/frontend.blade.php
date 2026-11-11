<!DOCTYPE html>
<html lang="id" class="scroll-smooth">

<head>
  <meta charset="utf-8" />
  <meta content="width=device-width, initial-scale=1.0" name="viewport" />
  <meta name="csrf-token" content="{{ csrf_token() }}">

  @php
    $schoolName = $seoProfile?->school_name ?? 'SDN Cikereteg 01';
    $defaultTitle = $seoProfile?->meta_title ?: ($schoolName . ' - Cerdas, Berakhlak Mulia & Berkarakter | Kurikulum Merdeka SD');
    $defaultDescription = $seoProfile?->meta_description ?: ('Website resmi ' . $schoolName . ', ' . ($seoProfile?->sub_district ?? 'Kec. Caringin') . ', ' . ($seoProfile?->district ?? 'Kab. Bogor') . '. Sekolah Dasar Negeri ramah anak dengan Kurikulum Merdeka, pembiasaan karakter luhur 5S, dan lingkungan belajar asri.');
    $defaultKeywords = $seoProfile?->meta_keywords ?: 'SDN Cikereteg 01, SD Negeri Caringin Bogor, Sekolah Dasar Terbaik Bogor, Kurikulum Merdeka SD, PPDB SD Online Bogor';
    $defaultOgImage = $seoProfile?->ogImage?->url ?? $seoProfile?->logo?->url ?? asset('frontend/images/logo-sdn-cikereteg-01.png');

    $pageTitle = trim($__env->yieldContent('title')) ?: $defaultTitle;
    $pageDescription = trim($__env->yieldContent('meta_description')) ?: $defaultDescription;
    $pageKeywords = trim($__env->yieldContent('meta_keywords')) ?: $defaultKeywords;
    $pageCanonical = trim($__env->yieldContent('canonical_url')) ?: url()->current();
    $pageRobots = trim($__env->yieldContent('meta_robots')) ?: 'index, follow, max-image-preview:large, max-snippet:-1, max-video-preview:-1';
    $ogType = trim($__env->yieldContent('og_type')) ?: 'website';
    $ogImage = trim($__env->yieldContent('og_image')) ?: $defaultOgImage;

    $sameAsLinks = array_values(array_filter([
        $seoProfile?->social_facebook,
        $seoProfile?->social_instagram,
        $seoProfile?->social_youtube,
    ]));

    $schoolSchema = [
        '@context' => 'https://schema.org',
        '@type' => 'ElementarySchool',
        'name' => $schoolName,
        'alternateName' => 'SD Negeri Cikereteg 01',
        'identifier' => $seoProfile?->npsn ?? '20200601',
        'url' => route('home'),
        'logo' => $defaultOgImage,
        'image' => $ogImage,
        'description' => $defaultDescription,
        'telephone' => $seoProfile?->phone ?? '(0251) 8241234',
        'email' => $seoProfile?->email ?? 'info@sdncikereteg01.sch.id',
        'address' => [
            '@type' => 'PostalAddress',
            'streetAddress' => $seoProfile?->address ?? 'Jl. Raya Sukabumi KM 15, Cikereteg',
            'addressLocality' => $seoProfile?->sub_district ?? 'Kec. Caringin',
            'addressRegion' => $seoProfile?->district ?? 'Kab. Bogor, Jawa Barat',
            'postalCode' => $seoProfile?->postal_code ?? '16730',
            'addressCountry' => 'ID',
        ],
    ];

    if ($sameAsLinks !== []) {
        $schoolSchema['sameAs'] = $sameAsLinks;
    }
  @endphp

  <!-- Primary Meta Tags -->
  <title>{{ $pageTitle }}</title>
  <meta name="description" content="{{ $pageDescription }}" />
  <meta name="keywords" content="{{ $pageKeywords }}" />
  <meta name="author" content="{{ $schoolName }}" />
  <meta name="robots" content="{{ $pageRobots }}" />
  <link rel="canonical" href="{{ $pageCanonical }}" />
  <link rel="sitemap" type="application/xml" title="Sitemap" href="{{ route('seo.sitemap') }}" />

  <!-- Open Graph / WhatsApp / Facebook Meta Tags -->
  <meta property="og:locale" content="id_ID" />
  <meta property="og:type" content="{{ $ogType }}" />
  <meta property="og:site_name" content="{{ $schoolName }}" />
  <meta property="og:title" content="{{ $pageTitle }}" />
  <meta property="og:description" content="{{ $pageDescription }}" />
  <meta property="og:url" content="{{ $pageCanonical }}" />
  <meta property="og:image" content="{{ $ogImage }}" />
  <meta property="og:image:alt" content="{{ $pageTitle }}" />
  @stack('seo_meta')

  <!-- Twitter Card Meta Tags -->
  <meta name="twitter:card" content="summary_large_image" />
  <meta name="twitter:title" content="{{ $pageTitle }}" />
  <meta name="twitter:description" content="{{ $pageDescription }}" />
  <meta name="twitter:image" content="{{ $ogImage }}" />

  <!-- Schema.org JSON-LD Structured Data -->
  <script type="application/ld+json">{!! json_encode($schoolSchema, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) !!}</script>
  @stack('json_ld')

  <!-- Google Fonts & Material Symbols -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" rel="stylesheet" />

  <!-- Custom CSS -->
  <link href="{{ asset('frontend/css/styles.css') }}" rel="stylesheet" />

  <!-- Tailwind CSS CDN & External Config -->
  <script src="https://cdn.tailwindcss.com"></script>
  <script src="{{ asset('frontend/js/tailwind-config.js') }}"></script>

  <style>
    .card-hover {
      transition: transform 0.25s cubic-bezier(0.4, 0, 0.2, 1), box-shadow 0.25s ease;
    }
    .card-hover:hover {
      transform: translateY(-4px);
      box-shadow: 0 12px 24px -6px rgba(0, 35, 111, 0.12);
    }
  </style>

  @stack('styles')
</head>

<body class="bg-surface font-body-md text-body-md text-on-surface antialiased flex flex-col min-h-screen">

  <!-- HEADER -->
  @include('partials.frontend-header')

  <!-- MAIN CONTENT -->
  <main class="w-full pt-[120px] bg-surface flex-grow">
    @yield('content')
  </main>

  <!-- FOOTER -->
  @include('partials.frontend-footer')

  <!-- Core JavaScript -->
  <script src="{{ asset('frontend/js/main.js') }}"></script>

  @stack('scripts')
</body>

</html>

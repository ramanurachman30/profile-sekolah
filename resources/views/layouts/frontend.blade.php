<!DOCTYPE html>
<html lang="id" class="scroll-smooth">

<head>
  <meta charset="utf-8" />
  <meta content="width=device-width, initial-scale=1.0" name="viewport" />
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>@yield('title', 'SDN Cikereteg 01 - Cerdas, Berakhlak Mulia & Berkarakter | Kurikulum Merdeka SD')</title>
  <meta name="description" content="@yield('meta_description', 'Website resmi SDN Cikereteg 01, Kec. Caringin, Kab. Bogor. Sekolah Dasar Negeri ramah anak dengan Kurikulum Merdeka, pembiasaan karakter luhur 5S, dan lingkungan belajar asri.')" />

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

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="csrf-token" content="{{ csrf_token() }}">

  <title>Leadr - Platform Manajemen Pelatihan Peserta</title>
  <link rel="icon" href="{{ asset('assets/img/profpic.svg') }}">

  <meta name="description" content="@yield('meta_description', 'Leadr adalah platform manajemen pelatihan peserta dengan sistem tugas, penilaian, dan leaderboard.')">
  <meta name="keywords" content="@yield('meta_keywords', 'Leadr, Manajemen Pelatihan, Tugas, Leaderboard, Pengembangan Peserta')">
  <meta property="og:image" content="@yield('meta_image', asset('assets/img/landing/default-og.jpg'))">

  <!-- Fonts -->
  <link rel="preconnect" href="https://fonts.bunny.net">
  <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

  <!-- Tailwind / Vite Assets -->
  @vite(['resources/css/app.css', 'resources/js/app.js'])

  {{-- CDN CSS --}}
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/themes/airbnb.css">

  {{-- Additional Styles --}}
  @stack('styles')
</head>

<body class="font-sans antialiased bg-gray-50">

  <!-- Navbar -->
  <nav class="bg-blue-600 fixed w-full z-50 top-0 py-4">
    <div class="container mx-auto flex justify-between items-center px-4">
      <!-- Logo -->
      <a href="{{ url('/') }}" class="text-2xl font-bold text-white">Leadr</a>

      <div class="md:flex flex-col md:flex-row md:items-center space-y-4 md:space-y-0 md:space-x-4">
        <a href="#fitur" class="hidden sm:inline text-white hover:underline">Fitur</a>
        <a href="#cara-kerja" class="hidden sm:inline text-white hover:underline">Cara Kerja</a>
        <a href="{{ route('login') }}"
          class="px-4 py-2 bg-white text-blue-600 font-semibold rounded-lg hover:bg-gray-100 text-center">
          Login
        </a>
      </div>

    </div>
  </nav>


  <!-- Page Content -->
  <main>
    @yield('content')
    <div class="container mx-auto text-center my-4">
      <script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js?client=ca-pub-2050040983829954"
        crossorigin="anonymous"></script>
      <!-- responsive -->
      <ins class="adsbygoogle" style="display:block" data-ad-client="ca-pub-2050040983829954" data-ad-slot="3786022839"
        data-ad-format="auto" data-full-width-responsive="true"></ins>
      <script>
        (adsbygoogle = window.adsbygoogle || []).push({});
      </script>
    </div>
  </main>

  {{-- Additional Scripts --}}
  @stack('scripts')

</body>

</html>

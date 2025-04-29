@extends('layouts.page')

@section('title', 'Leadr by Inisiator')
@section('meta_description',
  'Leadr adalah platform untuk mengelola pelatihan peserta dengan sistem tugas, penilaian,
  dan leaderboard yang mendorong kompetisi sehat.')
@section('meta_keywords', 'Leadr, Manajemen Pelatihan, Tugas, Leaderboard, Pengembangan Peserta, Skoring')
@section('meta_image', asset('assets/img/landing/hero-start.jpg'))

@section('content')
  <!-- Hero Section -->
  <section
    class="min-h-screen flex flex-col items-center justify-center text-center bg-gradient-to-br from-blue-600 to-indigo-500 text-white">
    <div class="container">
      <h1 class="text-4xl md:text-6xl font-bold mb-6 animate-fade-up">Kelola Pelatihan dengan Mudah di Leadr</h1>
      <p class="text-lg md:text-xl mb-8 animate-fade-up delay-1">Beri tugas, nilai performa, dan bangun semangat
        kompetisi sehat melalui sistem leaderboard otomatis.</p>
      <a href="#fitur"
        class="px-6 py-3 bg-white text-blue-700 font-semibold rounded-lg animate-fade-up delay-2 hover:bg-gray-100 smooth-scroll">
        Mulai Sekarang
      </a>

      <!-- Animated Counters -->
      <div class="flex flex-wrap justify-center gap-8 mt-10">
        <div class="text-center animate-fade-up delay-2">
          <h2 class="text-3xl font-bold"><span class="counter" data-target="{{ $taskCount }}">0</span>+</h2>
          <p>Tugas Diberikan</p>
        </div>
        <div class="text-center animate-fade-up delay-3">
          <h2 class="text-3xl font-bold"><span class="counter" data-target="{{ $participantCount }}">0</span>+</h2>
          <p>Peserta Terdaftar</p>
        </div>
        <div class="text-center animate-fade-up delay-4">
          <h2 class="text-3xl font-bold"><span class="counter" data-target="{{ $organizationCount }}">0</span>+</h2>
          <p>Organisasi Menggunakan</p>
        </div>
      </div>
    </div>
  </section>

  <!-- Fitur -->
  <section id="fitur" class="p-16 bg-white">
    <div class="container mx-auto text-center">
      <h2 class="text-3xl font-bold mb-6 animate-fade-up">Mengapa Menggunakan Leadr?</h2>
      <p class="text-gray-600 max-w-2xl mx-auto animate-fade-up delay-1">
        Leadr membantu Anda mengelola seluruh proses pelatihan: mulai dari memberikan tugas, menilai kinerja peserta,
        hingga membangun kompetisi positif dengan sistem leaderboard.
      </p>

      <!-- Features -->
      <div class="grid grid-cols-1 md:grid-cols-3 gap-8 mt-10">
        <div class="animate-fade-up">
          <img src="{{ asset('assets/img/icons/tasks.svg') }}" alt="Tugas" class="mx-auto w-16 mb-4">
          <h5 class="font-bold mb-2">Pemberian Tugas Mudah</h5>
          <p class="text-gray-600">Buat tugas pelatihan hanya dalam beberapa klik untuk seluruh peserta.</p>
        </div>
        <div class="animate-fade-up delay-1">
          <img src="{{ asset('assets/img/icons/realtime.svg') }}" alt="Penilaian" class="mx-auto w-16 mb-4">
          <h5 class="font-bold mb-2">Sistem Penilaian Real-Time</h5>
          <p class="text-gray-600">Nilai peserta secara otomatis dan pantau perkembangan mereka setiap saat.</p>
        </div>
        <div class="animate-fade-up delay-2">
          <img src="{{ asset('assets/img/icons/award.svg') }}" alt="Leaderboard" class="mx-auto w-16 mb-4">
          <h5 class="font-bold mb-2">Leaderboard Kompetitif</h5>
          <p class="text-gray-600">Motivasi peserta dengan sistem peringkat berbasis pencapaian tugas.</p>
        </div>
      </div>
    </div>
  </section>

  <div class="container mx-auto text-center my-2">
    <script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js?client=ca-pub-2050040983829954"
      crossorigin="anonymous"></script>
    <!-- responsive -->
    <ins class="adsbygoogle" style="display:block" data-ad-client="ca-pub-2050040983829954" data-ad-slot="3786022839"
      data-ad-format="auto" data-full-width-responsive="true"></ins>
    <script>
      (adsbygoogle = window.adsbygoogle || []).push({});
    </script>
  </div>

  <!-- Cara Kerja -->
  <section class="p-16 bg-gray-100">
    <div class="container mx-auto text-center">
      <h2 class="text-3xl font-bold mb-10 animate-fade-up">Bagaimana Leadr Bekerja</h2>
      <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
        <div class="animate-fade-up">
          <div class="text-4xl font-bold text-blue-600 mb-2">1</div>
          <h5 class="font-bold mb-2">Buat Pelatihan & Tugas</h5>
          <p class="text-gray-600">Admin membuat pelatihan dan tugas untuk peserta dengan mudah.</p>
        </div>
        <div class="animate-fade-up delay-1">
          <div class="text-4xl font-bold text-blue-600 mb-2">2</div>
          <h5 class="font-bold mb-2">Peserta Menyelesaikan Tugas</h5>
          <p class="text-gray-600">Peserta mengerjakan tugas dan mengumpulkan hasil melalui platform.</p>
        </div>
        <div class="animate-fade-up delay-2">
          <div class="text-4xl font-bold text-blue-600 mb-2">3</div>
          <h5 class="font-bold mb-2">Nilai & Naik di Leaderboard</h5>
          <p class="text-gray-600">Sistem menilai tugas dan memperbarui posisi peserta di leaderboard.</p>
        </div>
      </div>
    </div>
  </section>

  <!-- Final CTA -->
  <section class="py-16 bg-gradient-to-br from-indigo-500 to-blue-600 text-white text-center">
    <div class="container mx-auto">
      <h2 class="text-4xl font-bold mb-4 animate-fade-up">Siap Membawa Pelatihan Anda ke Level Selanjutnya?</h2>
      <p class="text-lg mb-6 animate-fade-up delay-1">Gabung sekarang dan kelola pelatihan lebih efektif dengan Leadr.
      </p>
      <a href="{{ route('register') }}"
        class="px-6 py-3 bg-white text-indigo-700 font-semibold rounded-lg animate-fade-up delay-2 hover:bg-gray-100">
        Daftar Gratis Sekarang
      </a>
    </div>
  </section>
@endsection

@push('styles')
  <link rel="stylesheet" href="{{ asset('assets/css/landing.css') }}">
@endpush

@push('scripts')
  <script>
    document.addEventListener('DOMContentLoaded', function() {
      const counters = document.querySelectorAll('.counter');
      counters.forEach(counter => {
        const target = +counter.getAttribute('data-target');
        let current = 0;
        const increment = target / 200;

        const updateCounter = () => {
          if (current < target) {
            current += increment;
            counter.innerText = Math.ceil(current);
            setTimeout(updateCounter, 10);
          } else {
            counter.innerText = target;
          }
        };
        updateCounter();
      });
    });
  </script>
@endpush

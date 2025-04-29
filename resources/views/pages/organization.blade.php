@extends('layouts.page')

@section('title', 'Bergabung dengan ' . $organization->name . ' di Leadr')
@section('meta_description',
  'Daftar sebagai peserta di organisasi ' .
  $organization->name .
  ' dan ikuti pelatihan serta
  leaderboard interaktif.')
@section('meta_keywords', 'Leadr, Organisasi, Pelatihan, Kompetisi, ' . $organization->name)
@section('meta_image', asset('assets/img/landing/hero-start.jpg'))

@section('content')
  <!-- Hero Section -->
  <section
    class="min-h-[100vh] flex items-center justify-center text-center bg-gradient-to-br from-blue-600 to-indigo-500 text-white">
    <div class="container px-4">
      <h1 class="text-3xl md:text-5xl font-bold mb-4 mt-8 animate-fade-up">{{ $organization->name }}</h1>
      <!-- Statistik Organisasi -->
      <div class="flex flex-wrap justify-center gap-6 mt-10 text-white animate-fade-up delay-1">
        <div class="text-center min-w-[100px]">
          <h2 class="text-3xl font-bold"><span class="counter" data-target="{{ $memberCount }}">0</span>+</h2>
          <p class="text-sm mt-1">Anggota Terdaftar</p>
        </div>
        <div class="text-center min-w-[100px]">
          <h2 class="text-3xl font-bold"><span class="counter" data-target="{{ $completedTasksCount }}">0</span>+</h2>
          <p class="text-sm mt-1">Tugas Dikerjakan</p>
        </div>
        <div class="text-center min-w-[100px]">
          <h2 class="text-3xl font-bold"><span class="counter" data-target="{{ $totalScore }}">0</span>+</h2>
          <p class="text-sm mt-1">Total Skor Diberikan</p>
        </div>
      </div>
      <a href="{{ route('register', ['organization_id' => $organization->id]) }}"
        class="mt-6 inline-block px-6 py-3 bg-white text-blue-700 font-semibold rounded-lg hover:bg-gray-100 transition animate-fade-up delay-2">
        Daftar Sekarang
      </a>
    </div>
  </section>

  <!-- Informasi Organisasi -->
  <section class="py-16 bg-white">
    <div class="container mx-auto max-w-3xl px-4">
      <h2 class="text-2xl font-bold mb-6 text-center">Informasi Organisasi</h2>
      <div class="grid grid-cols-1 gap-6">
        <div class="bg-gray-50 p-6 rounded-lg shadow animate-fade-up">
          <h3 class="font-semibold text-gray-700 mb-1">Nama Organisasi</h3>
          <p class="text-gray-900">{{ $organization->name }}</p>
        </div>
        <div class="bg-gray-50 p-6 rounded-lg shadow animate-fade-up delay-1">
          <h3 class="font-semibold text-gray-700 mb-1">Deskripsi</h3>
          <p class="text-gray-900">{{ $organization->description }}</p>
        </div>
        <div class="bg-gray-50 p-6 rounded-lg shadow animate-fade-up delay-2">
          <h3 class="font-semibold text-gray-700 mb-1">Email</h3>
          <p class="text-gray-900">{{ $organization->email }}</p>
        </div>
        <div class="bg-gray-50 p-6 rounded-lg shadow animate-fade-up delay-3">
          <h3 class="font-semibold text-gray-700 mb-1">Nomor HP</h3>
          <p class="text-gray-900">{{ $organization->phone }}</p>
        </div>
      </div>

      <div class="text-center mt-10 animate-fade-up delay-4">
        <a href="{{ route('register', ['organization_id' => $organization->id]) }}"
          class="px-6 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 font-semibold">
          Bergabung dengan Organisasi Ini
        </a>
      </div>
    </div>
  </section>
@endsection

@push('scripts')
  <script>
    document.addEventListener('DOMContentLoaded', function() {
      const counters = document.querySelectorAll('.counter');
      counters.forEach(counter => {
        const target = +counter.getAttribute('data-target');
        let current = 0;
        const increment = Math.ceil(target / 100);

        const updateCounter = () => {
          if (current < target) {
            current += increment;
            counter.innerText = current > target ? target : current;
            requestAnimationFrame(updateCounter);
          } else {
            counter.innerText = target;
          }
        };

        updateCounter();
      });
    });
  </script>
@endpush

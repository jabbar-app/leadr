@extends('layouts.guest')

@section('content')
  <form method="POST" action="{{ route('register') }}">
    @csrf

    <!-- Nama Organisasi -->
    <div class="mt-4">
      <x-input-label for="organization_name" :value="'Organisasi'" />
      <x-text-input id="organization_name" class="block mt-1 w-full bg-gray-100" type="text" name="organization_name"
        :value="$organization->name ?? ''" readonly />
      <x-input-error :messages="$errors->get('organization_name')" class="mt-2" />
    </div>

    <!-- Nama Lengkap -->
    <div class="mt-4">
      <x-input-label for="name" :value="'Nama Lengkap'" />
      <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required
        autofocus autocomplete="name" />
      <x-input-error :messages="$errors->get('name')" class="mt-2" />
    </div>

    <!-- Email -->
    <div class="mt-4">
      <x-input-label for="email" :value="'Email'" />
      <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required
        autocomplete="username" />
      <x-input-error :messages="$errors->get('email')" class="mt-2" />
    </div>

    <!-- Nomor HP -->
    <div class="mt-4">
      <x-input-label for="phone" :value="'Nomor HP (wajib awalan 62)'" />
      <x-text-input id="phone" class="block mt-1 w-full" type="text" name="phone" :value="old('phone')" required
        autocomplete="tel" inputmode="numeric" pattern="[0-9]*" />
      <x-input-error :messages="$errors->get('phone')" class="mt-2" />
    </div>

    <!-- Hidden Organization ID -->
    <input type="hidden" name="organization_id" value="{{ $organization->id ?? '' }}">

    <!-- Password dengan Show/Hide Text -->
    <div class="mt-4 relative">
      <x-input-label for="password" :value="'Kata Sandi'" />
      <div class="relative">
        <x-text-input id="password" class="block mt-1 w-full pr-24" type="password" name="password" required
          autocomplete="new-password" />
        <button type="button" onclick="togglePassword()"
          class="absolute inset-y-0 right-0 px-3 flex items-center text-sm font-medium text-gray-600">
          <span id="toggle-password-text">Show</span>
        </button>
      </div>
      <x-input-error :messages="$errors->get('password')" class="mt-2" />
    </div>

    <!-- Tombol -->
    <div class="flex items-center justify-end mt-6">
      <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
        href="{{ route('login') }}">
        Sudah punya akun?
      </a>

      <x-primary-button class="ml-4">
        Daftar
      </x-primary-button>
    </div>
  </form>

  <!-- Script -->
  <script>
    // Auto-replace 0 menjadi 62 saat input phone
    document.getElementById('phone').addEventListener('input', function(e) {
      if (e.target.value.startsWith('0')) {
        e.target.value = '62' + e.target.value.substring(1);
      }
    });

    // Show/Hide Password
    function togglePassword() {
      const passwordInput = document.getElementById('password');
      const toggleText = document.getElementById('toggle-password-text');
      if (passwordInput.type === 'password') {
        passwordInput.type = 'text';
        toggleText.textContent = 'Hide';
      } else {
        passwordInput.type = 'password';
        toggleText.textContent = 'Show';
      }
    }

    document.getElementById('phone').addEventListener('input', function(e) {
      let value = e.target.value.replace(/\D/g, ''); // Hapus semua karakter selain angka
      if (value.startsWith('0')) {
        value = '62' + value.substring(1);
      }
      e.target.value = value;
    });
  </script>
@endsection

@extends('layouts.app')

@section('content')
  <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
    <div class="p-6">
      <h1 class="text-2xl font-semibold mb-6">Tambah Organisasi</h1>

      <form action="{{ route('organizations.store') }}" method="POST" class="space-y-6">
        @csrf

        <div>
          <x-input-label for="name" :value="'Nama Organisasi'" />
          <x-text-input id="name" name="name" type="text" class="block mt-1 w-full" value="{{ old('name') }}"
            required autofocus />
          <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        <div>
          <x-input-label for="description" :value="'Deskripsi'" />
          <textarea id="description" name="description" class="block mt-1 w-full border-gray-300 rounded" required>{{ old('description') }}</textarea>
          <x-input-error :messages="$errors->get('description')" class="mt-2" />
        </div>

        <div>
          <x-input-label for="username" :value="'Username'" />
          <x-text-input id="username" name="username" type="text" class="block mt-1 w-full"
            value="{{ old('username') }}" required />
          <x-input-error :messages="$errors->get('username')" class="mt-2" />
        </div>

        <div>
          <x-input-label for="api_url" :value="'API URL'" />
          <x-text-input id="api_url" name="api_url" type="url" class="block mt-1 w-full"
            value="{{ old('api_url') }}" required />
          <x-input-error :messages="$errors->get('api_url')" class="mt-2" />
        </div>

        <div>
          <x-input-label for="email" :value="'Email'" />
          <x-text-input id="email" name="email" type="email" class="block mt-1 w-full" value="{{ old('email') }}"
            required />
          <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <div>
          <x-input-label for="phone" :value="'Phone'" />
          <x-text-input id="phone" name="phone" type="text" class="block mt-1 w-full" value="{{ old('phone') }}"
            required />
          <x-input-error :messages="$errors->get('phone')" class="mt-2" />
        </div>

        <div class="flex justify-end">
          <x-primary-button>Tambah Organisasi</x-primary-button>
        </div>
      </form>
    </div>
  </div>
@endsection

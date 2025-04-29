@extends('layouts.app')

@section('content')
  <div class="container mx-auto py-8">
    <h1 class="text-2xl font-bold mb-6">Edit Tugas</h1>

    <form action="{{ route('tasks.update', $task) }}" method="POST" class="space-y-6">
      @csrf
      @method('PUT')

      <div>
        <x-input-label for="organization_id" :value="'Organisasi'" />
        <select name="organization_id" id="organization_id" required class="block w-full mt-1 border-gray-300 rounded">
          @foreach ($organizations as $organization)
            <option value="{{ $organization->id }}" {{ $task->organization_id == $organization->id ? 'selected' : '' }}>
              {{ $organization->name }}
            </option>
          @endforeach
        </select>
        <x-input-error :messages="$errors->get('organization_id')" class="mt-2" />
      </div>

      <div>
        <x-input-label for="title" :value="'Judul Tugas'" />
        <x-text-input id="title" name="title" type="text" class="block w-full mt-1"
          value="{{ old('title', $task->title) }}" required />
        <x-input-error :messages="$errors->get('title')" class="mt-2" />
      </div>

      <div>
        <x-input-label for="description" :value="'Deskripsi Tugas'" />
        <textarea id="description" name="description" rows="5" class="block w-full border-gray-300 rounded">{{ old('description', $task->description) }}</textarea>
        <x-input-error :messages="$errors->get('description')" class="mt-2" />
      </div>

      <div>
        <x-input-label for="due_date" :value="'Batas Waktu'" />
        <x-text-input id="due_date" name="due_date" type="date" class="block w-full mt-1"
          value="{{ old('due_date', $task->due_date) }}" />
        <x-input-error :messages="$errors->get('due_date')" class="mt-2" />
      </div>

      <div>
        <x-input-label for="max_score" :value="'Skor Maksimal'" />
        <x-text-input id="max_score" name="max_score" type="number" min="1" class="block w-full mt-1"
          value="{{ old('max_score', $task->max_score) }}" required />
        <x-input-error :messages="$errors->get('max_score')" class="mt-2" />
      </div>

      <div class="flex justify-end">
        <x-primary-button>Update Tugas</x-primary-button>
      </div>
    </form>
  </div>
@endsection

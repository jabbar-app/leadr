@extends('layouts.app')

@section('content')
  <div class="container mx-auto py-10 px-4">
    <h1 class="text-2xl font-bold mb-6">Kirim Tugas</h1>

    <div class="bg-white p-6 rounded shadow-md">

      {{-- ALERT ERROR GLOBAL --}}
      @if ($errors->any())
        <div class="mb-6 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
          <strong class="font-bold">Oops! </strong>
          <span class="block sm:inline">Terjadi beberapa kesalahan pada input kamu:</span>
          <ul class="mt-2 list-disc list-inside text-sm">
            @foreach ($errors->all() as $error)
              <li>{{ $error }}</li>
            @endforeach
          </ul>
        </div>
      @endif

      <form action="{{ route('submissions.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <input type="hidden" name="task_id" value="{{ $task->id }}">

        <!-- Info Tugas -->
        <div class="mb-6">
          <h2 class="text-xl font-semibold text-gray-800">{{ $task->title }}</h2>
          <p class="text-sm text-gray-600 mt-1">{{ $task->description }}</p>

          @if ($task->due_date)
            <p class="text-xs text-gray-400 mt-1">
              Deadline: {{ \Carbon\Carbon::parse($task->due_date)->translatedFormat('d F Y') }}
            </p>
          @endif
        </div>

        <!-- Textarea Jawaban -->
        <div class="mb-6">
          <label for="submission_text" class="block text-sm font-medium text-gray-700 mb-1">
            Jawaban Kamu
          </label>
          <textarea id="submission_text" name="submission_text" rows="6"
            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm">{{ old('submission_text') }}</textarea>

          @error('submission_text')
            <p class="text-sm text-red-500 mt-2">{{ $message }}</p>
          @enderror
        </div>

        <!-- Upload File -->
        <div class="mb-6">
          <label for="submission_file" class="block text-sm font-medium text-gray-700 mb-1">
            Upload File (Opsional, Maks 2MB)
          </label>
          <input type="file" name="submission_file" id="submission_file" accept=".jpg,.jpeg,.png,.pdf"
            class="block w-full text-sm text-gray-700 border border-gray-300 rounded-md file:mr-4 file:py-2 file:px-4
                   file:rounded-md file:border-0 file:text-sm file:font-semibold
                   file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">

          @error('submission_file')
            <p class="text-sm text-red-500 mt-2">{{ $message }}</p>
          @enderror
        </div>

        <!-- Tombol Submit -->
        <div class="flex justify-end">
          <a href="{{ route('dashboard') }}" class="mr-4 text-gray-600 hover:text-gray-800 text-sm">
            Batal
          </a>
          <button type="submit"
            class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-white hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition">
            Kirim Tugas
          </button>
        </div>
      </form>
    </div>
  </div>
@endsection

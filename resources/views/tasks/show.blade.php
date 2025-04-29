@extends('layouts.app')

@section('content')
  <div class="container mx-auto py-8">
    <h1 class="text-2xl font-bold mb-6">{{ $task->title }}</h1>

    <div class="bg-white p-6 rounded shadow space-y-4">
      <div>
        <strong>Organisasi:</strong>
        <p>{{ $task->organization->name ?? '-' }}</p>
      </div>
      <div>
        <strong>Deskripsi:</strong>
        <p>{{ $task->description }}</p>
      </div>
      <div>
        <strong>Batas Waktu:</strong>
        <p>{{ \Carbon\Carbon::parse($task->due_date)->format('d M Y') }}</p>
      </div>
      <div>
        <strong>Skor Maksimal:</strong>
        <p>{{ $task->max_score }}</p>
      </div>

      <div class="mt-6">
        <a href="{{ route('tasks.index') }}" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
          Kembali ke Daftar Tugas
        </a>
      </div>
    </div>
  </div>
@endsection

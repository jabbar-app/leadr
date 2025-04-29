@extends('layouts.app')

@section('content')
  <div class="container mx-auto py-10 px-4">
    <h1 class="text-2xl font-bold mb-6">Dashboard Admin</h1>

    <!-- Ringkasan -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-10">
      <div class="bg-blue-100 text-blue-800 rounded-lg px-4 py-6 text-center">
        <h2 class="text-sm font-semibold">Total Pengguna</h2>
        <p class="text-3xl font-bold mt-2">{{ $totalUsers }}</p>
      </div>
      <div class="bg-indigo-100 text-indigo-800 rounded-lg px-4 py-6 text-center">
        <h2 class="text-sm font-semibold">Total Organisasi</h2>
        <p class="text-3xl font-bold mt-2">{{ $totalOrganizations }}</p>
      </div>
      <div class="bg-green-100 text-green-800 rounded-lg px-4 py-6 text-center">
        <h2 class="text-sm font-semibold">Total Tugas</h2>
        <p class="text-3xl font-bold mt-2">{{ $totalTasks }}</p>
      </div>
      <div class="bg-yellow-100 text-yellow-800 rounded-lg px-4 py-6 text-center">
        <h2 class="text-sm font-semibold">Total Submission</h2>
        <p class="text-3xl font-bold mt-2">{{ $totalSubmissions }}</p>
      </div>
    </div>

    <!-- Tugas Terbaru -->
    <div class="bg-white p-6 rounded shadow mb-10">
      <h2 class="text-xl font-bold mb-4">Tugas Terbaru</h2>
      @if ($recentTasks->isEmpty())
        <p class="text-gray-500">Belum ada tugas.</p>
      @else
        <ul class="divide-y divide-gray-200">
          @foreach ($recentTasks as $task)
            <li class="py-3">
              <div class="flex justify-between items-center">
                <div>
                  <h3 class="font-semibold text-gray-800">{{ $task->title }}</h3>
                  <p class="text-sm text-gray-500">{{ $task->organization->name }} &middot;
                    {{ $task->created_at->diffForHumans() }}</p>
                </div>
                <span class="text-sm text-gray-600">Score: {{ $task->score }}</span>
              </div>
            </li>
          @endforeach
        </ul>
      @endif
    </div>

    <!-- Submission Terbaru -->
    <div class="bg-white p-6 rounded shadow">
      <h2 class="text-xl font-bold mb-4">Submission Terbaru</h2>
      @if ($recentSubmissions->isEmpty())
        <p class="text-gray-500">Belum ada submission.</p>
      @else
        <ul class="divide-y divide-gray-200">
          @foreach ($recentSubmissions as $submission)
            <li class="py-3">
              <div class="flex justify-between items-center">
                <div>
                  <p class="font-medium text-gray-800">{{ $submission->user->name }}</p>
                  <p class="text-sm text-gray-500">{{ $submission->task->title }} &middot;
                    {{ $submission->submitted_at->diffForHumans() }}</p>
                </div>
                <span class="text-sm {{ $submission->status == 'approved' ? 'text-green-600' : 'text-yellow-600' }}">
                  {{ ucfirst($submission->status) }}
                </span>
              </div>
            </li>
          @endforeach
        </ul>
      @endif
    </div>
  </div>
@endsection

@extends('layouts.app')

@section('content')
  <div class="container mx-auto py-10 px-4">
    <h1 class="text-2xl font-bold mb-4">Leaderboard - {{ $organization->name }}</h1>

    <!-- Navigasi Hari -->
    <div class="flex items-center justify-between mb-6">
      <a href="{{ route('organizations.leaderboard', [$organization->username, 'date' => $previousDate]) }}"
        class="text-sm text-blue-600 hover:underline">&larr; Sebelumnya</a>

      <div class="text-sm font-semibold text-gray-700">
        Tanggal: {{ \Carbon\Carbon::parse($selectedDate)->translatedFormat('d F Y') }}
      </div>

      <a href="{{ route('organizations.leaderboard', [$organization->username, 'date' => $nextDate]) }}"
        class="text-sm text-blue-600 hover:underline">Berikutnya &rarr;</a>
    </div>

    <div class="bg-white p-6 rounded shadow-md">
      @if ($users->isEmpty())
        <p class="text-gray-600">Belum ada peserta yang mengumpulkan tugas hari ini.</p>
      @else
        <div class="overflow-x-auto">
          <table class="min-w-full table-auto">
            <thead>
              <tr class="bg-gray-100">
                <th class="px-4 py-2 text-left text-sm font-semibold text-gray-700">Peringkat</th>
                <th class="px-4 py-2 text-left text-sm font-semibold text-gray-700">Nama Peserta</th>
                <th class="px-4 py-2 text-left text-sm font-semibold text-gray-700">Skor</th>
                <th class="px-4 py-2 text-left text-sm font-semibold text-gray-700">Waktu Selesai</th>
              </tr>
            </thead>
            <tbody>
              @foreach ($users as $index => $user)
                <tr class="border-t {{ $user->id === auth()->id() ? 'bg-blue-50 font-semibold' : '' }}">
                  <td class="px-4 py-2">{{ $index + 1 }}</td>
                  <td class="px-4 py-2">{{ $user->name }}</td>
                  <td class="px-4 py-2">{{ $user->total_score }}</td>
                  <td class="px-4 py-2">{{ \Carbon\Carbon::parse($user->earliest_submission_time)->format('H:i') }}</td>
                </tr>
              @endforeach
            </tbody>
          </table>
        </div>
      @endif
    </div>
  </div>
@endsection
